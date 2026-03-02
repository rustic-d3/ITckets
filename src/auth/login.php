<?php
require_once __DIR__ . "/../../config/db.php";
include("../../includes/functions.php");



redirectIfLoggedIn();
$errors = [];
$username_email = '';
$password = '';
$db_password = '';
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (empty($_POST['username_email'])) {
        $errors['username_email'] = "Username or email fields can't be empty";
    }
    if (empty($_POST['password'])) {
        $errors['password'] = "Password field can't be empty!";
    }

    if (empty($errors)) {

        $username_email = clean_input($_POST['username_email']);
        $password = $_POST['password'];
        $stmt = $conn->prepare("SELECT uid, username, role, password from users WHERE email = ? or username = ? LIMIT 1");
        $stmt->bind_param("ss", $username_email, $username_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($result->num_rows === 1) {
            if (password_verify($password, $user["password"])) {
                $_SESSION['uid'] = $user['uid'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $user['role'] == 'user' ? header("Location: ../user/user_dashboard.php") : header("Location: ../admin/admin_dashboard.php");
                exit();
            } else {
                $errors['password'] = "Incorrect password. Try again.";
            }
        } else {
            $errors['username_email'] = "There is no user with that username or email";
        }

        $stmt->close();
        $conn->close();

    }


}
?>



<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Support System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-body-tertiary">

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <div class="card border-0 shadow-lg p-3">
                    <div class="card-body">
                        <h1 class="h3 mb-1 fw-bold">Log in.</h1>
                        <p class="text-secondary mb-4 small">Don't have an account? <a href="./register.php"
                                class="text-light text-decoration-none">Register</a></p>

                        <form action="login.php" method="POST">

                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Username or Email</label>
                                <input type="text" name="username_email"
                                    class="form-control form-control-lg <?php echo isset($errors['username_email']) ? 'is-invalid' : ''; ?>"
                                    placeholder="John / John@mail.com"
                                    value="<?php echo htmlspecialchars($_POST['username_email'] ?? ''); ?>">
                                <?php if (isset($errors['username_email'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['username_email']; ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-semibold text-secondary">Password</label>
                                <input type="password" name="password"
                                    class="form-control form-control-lg <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>"
                                    placeholder="••••••••">
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['password']; ?></div>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-outline-light btn-lg w-100 shadow-sm fw-bold">Log
                                in</button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4 text-secondary small">
                    &copy; 2026 ITicket
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>