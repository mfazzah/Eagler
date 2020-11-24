
from DBHandler import DBHandler
import Queries as qu
import random
import pandas as pd

dbh=DBHandler()
 
user_id = qu.get_user_ids()

for i in range(160, 210):
    if i in list(user_id['user_id']):
        results = dbh.query('SELECT count(user_id) from user_action where user_id= ' + str(i))
        a =  [item[0] for item in results]
        
        results = dbh.query('SELECT count(user_id) from user_seen where user_id= ' + str(i))
        b =  [item[0] for item in results]
        
        results = dbh.query('SELECT count(distinct sending_user) from user_message where sending_user= ' + str(i))
        c =  [item[0] for item in results]
    
        d = a[0]+b[0]+c[0]
        
        if d > 5:
            s = 'UPDATE eagler.user set is_active_user= 1 where user_id = '+str(i)
            dbh.update(s)