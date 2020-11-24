import Queries as qu
import pandas as pd
import numpy as np
from scipy.sparse.linalg import svds
import profile_similarity as ps
from sklearn.cluster import KMeans
from sklearn.ensemble import GradientBoostingRegressor
from sklearn.decomposition import NMF
from sklearn.metrics import mean_squared_error
from sklearn.model_selection import train_test_split, ShuffleSplit, cross_validate, GridSearchCV
from scipy.sparse.linalg import svds


#merge all actions with respect to user_id and host_id in one dataframe 
def get_user_actions():
    seen = qu.hosts_seen()
    liked = qu.hosts_liked()
    messaged = qu.hosts_messaged()
    
    #merge user actions into one dataframe 
    df_temp = pd.merge(seen, liked, how='outer', on=['user_id', 'host_id'])
    df_temp.rename(columns = {'flag_x':'flag_s', 'flag_y':'flag_l'}, inplace=True)
    df = pd.merge(df_temp, messaged, how='outer', on=['user_id', 'host_id']) 
    df.rename(columns = {'flag':'flag_m'}, inplace=True)
    
    return df
#convert flags to numerical value 
def convert(row):
    if row['flag_m'] == 'm':
        return 3
    if row['flag_l'] == 'l':
        return 2
    return 1

#applies converstion of actions to ratings on the dataframe 
def rating_table(df):
    df['rating'] = df.apply(convert, axis=1)
    df = df.drop(['flag_s', 'flag_l', 'flag_m'], axis=1)
    return df

#turns dataframe of users, hosts, and ratings into a matrix of ratings 
def rating_matrix(df):
    mat_rating = df.pivot(index='user_id', columns='host_id', values='rating').fillna(0)
    return mat_rating


def get_rating_data():
    r= rating_table(get_user_actions())
    return r

def save_rating_data(df):
    df.to_csv('rating_data.csv')

#calculate the cumulative rating and take the average so as to have a measure of "attractiveness"
def cumulative_rating(rating_data, host_data):
    h = rating_data.loc[rating_data['host_id'].isin(host_data['host_id'])]
    d = pd.DataFrame(h.groupby('host_id')['rating'].count())
  
    cumulative  = pd.DataFrame(h.groupby('host_id')['rating'].sum())
    cumulative['avg'] = cumulative['rating'] / d['rating']
    cumulative = cumulative.reset_index()
    
    avg_rating = cumulative[['host_id','avg']]
    return avg_rating


def gbr(profile_data, avg_ratings):
    #drop any rows in profile data that don't have user_ids in avg_ratings
    idx = [] 
    for i in range(len(profile_data)):
        if profile_data['user_id'][i] not in list(avg_ratings['host_id']):
            idx.append(i)
            
    profile_data.drop(idx, inplace=True)
    X = profile_data.drop('user_id', axis=1)
    y = avg_ratings.drop(['host_id'], axis=1)
    
    
    y = y.values.ravel()
    #replace NaN values in case of database errors 
    X = X.fillna(X.mean())
    
    #run GBR to get weights for features (the more weight, the more important)
    X_train, X_test, y_train, y_test = train_test_split(X, y, random_state=0)
    
    #implement grid search for hyperparameter tuning
    print('Grid search.....')
    # gbr= grid_search_gbr(X_train, y_train)
    # gbr.fit(X_train, y_train)
    gbr = GradientBoostingRegressor().fit(X_train, y_train)
    
    print("RMSE: ", np.sqrt(mean_squared_error(y_test, gbr.predict(X_test))))
    f_importance = gbr.feature_importances_
    f_scores = pd.DataFrame({'weight':f_importance}, index=X_train.columns)
    f_scores = f_scores.sort_values(by='weight')

    #get weights of top 25 features and write to file 
    top_25_f = f_scores.tail(23)
    top_25_f.to_csv('weights.csv')

    return top_25_f

#function finds best hyperparameters for GBR
def grid_search_gbr(X_train, y_train):
    param_grid={'n_estimators':[100], 'learning_rate': [0.1, 0.05, 0.025, 0.01], 'max_depth':[6,4,8], 'min_samples_leaf':[3,5,9,15], 'max_features':[1.0,0.3, 0.5] }
    n_jobs = 4
   
    gbr_estimator = GradientBoostingRegressor()
    cv = ShuffleSplit(X_train.shape[0], test_size=0.2)
    gbr = GridSearchCV(estimator=gbr_estimator, cv=cv, param_grid=param_grid, n_jobs=n_jobs)
    gbr.fit(X_train, y_train)
    
    # print(gbr.best_estimator_)
    return gbr.best_estimator_

def nmf(profile_similarity):
    #find the model with the lowest reconstruction error 
    err = 99999999
    lowest_i = 0
    for i in range(1, 24):
        model = NMF(n_components=i, init='random', alpha=0.01, random_state=0)
        W = model.fit_transform(profile_similarity)
        
        if model.reconstruction_err_ < err:
            err = model.reconstruction_err_
            lowest_i = i
    
    #reconstruct matrix with lowest error to get recommendations for active users 
    model = NMF(n_components=lowest_i, init='random', alpha=0.01, random_state=0)
    W = model.fit_transform(profile_similarity)
    host_id = qu.get_active_users()
    df_W = pd.DataFrame(W)
    
    #write W matrix to file
    df_W.index = host_id['user_id']
    df_W.to_csv('nmf_W.csv')
        
    return df_W
    
if __name__ == '__main__':
    active_id = qu.get_active_users()
    
    lst = active_id['user_id']
    df_ratings = rating_table(get_user_actions())
    
    #drop all inactive users 
    df_ratings[df_ratings['user_id'].isin(lst)]
    save_rating_data(df_ratings)
    
    host_ids = qu.get_host_ids()
    avg_rating = cumulative_rating(df_ratings, host_ids)
    
    data = (qu.get_profile_data())
    gbr(data, avg_rating)
    sim_matrix = np.load('sim_matrix.npy')
    W = nmf(sim_matrix)