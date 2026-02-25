<?php
session_start();
require_once __DIR__ . "/db_data.php";
$conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
if ($conn->error) {
    die("Error connecting to the database");
}


function isLoggedIn()
{
    if (!isset($_SESSION['username'])) {
        header('Location:' . __DIR__ . "/../src/auth/login.php");
        exit;
    }
}

function checkRole($uid, $role)
{
    global $conn;
    isLoggedIn();
    $stmt = $conn->prepare("SELECT role FROM users WHERE uid = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();


    if ($user['role'] != $role) {
        header("HTTP/1.1: 403 Forbidden");
        echo "You don't have acces to this page";
        exit;
    }

}
?>