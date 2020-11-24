from DBHandler import DBHandler
import pandas as pd
import numpy as np
from scipy.sparse.linalg import svds
import Queries as qu
import action_to_rating as atr


def recommend(df_ratings, user_id, num_recommendations):
    #get ratings matrix 
    mat_ratings = atr.rating_matrix(df_ratings)

    #SVD 
    R = mat_ratings.to_numpy()
    mean_ratings = np.mean(R, axis = 1)
    R_nomean = R - mean_ratings.reshape(-1,1)
    
    U, sigma, Vt = svds(R_nomean, k=1)
    #get diagonal matrix of values returned 
    sigma = np.diag(sigma)
    pred = np.dot(np.dot(U,sigma), Vt) + mean_ratings.reshape(-1,1)
    
    df_predictions = pd.DataFrame(pred, columns = mat_ratings.columns)
    
    #sort predictions. Account for user_id, which starts at 1
    row_num = user_id - 1
    df_sorted_pred = df_predictions.iloc[row_num].sort_values(ascending=False).to_frame()
    
    df_hosts = qu.get_host_ids()
    user_data = df_ratings[df_ratings.user_id ==(user_id)]
    
    #dataframe consisting of all of specified user's ratings, host id, and host name 
    user_full = user_data.merge(df_hosts, how='left', left_on='host_id', right_on='host_id').sort_values(['rating'], ascending=False)
    
    #return list of sorted recommended user ids that user has not seen
    rec = (df_hosts[~df_hosts['host_id'].isin(user_full['host_id'])])
    rec = rec.merge(pd.DataFrame(df_sorted_pred).reset_index(), how = 'left', left_on='host_id', right_on='host_id').rename(columns = {row_num : 'results'})
    rec = rec.sort_values('results', ascending=False).iloc[:num_recommendations,:]
    print(rec)
    return df_sorted_pred

df_ratings = pd.read_csv('rating_data.csv')

#get active users
active_users = qu.get_active_users()

#recommend users 
list_recs = []
for i in active_users:
    a = recommend(df_ratings, 2, 10)
    list_recs.append(a)
