<?php
session_start();

$host = 'sql100.infinityfree.com';
$username = 'if0_38761482';
$password = 'booknest123';
$database = 'if0_38761482_booknest';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input
$email = $conn->real_escape_string($_POST['email']);
$password = $_POST['password'];

// Fetch user from database
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

// Check if user exists
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
        // Set session variables
      $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['name'] ?? 'User';
        $_SESSION['email'] = $user['email'];
        $_SESSION['phone'] = $user['mobile'];
        $_SESSION['created'] = $user['created_at'];

        // Redirect to the PHP dashboard (index.php)
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Incorrect password.'); window.location.href='login.html';</script>";
        exit;
    }
} else {
    echo "<script>alert('No account found with that email.'); window.location.href='login.html';</script>";
    exit;
}

$conn->close();
?>