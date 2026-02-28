<?php
require_once __DIR__ . "/../../config/db.php";
include("../../includes/functions.php");
checkRole($_SESSION['uid'], "admin");

if (isset($_GET['ticket_id'])) {
    $stmt = $conn->prepare("SELECT t.*, u.username as creator_username, r.username as admin_responsable FROM tickets t 
                                    JOIN users u on u.uid = t.uid
                                    JOIN users r on r.uid = t.responsable
                                    WHERE t.tid = ?");
    $stmt->bind_param("i", $_GET['ticket_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $db_ticket = $result->fetch_assoc();

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>ITicket</title>
</head>

<body>
    <?php include("../../includes/navbar.php") ?>
    <div class="container " style="margin-top: 15vh;">

        <div class="card">
            <h5 class="card-header justify-content-between d-flex w-100 p-3">
                <div>User id: <?php echo "{$db_ticket['creator_username']} ({$db_ticket['uid']})" ?></div>
                <?php if ($db_ticket['status'] === "open"): ?>
                    <div>Ticket status: <span class="badge text-bg-success"><?php echo $db_ticket['status'] ?></span></div>
                <?php endif; ?>
                <?php if ($db_ticket['status'] === "closed"): ?>
                    <div>Ticket status: <span class="badge text-bg-danger"><?php echo $db_ticket['status'] ?></span></div>
                <?php endif; ?>
                <?php if ($db_ticket['status'] === "pending"): ?>
                    <div>Ticket status: <span class="badge text-bg-warning"><?php echo $db_ticket['status'] ?></span></div>
                <?php endif; ?>

            </h5>
            <div class="card-body">
                <h5 class="card-title"> <?php echo $db_ticket['subject'] ?></h5>
                <p class="card-text"><?php echo $db_ticket['description'] ?></p>
                <?php if (empty($db_ticket['admin_responsable'])): ?>
                    <a href="#" class="btn btn-primary">Solve</a>
                <?php endif; ?>
                <?php if (!empty($db_ticket['admin_responsable'])): ?>
                    <a href="#" class="btn btn-primary" style="pointer-events: none;">Responsable:
                        <?php echo "{$db_ticket['admin_responsable']} ({$db_ticket['responsable']})" ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>