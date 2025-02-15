<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'crud');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if (!empty($email)) {
        $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
    } else {
        $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
    }

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $user, $user_email, $hashed_password, $role);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $user;
            $_SESSION['email'] = $user_email;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: indexmain.php');
            }
            exit;
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('No user found.'); window.location.href='login.php';</script>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e8f1f8; 
            color: #333;
            display: flex;
            justify-content: center; 
            align-items: center; 
            height: 100vh;
            width: 100%; 
            margin: 0;
            padding-top: 70px; 
        }

        
        .formm {
            background: rgba(255, 255, 255, 0.8); 
            color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 360px; 
        }

        .formm h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #6DBE45; 
        }

        
        .inputt {
            margin-bottom: 15px;
        }

        .inputt label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #4a4a4a;
        }

        .inputt input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .inputt input:focus {
            border-color: #6DBE45; 
            outline: none;
        }

        
        .loginn {
            width: 100%;
            padding: 10px;
            background-color: #6DBE45; 
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        .loginn:hover {
            background-color: #4CAF50; 
        }

        
        .forgot {
            text-align: center;
            margin-top: 10px;
        }

        .forgot a {
            color: #6DBE45; 
            text-decoration: none;
            font-size: 14px;
        }

        .forgot a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?>

    
    <div class="formm">
        <h1>Login</h1>
        <form id="loginForm" action="login.php" method="post">
            <div class="inputt">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="inputt">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="inputt">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="loginn">Login</button>
        </form>
        <div class="forgot">
            <a href="#">Forgot your password?</a>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            let isValid = true;

            const email = document.getElementById('email').value.trim();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (email.length < 5 && username.length < 3) {
                alert("Please enter a valid email or username.");
                isValid = false;
            }

            if (password.length < 6) {
                alert("Password must be at least 6 characters.");
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
