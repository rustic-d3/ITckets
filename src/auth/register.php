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

            <form action="register.php" class="register-form">
                <div class="row">
                    <div class="column col-1 bg-input">
                        <p>First name</p>
                        <div class="input-wrapper">
                            <input type="text" placeholder="John">
                            <img src="../../assets/person.png" alt="">
                        </div>
                    </div>
                    <div class="column col-1 bg-input">
                        <p>Last name</p>
                        <div class="input-wrapper">
                            <input type="text" placeholder="Doe">
                            <img src="../../assets/person.png" alt="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column col-2 bg-input">
                        <p>Email</p>
                        <div class="input-wrapper">
                            <input type="email" placeholder="john@example.com">
                            <img src="../../assets/email.png" alt="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column col-2 bg-input">
                        <p>Password</p>
                        <div class="input-wrapper">
                            <input type="password" placeholder="••••••••">
                            <img src="../../assets/password.png" alt="">
                        </div>
                    </div>
                </div>

                <button type="submit">Create account</button>
            </form>
        </section>

    </div>

</body>

</html>