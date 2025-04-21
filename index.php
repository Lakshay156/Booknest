<?php

include 'db_connection.php';
session_start();
$books_count = $_SESSION['borrowed_count'] ?? 0;


$query = "SELECT * FROM popular_books ORDER BY borrow_count DESC LIMIT 10";
$result = mysqli_query($conn, $query);

$popularBooks = [];
while ($row = mysqli_fetch_assoc($result)) {
    $popularBooks[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BookNest | Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .hover-scale {
      transition: transform 0.3s ease;
    }
    .hover-scale:hover {
      transform: scale(1.05);
    }
    .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }

  </style>
</head>
<body class="  bg-gray-50 text-gray-800">

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
  <a href="bought_books.php" class="hover:text-amber-800 text-lg font-semibold">Borrowed</a>
  <a href="contact.php" class="hover:text-amber-800 text-lg font-semibold">Contact</a>

  <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Username with click to open modal -->
    <span id="user-info-btn" class="cursor-pointer text-amber-800 text-lg font-semibold">
      <?php echo htmlspecialchars($_SESSION['user_name']); ?>
    </span>
    <a href="logout.php" class="bg-red-500 text-white text-lg px-3 py-1 rounded hover:bg-red-600">Logout</a>

    <!-- Modal -->
    <div id="user-modal" class="hidden fixed inset-0  bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white/95  p-6 rounded-lg justify-center items-center shadow-lg h-[300px] w-[500px] relative">
        <button id="close-modal" class="absolute top-2 right-2 text-gray-600 text-xl font-bold">&times;</button>
        <h2 class="text-3xl font-semibold mb-4 text-center text-amber-800 underline">Your Profile Details</h2>
        <p class="text-xl py-2"><strong>Full Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        <p class="text-xl py-2"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p class="text-xl py-2"><strong>Phone:</strong> <?php echo htmlspecialchars($_SESSION['phone']); ?></p>
        <p class="text-xl py-2"><strong>Account Created On: </strong> <?php echo $_SESSION['created']; ?></p>
      </div>
    </div>
  <?php else: ?>
    <a href="login.php" class="bg-amber-800 text-white text-lg px-3 py-1 rounded hover:bg-amber-900">Login</a>
  <?php endif; ?>
</nav>
  </div>
</header>

<!-- Hero Section: Below Sticky Header -->
<section class="relative h-[90vh] overflow-hidden">
  <!-- <img src="https://images.pexels.com/photos/2041540/pexels-photo-2041540.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" -->
  <img src="https://img.freepik.com/free-photo/fairytale-scene-coming-out-book_23-2151778623.jpg?t=st=1745170219~exp=1745173819~hmac=9709ee9f93ca409e781739f481725854cd067167200f8deb729bdc5f695f9bc6&w=1380"

    class="absolute inset-0 w-full h-full object-cover brightness-75 z-0" alt="Hero Background" />
  <div class="relative z-10 h-full flex flex-col justify-center items-center text-white text-center px-4">
    <h2 class="text-4xl md:text-7xl font-bold mb-4 leading-tight">Your Library. Your Way.</h2>
    <p class="text-lg md:text-xl mb-6 max-w-xl">Borrow and explore thousands of books online — fast, free, and easy.</p>
    <a href="books.php" class="bg-white text-amber-600 px-6 py-3 rounded font-semibold hover:bg-gray-100 transition">Browse Books</a>
    <br>

  </div>
  <div id="explore"></div>


</section>
<br>
  <!-- Categories Section -->
<section class="relative py-16 px-4  overflow-hidden bg-cover bg-center z-10" style="background-image: url('https://cdn.prod.website-files.com/604a97c70aee09eed25ce991/61897a35583a9b51db018d3e_MartinPublicSeating-97560-Importance-School-Library-blogbanner1.jpg');">
  
  <!-- Overlay -->
  <div class="absolute inset-0 bg-black opacity-40 blur-sm z-0"></div>

  <!-- Heading -->
  <div class="relative z-10 flex justify-center items-center">
    <h1 class="text-4xl font-bold text-center mb-8 bg-white/90 rounded-lg inline-block px-6 py-8 transform transition duration-300 hover:scale-110 hover:shadow-xl">
      🧠 Browse Our Categories
    </h1>
  </div>

  <br><br><br>

  <!-- Category Cards -->
  <div class="relative z-10 overflow-x-auto  scrollbar-hide" id="scroll-wrapper">
    <div id="scroll-content" class="flex space-x-12 pb-6 scrollbar-hide">

      <!-- Fiction -->
      <a href="books.php?category=Fiction">
        <div class="min-w-[400px] max-w-sm bg-white/80 rounded-2xl shadow-lg transform transition duration-300 hover:scale-110 hover:shadow-xl hover:bg-yellow-100">
          <img class="w-full h-[300px] object-cover rounded-t-2xl" src="https://cdn.dribbble.com/userupload/26650664/file/original-5042a2da9685bf3543e23fe0dbc644d9.gif" alt="Fiction">
          <div class="p-10">
            <h2 class="text-xl font-semibold text-gray-800">Fiction</h2>
            <p class="text-gray-600 mt-4">Explore a world of imagination and creativity with Fiction books.</p>
          </div>
        </div>
      </a>

      <!-- Science -->
      <a href="books.php?category=Science">
        <div class="min-w-[400px] max-w-sm bg-white/80 rounded-2xl shadow-lg transform transition duration-300 hover:scale-110 hover:shadow-xl hover:bg-blue-100">
          <img class="w-full h-[300px] object-cover rounded-t-2xl" src="https://edusmart-website.s3.amazonaws.com/images/homepage/home-1.gif" alt="Science">
          <div class="p-10">
            <h2 class="text-xl font-semibold text-gray-800">Science</h2>
            <p class="text-gray-600 mt-4">Discover the wonders of the universe and the world of science.</p>
          </div>
        </div>
      </a>

      <!-- Biography -->
      <a href="books.php?category=Biography">
        <div class="min-w-[400px] max-w-sm bg-white/80 rounded-2xl shadow-lg transform transition duration-300 hover:scale-110 hover:shadow-xl hover:bg-green-100">
          <img class="w-full h-[300px] object-cover rounded-t-2xl" src="https://files.askiitians.com/cdn1/images/2014106-1405299-1283-tumblr_mve89xajw21s9j08jo1_500.gif" alt="Biography">
          <div class="p-10">
            <h2 class="text-xl font-semibold text-gray-800">Biography</h2>
            <p class="text-gray-600 mt-4">Get inspired by the lives and stories of famous personalities.</p>
          </div>
        </div>
      </a>

      <!-- Technology -->
      <a href="books.php?category=Technology">
        <div class="min-w-[400px] max-w-sm bg-white/80 rounded-2xl shadow-lg transform transition duration-300 hover:scale-110 hover:shadow-xl hover:bg-indigo-100">
          <img class="w-full h-[300px] object-cover rounded-t-2xl" src="https://media1.tenor.com/m/ueCTt_UQF2EAAAAd/innovation-future.gif" alt="Technology">
          <div class="p-10">
            <h2 class="text-xl font-semibold text-gray-800">Technology</h2>
            <p class="text-gray-600 mt-4">Explore the advancements and innovations in the field of technology.</p>
          </div>
        </div>
      </a>

      <!-- Self-Help -->
      <a href="books.php?category=Self-Help">
        <div class="min-w-[400px] max-w-sm bg-white/80 rounded-2xl shadow-lg transform transition duration-300 hover:scale-110 hover:shadow-xl hover:bg-pink-100">
          <img class="w-full h-[300px] object-cover rounded-t-2xl" src="https://cdn.prod.website-files.com/61cb94e5fee3d491ca9aa59c/61cb94e5fee3d4055c9aa6fb_self-care-during-busy-work-week.gif" alt="Self-Help">
          <div class="p-10">
            <h2 class="text-xl font-semibold text-gray-800">Self-Help</h2>
            <p class="text-gray-600 mt-4">Find guidance and inspiration for personal growth and development.</p>
          </div>
        </div>
      </a>

      <!-- Children -->
      <a href="books.php?category=Children">
        <div class="min-w-[400px] max-w-sm bg-white/80 rounded-2xl shadow-lg transform transition duration-300 hover:scale-110 hover:shadow-xl hover:bg-teal-100">
          <img class="w-full h-[300px] object-cover rounded-t-2xl" src="https://i.pinimg.com/originals/10/e0/93/10e0938774f51bc442180a6854454ac5.gif" alt="Children">
          <div class="p-10">
            <h2 class="text-xl font-semibold text-gray-800">Children</h2>
            <p class="text-gray-600 mt-4">Delight in the world of stories and learning for young minds.</p>
          </div>
        </div>
      </a>
    </div>
  </div>
</section>

<br>

<!-- Popular Books -->
<section class="relative py-16 px-4 bg-cover bg-center" style="background-image: url('https://i.ibb.co/zVX33yH3/freepicdownloader-com-book-is-open-book-table-with-words-word-book-large.jpg5');">
  <!-- Blurred Dark Overlay -->
  <div class="absolute inset-0 bg-black opacity-50 filter blur-sm z-0"></div>

  <!-- Heading -->
  <div class="relative z-10 text-center mb-12">
    <h2 class="text-4xl font-bold bg-white/90 px-8 py-8 rounded-xl inline-block hover:scale-110 transition duration-300 shadow-lg">
      📚 Most Borrowed Books
    </h2>
  </div>

  <!-- Grid of Book Cards -->
  <div class="relative z-10 grid gap-x-10 gap-y-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
    <?php foreach ($popularBooks as $book): ?>
      <div class="w-full h-[380px] bg-white/80 rounded-2xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-yellow-100 overflow-hidden">
        <img src="<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?>" class="h-[200px] w-full object-cover rounded-t-2xl">
        <div class="p-4">
          <h3 class="font-semibold text-lg truncate"><?php echo $book['title']; ?></h3>
          <p class="text-gray-600 text-sm mb-2 truncate">by <?php echo $book['author']; ?></p>
          <h4 class=" text-sm truncate">Borrow Count : <?php echo $book['borrow_count']; ?></h4>
          <h4 class="font-semibold text-red-600 text-lg truncate">Book Rent : ₹<?php echo $book['book_rent']; ?></h4>
          <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="books_id" value="<?php echo $book['books_id']; ?>">
            <input type="hidden" name="title" value="<?php echo $book['title']; ?>">
            <input type="hidden" name="author" value="<?php echo $book['author']; ?>">
            <input type="hidden" name="image" value="<?php echo $book['image']; ?>">
            <input type="hidden" name="borrow_count" value="<?php echo $book['borrow_count']; ?>">
            <input type="hidden" name="book_rent" value="<?php echo $book['book_rent']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <button type="submit" class="mt-2 bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">
              ADD TO CART
            </button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<br>
  <section class="relative h-[100vh] py-16 px-4 overflow-hidden bg-cover bg-center" style="background-image: url('https://media.npr.org/assets/img/2013/06/11/istock_000010429015medium-7f4dd880ae416af1948761a56023dc94d19f769d.jpg?s=1100&c=50&f=jpeg');">
  <div class="absolute inset-0 bg-black opacity-40 filter blur-lg z-0"></div>     
  <div class="relative z-10 flex justify-center items-center">
    <h1 class="text-4xl font-bold text-center mb-8 bg-white/90 rounded-lg inline-block px-6 py-8 transform transition duration-300 hover:scale-110 hover:shadow-xl">
    What Our Readers Say
    </h1>
  </div>
<br><br><br>
    <div class="max-w-4xl mx-auto grid sm:grid-cols-2 gap-8">
      <div class="bg-gray-50 p-6 rounded shadow-lg transform transition duration-300 text-left hover:scale-110">
        <div class="flex items-center gap-4 mb-4">
          <img src="https://randomuser.me/api/portraits/women/79.jpg" class="w-12 h-12 rounded-full" alt="Aditi Sharma">
          <span class="font-semibold">Aditi Sharma</span>
        </div>
        <p>"I don’t read a lot, but this site made it really easy to try new titles. I borrowed The Alchemist on a friend’s suggestion, and now I’m hooked. 10/10 for the user experience!"</p>
      </div>
      <div class="bg-gray-50 p-6 rounded shadow transform transition duration-300 hover:scale-110 hover:shadow-xl">
        <div class="flex items-center gap-4 mb-4">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-12 h-12 rounded-full" alt="Ravi Joshi">
          <span class="font-semibold">Ravi Joshi</span>
        </div>
        <p>"From fiction to biographies, this site has every genre I crave. The borrowing system is reliable and quick, and I love the recommendations section. It's a paradise for any true book lover!"</p>
      </div>
      <div class="bg-gray-50 p-6 rounded shadow transform transition duration-300 hover:scale-110 hover:shadow-xl">
        <div class="flex items-center gap-4 mb-4">
          <img src="https://randomuser.me/api/portraits/women/49.jpg" class="w-12 h-12 rounded-full" alt="Ravi Joshi">
            <span class="font-semibold">Aanya Verma</span>
        </div>
        <p>"Absolutely love this platform! The book collection is diverse and always up-to-date. I borrowed Atomic Habits last week, and the process was so smooth. Already eyeing my next read!"</p>
      </div>
     <div class="bg-gray-50 p-6 rounded shadow transform transition duration-300 hover:scale-110 hover:shadow-xl">
        <div class="flex items-center gap-4 mb-4">
          <img src="https://randomuser.me/api/portraits/men/22.jpg" class="w-12 h-12 rounded-full" alt="Ravi Joshi">
          <span class="font-semibold"> Rohit Sinha</span>
        </div>
        <p>"Super clean interface and fast loading! I appreciate how easy it is to search, add to cart, and track borrowed books. Feels like the Netflix of books!"</p>
      </di>
    </div>
  </section>
<br>

<!-- About us -->

<section class="relative min-h-[90vh] py-16 px-4 overflow-hidden bg-cover bg-center" style="background-image: url('https://www.codemotion.com/magazine/wp-content/uploads/2023/07/Collaborative-Coding.-A-developer-team-working-together.-min.jpg');">
  <div class="absolute inset-0 bg-black opacity-40 filter blur-sm z-0"></div>

  <div class="relative z-10 max-w-6xl mx-auto">
  <div class="relative z-10 flex justify-center items-center">
    <h1 class="text-4xl font-bold text-center mb-8 bg-white/90 rounded-lg inline-block px-6 py-8 transform transition duration-300 hover:scale-110 hover:shadow-xl">
      Meet Our Team
    </h1>
  </div>
  <br>
    <!-- Your Card -->
    <div class="flex justify-center mb-12">
      <a href="https://www.linkedin.com/in/lakshay156?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-2xl w-full max-w-2xl transform transition duration-300 hover:scale-105 hover:shadow-2xl text-center">
        <img src="https://i.ibb.co/0VjdzSbH/lakshay.jpg" alt="Lakshay" class="w-32 h-32 mx-auto rounded-full border-4 border-amber-600 mb-4 shadow">
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Lakshay</h3>
        <p class="text-gray-700 text-md">Lead Developer & Designer of BookNest. Handles full-stack web development and user interface architecture.</p>
      </a>
    </div>
<br>
    <!-- Other Team Members -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <!-- Member 1 -->
      <a href="https://www.linkedin.com/in/shailendra-kumar-chaudhary-42a880294?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" class="bg-white/80 p-6 rounded-2xl shadow-xl text-center hover:scale-105 transform transition duration-300">
        <img src="https://i.ibb.co/TBb1QKry/shailu.jpg" alt="Shailendra" class="w-20 h-20 mx-auto rounded-full mb-4 border-4 border-pink-500">
        <h4 class="text-xl font-semibold text-gray-800">Shailendra Kumar Chaudhary</h4>
        <p class="text-gray-700 text-sm mt-2">Managed content sourcing and book curation. Helped categorize books into genres.</p>
      </a>

      <!-- Member 2 -->
      <a href="https://www.linkedin.com/in/anjali-shrivastava-869aab297?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" class="bg-white/80 p-6 rounded-2xl shadow-xl text-center hover:scale-105 transform transition duration-300">
        <img src="https://i.ibb.co/svcYzgWg/anjali.jpg" alt="Aman Verma" class="w-20 h-20 mx-auto rounded-full mb-4 border-4 border-green-500">
        <h4 class="text-xl font-semibold text-gray-800">Anjali Shrivastava</h4>
        <p class="text-gray-700 text-sm mt-2">Worked on backend logic for cart, borrowing, and login system in PHP and MySQL.</p>
      </a>

      <!-- Member 3 -->
      <a href="https://www.linkedin.com/in/samar-bhati-4aa2a7298?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" class="bg-white/90 p-6 rounded-2xl shadow-xl text-center hover:scale-105 transform transition duration-300">
        <img src="https://i.ibb.co/V09BDFLp/samar.jpg" alt="Neha Khurana" class="w-20 h-20 mx-auto rounded-full mb-4 border-4 border-purple-500">
        <h4 class="text-xl font-semibold text-gray-800">Samar Bhati</h4>
        <p class="text-gray-700 text-sm mt-2">Led the testing and deployment phase, ensuring every feature worked as expected.</p>
      </a>
    </div>
  </div>
</section>


<br>


 
  <!-- Newsletter -->
  <section class="relative py-20 px-4 text-center bg-cover bg-center" style="background-image: url('https://cdn.shopify.com/s/files/1/0070/7032/files/email-newsletter-design.png?v=1678232473&originalWidth=1848&originalHeight=782&width=1800');">
  <!-- Dark overlay -->
  <div class="absolute inset-0 bg-black opacity-50 z-0"></div>

  <!-- Content -->
  <div class="relative z-10 max-w-2xl mx-auto bg-white/80 backdrop-blur-md p-10 rounded-xl shadow-xl">
    <h3 class="text-3xl font-bold text-gray-900 mb-4">📬 Stay Updated</h3>
    <p class="text-gray-700 mb-6">Subscribe to our newsletter to get the latest updates, book arrivals, and top recommendations delivered to your inbox.</p>
    
    <form class="flex flex-col sm:flex-row items-center justify-center gap-4">
      <input type="email" placeholder="Enter your email" class="border border-gray-300 px-4 py-2 rounded-lg w-full sm:w-2/3 focus:outline-none focus:ring-2 focus:ring-amber-500" required />
      <button class="bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition">Subscribe</button>
    </form>
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



  <script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
      const menu = document.getElementById("mobile-menu");
      menu.classList.toggle("hidden");
    });
  </script>
  <script>
  const container = document.getElementById('scroll-wrapper');
  const content = document.getElementById('scroll-content');

  // Duplicate content for seamless looping
  content.innerHTML += content.innerHTML;
  // Watch scroll position and reset when needed
  container.addEventListener('scroll', () => {
    const half = content.scrollWidth / 2;
    
    if (container.scrollLeft <= 0) {
      container.scrollLeft = half;
    } else if (container.scrollLeft >= content.scrollWidth - container.clientWidth) {
      container.scrollLeft = half - container.clientWidth;
    }
  });
</script>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>

<script>
  const userBtn = document.getElementById("user-info-btn");
  const modal = document.getElementById("user-modal");
  const closeModal = document.getElementById("close-modal");

  if (userBtn && modal && closeModal) {
    userBtn.addEventListener("click", () => {
      modal.classList.remove("hidden");
    });

    closeModal.addEventListener("click", () => {
      modal.classList.add("hidden");
    });

    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.classList.add("hidden");
      }
    });
  }
</script>

</body>
</html>
