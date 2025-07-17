<?php
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$size = isset($_GET['size']) ? (int) $_GET['size'] : 10;
$sort = isset($_GET['sort']) ? $_GET['sort'] : '-published_at';

$apiURL = "https://suitmedia-backend.suitdev.com/api/ideas?"
        . "page[number]=$page&page[size]=$size"
        . "&append[]=small_image&append[]=medium_image"
        . "&sort=$sort";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json"
]);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$ideas = $data['data'] ?? [];

// echo "<pre>";
// print_r($ideas[0]['medium_image'] ?? 'Tidak ada medium_image');
// echo "</pre>";

$meta = $data['meta'] ?? [];
$currentPage = $meta['current_page'] ?? 1;
$totalPages = $meta['last_page'] ?? 1;
?>

<!-- Hero section -->
<section class="relative aspect-[16/5] md:aspect-[16/4] overflow-hidden" aria-label="Ideas hero banner">
  <div class="absolute inset-0 bg-cover bg-top bg-no-repeat z-0" style="background-image: url('wallhaven-01.jpg');"></div>
  <div class="relative z-10 flex items-center justify-center h-full px-6 text-white text-center">
    <div>
      <h1 class="text-3xl md:text-4xl font-semibold mb-2">Ideas</h1>
      <p class="text-sm md:text-base opacity-80">Where all our great things begin</p>
    </div>
  </div>
  <div class="absolute bottom-0 left-0 w-full h-[75px] z-20 bg-white"
       style="clip-path: polygon(100% 0, 100% 100%, 0 100%);"></div>
</section>

<div class="max-w-7xl mx-auto px-6 md:px-12 pt-12 pb-16">

  <!-- Dropdown -->
  <div class="flex flex-wrap justify-between items-center gap-6 mb-8 text-sm text-gray-600 select-none">
    <div>Showing <?= count($ideas) ?> of <?= $data['meta']['total'] ?? '...' ?></div>
    <div class="flex gap-6 items-center">
      <label for="showPerPage">Show per page:</label>
      <select id="showPerPage" onchange="location.href='?page=<?= $page ?>&size='+this.value+'&sort=<?= $sort ?>';" class="border rounded px-2 py-1">
        <option value="10" <?= $size == 10 ? 'selected' : '' ?>>10</option>
        <option value="20" <?= $size == 20 ? 'selected' : '' ?>>20</option>
        <option value="50" <?= $size == 50 ? 'selected' : '' ?>>50</option>
      </select>

      <label for="sortBy">Sort by:</label>
      <select id="sortBy" onchange="location.href='?page=<?= $page ?>&size=<?= $size ?>&sort='+this.value;" class="border rounded px-2 py-1">
        <option value="-published_at" <?= $sort == '-published_at' ? 'selected' : '' ?>>Newest</option>
        <option value="published_at" <?= $sort == 'published_at' ? 'selected' : '' ?>>Oldest</option>
      </select>
    </div>
  </div>

  <!-- Grid card -->
    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <?php foreach ($ideas as $idea): 
            $title = $idea['title'] ?? 'No title';
            $published = isset($idea['published_at']) ? date("j F Y", strtotime($idea['published_at'])) : '';

            // $image = isset($idea['medium_image'][0]['url']) 
            // ? 'image-proxy.php?url=' . urlencode($idea['medium_image'][0]['url']) 
            // : 'https://placehold.co/600x400?text=No+Image';
            $image = isset($idea['medium_image'][0]['url']) 
            ? $idea['medium_image'][0]['url'] 
            : 'https://placehold.co/600x400?text=No+Image';
        ?>
            <article tabindex="0" class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow duration-200">

            <img 
                src="image-proxy.php?url=<?= urlencode($image) ?>" 
                alt="<?= htmlspecialchars($title) ?>" 
                class="w-full h-40 object-cover" 
                loading="lazy"
            />          


            <div class="p-4">
                <time class="block text-xs text-gray-500 mb-2"><?= htmlspecialchars($published) ?></time>
                <h3 class="text-sm font-semibold text-gray-900 leading-tight line-clamp-3"><?= htmlspecialchars($title) ?></h3>
            </div>
            </article>
        <?php endforeach; ?>
    </section>

  <!-- Pagination -->
  <nav aria-label="Pagination navigation" class="mt-12 flex justify-center space-x-2 text-sm select-none">
    <?php if ($currentPage > 1): ?>
      <a href="?page=1&size=<?= $size ?>&sort=<?= $sort ?>" class="pagination-btn">«</a>
      <a href="?page=<?= $currentPage - 1 ?>&size=<?= $size ?>&sort=<?= $sort ?>" class="pagination-btn">‹</a>
    <?php endif; ?>
    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
      <a href="?page=<?= $i ?>&size=<?= $size ?>&sort=<?= $sort ?>" class="pagination-btn <?= $i == $currentPage ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
    <?php if ($currentPage < $totalPages): ?>
      <a href="?page=<?= $currentPage + 1 ?>&size=<?= $size ?>&sort=<?= $sort ?>" class="pagination-btn">›</a>
      <a href="?page=<?= $totalPages ?>&size=<?= $size ?>&sort=<?= $sort ?>" class="pagination-btn">»</a>
    <?php endif; ?>
  </nav>
</div>
