<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "sns_gold";

$db = mysqli_connect($server,$username,$password,$database);


if(mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else
{	
	
	date_default_timezone_set('Asia/Calcutta');
}
?>