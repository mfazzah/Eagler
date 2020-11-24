<?php
 $message = $_POST["message"];
 $subject = $_POST["subject"];
 $to = $_POST["to"];
 $from = $_POST["from"];

 // change this to your local server
    // example: "http://localhost/eagler/php/quiz.php?email="
 $replace = 'http://localhost:8000/php/quiz.php?email=';
 $replace .= $to;
 $emailConts = file_get_contents("../html/email.html") or die("cannot open");
 $emailConts = str_replace("ENTER_EMAIL_HERE",$replace, $emailConts);
 //echo $emailConts;
 require 'vendor/autoload.php';
 use \Mailjet\Resources;
 $mj = new \Mailjet\Client('4e7436f841db41c0555e6d97723e821d','276617d094db5aea31d1ef95dc2983f9',true,['version' => 'v3.1']);
 $body = [
   'Messages' => [
     [
       'From' => [
         'Email' => "cc12954@georgiasouthern.edu",
         'Name' => "Eagler"
       ],
       'To' => [
         [
           'Email' => $to,
           'Name' => "User"
         ]
       ],
       'Subject' => $subject,
       'TextPart' => "please click the following link to finish registration",
       'HTMLPart' => $emailConts,
       'CustomID' => ""
     ]
   ]
 ];
 $response = $mj->post(Resources::$Email, ['body' => $body]);
 //$response->success() && var_dump($response->getData());
?>

<html lang="en" dir="ltr">
  <head>
    <title>Verify e-mail</title>
  </head>
  <body>
    <h1>E-mail verification in process</h1>
    <p>Please verify your e-mail to finish your registration</p>

  </body>
</html>
