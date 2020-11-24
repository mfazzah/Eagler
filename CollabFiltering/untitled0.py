# -*- coding: utf-8 -*-
"""
Created on Tue Apr 21 06:03:33 2020

@author: Mira
"""

import mysql.connector
from mysql.connector import Error
from random import randint

fnames= ['cole', 'chad', 'brad', 'amr', 'ryan', 'stuart', 'amy', 'britni', 'zen', 'arthur', 'dunkin', 'luis', 'kobe', 'cobe', 'mira', 'sofia', 'ashley', 'bethany', 'mira', 'carlos']
lnames= ['smith', 'rodrigues', 'green', 'black', 'ahmed', 'james', 'bryant', 'gonzelez', 'apple', 'car', 'fushy', 'fword', 'phuck', 'greenlee', 'blueberry', 'tiffany']
email = '@georgiasouthern.edu'
numbers = ['1','2','3','4','5','6','7','8','9','0']
genders = ['male', 'female']
photos = ['photo1.jpg','photo2.jpg','photo3.jpg', 'photo4.jpg', 'photo5.jpg']


for i in range(25):
	#print(str(i))

	# create a first name
	fname=fnames[randint(0, len(fnames)-1)]
	# create a last name
	lname=lnames[randint(0, len(lnames)-1)]
	# create an email
	emails=''
	emails = emails + fname[0];
	emails = emails + fname[1];
	for xx in range(5):
		emails = emails+ numbers[randint(0, len(numbers)-1)]
	emails = emails + email
	# make a password
	passa = ''
	for x in range(5):
		passa = passa + numbers[randint(0, len(numbers)-1)]
	passa = passa + fnames[randint(0, len(fnames)-1)]
	# make a gender
	gender = genders[randint(0,1)]

	#select a user photo
	photo=''
	photo = photo + photos[randint(0,len(photos)-1)]



	try:
	    connection = mysql.connector.connect(host='db1.cnbbbm1ieq4m.us-east-1.rds.amazonaws.com',
	                                         database='eagler',
	                                         user='root',
	                                         password='Gulfstream2020!!')
	    if connection.is_connected():
	        db_Info = connection.get_server_info()
	        #print("Connected to MySQL Server version ", db_Info)
	        cursor = connection.cursor()
	        sql = 'insert into user(fname, lname, user_password, email, gender) values'+ '(\'' +fname+ '\',\'' + lname + '\',\'' + passa + '\',\'' + emails + '\',\'' + gender + '\')'
	        #print(sql)
	        result = cursor.execute(sql)
	        connection.commit()
	        sql2 = 'insert into user_image(user_id, filepath) values(' + str(i+1) + ',\'' + photo + '\')'
	        #print(sql2)
	        result = cursor.execute(sql2)
	        connection.commit()
	        cursor.close()

	except Error as e:
	    print("Error while connecting to MySQL", e)
	finally:
	    if (connection.is_connected()):
	        cursor.close()
	        connection.close()
	        #print("MySQL connection is closed")