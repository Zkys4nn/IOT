<?php

$servername = "localhost";
$username = "zakiy";
$password = "11235381m";
$dbname = "iot";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
