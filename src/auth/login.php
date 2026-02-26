<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once __DIR__ . "/../../config/db.php";
if (isset($_SESSION['uid'])) {
    $redirectTo = "../user/user_dashboard.php";

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $redirectTo = "../admin/admin_dashboard.php";
    }

    header("Location: " . $redirectTo);
    exit();
}

function clean_input($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    return $input;
}

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
                $user['role'] == 'user' ? header("Location: ../user/user_dashboard") : header("Location: ../admin/admin_dashboard.php");
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cascadia+Mono:ital,wght@0,200..700;1,200..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../styles/register.css">

    <title>Register</title>

</head>

<body>
    <div class="container">
        <section class="form-section">
            <h1>Log in<span>.</span></h1>
            <p class="medium-p">Don't have an account? <a href="./register.php">Register</a></p>

            <form action="login.php" class="register-form" method="post">
                <div class="row">
                    <div class="column col-1 bg-input">
                        <p>Username or Email</p>
                        <div class="input-wrapper">
                            <input type="text" placeholder="John / John@mail.com" name="username_email"
                                value="<?php echo htmlspecialchars($_POST['username_email'] ?? ''); ?>">
                            <img src="../../assets/person.png" alt="">
                        </div>
                    </div>
                    <?php if (!empty($errors['username_email'])): ?>
                        <div><?php echo htmlspecialchars($errors['username_email']) ?></div>
                    <?php endif ?>

                </div>

                <div class="row">
                    <div class="column col-2 bg-input">
                        <p>Password</p>
                        <div class="input-wrapper">
                            <input type="password" placeholder="••••••••" name="password"
                                value="<?php echo htmlspecialchars($_POST['password'] ?? ''); ?>">
                            <img src="../../assets/password.png" alt="">
                        </div>
                        <?php if (!empty($errors['password'])): ?>
                            <div>
                                <?php echo htmlspecialchars($errors['password']) ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>

                <button type="submit">Log in</button>
            </form>
        </section>

    </div>

</body>

</html>