<?php
// Database connection details
$host = 'sql100.infinityfree.com';
$username = 'if0_38761482';
$password = 'booknest123';
$database = 'if0_38761482_booknest';
// Connect to MySQL
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize user input
$firstname = $conn->real_escape_string($_POST['firstname']);
$lastname = $conn->real_escape_string($_POST['lastname']);
$mobile = $conn->real_escape_string($_POST['mobile']);
$email = $conn->real_escape_string($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Check if passwords match
if ($password !== $confirm_password) {
    echo "Passwords do not match.";
    exit;
}

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$sql = "INSERT INTO users (name, email, password, mobile) 
        VALUES ('$firstname $lastname', '$email', '$hashed_password', '$mobile')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Registration successful! Redirecting to login page...');
            window.location.href = 'login.html';
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
