<?php
require_once "../core/db_config.php";
include 'task-manager/core/db.php';

session_start();
if (isset($_SESSION['user_login']) and $_SESSION['user_login']) {
    $_SESSION['message'] = "You have already Logged in";
    header("Location: /task-manager/index.php");
}

// Check if there's a success message in the session
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
} else {
    $success_message = "";
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = "";
    $success = "";
    $table = "users";


// Get the form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

// Check if the username exists
    if ($stmt->num_rows == 1) {
        // Bind the result variables
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION["user_login"] = true;
            $_SESSION["user_id"] = $id;
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is not valid
            $error = "Invalid username or password.";
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
    <title>Login</title>
    <link href="../assets/css/style.css" rel="stylesheet"/>
    <link href="../assets/css/signUp.css" rel="stylesheet"/>
</head>
<body>
<?php
include '../components/header.php';
?>
<main>
    <!-- Form Section -->
    <div class="form-container">
        <form class="signup-form" action="./login.php" method="POST">
            <h2>Login</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username"
                       required>
                <span class="input-message" id="username-input-message"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       required>
            </div>
            <button type="submit" class="btn submit-btn" id="login-form-button">
                Login
            </button>
            <p class="redirect-login">
                Are you a new User? <a
                        href="./signUp.php">Sign Up here</a>.</p>
        </form>
    </div>
    <!-- End form Section -->
</main>

<script>
    <?php
    if (!empty($success_message)) {
        echo "alert('" . $success_message . "');";
    }
    if ($error) {
        echo "alert('" . $error . "');";
    }
    ?>
</script>
</body>
</html>