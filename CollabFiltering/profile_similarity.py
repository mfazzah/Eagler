import numpy as np
import pandas as pd
import Queries as qu
import math


def get_profile_sim(profile_data, user_ids, host_ids, weights):
    #get list of features 
    temp = profile_data.drop(['user_id', 'Unnamed: 0'], axis=1, inplace=False)
    feat = list(set(temp.columns.tolist()))
    
    #drop superfluous columns 
    profile_data.drop(['Unnamed: 0', 'user_id'], axis=1, inplace=True)
    
    #maximum difference between users and
    max_diff = [] 
    for f in feat:
        max_diff.append(max((max(profile_data[f]) - min(profile_data[f])), abs(max(profile_data[f]) - min(profile_data[f]))))
    
    #initialize nxn similarity matrix, where n is number of total users 
    n = user_ids.shape[0]
    sim_matrix = np.zeros((n,n))
    
    #get list of categorical and numerical vars 
    num_cols = []
    cat_cols = []

    for f in feat:
        if '_' in f:
            cat_cols.append(f)
        else:
            num_cols.append(f)
            
    print(feat)
        
    #construct similarity matrix 
    for i in range(len(host_ids)):
        for j in range((i+1), len(user_ids)):
            score = 0
            for k in range(1, len(feat)):
                #calculate scores for categorical features 
                if feat[k] in cat_cols:
                    if profile_data.iloc[i,k] == profile_data.iloc[j, k]:
                        score += 1 * weights[feat[k]]
                    else:
                        score += 0.0000000001 * weights[feat[k]]
                    #calculate scores for numerical features
                if feat[k] in num_cols:
                    a = float((max_diff[k] - abs(profile_data.iloc[i,k] - profile_data.iloc[j, k])))
                    b = a /max_diff[k]
                    c = b * weights[feat[k]]
                    score += c
                sim_score = float(score / (len(feat) - 1))
            sim_matrix[i,j] = sim_score
        print(i)
    
    for i in range(len(sim_matrix)):
        for j in range(len(sim_matrix)):
            if sim_matrix[i][j] <= 0:
                sim_matrix[i][j] = 0.0000000001
    return sim_matrix
            



if __name__ == '__main__':
    weights = pd.read_csv('weights.csv')
    profile_data = pd.read_csv('profile_data1.csv')
    active_ids = qu.get_active_users()
    active_ids_l = list(active_ids['user_id'])
    print()
    
    #drop all inactive users from profile_data as they do not have enough data to be significant
    profile_data = profile_data[profile_data['user_id'].isin(active_ids_l)]
    key = weights['Unnamed: 0']
    value = weights['weight']
    
    weights = {}
    for i in range(len(value)):
        weights.update({str(key[i]): value[i]})
        
        
    host_ids = qu.get_host_ids()
    host_ids.drop(['name'], axis=1, inplace=True)
    host_ids = host_ids[host_ids['host_id'].isin(active_ids_l)]
    
    
    sim_matrix = get_profile_sim(profile_data, active_ids, active_ids, weights)
    np.save('sim_matrix.npy', sim_matrix)