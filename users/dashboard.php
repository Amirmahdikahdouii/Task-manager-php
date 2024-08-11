<?php
session_start();
include "../permissions/login_required.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../assets/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="../assets/css/style.css" rel="stylesheet"/>
    <link href="../assets/css/dashboard.css" rel="stylesheet">
    <link href="../assets/css/footer.css" rel="stylesheet"/>
    <?php
    include "../components/messagesAssets.php";
    ?>
</head>
<body>
<?php
include "../components/header.php";
?>

<main>
    <section class="main-section">
        <div class="main-section-item">
            <div class="main-section-item-image-container">
                <img src="../assets/img/dashboard-add-task.jpeg" alt="Add Task" class="main-section-item-image">
            </div>
            <a href="../tasks/addNewTask.php" class="main-section-item-title">Add New Task</a>
            <p class="main-section-item-text">
                Here, you can add new task for yourself and start have control on your plans.
            </p>
        </div>
        <div class="main-section-item">
            <div class="main-section-item-image-container">
                <img src="../assets/img/dashboard-list-task.jpeg" alt="List Task" class="main-section-item-image">
            </div>
            <a href="../tasks/taskList.php" class="main-section-item-title">List Task</a>
            <p class="main-section-item-text">
                Here, You can see you task list and manage them.
            </p>
        </div>
        <div class="main-section-item">
            <div class="main-section-item-image-container">
                <img src="../assets/img/dashboard-edit-profile.jpg" alt="Edit profile" class="main-section-item-image">
            </div>
            <a href="" class="main-section-item-title">Edit profile</a>
            <p class="main-section-item-text">
                Manage your information and have a better profile for yourself.
            </p>
        </div>
    </section>

    <?php
    include "../components/messages.php";
    ?>
</main>

<?php
include "../components/footer.php";
include "../components/messageScript.php";
?>
</body>
</html>