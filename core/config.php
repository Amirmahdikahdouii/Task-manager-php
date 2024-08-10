<?php
session_start();
if (
    isset($_SESSION['user_login']) and
    isset($_SESSION['user_id']) and
    $_SESSION['user_login'] and
    $_SESSION['user_id']
) {
    define("USER_LOGIN", true);
    define("USER_ID", $_SESSION['user_id']);
} else {
    define("USER_LOGIN", false);
    define("USER_ID", null);
}