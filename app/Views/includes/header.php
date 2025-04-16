<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #5469d4;
            --primary-light: #e6ebff;
            --secondary-color: #1a2236;
            --accent-color: #4caf93;
            --light-gray: #f8f9fa;
            --border-radius: 0.5rem;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
        }

        html {
        scroll-behavior: smooth;
        }

        /* Base Styles */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        /* Navbar Styles */
        .navbar {
            box-shadow: var(--box-shadow);
            background-color: white !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            z-index: 100px;
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--secondary-color) !important;
        }

        .navbar .nav-link {
            color: #495057 !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .navbar .nav-link:hover {
            color: var(--primary-color) !important;
        }

        /* Layout Styles */
        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }

        .container-fluid>.d-flex {
            min-height: unset; /* Remove this min-height constraint */
        }

        .content {
            flex: 1;
            transition: var(--transition);
            padding: 1.5rem;
            overflow-y: auto;
        }

        

        /* Sidebar Styles */
        .sidebar {
            background-color: white;
            box-shadow: var(--box-shadow);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            overflow-y: auto;
            padding-top: 0.4rem;
            padding-left: 16px;
            width: var(--sidebar-width);
            flex-shrink: 0;
            min-height: unset; /* Remove the min-height: 100vh */
            height: auto;
            top: 0;
            overflow-y: auto;
            max-height: 200vh;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .user-info,
        .sidebar.collapsed .sidebar-heading {
            display: none;
        }

        .sidebar.collapsed .avatar-wrapper {
            padding: 0.75rem 0;
            padding-left: 6px;
        }

        .sidebar.collapsed .avatar {
            width: 40px;
            height: 40px;
        }

        .sidebar.collapsed .nav-link {
            text-align: center;
            padding: 0.75rem 0;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        .content.expanded {
            width: calc(100% - var(--sidebar-collapsed-width));
            margin-left: var(--sidebar-collapsed-width);
        }

        .sidebar .nav-link {
            color: #495057;
            padding: 0.75rem 1.25rem;
            border-radius: var(--border-radius);
            margin: 0.25rem 0.75rem;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            min-width: 24px;
            margin-right: 10px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-light);
            color: var(--primary-color);
            font-weight: 600;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            font-weight: 700;
            padding: 0.75rem 1.25rem;
            color: #8697a8;
        }

        /* User Profile */
        .avatar-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 1rem;
            transition: var(--transition);
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 3px solid white;
            transition: var(--transition);
        }

        .user-info {
            margin-top: 0.75rem;
            text-align: center;
            transition: var(--transition);
        }

        .user-name {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.25rem;
        }

        .user-role {
            font-size: 0.85rem;
            color: #8697a8;
        }

        /* Cards & Components */
        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            height: 100%;
        }

        .card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
        }

        .card-title {
            margin-bottom: 0;
            font-weight: 600;
            color: var(--secondary-color);
        }

        .stat-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            height: 100%;
        }

        .stat-card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-bottom: 1rem;
        }

        .stat-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #8697a8;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
        }

        /* Tables & Lists */
        .table {
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .table thead th {
            background-color: var(--light-gray);
            font-weight: 600;
            color: var(--secondary-color);
            border-top: none;
            padding: 0.75rem 1rem;
        }

        .list-group-item {
            border: none;
            border-radius: var(--border-radius) !important;
            margin-bottom: 0.5rem;
            padding: 1rem;
            transition: var(--transition);
        }

        .list-group-item:hover {
            background-color: var(--light-gray);
        }

        /* Buttons & Interactive Elements */
        .btn {
            border-radius: var(--border-radius);
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #4258c5;
            border-color: #4258c5;
        }

        #sidebarToggle {
            background-color: transparent;
            border: none;
            color: #495057;
            padding: 0.5rem;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #sidebarToggle:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        .dropdown-menu {
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        footer {
            margin-top: auto;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
                position: fixed;
                z-index: 1000;
                height: 100%;
            }

            .sidebar.expanded {
                margin-left: 0;
            }

            .content {
                width: 100%;
                margin-left: 0;
            }

            .sidebar.collapsed {
                margin-left: calc(-1 * var(--sidebar-collapsed-width));
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container-fluid me-2">
            <button id="sidebarToggle" class="btn ms-2 me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand" href="/">BookSync</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex ms-auto me-3">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View notifications">
                            <i class="fas fa-bell"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=5469d4&color=fff" class="rounded-circle me-2" width="32" height="32" alt="User">
                            <span>Account</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php" data-bs-toggle="tooltip" data-bs-placement="left" title="View your profile"><i class="fas fa-user me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="settings.php" data-bs-toggle="tooltip" data-bs-placement="left" title="Change your settings"><i class="fas fa-cog me-2"></i> Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/logout" data-bs-toggle="tooltip" data-bs-placement="left" title="Log out of your account"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="d-flex">