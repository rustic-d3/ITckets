<?php
require_once __DIR__ . "/../../config/db.php";
include("../../includes/functions.php");
checkRole($_SESSION['uid'], "user");

echo "<pre>";
print_r($_SESSION); // Vezi dacă uid și role apar aici
echo "</pre>";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>Hello user</div>
    <a href="../auth/logout.php">Log out</a>

</body>

</html>