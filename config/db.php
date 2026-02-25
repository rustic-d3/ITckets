<?php
session_start();
require_once __DIR__ . "/db_data.php";
$conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
if ($conn->error) {
    die("Error connecting to the database");
}
?>