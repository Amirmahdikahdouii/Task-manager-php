<?php
// Message Script to run message framework if message is in session
if (isset($_SESSION['message'])) {
    ?>
    <script>
        // Show the pop-up to the user, by getting message from session
        showCustomAlert("<?php echo $_SESSION['message'] ?>")
        <?php
        $_SESSION['message'] = null;
        ?>
    </script>
    <?php
    if ($_SESSION['message'] === null) {
        // Clear messages from session
        unset($_SESSION['message']);
        unset($_SESSION['message_icon']);
    }
}
?>
