from DBHandler import DBHandler
import random
import pandas as pd

dbh = DBHandler()
results = dbh.query('SELECT max(user_id) FROM user')
last_id = [item[0] for item in results]
last_id = last_id[0]

results = dbh.query("SELECT user_id FROM user")
ids = pd.DataFrame(results, columns=['user_id'])

def generate_random_geo_data():
        lat = random.uniform(-90, 90)
        lon = random.uniform(-180, 80)
        
        return lat, lon
    

for i in range(1, last_id+1):
    if i in list(ids['user_id']):
        print(i)
        lat, lon = generate_random_geo_data()
        s = 'UPDATE eagler.user SET latitude = '+str(lat) +', longitude = '+ str(lon)+' WHERE user_id = '+str(i)
        dbh.update(s)
 
    
    