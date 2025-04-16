

<?php
// Start session for user information

// Simulate a logged in user (you would get this from your authentication system)

use Core\Session;


?>

<?php include $headerPath; ?>

<div class="container-fluid">
    <div class="row">
        <?php include $sidebarPath; ?>

        <!-- Main Content -->
        <div class="col-md-10 content ">
            <!-- Welcome Section -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                <h1 class="h2">Welcome back, <?php echo Session::get("user_name"); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Add New Book
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: rgba(84, 105, 212, 0.1); color: #5469d4;">
                            <i class="fas fa-book fa-lg"></i>
                        </div>
                        <div class="stat-title">TOTAL BOOKS</div>
                        <div class="stat-value">1,240</div>
                        <div class="text-success mt-2 small">
                            <i class="fas fa-arrow-up me-1"></i>
                            <span>12% more than last month</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: rgba(76, 175, 147, 0.1); color: #4caf93;">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div class="stat-title">ACTIVE USERS</div>
                        <div class="stat-value">456</div>
                        <div class="text-success mt-2 small">
                            <i class="fas fa-arrow-up me-1"></i>
                            <span>5% more than last month</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: rgba(66, 153, 225, 0.1); color: #4299e1;">
                            <i class="fas fa-glasses fa-lg"></i>
                        </div>
                        <div class="stat-title">READING SESSIONS</div>
                        <div class="stat-value">789</div>
                        <div class="text-success mt-2 small">
                            <i class="fas fa-arrow-up me-1"></i>
                            <span>8% more than last month</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: rgba(237, 137, 54, 0.1); color: #ed8936;">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                        </div>
                        <div class="stat-title">RECENT PURCHASES</div>
                        <div class="stat-value">68</div>
                        <div class="text-danger mt-2 small">
                            <i class="fas fa-arrow-down me-1"></i>
                            <span>3% less than last month</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Recent Books -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Recent Books</h5>
                            <a href="#" class="btn btn-sm btn-link">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 30%">Title</th>
                                            <th style="width: 25%">Author</th>
                                            <th style="width: 20%">Category</th>
                                            <th style="width: 25%">Added Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium text-truncate" style="max-width: 200px;" title="The Great Gatsby">The Great Gatsby</td>
                                            <td>F. Scott Fitzgerald</td>
                                            <td><span class="badge bg-primary-subtle text-primary">Classic</span></td>
                                            <td>2025-03-28</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium text-truncate" style="max-width: 200px;" title="To Kill a Mockingbird">To Kill a Mockingbird</td>
                                            <td>Harper Lee</td>
                                            <td><span class="badge bg-success-subtle text-success">Fiction</span></td>
                                            <td>2025-03-27</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium text-truncate" style="max-width: 200px;" title="1984">1984</td>
                                            <td>George Orwell</td>
                                            <td><span class="badge bg-danger-subtle text-danger">Dystopian</span></td>
                                            <td>2025-03-26</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium text-truncate" style="max-width: 200px;" title="The Hobbit">The Hobbit</td>
                                            <td>J.R.R. Tolkien</td>
                                            <td><span class="badge bg-warning-subtle text-warning">Fantasy</span></td>
                                            <td>2025-03-25</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Recent Activity</h5>
                            <a href="#" class="btn btn-sm btn-link">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item p-3 border-start-0 border-end-0">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background-color: rgba(84, 105, 212, 0.1);">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">New user registered</h6>
                                                <small class="text-muted">3 mins ago</small>
                                            </div>
                                            <p class="mb-1">A new user registered to the system.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of Main Content -->
    </div>
</div>

<?php include $footerPath; ?>