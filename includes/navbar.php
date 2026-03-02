<?php
$role = $_SESSION['role'] ?? " ";
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['tickets']) and $_GET['tickets'] === "true") {
        $users_link = '<a class="nav-link" aria-current="page" href="admin_dashboard.php">All clients</a>';
        $tickets_link = '<a class="nav-link active" aria-current="page" href="admin_dashboard.php?tickets=true">All clients</a>';
        $to_solve_link = '<a class="nav-link" href="admin_dashboard.php?tickets_to_solve=true">Tickets to solve</a>';
        $closed_link = '<a class="nav-link" href="admin_dashboard.php?closed_tickets=true">Tickets to solve</a>';
    } elseif (isset($_GET['tickets_to_solve']) and $_GET['tickets_to_solve'] === "true") {
        $users_link = '<a class="nav-link" aria-current="page" href="admin_dashboard.php">All clients</a>';
        $tickets_link = '<a class="nav-link" aria-current="page" href="admin_dashboard.php?tickets=true">All clients</a>';
        $to_solve_link = '<a class="nav-link active" href="admin_dashboard.php?tickets_to_solve=true">Tickets to solve</a>';
        $closed_link = '<a class="nav-link" href="admin_dashboard.php?closed_tickets=true">Tickets to solve</a>';

    } elseif (isset($_GET['closed_tickets']) and $_GET['closed_tickets'] === "true") {
        $users_link = '<a class="nav-link" aria-current="page" href="admin_dashboard.php">All clients</a>';
        $tickets_link = '<a class="nav-link" aria-current="page" href="admin_dashboard.php?tickets=true">All clients</a>';
        $to_solve_link = '<a class="nav-link" href="admin_dashboard.php?tickets_to_solve=true">Tickets to solve</a>';
        $closed_link = '<a class="nav-link active" href="admin_dashboard.php?closed_tickets=true">Tickets to solve</a>';

    } else {
        $users_link = '<a class="nav-link active" aria-current="page" href="admin_dashboard.php">All clients</a>';
        $tickets_link = '<a class="nav-link" aria-current="page" href="admin_dashboard.php?tickets=true">All clients</a>';
        $to_solve_link = '<a class="nav-link" href="admin_dashboard.php?tickets_to_solve=true">Tickets to solve</a>';
        $closed_link = '<a class="nav-link" href="admin_dashboard.php?closed_tickets=true">Tickets to solve</a>';
    }

}


?>

<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid text-primary">
        <?php if ($role == "admin"): ?>
            <a class="navbar-brand" href="#" style="pointer-events: none;">Admin Dashboard</a>
        <?php endif; ?>
        <?php if ($role == "user"): ?>
            <a class="navbar-brand" href="./user_dashboard.php">User Dashboard</a>
        <?php endif; ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($role == "admin"): ?>
                    <li class="nav-item">
                        <?php echo $users_link ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $tickets_link ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $to_solve_link ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $closed_link ?>
                    </li>
                <?php endif; ?>
            </ul>
            <a href="../auth/logout.php" class="btn  btn-outline-light">Log Out</a>
        </div>
    </div>
</nav>