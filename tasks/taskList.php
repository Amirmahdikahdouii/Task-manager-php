<?php
session_start();
include '../permissions/login_required.php';
include '../core/db_config.php';
include '../core/db.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $user_id = USER_ID;
    $where_conditions = [];
    $params = [$user_id];
    $types = 's';

    // Check for search parameter
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $where_conditions[] = "title LIKE ?";
        $params[] = "%" . $_GET['search'] . "%";
        $types .= 's';
    }

    // Check for status parameter
    if (isset($_GET['status'])) {
        $completed = $_GET['status'] == "completed" ? 1 : 0;
        $where_conditions[] = "completed = ?";
        $params[] = $completed;
        $types .= 'i';
    }
    // Construct the base query
    $sql = "SELECT * FROM tasks WHERE user_id = ?";

    // Add WHERE clause if conditions exist
    if (!empty($where_conditions)) {
        $sql .= " AND ";
        $sql .= " " . implode(" AND ", $where_conditions);
    }

    // Add ORDER BY clause (optional)
    $sql .= " ORDER BY id DESC";
    $statement = $conn->prepare($sql);
    $statement->bind_param($types, ...$params);
    $statement->execute();
    $result = $statement->get_result();
} else {
    $_SESSION['message'] = "GET method only is required";
    $_SESSION['message_icon'] = "warning";
    header("Location ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../assets/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link href="../assets/css/style.css" rel="stylesheet"/>
    <link href="../assets/css/taskList.css" rel="stylesheet">
    <link href="../assets/css/footer.css" rel="stylesheet"/>
    <?php
    include '../components/messagesAssets.php';
    ?>
</head>
<body>
<?php
include '../components/header.php';
?>
<main>
    <section class="accordion-container">
        <h1 class="main-title">Task List</h1>
        <div class="search-container">
            <div class="top-bar">
                <div class="search-bar">
                    <input type="text" class="search-input" placeholder="Search...">
                    <button class="search-button">Search</button>
                </div>
                <div class="filter-section">
                    <button class="filter-button">Filter</button>
                    <div class="filter-menu" id="filterMenu">
                        <div class="menu-item">
                            <div>1. Complete status</div>
                            <div class="sub-menu">
                                <label class="sub-menu-item">
                                    <input type="checkbox" name="status" value="completed" class="filter-checkbox">
                                    Completed
                                </label>
                                <label class="sub-menu-item">
                                    <input type="checkbox" name="status" value="incomplete" class="filter-checkbox">
                                    Incomplete
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($result->num_rows) {
            // Fetch data from result and display to user
            while ($row = $result->fetch_assoc()):
                ?>
                <div class="accordion">
                    <div class="accordion-header">
                        <div class="title">
                            <?php
                            echo $row['title'];
                            ?>
                        </div>
                        <div class="actions">
                            <?php
                            if ($row['completed'] == 1):
                                ?>
                                <button class="status-button completed">Completed</button>
                            <?php
                            elseif (($row['completed'] == 0)):
                                ?>
                                <button class="status-button incomplete">Incomplete</button>
                            <?php
                            endif;
                            ?>
                            <button class="toggle-button">▼</button>
                        </div>
                    </div>
                    <div class="accordion-body">
                        <?php
                        echo "<p class='description'>" . nl2br(htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8')) . "</p>";
                        ?>
                        <a href="./editTask.php?task_id=<?php echo $row['id'] ?>" class="edit-button">Edit Task</a>
                    </div>
                </div>
            <?php
            endwhile;
        } else {
            // Meaningful message for no result founded based on user request
            echo "<h2 class='main-title'>No tasks found</h2>";
        }
        ?>
    </section>

    <?php
    include "../components/messages.php";
    ?>
</main>

<?php
include '../components/footer.php';
include "../components/messageScript.php";

$statement->close();
$conn->close();
?>
<script src="../assets/js/taskList.js"></script>
</body>
</html>