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
    <title>Sign up for Twitter / Twitter</title>
</head>
<body>
    <div class="row main-row">
        <form action="" id="signUpForm">
            <h1>Sign up for Twitter</h1>
            <div class="row">
                <label for="usernameInput">Username</label>
                <input type="text" id="usernameInput" name="username">
            </div>
            <div class="row">
                <label for="emailInput">Email</label>
                <input type="email" id="emailInput" name="email">
            </div>
            <div class="row">
                <label for="passwordInput">Password</label>
                <input type="password" id="passwordInput" name="password">
            </div>
            <div class="row">
                <label for="phoneNumberInput">Phone</label>
                <input type="tel" id="phoneNumberInput" name="phoneNumber">
            </div>
            <a href="<?php echo "http://localhost:8080/twitter_clone/public/login.php"; ?>">Already have an account?</a>
            <a class="primary-button" id="submitForm">Submit</a>
        </form>
    </div>
    <script src="scripts/signUp.js"></script>
</body>
</html>
