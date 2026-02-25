<?php
require_once("./db_data.php");
session_start();
$conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
if ($conn->error) {
    die("Error connecting to the database");
}
?>