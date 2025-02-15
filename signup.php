<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'crud');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    if ($stmt->execute()) {

        $user_id = $stmt->insert_id;
        

        $_SESSION['user_id'] = $user_id;
        header("Location: indexmain.php");
        exit;  
    } else {
        echo "Error: " . $stmt->error;
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
  <title>Sign Up</title>
  <style>
    /* Scoped CSS to only apply inside the .signup-page */
    body.signup-page {
      font-family: 'Arial', sans-serif;
      background-color: #f0f3f4; 
      margin: 0;
      padding: 0;
    }

    .signup-page .content {
      padding-top: 60px; 
    }

    .signup-page .container {
      max-width: 450px;
      margin: 50px auto;
      padding: 2rem;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .signup-page h1 {
      color: #4e9f7f; 
      margin-bottom: 1.5rem;
      font-size: 1.8rem;
    }

    .signup-page .form-group {
      margin-bottom: 1.5rem;
      text-align: left;
    }

    .signup-page .form-group label {
      display: block;
      font-size: 0.9rem;
      margin-bottom: 0.5rem;
      color: #333;
    }

    .signup-page .form-group input {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
      outline: none;
      transition: border-color 0.3s ease;
    }

    .signup-page .form-group input:focus {
      border-color: #4e9f7f; 
    }

    .signup-page .btn {
      width: 100%;
      padding: 0.8rem;
      background: #4e9f7f; 
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .signup-page .btn:hover {
      background: #3d7c60; 
    }

    .signup-page .footer {
      margin-top: 2rem;
      font-size: 0.8rem;
      color: #888;
    }

    .signup-page .footer a {
      color: #4e9f7f;
      text-decoration: none;
    }

    .signup-page .footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body class="signup-page">
<?php include('navbar.php'); ?>

  <div class="content">
    <div class="container">
      <h1>Create Account</h1>
      <form method="POST" action="">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Create a password" required>
        </div>
        <button type="submit" class="btn">Sign Up</button>
      </form>
    </div>
  </div>
</body>
</html>
