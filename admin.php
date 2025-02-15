<?php
$conn = new mysqli('localhost', 'root', '', 'crud');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pending_sql = "SELECT tasks.*, COALESCE(users.username, 'Unassigned') AS username 
                FROM tasks 
                LEFT JOIN users ON tasks.user_id = users.id 
                WHERE tasks.status = 'pending'";

$completed_sql = "SELECT tasks.*, COALESCE(users.username, 'Unassigned') AS username 
                  FROM tasks 
                  LEFT JOIN users ON tasks.user_id = users.id 
                  WHERE tasks.status = 'completed'";

$users_sql = "SELECT id, username, email, role FROM users";

$pending_result = $conn->query($pending_sql);
$completed_result = $conn->query($completed_sql);
$users_result = $conn->query($users_sql);
if (isset($_GET['id']) && isset($_GET['action'])) {
    $taskId = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->bind_param("i", $taskId);
        executeAndRedirect($stmt, "Task deleted successfully.", "Error deleting task.");
    } elseif ($action === 'edit' && isset($_GET['text'])) {
        $newText = htmlspecialchars($_GET['text']);
        $stmt = $conn->prepare("UPDATE tasks SET task_text = ? WHERE id = ?");
        $stmt->bind_param("si", $newText, $taskId);
        executeAndRedirect($stmt, "Task updated successfully.", "Error updating task.");
    } elseif ($action === 'complete') {
        $stmt = $conn->prepare("UPDATE tasks SET status = 'completed' WHERE id = ?");
        $stmt->bind_param("i", $taskId);
        executeAndRedirect($stmt, "Task marked as completed.", "Error completing task.");
    } elseif ($action === 'edit_user' && isset($_GET['user_id'], $_GET['username'], $_GET['email'], $_GET['role'])) {
        $userId = intval($_GET['user_id']); // Get the user ID separately
        $username = htmlspecialchars($_GET['username']);
        $email = htmlspecialchars($_GET['email']);
        $role = htmlspecialchars($_GET['role']);
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $role, $userId); // Use correct user ID
        executeAndRedirect($stmt, "User updated successfully.", "Error updating user.");
    } elseif ($action === 'delete_user' && isset($_GET['user_id'])) {
        $userId = intval($_GET['user_id']); // Get the user ID separately
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId); // Use correct user ID
        executeAndRedirect($stmt, "User deleted successfully.", "Error deleting user.");
    }
    
}


function executeAndRedirect($stmt, $successMsg, $errorMsg) {
    if ($stmt->execute()) {
        echo "<script>alert('$successMsg'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('$errorMsg'); window.location.href='admin.php';</script>";
    }
    $stmt->close();
}

?>
<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f8f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin: 20px 0;
            font-size: 36px;
            color: #6dbf8e;
        }

        .main {
            padding: 20px;
        }

        .section-title {
            text-align: center;
            font-size: 24px;
            color: #6dbf8e;
            margin-bottom: 15px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background-color: white;
            border: 1px solid #a5d8b3;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card h3 {
            color: #6dbf8e;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .actions button {
            background-color: #a5d8b3;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            margin: 5px;
        }

        .actions button:hover {
            background-color: #77c39e;
        }

        hr {
            width: 80%;
            margin: 20px auto;
            border: 0;
            border-top: 1px solid #d3ebd8;
        }
    </style>
</head>

<body>
    <h1 class="header">Admin Dashboard</h1>

    <div class="main">
        <h2 class="section-title">Pending Tasks</h2>
        <div class="gallery">
            <?php
            while ($row = $pending_result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<h3>" . htmlspecialchars($row['task_text']) . "</h3>";
                echo "User: " . htmlspecialchars($row['username']) . "</p>";
                echo "<div class='actions'>
                        <button class='complete' data-id='" . $row['id'] . "'>Complete</button>
                        <button class='edit' data-id='" . $row['id'] . "'>Edit</button>
                        <button class='delete' data-id='" . $row['id'] . "'>Delete</button>
                      </div>";
                echo "</div>";
            }
            ?>
        </div>

        <hr>

        <h2 class="section-title">Completed Tasks</h2>
        <div class="gallery">
            <?php
            while ($row = $completed_result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<h3>Task: " . htmlspecialchars($row['task_text']) . "</h3>";
                echo "<p>User: " . htmlspecialchars($row['username']) . "</p>";
                echo "<div class='actions'>
                        <button class='delete' data-id='" . $row['id'] . "'>Delete</button>
                      </div>";
                echo "</div>";
            }
            ?>
        </div>

        <hr>

        <h2 class="section-title">All Users</h2>
        <div class="gallery">
            <?php
            while ($row = $users_result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<h3>User: " . htmlspecialchars($row['username']) . "</h3>";
                echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
                echo "<p>Role: " . ucfirst(htmlspecialchars($row['role'])) . "</p>";
                echo "<div class='actions'>
                        <button class='edit_user' data-id='" . $row['id'] . "'>Edit</button>
                        <button class='delete_user' data-id='" . $row['id'] . "'>Delete</button>
                      </div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    // Delete Task
    document.querySelectorAll('.delete').forEach(button => {
        button.addEventListener('click', e => {
            if (confirm('Are you sure you want to delete this task?')) {
                window.location.href = `admin.php?id=${e.target.dataset.id}&action=delete`;
            }
        });
    });

    // Complete Task
    document.querySelectorAll('.complete').forEach(button => {
        button.addEventListener('click', e => {
            if (confirm('Mark this task as completed?')) {
                window.location.href = `admin.php?id=${e.target.dataset.id}&action=complete`;
            }
        });
    });

    // Edit Task
    document.querySelectorAll('.edit').forEach(button => {
        button.addEventListener('click', e => {
            const newText = prompt('Enter new task text:');
            if (newText !== null && newText.trim() !== '') {
                window.location.href = `admin.php?id=${e.target.dataset.id}&action=edit&text=${encodeURIComponent(newText)}`;
            }
        });
    });

    // Edit User
    document.querySelectorAll('.edit_user').forEach(button => {
        button.addEventListener('click', e => {
            const userId = e.target.dataset.id;
            const username = prompt('Enter new username:');
            const email = prompt('Enter new email:');
            const role = prompt('Enter new role (admin/user):');

            if (username && email && role) {
                window.location.href = `admin.php?id=${userId}&action=edit_user&user_id=${userId}&username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&role=${encodeURIComponent(role)}`;
            }
        });
    });

    // Delete User
    document.querySelectorAll('.delete_user').forEach(button => {
        button.addEventListener('click', e => {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `admin.php?id=${e.target.dataset.id}&action=delete_user&user_id=${e.target.dataset.id}`;
            }
        });
    });
});

    </script>

</body>
</html>
