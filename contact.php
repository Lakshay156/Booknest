<?php
session_start();
$books_count = $_SESSION['borrowed_count'] ?? 0;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BookNest | Contact</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">
<div class="fixed inset-0 bg-[url('https://images.pexels.com/photos/245240/pexels-photo-245240.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')] bg-cover bg-center blur-sm brightness-50 z-[-1]"></div>

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
      
      </a>
      <a href="bought_books.php" class="hover:text-amber-800 text-lg font-semibold ">Borrowed</a>
      <a href="contact.php" class="hover:text-amber-800 text-lg font-semibold">Contact</a>
      <span class="text-amber-800 text-lg font-semibold"><?php echo $_SESSION['user_name']; ?>!</span>
      <a href="logout.php" class="bg-red-500 text-white text-lg px-3 py-1 rounded hover:bg-red-600">Logout</a>
    </nav>
  </div>
</header>

  <section class="max-w-xl mx-auto py-0 px-4">

  <!-- Contact Section -->
  <section class="max-w-xl mx-auto py-16 px-4 ">
  <section class="flex justify-center items-center ">
  <h1 class="text-4xl font-bold text-center mb-4 bg-white/90 rounded-lg inline-block px-20 py-4 transform transition duration-300 hover:scale-110 hover:shadow-xl cursor-default">
        Contact Us
  </h1>
</section>
<br>
    <p class="text-center text-lg text-white mb-8">We'd love to hear from you. Please fill out the form below and we'll get back to you as soon as possible.</p>
    <form class="space-y-6" action="contact-confirmation.html">
    <div>
        <label class="block text-white mb-1 font-medium" for="name"> Name</label>
        <input type="text" id="name" placeholder="Enter Your Name" class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required />
      </div>
      <div>
        <label class="block text-white mb-1 font-medium" for="email">Email</label>
        <input type="email" id="email" placeholder="Enter Your Email" class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required />
      </div>
      <div>
        <label class="block text-white mb-1 font-medium" for="name">Contact Number</label>
        <input type="tel" name="mobile" pattern="[0-9]{10}" maxlength="10" class="w-full border rounded-r px-3 py-2 transition duration-200 ease-in-out hover:shadow-md" placeholder="Enter your mobile number" required />
        </div>
      <div>
        <label class="block text-white text-whiten mb-1 font-medium" for="message">Message</label>
        <textarea id="message" placeholder="Your Message......" class="w-full border border-gray-300 px-3 py-2 rounded h-32 focus:outline-none focus:ring-2 focus:ring-indigo-400" required></textarea>
      </div>
      <button type="submit" class="w-full bg-orange-600 text-white px-4 py-2 rounded hover:bg-amber-800 transition">Send Message</button>
    </form>
  </section>


</section>

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

  <!-- Mobile Navigation Toggle Script -->
  <script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    menuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>

</body>
</html>