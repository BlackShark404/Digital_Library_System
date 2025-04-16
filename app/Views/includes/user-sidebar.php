<!-- Sidebar -->
<div class="col-md-2 sidebar">
    <div class="avatar-wrapper">
        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode(isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User'); ?>&background=5469d4&color=fff" alt="User" class="avatar">
        <div class="user-info">
            <div class="user-name"><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User'; ?></div>
            <div class="user-role">Reader</div>
        </div>
    </div>

    <hr class="my-2">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'user-dashboard.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="View your dashboard">
                <i class="fas fa-tachometer-alt"></i> <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="browse-books.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'browse-books.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Browse all available books">
                <i class="fas fa-book-open"></i> <span class="menu-text">Browse Books</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="reading-sessions.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'reading-sessions.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="View your reading history">
                <i class="fas fa-glasses"></i> <span class="menu-text">My Reading Sessions</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="wishlist.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'wishlist.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Manage your wishlist">
                <i class="fas fa-heart"></i> <span class="menu-text">Wishlist</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="purchases.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'purchases.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="View your purchase history">
                <i class="fas fa-shopping-cart"></i> <span class="menu-text">My Purchases</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="profile.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Edit your profile information">
                <i class="fas fa-user"></i> <span class="menu-text">Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="/logout" class="nav-link" data-bs-toggle="tooltip" data-bs-placement="right" title="Log out from your account">
                <i class="fas fa-sign-out-alt"></i> <span class="menu-text">Logout</span>
            </a>
        </li>
    </ul>
</div>