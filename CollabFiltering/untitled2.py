
from DBHandler import DBHandler
import Queries as qu
import random
import pandas as pd

dbh=DBHandler()
 
user_id = qu.get_user_ids()

for i in range(151, 210):
        s1 = "INSERT into user_action(user_id, liked_id) values(" + str(i) + ',' + str(3)+ ');'
        s2 = "INSERT into user_action(user_id, liked_id) values(" + str(i) + ',' + str(15)+ ');'
        s3 = "INSERT into user_action(user_id, liked_id) values(" + str(i) + ',' + str(21)+ ');'
        s4 = "INSERT into user_action(user_id, liked_id) values(" + str(i) + ',' + str(19)+ ');'
        s5 = 'INSERT into user_seen(user_id, seen_id) values(' + str(i) + ',' + str(4) + ');'
        s6 = 'INSERT into user_seen(user_id, seen_id) values(' + str(i) + ',' + str(31) + ');'
        s7 = 'INSERT into user_seen(user_id, seen_id) values(' + str(i) + ',' + str(33) + ');'
        s8 = 'INSERT into user_seen(user_id, seen_id) values(' + str(i) + ',' + str(14) + ');'
        s9 = 'INSERT into user_seen(user_id, seen_id) values(' + str(i) + ',' + str(16) + ');'
        
        print(s1)
        print(s2)
        print(s3)
        print(s4)
        print(s5)
        print(s6)
        print(s7)
        print(s8)
        print(s9)
        
        if i% 3 == 0:
            s11 = 'INSERT into user_message(sending_user, receiving_user, sent_date, content) values(' + str(i) + ',' + str(15) + ', "2020-04-30 08:02:55", "congratuations we matched!");'
            s12 = 'INSERT into user_message(sending_user, receiving_user, sent_date, content) values(' + str(i) + ',' + str(19) + ', "2020-04-30 08:02:55", "congratuations we matched!");'
            s13 = 'INSERT into user_message(sending_user, receiving_user, sent_date, content) values(' + str(i) + ',' + str(19) + ', "2020-04-30 08:02:55", "congratuations we matched!");'
        
            print(s11)
            print(s12)
            print(s13)
    