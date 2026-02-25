<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once __DIR__ . "/../../config/db.php";

function clean_input($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    return $input;
}

$errors = [];
$username = '';
$email = '';
$password = '';
$password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (empty($_POST['username'])) {
        $errors['username'] = "Username" . $_POST['username'] . " can't be empty";
    } elseif (strlen($_POST['username']) < 3) {
        $errors['username'] = "Username should be more than 3 chars";
    }
    if (empty($_POST['email'])) {
        $errors['email'] = "email can't be empty!";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid format for email" . $_POST['email'] . "!";
    }
    if (empty($_POST['password'])) {
        $errors['password'] = "Password field can't be empty!";
    } elseif (strlen($_POST['password']) < 8) {
        $errors['password'] = "Password should be at least 8 chars";
    } elseif (!preg_match($password_regex, $_POST['password']))
        $errors['password'] = "Invalid password format";

    if (empty($errors)) {

        $username = clean_input($_POST['username']);
        $email = clean_input($_POST['email']);
        $password = clean_input($_POST['password']);
        $hashed_pasword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("SELECT uid from users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors['email'] = "User with this mail already exists";
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
            <p>START FOR FREE</p>
            <h1>Create new account<span>.</span></h1>
            <p class="medium-p">Already A member? <a href="#">Log In</a></p>

            <form action="register.php" class="register-form" method="post">
                <div class="row">
                    <div class="column col-1 bg-input">
                        <p>Username</p>
                        <div class="input-wrapper">
                            <input type="text" placeholder="John" name="username">
                            <img src="../../assets/person.png" alt="">
                        </div>
                    </div>
                    <?php if (!empty($errors['username'])): ?>
                        <div><?php echo htmlspecialchars($errors['username']) ?></div>
                    <?php endif ?>

                </div>

                <div class="row">
                    <div class="column col-2 bg-input">
                        <p>Email</p>
                        <div class="input-wrapper">
                            <input type="email" placeholder="john@example.com" name="email">
                            <img src="../../assets/email.png" alt="">
                        </div>
                        <?php if (!empty($errors['email'])): ?>
                            <div>
                                <?php echo htmlspecialchars($errors['email']) ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>

                <div class="row">
                    <div class="column col-2 bg-input">
                        <p>Password</p>
                        <div class="input-wrapper">
                            <input type="password" placeholder="••••••••" name="password">
                            <img src="../../assets/password.png" alt="">
                        </div>
                        <?php if (!empty($errors['password'])): ?>
                            <div>
                                <?php echo htmlspecialchars($errors['password']) ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>

                <button type="submit">Create account</button>
            </form>
        </section>

    </div>

</body>

</html>