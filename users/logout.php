<?php
session_start();
if (isset($_SESSION['user_login']) and $_SESSION['user_login']) {
    unset($_SESSION['user_login']);
    unset($_SESSION['user_id']);
    header("Location: /task-manager/index.php");
}