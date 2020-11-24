drop database eagler; 
create database eagler;
use eagler;

create table user(user_id int(10) NOT NULL AUTO_INCREMENT, fname varchar(25), lname varchar(30), username varchar(45), user_password varchar(128), email varchar(45), phone_num int(15), country_code int(3), bdate Date, gender varchar (10), latitude float DEFAULT 0, longtitude float DEFAULT 0, role varchar(4), admin boolean DEFAULT 0, primary key (user_id)) ENGINE=InnoDB;
create table user_image(user_id int(10) NOT NULL, image_id int(25), filepath varchar(50), is_deleted boolean default NULL, primary key(user_id)) ENGINE=InnoDB;
create table user_action(user_id int(10), liked_id int(10), primary key(user_id, liked_id)) ENGINE=InnoDB;
create table user_seen(user_id int(10), seen_id int(10), primary key(user_id, seen_id)) ENGINE=InnoDB;
create table user_survey(q_1 varchar(50), q_2 varchar(50), q_3 varchar(50), q_4 varchar(50), q_5 varchar(50), q_6 varchar(50), q_7 varchar(50), q_8 varchar(50), q_9 varchar(50), q_10 varchar(50), user_id int(10), primary key(user_id)) ENGINE=InnoDB;
create table user_detail(user_id int(10), home_campus varchar(25), age int(3), major varchar(25), sexual_preference varchar(25), bio varchar(256), purpose int(1), is_active_user boolean DEFAULT 0,  primary key(user_id)) ENGINE=InnoDB;
create table user_purpose(pur_num int(1), pur_name varchar(25), primary key(pur_num, pur_name)) ENGINE=InnoDB;
create table user_message(message_id int(10) NOT NULL AUTO_INCREMENT, sending_user int(10), receiving_user int(10), sent_date datetime, content varchar(140), primary key(message_id)) ENGINE=InnoDB;

ALTER TABLE user_image
ADD foreign key(user_id)
REFERENCES user(user_id) ON DELETE CASCADE;

ALTER TABLE user_action
ADD foreign key(liked_id)
REFERENCES user(user_id),
ADD foreign key(user_id)
REFERENCES user(user_id) ON DELETE CASCADE;

ALTER TABLE user_seen
ADD foreign key(seen_id)
REFERENCES user(user_id),
ADD foreign key(user_id)
REFERENCES user(user_id) ON DELETE CASCADE;

ALTER TABLE user_survey
ADD foreign key(user_id)
REFERENCES user(user_id) ON DELETE CASCADE;

ALTER TABLE user_detail
ADD foreign key(user_id)
REFERENCES user(user_id) ON DELETE CASCADE;

ALTER TABLE user_message
ADD foreign key(sending_user)
REFERENCES user(user_id),
ADD foreign key(receiving_user)
REFERENCES user(user_id);