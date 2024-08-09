<?php
require_once "core/config.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="./assets/img/favicon.ico">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/index.css" rel="stylesheet">
    <link href="assets/css/footer.css" rel="stylesheet">
</head>
<body>
<?php
include "components/header.php";
?>
<main>
    <!-- Main Section -->
    <section class="main-section">
        <div class="main-section-item main-section-text-container">
            <h1 class="main-section-text">
                Are you having any dream?
            </h1>
            <h3 class="main-section-text">
                Remember to always have a plan.
            </h3>
            <h5 class="main-section-text">
                By using Task Manager You can achieve your dreams easily!
            </h5>
            <?php
            if (USER_LOGIN) {
                ?>
                <a href="./users/signUp.php" class="main-section-link">
                    Add New Task!
                </a>
                <?php
            } else {
                ?>
                <a href="./users/signUp.php" class="main-section-link">
                    Register Now!
                </a>
                <?php
            }
            ?>
        </div>
        <div class="main-section-item">
            <img src="./assets/img/main-section-image.jpg" alt="Main Image" class="main-section-image">
        </div>
    </section>
    <!-- End Main Section -->
</main>

<?php
include "components/footer.php";
?>
</body>
</html>