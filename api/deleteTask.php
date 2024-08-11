<?php
session_start();
include "../core/db_config.php";
include "../core/db.php";
include "../core/config.php";
include "../permissions/login_required.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['task_id']) or empty($data['task_id']) or !ctype_digit($data['task_id'])) {
        $_SESSION['message'] = "Task Not found!";
        $_SESSION['message_icon'] = "warning";
        echo json_encode(array("success" => false, "message" => "Task ID not found!"));
        exit();
    }

    $user_id = USER_ID;
    $task_id = $data['task_id'];

// Retrieve User Task
    $sql = "SELECT * FROM tasks WHERE user_id = ? AND id = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("ii", $user_id, $task_id);
    $statement->execute();
    $task = $statement->get_result();
    if ($task->num_rows === 0) {
        $_SESSION['message'] = "Task Not found!";
        $_SESSION['message_icon'] = "warning";
        echo json_encode(array("success" => false, "message" => "Task ID not found!"));
        exit();
    }
    $task = $task->fetch_assoc();
    $statement = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $statement->bind_param("i", $task_id);
    if ($statement->execute()) {
        $_SESSION['message'] = "Task Deleted!";
        $_SESSION['message_icon'] = "success";
        echo json_encode(array("success" => true, "message" => "Task Deleted"));
        exit();
    } else {
        $_SESSION["message"] = "Error while delete task";
        $_SESSION["message_icon"] = "error";
        echo json_encode(array("success" => false, "message" => "Error while delete task"));
        exit();
    }
} else {
    $_SESSION['message'] = "Post method is required";
    $_SESSION['message_icon'] = "error";
    echo json_encode(array("success" => false, "message" => "Post method is required"));
    exit();
}