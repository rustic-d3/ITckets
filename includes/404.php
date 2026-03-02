<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | ITicket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-body-tertiary">

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="text-center">
            <h1 class="display-1 fw-bold text-info">404</h1>

            <div class="mb-4">
                <h2 class="h3 fw-bold">Oops! Page not found.</h2>
                <p class="text-secondary">
                    The page you are looking for might have been removed,<br>
                    had its name changed, or is temporarily unavailable.
                </p>
            </div>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg px-4 fw-bold">
                    Go Back
                </a>
                <?php if ($_SESSION['role'] === "user"): ?>
                    <a href="../src/user/user_dashboard.php" class="btn btn-outline-light btn-lg px-4 fw-bold shadow-sm">
                        Return Home
                    </a>
                <?php endif; ?>
                <?php if ($_SESSION['role'] === "admin"): ?>
                    <a href="../src/admin/admin_dashboard.php" class="btn btn-outline-light btn-lg px-4 fw-bold shadow-sm">
                        Return Home
                    </a>
                <?php endif; ?>
            </div>

            <div class="mt-5 pt-5">
                <div class="text-secondary small">
                    &copy; 2026 ITicket • Support System
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>