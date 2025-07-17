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
        <!-- SVG Logo -->
        <svg width="86" height="20" viewBox="0 0 86 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path fill="#fff" d="M18 19H10v-1h8v1zm-6-3v-2a6 6 0 0 0-5-5.9v-1.2c3.5.5 5.1 3.5 5.5 5H18a7 7 0 0 0-6-6.88v-1.1h2v-1H8v1h2v1.08a7 7 0 0 0-5 5.92v2h2v-2a5 5 0 0 1 5-5v3h-2v1h7v-1a5 5 0 0 1 6 5v1h-2v-1a3 3 0 0 0-4-2.83V16h2v1z"/>
          <path fill="#fff" d="M27 13h3v6h-3zM30 14h6v1h-6zM39 19v-2a4 4 0 1 1 5 3.85V19zM44 17v-2a4 4 0 1 1 5 3.85V19zM51 15h4v4h-4zM56 16h6v1h-6zM66 19v-4a5 5 0 0 1 7-4.64v2.07a3 3 0 0 0-2 2.57v3h-5z"/>
          <path fill="#fff" d="M72 19v-5a1 1 0 0 0-2 0v5H67v-10h3v4a1 1 0 0 0 2 0v-4h3v10z"/>
          <path fill="#fff" d="M82 15v-1a2 2 0 1 0-2 2v4h-3v-10h3v4a1 1 0 0 0 2 0v-4h3v10z"/>
        </svg>
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

  <!-- Konten akan dimuat di sini -->
  <main id="content">
    <?php
      // Tentukan halaman aktif berdasarkan query string
      $page = $_GET['view'] ?? 'ideas.php';
      $allowedPages = ['work.php', 'about.php', 'services.php', 'ideas.php', 'careers.php', 'contact.php'];

      // Keamanan: hanya allow file tertentu
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
