<!-- Admin Sidebar -->
<div class="sidebar bg-dark text-white" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-user-shield d-none d-sidebar-collapsed-block"></i>
        <h5 class="mb-0">Book Admin</h5>
    </div>
    <ul class="nav flex-column">
        <?php
        // Define sidebar links with their icons and URLs
        $admin_links = [
            ['title' => 'Dashboard', 'icon' => 'tachometer-alt', 'url' => 'dashboard.php'],
            ['title' => 'User Management', 'icon' => 'users', 'url' => 'user_management.php'],
            ['title' => 'Book Management', 'icon' => 'book', 'url' => 'book_management.php'],
            ['title' => 'Reading Sessions', 'icon' => 'history', 'url' => 'reading_sessions.php'],
            ['title' => 'Purchases', 'icon' => 'shopping-cart', 'url' => 'purchases.php'],
            ['title' => 'Activity Log', 'icon' => 'clipboard-list', 'url' => 'activity_log.php'],
            ['title' => 'Logout', 'icon' => 'sign-out-alt', 'url' => 'logout.php']
        ];

        // Get current page filename
        $current_page = basename($_SERVER['PHP_SELF']);

        // Display each link
        foreach ($admin_links as $link) {
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