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

$user_id = $_SESSION['user_id'];
$sql = "SELECT b.title AS book_title, b.author AS book_author, b.image AS book_cover, bb.bought_on 
        FROM bought_books bb 
        JOIN books b ON bb.books_id = b.books_id 
        WHERE bb.user_id = ? 
        ORDER BY bb.bought_on DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bought_books = [];
while ($row = $result->fetch_assoc()) {
    $bought_books[] = $row;
}
$borrowed_count = isset($_SESSION['borrowed_count']) ? $_SESSION['borrowed_count'] : 0;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BookNest | Purchase History</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col">

<!-- Header -->
<header class="bg-white/90 shadow-md rounded-2xl sticky top-0 z-50 px-2 py-4" >
  <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-2">
    <h1>
      <a href="index.php">
        <img src="https://i.ibb.co/Kc0pZmw6/logo-no-background.png" class="w-[200px]">
      </a>
    </h1>
    <button id="menu-toggle" class="sm:hidden text-2xl">&#9776;</button>
    <nav id="menu" class="hidden sm:flex space-x-6 items-center">
      <a href="index.php" class="text-amber-800 text-lg font-semibold">Home</a>
      <a href="books.php" class="hover:text-amber-800 text-lg font-semibold">Books</a>
      <a href="cart.php" class="hover:text-amber-800 text-lg font-semibold relative">
        Cart
        <?php if ($borrowed_count > 0): ?>
          <span class="absolute -top-2 -right-4 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
            <?php echo $borrowed_count; ?>
          </span>
        <?php endif; ?>
      </a>
      <a href="bought_books.php" class="hover:text-amber-800 text-lg font-semibold ">Borrowed</a>
      <a href="contact.php" class="hover:text-amber-800 text-lg font-semibold">Contact</a>
      <span class="text-amber-800 text-lg font-semibold"><?php echo $_SESSION['user_name']; ?>!</span>
      <a href="logout.php" class="bg-red-500 text-white text-lg px-3 py-1 rounded hover:bg-red-600">Logout</a>
    </nav>
  </div>
</header>
  

<section class="relative py-16 px-4 overflow-hidden">
  <div class="absolute inset-0 bg-cover bg-center filter blur-sm z-0 brightness-50"
       style="background-image: url('https://iili.io/315mRaf.jpg'); background-attachment: fixed;">
  </div>

  <div class="max-w-7xl mx-auto px-4 pb-16">
    <section class="flex justify-center items-center">
      <div class="bg-white/80 rounded-xl px-6 py-4 shadow-md z-10">
        <h2 class="text-amber-700 text-4xl font-semibold underline text-center hover:text-amber-500 transition duration-300 ease-in-out uppercase"
            style="--tw-shadow-glow: 0 0 8px #FBE084; text-shadow: var(--tw-shadow-glow);">
          Your Borrowings
        </h2>
      </div>
    </section>

    <br><br>

    <section class="px-4 pb-16">
      <div class="grid gap-x-10 gap-y-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <?php if (count($bought_books) > 0): ?>
          <?php foreach ($bought_books as $book): ?>
            <div class="w-full h-[400px] bg-white/80 rounded-2xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-100 overflow-hidden">
  <img src="<?php echo $book['book_cover']; ?>" alt="Book Cover" class="w-full h-56 object-cover rounded-t-2xl">
  <div class="p-4">
    <h3 class="font-semibold text-lg truncate"><?php echo $book['book_title']; ?></h3>
    <p class="text-gray-600 text-sm truncate">by <?php echo $book['book_author']; ?></p>
    <br>
    <p class="text-gray-500 text-xs mt-1">Borrowed on: <?php echo date("F j, Y", strtotime($book['bought_on'])); ?></p>
  </div>
</div>

          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-span-full z-10">
            <div class="flex justify-center items-center mt-10 z-10">
              <h1 class="text-2xl text-red-600 text-center bg-white/80 rounded-lg px-6 py-4 shadow">
                You haven't borrowed any books yet 😔
              </h1>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </section>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-6 px-6">
  <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
    
    <!-- Branding -->
    <div>
      <h4 class="text-white text-xl font-semibold mb-4">📚 BookNest</h4>
      <p class="text-sm">Borrow. Read. Repeat.</p>
      <p class="mt-2 text-xs text-gray-400">Bringing books closer to you since 2025.</p>
    </div>
    
    <!-- Quick Links -->
    <div>
      <h4 class="text-white text-lg font-semibold mb-4">Quick Links</h4>
      <ul class="space-y-2 text-sm">
        <li><a href="index.php" class="hover:underline transition">Home</a></li>
        <li><a href="books.php" class="hover:underline transition">Books</a></li>
        <li><a href="bought_books.php" class="hover:underline transition">Borrowed</a></li>
        <li><a href="cart.php" class="hover:underline transition">Your Cart</a></li>
        <li><a href="contact.php" class="hover:underline transition">Contact Us</a></li>
      </ul>
    </div>

    <!-- Connect -->
    <div>
      <h4 class="text-white text-lg font-semibold mb-4">Connect With Us</h4>
      <p class="text-sm mb-2">📧 <a href="mailto:support@booknest.com" class="hover:underline">support@booknest.com</a></p>
      <p class="text-sm mb-4">📞 +91-9466812417</p>
      <div class="flex gap-4 mt-2">
        <a href="https://linkedin.com/in/booknest" target="_blank" class="hover:text-blue-400 transition" aria-label="LinkedIn">
          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M4.98 3.5C4.98 4.88 3.88 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.5 8h4V24h-4V8zm7.5 0h3.6v2.2h.1c.5-1 1.7-2.2 3.4-2.2 3.6 0 4.3 2.3 4.3 5.3V24h-4v-7.7c0-1.8-.03-4.1-2.5-4.1-2.5 0-2.9 1.9-2.9 4v7.8h-4V8z"/></svg>
        </a>
        <a href="https://github.com/booknest" target="_blank" class="hover:text-gray-400 transition" aria-label="GitHub">
          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 .5C5.65.5.5 5.65.5 12.08c0 5.15 3.44 9.5 8.2 11.03.6.11.82-.26.82-.58 0-.28-.01-1.02-.02-2.01-3.34.73-4.04-1.61-4.04-1.61-.55-1.4-1.35-1.77-1.35-1.77-1.1-.76.09-.75.09-.75 1.22.09 1.86 1.26 1.86 1.26 1.08 1.84 2.84 1.31 3.54 1 .11-.78.42-1.31.76-1.61-2.67-.3-5.47-1.34-5.47-5.96 0-1.32.47-2.39 1.24-3.23-.12-.3-.54-1.52.12-3.17 0 0 1-.32 3.3 1.23a11.49 11.49 0 013-.4c1.02.01 2.04.14 3 .4 2.28-1.55 3.28-1.23 3.28-1.23.66 1.65.24 2.87.12 3.17.78.84 1.23 1.91 1.23 3.23 0 4.63-2.8 5.65-5.48 5.95.43.38.81 1.12.81 2.26 0 1.63-.01 2.94-.01 3.34 0 .32.22.7.83.58 4.76-1.53 8.2-5.88 8.2-11.03C23.5 5.65 18.35.5 12 .5z"/></svg>
        </a>
      </div>
    </div>

  </div>

  <!-- Bottom line -->
  <div class="mt-12 text-center text-xs text-gray-500 border-t border-gray-700 pt-6">
    &copy; 2025 <span class="text-white font-medium">BookNest</span>. All rights reserved.
  </div>
</footer>

</body>
</html>
