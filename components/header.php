<?php
session_start();
if (isset($_SESSION['user_login']) and $_SESSION['user_login']) {
    $user_login = true;
} else {
    $user_login = false;
}
?>
<!-- Header Section -->
<header class="site-header">
    <div class="header-container">
        <div class="header-brand">
            <a href="/task-manager/index.php" class="header-brand-name">Task Manager</a>
        </div>
        <nav class="header-main-nav">
            <ul>
                <li><a href="/task-manager/index.php" class="nav-link">Home</a></li>
                <li><a href="#" class="nav-link">Tasks</a></li>
                <li><a href="#" class="nav-link">Contact</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <?php
            if ($user_login) {
                ?>
                <a href="/task-manager/users/dashboard.php" class="btn login-btn">Dashboard</a>
                <?php
            } else {
                ?>
                <a href="/task-manager/users/login.php" class="btn login-btn">Login</a>
                <a href="/task-manager/users/signUp.php"
                   class="btn signup-btn">
                    Sign Up
                </a>
                <?php
            }
            ?>
        </div>
    </div>
</header>
<!-- End Header section -->