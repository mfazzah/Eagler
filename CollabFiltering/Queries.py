from DBHandler import DBHandler
import pandas as pd
import numpy as np
import Queries as qu

def get_user_ids():
    dbh = DBHandler()
    results = dbh.query('SELECT user_id FROM user')
    user_id = [item[0] for item in results]
    user_id = pd.DataFrame(user_id, columns=['user_id'])
    
    return user_id

def get_host_ids():
    dbh = DBHandler()
    results = dbh.query('SELECT user_id, CONCAT(fname, \" \", lname) AS name FROM user')
    host_id = pd.DataFrame(results, columns=['host_id', 'name'])
    
    return host_id

def get_active_users():
    dbh=DBHandler()
    results = dbh.query("SELECT user_id FROM user WHERE is_active_user= 1")
    active_user_id = pd.DataFrame(results, columns=['user_id'])
    
    return active_user_id

def get_inactive_users():
    dbh=DBHandler()
    results = dbh.query("SELECT user_id FROM user WHERE is_active_user= 0")
    inactive_user_id = pd.DataFrame(results, columns=['user_id'])
    
    return inactive_user_id
    
def hosts_seen():
    dbh = DBHandler()
    results = dbh.query("SELECT user_id, seen_id FROM user_seen")
    seen = pd.DataFrame(results, columns=['user_id', 'host_id'])
    seen['flag'] = 's'
    
    return seen 

def hosts_liked():
    dbh = DBHandler()
    results = dbh.query("SELECT user_id, liked_id FROM user_action")
    liked = pd.DataFrame(results, columns=['user_id', 'host_id'])
    liked['flag'] = 'l'
    
    return liked 

def hosts_messaged():
    dbh = DBHandler()
    results = dbh.query("SELECT DISTINCT sending_user, receiving_user FROM user_message")
    messaged = pd.DataFrame(results, columns=['user_id', 'host_id'])
    messaged['flag'] = 'm'
    
    return messaged

def all_user_ids():
    dbh = DBHandler()
    results = dbh.query("SELECT user_id FROM user")
    user_id = [item[0] for item in results]
    user_id = user_id[user_id['user_id']!= 236]
    return user_id

"""Location queries"""
def get_all_user_locations():
    dbh = DBHandler()
    results = dbh.query('SELECT user_id, latitude, longitude FROM user')
    df = pd.DataFrame(results, columns=['user_id', 'latitude', 'longitude'])
    return df

def get_user_location(user_id):
    dbh = DBHandler()
    results = dbh.query('SELECT latitude, longitude FROM user WHERE user_id=' + str(user_id))
    df = pd.DataFrame(results, columns=['latitude', 'longitude'])
    return df
 

def get_profile_data():
    dbh=DBHandler()
    
    #query pulls survery questions to help form features 
    results = dbh.query("SELECT q_3, q_4, q_5,q_6, q_7, q_8, q_9, q_10, user.user_id FROM user_survey JOIN user ON user_survey.user_id = user.user_id WHERE user.admin != 1 ")
    survey = pd.DataFrame(results, columns=['q3', 'q4','q5','q6', 'q7', 'q8', 'q9', 'q10', 'user_id'])
    users = survey[['user_id']]
    survey.drop('user_id', axis=1, inplace=True)
    
    #split dataframe into numerical and categorical variables, and transform categorical vars
    survey_categorical = pd.get_dummies(survey[['q3', 'q8', 'q9','q10']])
    survey_numerical = survey[['q4', 'q5','q6','q7']]
    
    survey = pd.concat([survey_categorical, survey_numerical], axis = 1)
    survey = survey.astype(float)
    
    survey_categorical = survey_categorical.astype(float)
    survey_numerical = survey_numerical.astype(float)
    survey_matrix = pd.concat([survey_categorical, survey_numerical], axis = 1)
    
    #query age, home campus and major to form profile data features 
    results = dbh.query('SELECT user.user_id, age, home_campus, major FROM user_detail JOIN user ON user_detail.user_id = user.user_id WHERE user.admin != 1')
    detail = pd.DataFrame(results, columns=['user_id', 'age', 'home_campus', 'major'])
    detail.drop('user_id', axis=1, inplace=True)
    detail_categorical =  pd.get_dummies(detail[['home_campus', 'major']])
    detail_numerical = detail[['age']]
    
    detail = pd.concat([detail_categorical, detail_numerical], axis = 1)
    detail = detail.astype(float)
    
    
    profile_data = pd.concat([qu.get_all_user_locations(), detail, survey_matrix], axis = 1)
    
    return profile_data

def save_profile_data(df):
    df.to_csv('profile_data.csv')

def get_rating_data():
    import action_to_rating as atr
    r = pd.DataFrame()
    r = atr.get_rating_data
    return r

d = get_profile_data()
#drop admin ID
d = d[d['user_id'] != 236]

#replace NaN values with means of columns
d = d.fillna(d.mean())
    
save_profile_data(d)