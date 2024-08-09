<?php
include "../core/db_config.php";
include "../core/db.php";
include "../core/config.php";
include "../permissions/login_required.php";

session_start();
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $title = $conn->real_escape_string($_POST["title"]);
    $message = $conn->real_escape_string($_POST["message"]);
    $statement = $conn->prepare(
        "INSERT INTO tasks (user_id, title, description, completed) VALUES (?, ?, ?, false)"
    );

    $statement->bind_param("sss", $user_id, $title, $message);
    if ($statement->execute()) {
        $_SESSION['message'] = "Task added successfully!";
        $_SESSION['message_icon'] = "success";
        header("Location: addNewTask.php");
        exit();
    } else {
        $_SESSION['message'] = "Something went wrong!";
        $_SESSION['message_icon'] = "error";
    }
    $statement->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../assets/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>
    <link href="../assets/css/style.css" rel="stylesheet"/>
    <link href="../assets/css/addNewTask.css" rel="stylesheet">
    <link href="../assets/css/footer.css" rel="stylesheet"/>
    <?php
    include "../components/messages.php";
    ?>
</head>
<body>

<?php
include '../components/header.php';
?>

<main>
    <section class="main-section">
        <h1 class="main-title">New Task</h1>
        <div class="main-section-items-container">
            <form action="" method="post" id="new-task-form" class="main-section-item">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                    <span class="input-message" id="title-input-message"></span>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="message" id="message" rows="10"></textarea>
                    <span class="input-message" id="message-input-message"></span>
                </div>
                <div class="form-button-container">
                    <button class="btn btn-primary">
                        Add Task
                    </button>
                </div>
            </form>
            <div class="main-section-image-container">
                <img src="../assets/img/add-new-task.jpeg" alt="Add new Task" class="main-image">
            </div>
        </div>
    </section>
</main>

<?php
include '../components/footer.php';
?>
</body>
</html>
