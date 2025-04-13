<!-- User Sidebar -->
<div class="sidebar bg-light" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-book d-none d-sidebar-collapsed-block"></i>
        <h5 class="mb-0">Book Reader</h5>
    </div>
    <ul class="nav flex-column">
        <?php
        // Define sidebar links with their icons and URLs
        $user_links = [
            ['title' => 'Dashboard', 'icon' => 'tachometer-alt', 'url' => 'user_dashboard.php'],
            ['title' => 'Browse Books', 'icon' => 'books', 'url' => 'browse_books.php'],
            ['title' => 'My Reading Sessions', 'icon' => 'book-open', 'url' => 'reading_session.php'],
            ['title' => 'Wishlist', 'icon' => 'heart', 'url' => 'wishlist.php'],
            ['title' => 'My Purchases', 'icon' => 'shopping-bag', 'url' => 'my_purchases.php'],
            ['title' => 'Profile', 'icon' => 'user-circle', 'url' => 'user_profile.php'],
            ['title' => 'Logout', 'icon' => 'sign-out-alt', 'url' => 'logout.php']
        ];

        // Get current page filename
        $current_page = basename($_SERVER['PHP_SELF']);

        // Display each link
        foreach ($user_links as $link) {
            $active = (strpos($current_page, basename($link['url'])) !== false) ? 'active' : '';
            echo '<li class="nav-item">';
            echo '<a class="nav-link ' . $active . '" href="' . $link['url'] . '" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="' . $link['title'] . '">';
            echo '<i class="fas fa-' . $link['icon'] . '"></i>';
            echo '<span>' . $link['title'] . '</span>';
            echo '</a>';
            echo '</li>';
        }
        ?>
    </ul>
</div>