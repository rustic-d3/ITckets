<?php
$role = $_SESSION['role'] ?? " ";


?>

<nav class="navbar navbar-expand-lg" style="background-color: #3a3f50;" data-bs-theme="dark">
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
                        <a class="nav-link active" aria-current="page" href="admin_dashboard.php">All clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php?tickets=true">All tickets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php?tickets_to_solve=true">Tickets to solve</a>
                    </li>
                <?php endif; ?>
            </ul>
            <a href="../auth/logout.php" class="btn  btn-outline-light">Log Out</a>
        </div>
    </div>
</nav>