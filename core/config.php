<?php
error_reporting(E_ERROR | E_PARSE);
// This module will set attributes based on user login status, for using to check user is login or not.
if (isset($_SESSION['user_login'])) {
    define("USER_LOGIN", true);
    define("USER_ID", $_SESSION['user_id']);
} else {
    define("USER_LOGIN", false);
    define("USER_ID", null);
}
