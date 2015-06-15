<?php

/*Define constant to connect to database */
DEFINE('DATABASE_USER', 'ZDing');
DEFINE('DATABASE_PASSWORD', '19930920');
DEFINE('DATABASE_HOST', 'localhost');
DEFINE('DATABASE_NAME', 'mydb');
/*Default time zone ,to be able to send mail */
date_default_timezone_set('UTC');

//This is the address that will appear coming from ( Sender )
define('EMAIL', 'email@gmail.com');

/*Define the root url where the script will be found such as
http://website.com or http://website.com/Folder/ */
DEFINE('WEBSITE_URL', 'http://localhost');

// Make the connection:
$dbc = @mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD,
 DATABASE_NAME);

if (!$dbc) {
 trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
}

?>
