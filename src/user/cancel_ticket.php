<?php
require_once __DIR__ . "/../../config/db.php";
include("../../includes/functions.php");
checkRole($_SESSION['uid'], "user");

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (!empty($_GET["tid"])) {
        $stmt = $conn->prepare("Select tid FROM tickets WHERE tid=?");
        $stmt->bind_param("i", $_GET["tid"]);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt = $conn->prepare("DELETE FROM tickets WHERE tid=?");
            $stmt->bind_param("i", $_GET["tid"]);
            if ($stmt->execute()) {
                header("Location: user_dashboard.php");
                exit;
            }

        } else {
            header("HTTP/1.1 404 Not found");
            echo "Ticket not found";
            exit;
        }



    }
}

?>