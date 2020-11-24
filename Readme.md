To install 
Requirments:
- php enabled web sever
- Zip file of github repository
- mySQL database 

1. Run create.sql on mysql database
  - run user.sql (file located eagler -> db => user.sql) 
  - run generate Users.py  (file located generateUsers -> generateUsers.py) # update DB connectior with new hostname and password
2. Extract Zip file to websever rename folder to 'project-gs-eagles-dating-application' 
3. Follow readme in eagler -> php for configurations
4. turn on Websever and access http://localhost/project-gs-eagles-dating-application/eagler/php/login.php

For matching algorithm:
1. run action_to_rating.py
2. run profile_similarity.py
3. run inactive_users.py
4. run active_users.py
