<?php
require_once __DIR__ . "/../../config/db.php";
include("../../includes/functions.php");
checkRole($_SESSION['uid'], "admin");

$result;
$active_table = 'users';
$user_uid = $_SESSION['uid'] ?? " ";
if (!empty($user_uid)) {
    $increment = 1;

    if (isset($_GET['tickets']) && $_GET['tickets'] === 'true') {
        $result = $conn->query("  SELECT tid, subject, description, uid, responsable, status FROM tickets");
        $active_table = 'tickets';
    } elseif (isset($_GET['tickets_to_solve']) && $_GET['tickets_to_solve'] === 'true') {
        $stmt = $conn->prepare("  SELECT tid, subject, description, uid, responsable, status FROM ticketss WHERE responsable = ? ");
        $stmt->bind_param("i", $user_uid);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $active_table = 'tickets_to_solve';
    } else {
        $stmt = $conn->prepare("  SELECT username, email, role, created_at FROM users WHERE NOT uid = ? ");
        $stmt->bind_param("i", $user_uid);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Admin Dashboard</title>
</head>

<body class="  vh-100">
    <?php
    include("../../includes/navbar.php");
    ?>
    <div class="container-md bg-light vh-100 d-flex justify-content-center align-items-start">
        <div class="container-sm table-responsive" style="margin-top: 15vh;">
            <div class="container">
                <div class="row d-flex justify-content-start">
                    <?php if ($active_table == "tickets"): ?>
                        <div class="display-5 mb-3">
                            All tickets:
                        </div>
                    <?php endif; ?>
                    <?php if ($active_table == "tickets_to_solve"): ?>
                        <div class="display-5 mb-3">
                            Tickets to solve:
                        </div>
                    <?php endif; ?>
                    <?php if ($active_table == "users"): ?>
                        <div class="display-5 mb-3">
                            All clients:
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($active_table === 'users'): ?>
                <table class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($user = $result->fetch_assoc()) {
                                echo
                                    "<tr>
                                                <td> $increment </td>
                                                <td> {$user['username']}</td>
                                                <td> {$user['email']} </td>
                                                <td> {$user['role']} </td>
                                                <td> {$user['created_at']} </td>
                                                
                                                
                                    </tr>";
                                $increment++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if ($active_table === 'tickets'): ?>
                <table class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Description</th>
                            <th scope="col">User Id</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">status</th>
                            <th scope="col">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($ticket = $result->fetch_assoc()) {
                                echo
                                    "<tr>
                                                <td> $increment </td>
                                                <td> {$ticket['subject']}</td>
                                                <td> {$ticket['description']} </td>
                                                <td> {$ticket['uid']} </td>
                                                <td> {$ticket['responsable']} </td>
                                                <td> {$ticket['status']} </td>
                                                <td class='text-center'> <a class='btn btn-outline-light' href='./view_ticket.php?ticket_id={$ticket['tid']}'>View</a> </td>
                                                
                                    </tr>";
                                $increment++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php if ($active_table === 'tickets_to_solve'): ?>
                <table class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Description</th>
                            <th scope="col">User Id</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">status</th>
                            <th scope="col">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($ticket = $result->fetch_assoc()) {
                                echo
                                    "<tr>
                                                <td> $increment </td>
                                                <td> {$ticket['subject']}</td>
                                                <td> {$ticket['description']} </td>
                                                <td> {$ticket['uid']} </td>
                                                <td> {$ticket['responsable']} </td>
                                                <td> {$ticket['status']} </td>
                                                <td class='text-center'> <a class='btn btn-outline-light' href='./view_ticket.php?ticket_id={$ticket['tid']}'>View</a> </td>
                                                
                                    </tr>";
                                $increment++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>