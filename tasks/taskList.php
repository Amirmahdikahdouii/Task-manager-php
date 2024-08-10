<?php
include '../permissions/login_required.php';
include '../core/db_config.php';
include '../core/db.php';

session_start();
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $user_id = USER_ID;
    $sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC";
    $statement = $conn->prepare($sql);
    $statement->bind_param("s", $user_id);
    $statement->execute();
    $result = $statement->get_result();
} else {
    $_SESSION['message'] = "GET method only is required";
    $_SESSION['message_icon'] = "warning";
    header("Location ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../assets/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link href="../assets/css/style.css" rel="stylesheet"/>
    <link href="../assets/css/taskList.css" rel="stylesheet">
    <link href="../assets/css/footer.css" rel="stylesheet"/>
    <?php
    include '../components/messagesAssets.php';
    ?>
</head>
<body>
<?php
include '../components/header.php';
?>
<main>
    <section class="accordion-container">
        <h1 class="main-title">Task List</h1>
        <?php
        while ($row = $result->fetch_assoc()):
            ?>
            <div class="accordion">
                <div class="accordion-header">
                    <div class="title">
                        <?php
                        echo $row['title'];
                        ?>
                    </div>
                    <div class="actions">
                        <?php
                        if ($row['completed'] == 1):
                            ?>
                            <button class="status-button completed">Completed</button>
                        <?php
                        elseif (($row['completed'] == 0)):
                            ?>
                            <button class="status-button incomplete">Incomplete</button>
                        <?php
                        endif;
                        ?>
                        <button class="toggle-button">▼</button>
                    </div>
                </div>
                <div class="accordion-body">
                    <?php
                    echo "<p class='description'>" . nl2br(htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8')) . "</p>";
                    ?>
                    <button class="edit-button">Edit Task</button>
                </div>
            </div>
        <?php
        endwhile;
        ?>
    </section>
</main>

<?php
include '../components/footer.php';
$statement->close();
$conn->close();
?>
<script src="../assets/js/taskList.js"></script>
</body>
</html>