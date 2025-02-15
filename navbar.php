<!-- Navigation Bar -->
<nav class="navbar">
    <div class="logo">
        <a href="index.php">To-Do List</a>
    </div>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign Up</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="#" id="adminBtn">Admin</a></li>
    </ul>
</nav>
<!-- Admin Login Modal -->
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
<style>
    /* Navbar Styling */
    .navbar {
        background-color: #f4f6f7;
        padding: 12px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px solid #a6acaf;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
    }
    .navbar .logo a {
        color: #2c3e50;
        font-size: 28px;
        text-decoration: none;
        font-weight: bold;
    }
    .navbar ul {
        list-style-type: none;
        display: flex;
    }
    .navbar ul li {
        margin-right: 25px;
    }
    .navbar ul li a {
        color: #2c3e50;
        text-decoration: none;
        font-size: 18px;
        font-weight: 500;
        padding: 5px 15px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    .navbar ul li a:hover {
        background-color: #3498db;
        color: white;
        transform: scale(1.05);
    }
    /* Modal Styling */
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
<script>
    // Get modal elements
    var modal = document.getElementById("adminModal");
    var btn = document.getElementById("adminBtn");
    var closeBtn = document.getElementsByClassName("close")[0];
    var loginBtn = document.getElementById("adminLoginBtn");
    // Open modal when "Admin" button is clicked
    btn.onclick = function () {
        modal.style.display = "block";
    };
    // Close modal when 'X' is clicked
    closeBtn.onclick = function () {
        modal.style.display = "none";
    };
    // Close modal when clicking outside of the modal
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
    // Handle login button click
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
