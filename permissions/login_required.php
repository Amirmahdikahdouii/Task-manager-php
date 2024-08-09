<?php
include "../core/config.php";

session_start();
if (!USER_LOGIN) {
    $_SESSION['message'] = "PLEASE LOGIN TO ADD TASK";
    $_SESSION['message_icon'] = "warning";
    header("Location: ../users/login.php");
}
