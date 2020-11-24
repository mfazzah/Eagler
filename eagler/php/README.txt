E-mail is now pimped out and after you successfully register it will be sent.
    encoded the image eagle_love.jpg to be able to use it on pages and the e-mail
    For some reason gmail blocks the src from the image. Might be my popup blocker or something.
    E-mail layout is in html/email.html

login.php now displays "incorrect e-mail or password" on wrong attempt

Changed signup.html to register.php to display error messages.
    Eagle ID now requires a certain pattern for the ID
    Password requires a pattern. Must be 8 chars or more with at least a number and uppercase
    Phone number now accepts 2 patterns, 8888888888 or 888-888-8888
    Gender is now a radio button when registering.

Added the $_SESSION['site_path_var']
    contains your current URL and call that instead of $host in case you don't use the localhost
        all headers start with project-gs-eagles-dating-application/eagler/(whatever)
            if you start your server at eagler, there is a commented out header that will work instead

Made sure pages call on correct pages

Did not modify:
    db.php, info.php, page_navigation.php
