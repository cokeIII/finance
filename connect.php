<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "finance";
// Create connection
$conn = new mysqli($servername, $username, $password,$database);
$conn->set_charset("utf8");
?>