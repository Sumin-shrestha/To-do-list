<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'crud';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    echo("Connection failed: " . $conn->connect_error);
}
else{
    echo("Connected");
}
?>
