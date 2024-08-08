<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="../assets/css/style.css" rel="stylesheet"/>
    <link href="../assets/css/signUp.css" rel="stylesheet"/>
</head>
<body>
<?php
include '../components/header.php'
?>
<main>
    <!-- Form Section -->
    <div class="form-container">
        <form class="signup-form" action="#" method="POST">
            <h2>Create an Account</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username"
                       required>
                <span class="input-message" id="username-input-message"></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <span class="input-message" id="email-input-message"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password"
                       name="confirm_password" required>
                <span class="input-message" id="confirm-password-input-message"></span>
            </div>
            <button type="submit" class="btn submit-btn" id="submit-form-button">
                Sign Up
            </button>
            <p class="redirect-login">Already have an account? <a
                        href="./login.php">Login here</a>.</p>
        </form>
    </div>
    <!-- End form Section -->
</main>

<script src="../assets/js/signUp.js"></script>
</body>
</html>