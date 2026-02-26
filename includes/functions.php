<?php

function clean_input($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    return $input;
}
function isLoggedIn()
{
    if (!isset($_SESSION['uid'])) {
        header('Location: ../auth/login.php');
        exit;
    }
}
function redirectIfLoggedIn()
{
    if (isset($_SESSION['uid'])) {
        $redirect = $_SESSION['role'] == 'admin' ? "../admin/admin_dashboard.php" : "../user/user_dashboard.php";
        header("Location: $redirect");
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