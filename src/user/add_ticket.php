<?php
require_once __DIR__ . "/../../config/db.php";
include("../../includes/functions.php");
checkRole($_SESSION['uid'], "user");
$subject = "";
$description = "";
$uid = $_SESSION['uid'];
$phone = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (empty($_POST['subject'])) {
        $errors['subject'] = "Subject field is required";
    } elseif (strlen($_POST['subject']) < 3) {
        $errors['subject'] = "Subject should be more than 3 chars";
    }
    if (empty($_POST['description'])) {
        $errors['description'] = "Description field is required";
    }
    if (empty($_POST['phone'])) {
        $errors['phone'] = "Phone field is required";
    }

    if (empty($errors)) {

        $subject = clean_input($_POST['subject']);
        $description = clean_input($_POST['description']);
        $phone = $_POST['phone'];
        $stmt = $conn->prepare("INSERT INTO tickets (subject, description, uid, phone) VALUES (?, ?, ?, ?) ");
        $stmt->bind_param("ssis", $subject, $description, $uid, $phone);
        if (!$stmt->execute()) {
            $errors['general'] = "Something went wrong with the database!";
        } else {
            header("Location: user_dashboard.php");
            exit;
        }
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

    <title>Add ticket</title>
</head>

<body>
    <?php
    include("../../includes/navbar.php");
    ?>
    <div class="container vh-100">

        <div class="container  h-100 d-flex justify-content-start flex-column" style="margin-top: 15vh;">
            <?php if (!empty($errors["general"])): ?>
                <div class="alert alert-secondary" role="alert">
                    <?php echo $errors['general'] ?>
                </div>
            <?php endif; ?>

            <form class="w-50" action="add_ticket.php" method="POST">
                <div class="display-5 mb-4">
                    Add a new ticket:
                </div>
                <div class="form-floating mb-3">

                    <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="subject">
                    <label for="floatingInput">Subject</label>
                    <?php if (!empty($errors["subject"])): ?>
                        <div class="alert alert-secondary mt-3" role="alert">
                            <?php echo $errors['subject'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-floating mb-3">

                    <textarea class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="description"></textarea>
                    <label for="floatingInput">Description</label>
                    <?php if (!empty($errors["description"])): ?>
                        <div class="alert alert-secondary mt-3" role="alert">
                            <?php echo $errors['description'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-floating mb-3">

                    <input type="tel" class="form-control" id="floatingInput" placeholder="123-12-123"
                        pattern="[0-9]{3}[-]?[0-9]{2}[-]?[0-9]{3}" name="phone">
                    <label for="floatingInput">Phone number: 123-12-123</label>
                    <?php if (!empty($errors["phone"])): ?>
                        <div class="alert alert-secondary mt-3" role="alert">
                            <?php echo $errors['phone'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-dark">Submit</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
    </div>

</body>

</html>