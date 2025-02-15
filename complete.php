<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $taskId = $_GET['id'];
    $conn = new mysqli('localhost', 'root', '', 'crud');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE tasks SET status = 'completed' WHERE id = $taskId";
    if ($conn->query($sql) === TRUE) {
        header('Location: indexmain.php');
        exit; 
    } else {
        echo "Error completing task: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid task ID.";
}
?>
