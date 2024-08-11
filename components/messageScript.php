<?php
if (isset($_SESSION['message'])) {
    ?>
    <script>
        showCustomAlert("<?php echo $_SESSION['message'] ?>")
        <?php
        $_SESSION['message'] = null;
        ?>
    </script>
    <?php
    if ($_SESSION['message'] === null) {
        unset($_SESSION['message']);
        unset($_SESSION['message_icon']);
    }
}
?>
