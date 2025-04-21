<?php
session_start();
require 'db_connection.php'; // your DB connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Delete all borrowings for this user
$sql = "DELETE FROM borrowings WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header("Location: cart.php?message=cleared");
    exit();
} else {
    echo "Error clearing cart: " . $conn->error;
}
?>
