<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ideas - Suit Media</title>
  <link rel="stylesheet" href="style.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    nav a.active {
      border-bottom: 2px solid white;
      padding-bottom: 0.25rem;
    }
  </style>
</head>
<body class="bg-white text-gray-800 font-sans">

  <!-- Header Navigation -->
  <header class="bg-[#fe6200] px-6 md:px-12 py-4 flex items-center justify-between sticky top-0 z-30">
    <div class="flex items-center space-x-2">
      <div class="text-white font-black text-xl select-none" aria-label="Suit Media logo container">
        <!-- Logo -->
        <img src="site-logo(1).png" alt="Suitmedia Logo" class="h-5 md:h-6 object-contain">
      </div>
    </div>

    <!-- Navigation -->
    <nav class="text-white text-sm font-semibold space-x-8 hidden md:flex" aria-label="Primary">
      <a href="?view=work.php">Work</a>
      <a href="?view=about.php">About</a>
      <a href="?view=services.php">Services</a>
      <a href="?view=ideas.php">Ideas</a>
      <a href="?view=careers.php">Careers</a>
      <a href="?view=contact.php">Contact</a>
    </nav>

  </header>

  <!-- isi konteb -->
  <main id="content">
    <?php
      
      $page = $_GET['view'] ?? 'ideas.php';
      $allowedPages = ['work.php', 'about.php', 'services.php', 'ideas.php', 'careers.php', 'contact.php'];

      if (in_array($page, $allowedPages)) {
        include $page;
      } else {
        echo "<p class='text-red-500 p-4'>Halaman tidak ditemukan.</p>";
      }
    ?>
  </main>

<script src="script.js"></script>

</body>
</html>
