<?php

session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
    header("location: wall.php");
    exit;
}

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="//abs.twimg.com/favicons/twitter.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/signUp.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <title>Login on Twitter / Twitter</title>
</head>
<body>
    <div class="row main-row">
        <div class="row main-row">
            <form action="" id="signUpForm">
                <h1>Login on Twitter</h1>
                <div class="row">
                    <label for="emailInput">Email</label>
                    <input type="email" id="emailInput" name="email">
                </div>
                <div class="row">
                    <label for="passwordInput">Password</label>
                    <input type="password" id="passwordInput" name="password">
                </div>
                <span>If you don't already have an account, please <a href="<?php echo "http://localhost:8080/twitter_clone/public/signUp.php"; ?>">sign up</a>.</span>
                <a class="primary-button" id="submitForm">Log In</a>
            </form>
        </div>
    </div>
    <script src="scripts/login.js"></script>
</body>
</html>
