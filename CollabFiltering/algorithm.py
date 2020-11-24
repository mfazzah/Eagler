import numpy as np
import pandas as pd
from connect import connect, prepare_ratings_matrix
from sklearn.neighbors import NearestNeighbors
"""
"""
def k_nearest():
    return 

conn = connect()
df_rating, mat_rating, user_id = prepare_ratings_matrix(conn)

#get number of ratings given by each user, and number of ratings each host has
count = df_rating.sum(axis = 0).tolist()
df_user_action_count = pd.DataFrame()
df_user_action_count['user_id'] = user_id
df_user_action_count['count'] = count

count= df_rating.sum(axis = 1).tolist()
df_host_rating_count = pd.DataFrame()
df_host_rating_count['host_id'] = user_id 
df_host_rating_count['count'] = count 

#threshold removes "cold"/inactive users or hosts for better recommendation
action_threshold = 3
rating_threshold = 3

print(df_rating)

d = list(set(df_user_action_count[df_user_action_count['count'] > 3].user_id))
drop_inactive = df_rating[d]
print(drop_inactive)