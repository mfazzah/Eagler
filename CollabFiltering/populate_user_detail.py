from DBHandler import DBHandler 
import pandas as pd
import numpy as np
from random import randint


dbh = DBHandler()


age = ['female', 'male', 'both']
home_campus = ['Armstrong','Statesboro']

results = dbh.query("SELECT user_id FROM user")
ids = pd.DataFrame(results, columns=['user_id'])

major = dbh.query('SELECT distinct q_2 from user_survey')
majors = pd.DataFrame(major, columns=['q_2'])
majors = majors['q_2'].tolist()


highest_user_id = ids['user_id'].max()
# users = 226

for i in range(1, 237):
    if i in list(ids['user_id']):
        a=age[randint(0, len(age)-1)]
        h=home_campus[randint(0, len(home_campus)-1)]
        m = majors[randint(0, len(majors) - 1)]
        s ='UPDATE user_detail SET sexual_preference="'+ a + '" where user_id= ' + str(i)+';'
        dbh.execute(s)