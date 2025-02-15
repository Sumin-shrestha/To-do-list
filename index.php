<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-image: url('home.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333;
            padding-top: 80px; /* Ensures the content is below the fixed navbar */
        }

        nav {
            background-color: #f4f6f7;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #a6acaf;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .navbar .logo a {
            color: #2c3e50;
            font-size: 28px;
            text-decoration: none;
            font-weight: bold;
        }

        nav ul {
            list-style-type: none;
            display: flex;
        }

        nav ul li {
            margin-right: 25px;
        }

        nav ul li a {
            color: #2c3e50;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            padding: 5px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #3498db;
            color: white;
            transform: scale(1.05);
        }

        .content {
            width: 100%;
            margin-top: 80px; /* Adjust content to not be hidden behind the navbar */
            max-width: 800px;
            margin: 30px auto;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 22px;
            line-height: 1.8;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }

        h1 {
            font-size: 36px;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 28px;
            color: #6DBE45;
            margin-top: 20px;
        }

        pre {
            font-size: 18px;
            color: #7f8c8d;
            font-family: 'Courier New', monospace;
            margin-top: 20px;
        }

        .gallery {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .gallery img {
            width: 22%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .gallery img:hover {
            transform: scale(1.05);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 200;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            width: 30%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }

        input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #2c81ba;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="logo">
        <a href="index.html">To-Do List</a>
    </div>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign Up</a></li>
        <li><a href="about.html">About Us</a></li>
        <li><a href="admin.php" id="adminBtn">Admin</a></li>
    </ul>
</nav>

<!-- Admin Modal -->
<div id="adminModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Admin Login</h2>
        <label for="adminUsername">Username:</label>
        <input type="text" id="adminUsername" placeholder="Enter Username">
        <label for="adminPassword">Password:</label>
        <input type="password" id="adminPassword" placeholder="Enter Password">
        <button id="adminLoginBtn">Login</button>
    </div>
</div>

<!-- Content Section -->
<div class="content">
    <h1>Welcome to the To-Do List System</h1>
    <p>Organize and manage your tasks efficiently.</p>
    <h2>TO-DO LIST SYSTEM</h2>
    <pre>Members:
        Shresha Maharjan
        Pujan Gautam
        Sumin Shrestha
        Ronish Shrestha
    </pre>

    
</div>

<script>
    var modal = document.getElementById("adminModal");
    var btn = document.getElementById("adminBtn");
    var closeBtn = document.getElementsByClassName("close")[0];
    var loginBtn = document.getElementById("adminLoginBtn");

    btn.onclick = function () {
        modal.style.display = "block";
    };

    closeBtn.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    loginBtn.onclick = function () {
        var username = document.getElementById("adminUsername").value;
        var password = document.getElementById("adminPassword").value;

        if (username === "adminuser" && password === "admin123") { // Replace with actual credentials
            window.location.href = "admin.php?username=" + encodeURIComponent(username);
        } else {
            alert("Incorrect username or password!");
        }
    };
</script>

</body>
</html>