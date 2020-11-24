<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();
  $message = $_POST["message"];
  $subject = $_POST["subject"];
  $to = $_POST["to"];
  $from = $_POST["from"];

  include('php/info.php');

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
        'TextPart' => ' has submitted an error in the eagler application',
        'HTMLPart' => "Eagler user with user_id:".$from ." has submitted the following message: ".$message,
        'CustomID' => ""
      ]
    ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Eagler</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href='./css/report.css'>
<link rel="stylesheet" href='./css/main.css'>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

<?php
include('php/page_navigation_reported.php');
?>

<div id="content" class="pretty-box">
  <h3>Error has been reported, thank you.</h3>
</div>
</body>
</html>
