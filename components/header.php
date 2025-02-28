<?php
include '../core/config.php';
// This module is a header component for easy to use in other pages
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
                <li><a href="/task-manager/users/dashboard.php" class="nav-link">Dashboard</a></li>
                <li><a href="/task-manager/tasks/taskList.php" class="nav-link">Tasks</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <?php
            if (USER_LOGIN) {
                ?>
                <a href="/task-manager/users/logout.php" class="btn login-btn">Logout</a>
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