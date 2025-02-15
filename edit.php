<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'crud');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$user_id = $_SESSION['user_id']; 
if (isset($_GET['id']) && isset($_GET['text'])) {
    $task_id = intval($_GET['id']); 
    $new_text = $conn->real_escape_string(urldecode($_GET['text'])); 
    $sql = "UPDATE tasks SET task_text = '$new_text' WHERE id = $task_id AND user_id = $user_id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: indexmain.php"); 
        exit();
    } else {
        echo "Error updating task: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
