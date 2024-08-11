<?php
if (isset($_SESSION['message'])) {
    ?>
    <!-- Custom Alert Popup -->
    <div id="customAlert" class="custom-alert">
        <div class="custom-alert-content">
            <?php
            if (trim($_SESSION['message_icon']) == "success") {
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="60"
                     height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00b341" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 12l5 5l10 -10"/>
                </svg>
                <?php
            } else if (trim($_SESSION['message_icon']) == "error") {
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="60" height="60"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 6l-12 12"/>
                    <path d="M6 6l12 12"/>
                </svg>
                <?php
            } else if (trim($_SESSION['message_icon']) == "warning") {
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-exclamation-mark" width="60"
                     height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffec00" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 19v.01"/>
                    <path d="M12 15v-10"/>
                </svg>
                <?php
            }
            ?>
            <span id="alertMessage"></span>
            <button onclick="closeCustomAlert()">Close</button>
        </div>
    </div>

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