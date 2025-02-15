<?php
if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    $conn = new mysqli('localhost', 'root', '', 'crud');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM tasks WHERE id = $taskId";
    if ($conn->query($sql) === TRUE) {
        header('Location: indexmain.php');
    } else {
        echo "Error deleting task: " . $conn->error;
    }

    $conn->close();
}
?>
