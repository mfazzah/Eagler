import mysql.connector
from mysql.connector import Error 

#connect to database
class DBHandler:
    def __init__(self):
        self.host = 'db1.cnbbbm1ieq4m.us-east-1.rds.amazonaws.com'
        self.user = 'eagler'
        self.password = 'root'
        self.db = 'Gulfstream2020!!'
        
    def __connect__(self):
        self.conn = None
        
        try:
            self.conn = mysql.connector.connect(host='db1.cnbbbm1ieq4m.us-east-1.rds.amazonaws.com',
                                             database='eagler', 
                                             user='root',
                                             password='Gulfstream2020!!')
            if self.conn.is_connected():
                self.cursor = self.conn.cursor()
        except Error as e:
            print("Error while connecting", e)
    def __disconnect__(self):
        self.conn.close()
    
    def query(self, sql):
        self.__connect__()
        self.cursor.execute(sql)
        result = self.cursor.fetchall()
        self.__disconnect__()
        return result
    
    def update(self, sql):
        self.__connect__()
        self.cursor.execute(sql)
        self.conn.commit()
        self.__disconnect__()
    