<?php
// A permission middleware like module to check user is authenticated or not
require_once "../core/config.php";
if (!USER_LOGIN) {
    $_SESSION['message'] = "PLEASE LOGIN First";
    $_SESSION['message_icon'] = "warning";
    header("Location: ../users/login.php");
    exit();
}
