<?php
$username = "root";
$password = "password";
$servername = "localhost";
$database = "travel";

// Create connection
$con = new mysqli($servername, $username, $password, $database);
// Check connection
if ($con->connect_error) {
   die("Connection failed: " . $con->connect_error);
}

?>