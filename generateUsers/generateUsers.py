import mysql.connector
from mysql.connector import Error
from random import randint
import bcrypt

fnames= ['cole', 'chad', 'brad', 'amr', 'ryan', 'stuart', 'amy', 'britni', 'zen', 'arthur', 'dunkin', 'luis', 'kobe', 'cobe', 'mira', 'sofia', 'ashley', 'bethany', 'mira', 'carlos']
lnames= ['smith', 'rodrigues', 'green', 'black', 'ahmed', 'james', 'bryant', 'gonzelez', 'apple', 'car', 'fushy', 'fword', 'phuck', 'greenlee', 'blueberry', 'tiffany']
email = '@georgiasouthern.edu'
numbers = ['1','2','3','4','5','6','7','8','9','0']
genders = ['male', 'female', 'both']
photos = ['photo1.jpg','photo2.jpg','photo3.jpg', 'photo4.jpg', 'photo5.jpg']
femalePhotos = ['photo.jpg','photog1.jpg','photog2.jpg','photog3.jpg','photog4.jpg','photog5.jpg','photog6.jpg','photog7.jpg',
'photog7.jpg','photog8.jpg','photog9.jpg','photog10.jpg','photog11.jpg']
malePhotos = ['photoo1.jpg','photoo2.jpg','photoo3.jpg','photoo4.jpg','photoo5.jpg','photoo6.jpg','photoo7.jpg',
'photoo7.jpg','photoo8.jpg','photoo9.jpg','photoo10.jpg','photoo11.jpg', 'photoo12.jpg', 'photoo13.jpg', 'photoo14.jpg']

q1=['both', 'female', 'male']
q2=['accounting', 'art', 'biology', 'compScience', 'engineering', 'iTech']
q3=['duh', 'weird']
q4=['4.1','4.2','4.3','4.4']
q5=['5.1','5.2','5.3','5.4','5.5','5.6']
q6=['6.1','6.2','6.3','6.4','6.5','6.6','6.7']
q7=['7.1','7.2','7.3','7.4','7.5']
q8=['blondes','brunettes']
q9=['yes','no']
q10=['yes','no']
q11=['Academic','Romantic','Social']


for i in range(200):
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
	if (gender == "female"):
		photo = femalePhotos[randint(0,len(femalePhotos)-1)]
	
	else:
		photo = malePhotos[randint(0,len(malePhotos)-1)]
	
	

	# build
	q_1 = q1[randint(0,len(q1)-1)]
	q_2 = q2[randint(0,len(q2)-1)]
	q_3 = q3[randint(0,len(q3)-1)]
	q_4 = q4[randint(0,len(q4)-1)]
	q_5 = q5[randint(0,len(q5)-1)]
	q_6 = q6[randint(0,len(q6)-1)]
	q_7 = q7[randint(0,len(q7)-1)]
	q_8 = q8[randint(0,len(q8)-1)]
	q_9 = q9[randint(0,len(q9)-1)]
	q_10 = q10[randint(0,len(q10)-1)]
	q_11 = q11[randint(0,len(q11)-1)]
	



	try:
	    connection = mysql.connector.connect(host='db1.cnbbbm1ieq4m.us-east-1.rds.amazonaws.com',
	                                         database='eagler',
	                                         user='root',
	                                         password='Gulfstream2020!!')
	    if connection.is_connected():
	        db_Info = connection.get_server_info()
	        #print("Connected to MySQL Server version ", db_Info)
	        cursor = connection.cursor()
	        sql = 'insert into eagler.user(fname, lname, user_password, email, gender) values'+ '(\'' +fname+ '\',\'' + lname + '\',\'' + passa + '\',\'' + emails + '\',\'' + gender + '\')'
	        #print(sql)
	        result = cursor.execute(sql)
	        connection.commit()
	        sql2 = 'insert into eagler.user_image(user_id, filepath) values(' + str(i+1) + ',\'' + photo + '\')'
	        #print(sql2)
	        result = cursor.execute(sql2)
	        connection.commit()

	        #enter in the user quiz
	        sql3 = "insert into eagler.user_survey(q_1,q_2,q_3,q_4,q_5,q_6,q_7,q_8,q_9,q_10, user_id, purpose) values('"+q_1+"','"+q_2+"','"+q_3+"','"+q_4+"','"+q_5+"','"+q_6+"','"+q_7+"','"+q_8+"','"+q_9+"','"+q_10+"','"+str(i+1)+"','"+q_11+"')";
	        result = cursor.execute(sql3)
	        connection.commit()
	        cursor.close()

	except Error as e:
	    print("Error while connecting to MySQL", e)
	finally:
	    if (connection.is_connected()):
	        cursor.close()
	        connection.close()
	        #print("MySQL connection is closed")