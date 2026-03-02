<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once __DIR__ . "/../../config/db.php";
include("../../includes/functions.php");

redirectIfLoggedIn();
$errors = [];
$username = '';
$email = '';
$password = '';
$password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (empty($_POST['username'])) {
        $errors['username'] = "Username field is required";
    } elseif (strlen($_POST['username']) < 3) {
        $errors['username'] = "Username should be more than 3 chars";
    }
    if (empty($_POST['email'])) {
        $errors['email'] = "Email field is required";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid format for email";
    }
    if (empty($_POST['password'])) {
        $errors['password'] = "Password field is required";
    } elseif (strlen($_POST['password']) < 8) {
        $errors['password'] = "Password should be at least 8 chars";
    } elseif (!preg_match($password_regex, $_POST['password'])) {
        $errors['password'] = "Invalid password format";
    }

    if (empty($errors)) {
        $username = clean_input($_POST['username']);
        $email = clean_input($_POST['email']);
        $password = $_POST['password'];
        $hashed_pasword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT uid from users WHERE email = ? or username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors['general'] = "User with this mail or username already exists";
        }
        $stmt->close();

        if (empty($errors)) {
            $user = $conn->prepare("INSERT INTO users(username, email, password) values(?,?,?)");
            $user->bind_param("sss", $username, $email, $hashed_pasword);
            if ($user->execute()) {
                header("Location: login.php");
                exit;
            }
            $user->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Support System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-body-tertiary">

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5">

                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger shadow-sm mb-4" role="alert">
                        <?php echo htmlspecialchars($errors['general']) ?>
                    </div>
                <?php endif ?>

                <div class="card border-0 shadow-lg p-3">
                    <div class="card-body">
                        <p class="text-light mb-1 small fw-bold">START FOR FREE</p>
                        <h1 class="h3 mb-1 fw-bold">Create new account<span>.</span></h1>
                        <p class="text-secondary mb-4 small">Already a member? <a href="./login.php"
                                class="text-light text-decoration-none">Log In</a></p>

                        <form action="register.php" method="POST">

                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Username</label>
                                <input type="text" name="username"
                                    class="form-control form-control-lg <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>"
                                    placeholder="John"
                                    value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                                <?php if (isset($errors['username'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['username']; ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Email</label>
                                <input type="email" name="email"
                                    class="form-control form-control-lg <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>"
                                    placeholder="john@example.com"
                                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['email']; ?></div>
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
                                <div class="form-text small text-secondary">Min. 8 chars, 1 uppercase, 1 number, 1
                                    special char.</div>
                            </div>

                            <button type="submit" class="btn btn-outline-light btn-lg w-100 shadow-sm fw-bold">
                                Create account
                            </button>
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