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
if (!isset($_GET['task_id']) or empty($_GET['task_id']) or !ctype_digit($_GET['task_id'])) {
    $_SESSION['message'] = "Task Not found!";
    $_SESSION['message_icon'] = "warning";
    header("Location: taskList.php");
    exit();
}

$user_id = USER_ID;
$task_id = $_GET['task_id'];

// Retrieve User Task
$sql = "SELECT * FROM tasks WHERE user_id = ? AND id = ?";
$statement = $conn->prepare($sql);
$statement->bind_param("ii", $user_id, $task_id);
$statement->execute();
$task = $statement->get_result();
if ($task->num_rows === 0) {
    $_SESSION['message'] = "Task Not found!";
    $_SESSION['message_icon'] = "warning";
    header("Location: taskList.php");
    exit();
}
$task = $task->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check Information is valid or no
    if (strlen($_POST["title"]) <= 100) {
        $title = $conn->real_escape_string($_POST["title"]);
        $message = $_POST["message"];
        $completed = 1 ? $_POST["completed"] == "on" : 0;
        $statement = $conn->prepare(
            "UPDATE tasks SET title = ?, description = ?, completed = ? WHERE user_id=$user_id AND id=$task_id"
        );
        $statement->bind_param("ssi", $title, $message, $completed);
        if ($statement->execute()) {
            $_SESSION['message'] = "Task Updated";
            $_SESSION['message_icon'] = "success";
            header("Location: taskList.php");
            exit();
        }
    } else {
        if (strlen($_POST["title"]) > 100) {
            $_SESSION["message"] = "Task title should be maximum 100 character";
            $_SESSION["message_icon"] = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../assets/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
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
        <h1 class="main-title">Edit Task</h1>
        <h1 class="main-title">

        </h1>
        <div class="main-section-items-container">
            <form action="editTask.php?task_id=<?php echo $task_id ?>" method="post" id="new-task-form"
                  class="main-section-item">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required value="<?php echo $task['title'] ?>"
                           maxlength="100">
                    <span class="input-message" id="title-input-message"></span>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="message" id="message" rows="10"><?php echo $task['description'] ?></textarea>
                    <span class="input-message" id="message-input-message"></span>
                </div>
                <div class="form-group form-group-checkbox">
                    <label for="completed">Completed: </label>

                    <input type="checkbox" <?php if ($task['completed']) echo "checked" ?> name="completed"
                           id="completed">
                    <span class="input-message" id="message-input-message"></span>
                </div>
                <div class="form-button-container">
                    <button class="btn btn-error" type="button" id="deleteTaskButton">
                        Delete Task
                    </button>
                    <button class="btn btn-primary" type="submit">
                        Edit Task
                    </button>
                </div>
            </form>
            <div class="main-section-image-container">
                <img src="../assets/img/add-new-task.jpeg" alt="Add new Task" class="main-image">
            </div>
        </div>
    </section>

    <?php
    include "../components/messages.php";
    ?>
    <section>
        <!-- Delete Task confirmation section -->
        <div id="messageBox" class="message-box">
            <h4 class="mb-4">Confirmation</h4>
            <p id="message">Do you want to proceed with this action?</p>
            <div class="button-container">
                <button id="confirm-delete-button" class="btn btn-success">Yes</button>
                <button id="cancel-delete-button" class="btn btn-error">No</button>
            </div>
        </div>
    </section>
</main>

<script src="../assets/js/editTask.js"></script>
<?php
$statement->close();
$conn->close();
include '../components/footer.php';
require_once "../components/messageScript.php";
?>
</body>
</html>
