from DBHandler import DBHandler 
from scipy.spatial.distance import cdist 
import pandas as pd
import numpy as np
import sklearn.metrics.pairwise
import operator
import itertools
import functools
import Queries as qu

#Calcualte the distance of hosts to user 
def calculate_distance(user_location, host_location):

    #returns indices of sorted array (where array is sorted by distance from user)
    distance = cdist(user_location, host_location).argsort()
    
    #add one to each index to get actual user_id
    for i in distance:
        i += 1 
        
    
    return distance

dist = []
#For a user, find the top n closest hosts based on latitude/logitude 
def closest_hosts(user_location, host_locations, n):
    for ind_u, row_u in user_location[['latitude','longitude']].iterrows():
        lst = row_u.tolist()
        user = np.array([lst])
        
        location = []
    
        for ind_h, row_h in host_locations[['latitude', 'longitude']].iterrows():
            location.append(row_h.tolist())
        
        hosts = np.asarray(location)
    
        #get index of n closest hosts
        idx_closest = calculate_distance(user, hosts)[0][:n]

    return idx_closest


def cosine_similarity(x, y):
    m = sklearn.metrics.pairwise.cosine_similarity(x, y)
    return m


#top k 
def find_similar_hosts(cold_user_id, profile_data, k ):
    active_user_data = profile_data[profile_data['user_id'].isin(list(qu.get_active_users()['user_id']))]
    user_data = profile_data[profile_data['user_id'] == cold_user_id]
    host_data = profile_data[profile_data['user_id'] != cold_user_id]
    list_close_hosts = list(closest_hosts(active_user_data, host_data, 10))
    
    
    store = dict()
    #use profile similarity to find most similar among users in close proximity 
    for j in list_close_hosts:
        h = np.array(host_data.iloc[j].values.tolist()).reshape(1,-1)
        user = np.array(user_data.values.tolist()).reshape(1,-1)
        similarity = cosine_similarity(user, h)
        
        #convert index to appropriate user ids
        key = profile_data['user_id'][j]
        store[key] = similarity[0][0]
           
    most_similar_list = []

    #reverse key/value mapping 
    inv = dict([[v,k] for k,v in store.items()])
    sort = sorted(inv, reverse=True)
    
    for i in sort:
        most_similar_list.append(inv[i])
    return most_similar_list


def inactive_recommend(inactive_user_id, profile_data,rating_data, num_closest, num_recs):
    #get rating data for active users 
    most_similar_list = find_similar_hosts(inactive_user_id, profile_data, num_closest)
    recs = []
    
    for i in list(most_similar_list):
        match1 = rating_data[rating_data['host_id'] == inactive_user_id]['user_id'].unique()
        match2 = rating_data[rating_data['host_id'] == i]['user_id'].unique()
        
        recs.append(match1)
        recs.append(match2)
    
    recs_lst = list(itertools.chain(*recs))   
    #generates random sample of x recommendations with replacement (necesary)

    if len(recs_lst) >= num_recs:
        final = np.random.choice(recs_lst, num_recs, replace=False).tolist()
    else: 
        final = np.random.choice(recs_lst, num_recs, replace=True).tolist()
    print(final)
    return final 


if __name__ == '__main__':
    inactive_ids = qu.get_inactive_users()
    active_ids = qu.get_active_users()
    active_ids_l = list(active_ids['user_id'])
    inactive_ids_l = list(inactive_ids['user_id'])
    rating_data = qu.get_rating_data()
    
    all_user_ids = qu.get_user_ids()
    all_locations = qu.get_all_user_locations()
    
    profile_data = pd.read_csv('profile_data1.csv')

    list_closest = []
    inactive_recs = pd.DataFrame(columns=['user_id', 'recs'])
    for i in inactive_ids_l:
        print(i)
        list_closest = inactive_recommend(i, profile_data, rating_data(), 10, 25)
        inactive_recs = inactive_recs.append({'user_id': i, 'recs': list_closest},ignore_index=True)
    
    #write results for each inactive user to csv file 
    inactive_recs.to_csv('inactive_recs.csv')