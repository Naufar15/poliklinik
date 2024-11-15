<?php
$host = "localhost"; // Host database
$username = "root";  // Username database
$password = "";      // Password database
$database = "poliklinik"; // Nama database

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
