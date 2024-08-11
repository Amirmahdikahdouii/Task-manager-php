<?php
require_once "../core/db_config.php";
include 'task-manager/core/db.php';
require_once "../core/config.php";

if (USER_LOGIN) {
    header("Location: dashboard.php");
}

session_start();
// Create connection to MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = "users";


    // Get the form data
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['message'] = "Passwords are not match";
        $_SESSION['message_icon'] = "error";
    } else {
        // Prepare and bind
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? or email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        if ($count > 0) {
            $_SESSION['message'] = "Username or email is already taken";
            $_SESSION['message_icon'] = "error";
            $stmt->close();
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO $table (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            // Execute the statement
            if ($stmt->execute()) {
                $_SESSION['message'] = "User created successfully.";
                $_SESSION['message_icon'] = "success";
                // Redirect to the login page
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['message'] = "Error While creating user";
                $_SESSION['message_icon'] = "error";
            }
            $stmt->close();

        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../assets/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="../assets/css/style.css" rel="stylesheet"/>
    <link href="../assets/css/signUp.css" rel="stylesheet"/>
    <link href="../assets/css/footer.css" rel="stylesheet"/>
    <?php
    include "../components/messagesAssets.php";
    ?>
</head>
<body>
<?php
include '../components/header.php';
?>
<main>
    <!-- Form Section -->
    <div class="form-container">
        <form class="signup-form" action="./signUp.php" method="POST">
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
    <?php
    include "../components/messages.php";
    ?>
</main>

<script src="../assets/js/signUp.js"></script>
<?php
include "../components/footer.php";
include "../components/messageScript.php";
?>
</body>
</html>