<!-- Sidebar -->
<div class="col-md-2 sidebar">
    <div class="position-sticky">
        <div class="avatar-wrapper">
            <img src="https://ui-avatars.com/api/?name=Admin+User&background=1a2236&color=fff" alt="Admin" class="avatar">
            <div class="user-info">
                <div class="user-name">Admin User</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>

        <hr class="my-2">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin-dashboard.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="View admin dashboard">
                    <i class="fas fa-tachometer-alt"></i> <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <div class="sidebar-heading mt-3">User Management</div>
            <li class="nav-item">
                <a href="/admin/user-management" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin-users.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Manage system users">
                    <i class="fas fa-users"></i> <span class="menu-text">User Management</span>
                </a>
            </li>

            <div class="sidebar-heading mt-3">Content</div>
            <li class="nav-item">
                <a href="admin-books.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin-books.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Manage book inventory">
                    <i class="fas fa-book"></i> <span class="menu-text">Book Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="admin-reading-sessions.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin-reading-sessions.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="View all reading sessions">
                    <i class="fas fa-glasses"></i> <span class="menu-text">Reading Sessions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="admin-purchases.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin-purchases.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Manage book purchases">
                    <i class="fas fa-shopping-cart"></i> <span class="menu-text">Purchases</span>
                </a>
            </li>

            <div class="sidebar-heading mt-3">System</div>
            <li class="nav-item">
                <a href="admin-activity-log.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin-activity-log.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="View system activity logs">
                    <i class="fas fa-history"></i> <span class="menu-text">Activity Log</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/logout" class="nav-link" data-bs-toggle="tooltip" data-bs-placement="right" title="Log out from admin panel">
                    <i class="fas fa-sign-out-alt"></i> <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>