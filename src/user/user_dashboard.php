<?php
require_once __DIR__ . "/../../config/db.php";
include("../../includes/functions.php");
checkRole($_SESSION['uid'], "user");

$result;
$user_uid = $_SESSION['uid'] ?? " ";
if (!empty($user_uid)) {
    $increment = 1;


    $stms = $conn->prepare("  SELECT tid, subject, description, uid, responsible, status FROM tickets WHERE uid=? ");
    $stms->bind_param("i", $_SESSION['uid']);
    $stms->execute();
    $result = $stms->get_result();


}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=cancel" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>User Dashboard</title>
</head>

<body>
    <?php
    include("../../includes/navbar.php");
    ?>
    <div class="container-md bg-light vh-100 d-flex justify-content-center align-items-start">
        <div class="container-sm table-responsive" style="margin-top: 15vh;">
            <?php if ($result->num_rows > 0): ?>
                <div class="container d-flex justify-content-between">

                    <div class="display-5 mb-3">
                        My tickets:
                    </div>
                    <div class="d-flex align-items-center">
                        <a href='./add_ticket.php' class='btn btn-dark '> Add</a>
                    </div>


                </div>

                <table class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Description</th>
                            <th scope="col">Created by</th>
                            <th scope="col">responsible</th>
                            <th scope="col">Status</th>
                            <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        while ($ticket = $result->fetch_assoc()) {
                            echo
                                "<tr>
                                                <td> $increment </td>
                                                <td> {$ticket['subject']}</td>
                                                <td> {$ticket['description']} </td>
                                                <td> {$ticket['uid']} </td>
                                                <td> {$ticket['responsible']} </td>
                                                <td> {$ticket['status']} </td>
                                                <td class='text-center' > 
                                                    <a href='cancel_ticket.php?tid={$ticket['tid']}' class='text-white link-offset-2'> 
                                                    <span class='material-symbols-outlined'>
                                                        cancel
                                                    </span>
                                                    </a>
                                                </td>
                                                
                                                
                                    </tr>";
                            $increment++;
                        }

                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php if ($result->num_rows === 0): ?>
                <p class="display-5">No current data</p>
            <?php endif; ?>



            </tbody>
            </table>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>