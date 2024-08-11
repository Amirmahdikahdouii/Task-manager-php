<?php
session_start();
include "../core/db_config.php";
include "../core/db.php";
include "../core/config.php";
include "../permissions/login_required.php";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Validate data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (strlen($_POST['title']) > 100) {
        $_SESSION['message'] = "Title max length is 100 character ";
        $_SESSION['message_icon'] = "error";
        header("Location: addNewTask.php");
        exit();
    } elseif ($_POST["priority"] !== "low" && $_POST["priority"] !== "high" && $_POST["priority"] !== "medium") {
        $_SESSION['message'] = "Priority must be low, medium or high";
        $_SESSION['message_icon'] = "error";
        header("Location: addNewTask.php");
        exit();
    }
    $user_id = USER_ID;
    $title = $conn->real_escape_string($_POST["title"]);
    $message = $_POST["message"];
    $priority = $_POST["priority"];

    // Prepare SQL for creating new task
    $statement = $conn->prepare(
        "INSERT INTO tasks (user_id, title, description, priority, completed) VALUES (?, ?, ?, ?, false)"
    );
    $statement->bind_param("ssss", $user_id, $title, $message, $priority);
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
    include "../components/messagesAssets.php";
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
                    <input type="text" id="title" name="title" required maxlength="100">
                    <span class="input-message" id="title-input-message"></span>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="message" id="message" rows="10"></textarea>
                    <span class="input-message" id="message-input-message"></span>
                </div>
                <div class="form-group">
                    <label for="priority">Priority:</label>
                    <select name="priority" id="priority">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
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

    <?php
    include '../components/messages.php';
    ?>
</main>

<?php
include '../components/footer.php';
require_once "../components/messageScript.php";
?>
</body>
</html>
