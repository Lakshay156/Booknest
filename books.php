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
$sql = "SELECT books_id, title, author, image, category, book_rent FROM books";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category = $row['category'];
        $books[$category][] = $row;
    }
} else {
    echo "No books found.";
}
$category = isset($_GET['category']) ? $_GET['category'] : 'Fiction';

// Query to get books based on category
$search = isset($_GET['search']) ? trim($_GET['search']) : '';


$filteredBooks = [];

if (!empty($search)) {
    foreach ($books[$category] as $book) {
        if (
            stripos($book['title'], $search) !== false ||
            stripos($book['author'], $search) !== false
        ) {
            $filteredBooks[] = $book;
        }
    }
} else {
    $filteredBooks = $books[$category];
}

$books_count = isset($_SESSION['borrowed_count']) ? $_SESSION['borrowed_count'] : 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BookNest | Browse Books</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .hover-scale {
      transition: transform 0.3s ease;
    }
    .hover-scale:hover {
      transform: scale(1.03);
    }
  </style>
</head>


<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

<div class="flex-grow">

  <section class="relative py-1 px-1 overflow-hidden" >
  <!-- Blurred background image -->
  <div class="absolute inset-0 bg-cover bg-center filter blur-sm z-0 brightness-75"
       style="background-image: url('https://images.pexels.com/photos/2041540/pexels-photo-2041540.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'); background-attachment: fixed;">
  </div>

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
        <?php if ($books_count > 0): ?>
          <span class="absolute -top-2 -right-4 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
            <?php echo $books_count; ?>
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

<br>
<br>
  <!-- Page Title & Search Section -->
  <div class="relative z-10">
  <section class="flex justify-center items-center">
    <div class="relative">
      <!-- Dropdown Button -->
      <button onclick="toggleDropdown()" class="bg-white/90 rounded-xl px-6 py-4 shadow-md w-full">
        <h2 class="text-amber-700 text-4xl font-semibold underline text-center hover:text-amber-500 transition duration-300 ease-in-out uppercase"
            style="--tw-shadow-glow: 0 0 8px #FBE084; text-shadow: var(--tw-shadow-glow);">
          <?php echo htmlspecialchars(ucwords($category)); ?>
        </h2>
        
      </button>

      <!-- Dropdown Menu -->
      <div id="dropdownMenu" class="absolute left-0 mt-2 w-full bg-white rounded-lg shadow-lg hidden z-10">
        <ul class="py-2 text-center text-lg text-gray-700">
          <li><a href="books.php?category=Fiction" class="block px-4 py-2 hover:bg-amber-100">Fiction</a></li>
          <li><a href="books.php?category=Science" class="block px-4 py-2 hover:bg-amber-100">Science</a></li>
          <li><a href="books.php?category=Biography" class="block px-4 py-2 hover:bg-amber-100">Biography</a></li>
          <li><a href="books.php?category=Technology" class="block px-4 py-2 hover:bg-amber-100">Technology</a></li>
          <li><a href="books.php?category=Self-Help" class="block px-4 py-2 hover:bg-amber-100">Self-Help</a></li>
          <li><a href="books.php?category=Children" class="block px-4 py-2 hover:bg-amber-100">Children</a></li>
        </ul>
      </div>
    </div>
  </section>
<
<br>



  <form method="GET" action="books.php" class="flex flex-col sm:flex-row items-center justify-center gap-4">
  <input
    type="text"
    name="search"
    placeholder="Search books..."
    class="border px-4 py-2 rounded w-full sm:w-1/2 focus:outline-none focus:ring-2 focus:ring-amber-400"
    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
  />
  <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
  <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">Search</button>
  <?php if (isset($_GET['search']) && trim($_GET['search']) !== ''): ?>
    <a href="books.php?category=<?php echo urlencode($category); ?>" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Clear</a>
  <?php endif; ?>
</form>

<br>

<!-- Display Books -->
  <div class="max-w-7xl mx-auto px-4 pb-16">
  <section class="flex justify-center items-center ">
<p class="text-gray-800 text-bold text-center mb-8 bg-white/80 rounded-lg inline-block px-6 py-4">Find books by genre, author, or title</p>
</section>

<br>

<!-- Cards Section -->
<section class="px-4 pb-16">
  <div class="grid gap-x-10 gap-y-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    <?php foreach ($filteredBooks as $book): ?>
      <div class="w-full h-[350px] bg-white/80 rounded-2xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-blue-100 overflow-hidden">
        <img src="<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?>" class="h-[180px] w-full object-cover rounded-t-2xl">
        <div class="p-4">
          <h3 class="font-semibold text-lg truncate"><?php echo $book['title']; ?></h3>
          <p class="text-gray-600 text-sm mb-2 truncate">by <?php echo $book['author']; ?></p>
          <h4 class="font-semibold text-red-600 text-lg truncate">Book Rent : ₹<?php echo $book['book_rent']; ?></h4>
          <form method="POST" action="add_to_cart.php" onsubmit="handleFormSubmit(event, this)">
          <input type="hidden" name="books_id" value="<?php echo $book['books_id']; ?>">
            <input type="hidden" name="title" value="<?php echo $book['title']; ?>">
            <input type="hidden" name="author" value="<?php echo $book['author']; ?>">
            <input type="hidden" name="image" value="<?php echo $book['image']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="book_rent" value="<?php echo $book['book_rent']; ?>">
            <button type="submit" class="mt-2 bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">
              ADD TO CART
            </button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

</div>

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

  <div id="toast-success" class="fixed bottom-5 left-1/2 transform -translate-x-1/2 z-50 hidden p-4 w-80 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-lg transition-opacity duration-300">
  <div class="flex items-center justify-between">
    <span><strong class="font-semibold">Success!</strong> Book added to cart successfully.</span>
    <button onclick="hideToast()" class="ml-4 text-green-700 hover:text-green-900">&times;</button>
  </div>
</div>

  <script>
    
  function handleFormSubmit(event, form) {
    event.preventDefault(); // temporarily stop form submission
    showToast(); // show success message

    setTimeout(() => {
      form.submit(); // submit form after delay
    }, 1000); // delay in milliseconds
  }

  function showToast() {
    const toast = document.getElementById('toast-success');
    toast.classList.remove('hidden');
    setTimeout(() => hideToast(), 3000);
  }

  function hideToast() {
    const toast = document.getElementById('toast-success');
    toast.classList.add('hidden');
  }

  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  menuToggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
</script>
<script>
  function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('hidden');
  }

  // Optional: close dropdown if user clicks outside
  window.addEventListener('click', function(e) {
    const button = document.querySelector('button[onclick="toggleDropdown()"]');
    const menu = document.getElementById('dropdownMenu');
    if (!button.contains(e.target) && !menu.contains(e.target)) {
      menu.classList.add('hidden');
    }
  });
</script>

</body>
</html>
