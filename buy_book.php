<?php
session_start();

$host = 'sql100.infinityfree.com';
$username = 'if0_38761482';
$password = 'booknest123';
$database = 'if0_38761482_booknest';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['books_id'])) {
    $user_id = $_SESSION['user_id'];
    $books_id = $_POST['books_id'];

    // Fetch book details
    $book_sql = "SELECT * FROM books WHERE books_id = ?";
    $book_stmt = $conn->prepare($book_sql);
    $book_stmt->bind_param("i", $books_id);
    $book_stmt->execute();
    $book_result = $book_stmt->get_result();
    $book = $book_result->fetch_assoc();

    if ($book) {
        // Check if the book is in the user's borrowings
        $check_sql = "SELECT borrow_id FROM borrowings WHERE user_id = ? AND books_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $user_id, $books_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $borrow = $check_result->fetch_assoc();
            $borrow_id = $borrow['borrow_id'];

            // Remove from borrowings (cart)
            $delete_sql = "DELETE FROM borrowings WHERE borrow_id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $borrow_id);

            if ($delete_stmt->execute()) {
                // Insert into bought_books with title and author
                $book_title = $book['title'];
                $book_author = $book['author'];

                $insert_sql = "INSERT INTO bought_books (user_id, books_id, book_title, book_author) VALUES (?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("iiss", $user_id, $books_id, $book_title, $book_author);

                if ($insert_stmt->execute()) {
                    $success_message = "Thank you for borrowing \"" . $book['title'] . "\"!";
                } else {
                    $error_message = "Error while recording the purchase.";
                }

                $insert_stmt->close();
            } else {
                $error_message = "Failed to remove book from cart.";
            }

            $delete_stmt->close();
        } else {
            $error_message = "This book is not in your cart.";
        }

        $check_stmt->close();
    } else {
        $error_message = "Book not found.";
    }

    $book_stmt->close();
} else {
    $error_message = "Invalid request.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BookNest | Borrowing Confirmation</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen px-4">
<div class="fixed inset-0 bg-[url('https://images5.alphacoders.com/132/thumb-1920-1326363.png')] bg-cover bg-center blur-sm brightness-75 z-[-1]"></div>

<div class="bg-white/80 p-8 rounded-2xl shadow-xl w-full max-w-xl text-center">
  <img src="https://i.ibb.co/Kc0pZmw6/logo-no-background.png" class="w-48 mx-auto mb-6" alt="BookNest Logo">

  <?php if (!empty($success_message)): ?>
    <h2 class="text-2xl font-bold text-green-700 mb-4">Borrowing Successful 🎉</h2>
    <p class="text-gray-700 mb-6"><?php echo $success_message; ?></p>
    <a href="bought_books.php" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition mb-3">Borrowed Books</a>
    <br>
    <a href="cart.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Go to Cart</a>
  <?php else: ?>
    <h2 class="text-2xl font-bold text-red-600 mb-4">Borrowing Failed</h2>
    <p class="text-gray-700 mb-6"><?php echo $error_message; ?></p>
    <a href="cart.php" class="inline-block bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">Return to Cart</a>
  <?php endif; ?>
</div>

  <footer class="mt-10 text-white text-sm">
    &copy; 2025 BookNest. All rights reserved.
  </footer>

</body>
</html>
