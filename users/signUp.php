<?php
include '../core/db.php';
$servername = "localhost"; // usually 'localhost'
$username = "root"; // your MySQL username
$password = "Alimardani33"; // your MySQL password
$dbname = "task_manager"; // database name

// Create connection to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

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
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords are not match";
    } else {
        // Prepare and bind
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? or email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        if ($count > 0) {
            $error = "Username already exists";
            $stmt->close();
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO $table (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            // Execute the statement
            if ($stmt->execute()) {
                $success = "New record created successfully";
            } else {
                $error = $stmt->error;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
</main>

<script src="../assets/js/signUp.js"></script>
<script>
    <?php
    if ($error) {
        echo "alert($error);";
    } else if ($success) {
        header("Location: ./login.php");
    }
    ?>
</script>
</body>
</html>