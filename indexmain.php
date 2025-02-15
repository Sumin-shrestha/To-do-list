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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $task = $conn->real_escape_string($_POST['title']);
    if (!empty($task)) {

        $sql = "INSERT INTO tasks (task_text, status, user_id) VALUES ('$task', 'pending', $user_id)";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New task added successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('Please enter a task');</script>";
    }
}


$pending_sql = "SELECT * FROM tasks WHERE status = 'pending' AND user_id = $user_id";
$completed_sql = "SELECT * FROM tasks WHERE status = 'completed' AND user_id = $user_id";

$pending_result = $conn->query($pending_sql);
$completed_result = $conn->query($completed_sql);
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9fdf7; 
    color: #333;
    padding-top: 80px;
}

.header {
    text-align: center;
    margin-top: 20px;
    padding-top: 20px;
    font-size: 36px;
    color: #6fae6d; 
}

.main {
    padding: 20px;
    text-align: center;
}

input[type="text"] {
    width: 80%;
    padding: 10px;
    margin-top: 20px;
    margin-bottom: 20px;
    border: 1px solid #d4e8d4; 
    border-radius: 5px;
    font-size: 16px;
}

input[type="text"]::placeholder {
    font-size: 14px;
    color: #b0c8b0; 
}

input[type="text"]:focus {
    outline: none;
    border-color: #8cbf8c; 
    box-shadow: 0 0 5px rgba(142, 191, 142, 0.5);
}

button {
    background-color: #a1d4a1; 
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #77bb77; 
}

hr {
    width: 80%;
    margin: 20px auto;
    border: 0;
    border-top: 1px solid #c7e3c7; 
}

.table {
    background-color: white;
    border-color: #77bb77; 
    border: 4px solid #a1d4a1;
    width: 80%;
    margin: 0 auto;
    border-radius: 10px;
    overflow: hidden;
}

.table th,
.table td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #d8f1d8; 
}

.actions button {
    margin: 0 5px;
}

.actions {
    display: flex;
    justify-content: center;
}

.actions button {
    padding: 5px 10px;
    font-size: 14px;
    cursor: pointer;
    background-color: #a1d4a1; 
    color: white;
    border-radius: 5px;
    border: none;
}

.actions button:hover {
    background-color: #77bb77; 
}


    </style>
    <title>To-Do List</title>
</head>

<body>
<?php include('navbar.php'); ?>

    <h1 class="header">To-Do List</h1>
    <div class="main">
        <form action="" method="post" autocomplete="off">
            <label for="title">Task:</label><br>
            <input type="text" name="title" id="title" required placeholder="Enter your task to add in">
            <br>
            <button type="submit">Add to list</button>
        </form>

        <hr>

        <h2>Pending Tasks</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Task</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($pending_result->num_rows > 0) {
                    $sn = 1;
                    while ($row = $pending_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $sn . "</td>";
                        echo "<td>" . $row['task_text'] . "</td>";
                        echo "<td class='actions'>
                                <button class='complete' data-id='" . $row['id'] . "'>Complete</button>
                                <button class='edit' data-id='" . $row['id'] . "'>Edit</button>
                                <button class='delete' data-id='" . $row['id'] . "'>Delete</button>
                              </td>";
                        echo "</tr>";
                        $sn++;
                    }
                } else {
                    echo "<tr><td colspan='3'>No tasks found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <hr>

        <h2>Completed Tasks</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Task</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($completed_result->num_rows > 0) {
                    $sn = 1;
                    while ($row = $completed_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $sn . "</td>";
                        echo "<td>" . $row['task_text'] . "</td>";
                        echo "<td class='actions'>
                                <button class='delete' data-id='" . $row['id'] . "'>Delete</button>
                              </td>";
                        echo "</tr>";
                        $sn++;
                    }
                } else {
                    echo "<tr><td colspan='3'>No completed tasks</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', (e) => {
                const taskId = e.target.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this task?')) {
                    window.location.href = `delete.php?id=${taskId}`;
                }
            });
        });

        document.querySelectorAll('.complete').forEach(button => {
            button.addEventListener('click', (e) => {
                const taskId = e.target.getAttribute('data-id');
                if (confirm('Mark this task as complete?')) {
                    window.location.href = `complete.php?id=${taskId}`;
                }
            });
        });

        document.querySelectorAll('.edit').forEach(button => {
            button.addEventListener('click', (e) => {
                const taskId = e.target.getAttribute('data-id');
                const currentText = e.target.closest('tr').querySelector('td:nth-child(2)').innerText;
                const newTaskText = prompt("Edit your task:", currentText);
                if (newTaskText && newTaskText !== currentText) {
                    window.location.href = `edit.php?id=${taskId}&text=${encodeURIComponent(newTaskText)}`;

                }
            });
        }); 
    </script>
</body>

</html>
