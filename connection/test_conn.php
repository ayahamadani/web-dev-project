<?php
$host = 'localhost';
$username = 'Aya';
$password = 'CceNbmj6sV';
$database = 'test_task';

// connecting to the database
$conn = mysqli_connect($host, $username, $password, $database);
// check the connection
if(!$conn) echo 'Connection error: ' .mysqli_connect_error();

?>