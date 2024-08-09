<?php
session_start();
if (isset($_SESSION['user_login']) and $_SESSION['user_login']) {
    define("USER_LOGIN", true);
} else {
    define("USER_LOGIN", false);
}