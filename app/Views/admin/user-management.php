<?php include $headerPath; ?>

<div class="container-fluid">
    <div class="row">
        <?php include $sidebarPath; ?>

        <!-- Main Content -->
        <div class="col-md-10 content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                <h1 class="h2">User Management</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-user-plus me-1"></i> Add New User
                    </button>
                </div>
            </div>

            <!-- Filter & Search Row -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search users by name, email, or role...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex justify-content-end">
                        <select class="form-select me-2" style="max-width: 150px;">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="librarian">Librarian</option>
                            <option value="member">Member</option>
                        </select>
                        <select class="form-select" style="max-width: 150px;">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-hover align-middle">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- User 1 -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=John+Smith&background=5469d4&color=fff" class="rounded-circle me-2" width="40" height="40" alt="User">
                                            <div>
                                                <div class="fw-medium">John Smith</div>
                                                <small class="text-muted">ID: #1001</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>john.smith@example.com</td>
                                    <td><span class="badge bg-primary-subtle text-primary">Admin</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>2025-01-15</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> View Details</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-ban me-2"></i> Suspend</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!-- User 2 -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=4caf93&color=fff" class="rounded-circle me-2" width="40" height="40" alt="User">
                                            <div>
                                                <div class="fw-medium">Sarah Johnson</div>
                                                <small class="text-muted">ID: #1002</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>sarah.johnson@example.com</td>
                                    <td><span class="badge bg-success-subtle text-success">Librarian</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>2025-01-20</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> View Details</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-ban me-2"></i> Suspend</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!-- User 3 -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=David+Lee&background=4299e1&color=fff" class="rounded-circle me-2" width="40" height="40" alt="User">
                                            <div>
                                                <div class="fw-medium">David Lee</div>
                                                <small class="text-muted">ID: #1003</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>david.lee@example.com</td>
                                    <td><span class="badge bg-warning-subtle text-warning">Member</span></td>
                                    <td><span class="badge bg-secondary">Inactive</span></td>
                                    <td>2025-02-05</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> View Details</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                                <li><a class="dropdown-item text-success" href="#"><i class="fas fa-check me-2"></i> Activate</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!-- User 4 -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Emily+Garcia&background=ed8936&color=fff" class="rounded-circle me-2" width="40" height="40" alt="User">
                                            <div>
                                                <div class="fw-medium">Emily Garcia</div>
                                                <small class="text-muted">ID: #1004</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>emily.garcia@example.com</td>
                                    <td><span class="badge bg-warning-subtle text-warning">Member</span></td>
                                    <td><span class="badge bg-danger">Suspended</span></td>
                                    <td>2025-02-10</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> View Details</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                                <li><a class="dropdown-item text-success" href="#"><i class="fas fa-check me-2"></i> Activate</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!-- User 5 -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Michael+Chen&background=5469d4&color=fff" class="rounded-circle me-2" width="40" height="40" alt="User">
                                            <div>
                                                <div class="fw-medium">Michael Chen</div>
                                                <small class="text-muted">ID: #1005</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>michael.chen@example.com</td>
                                    <td><span class="badge bg-success-subtle text-success">Librarian</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>2025-02-15</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> View Details</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-ban me-2"></i> Suspend</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- End of Main Content -->
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add the ID attribute to the form -->
                <form id="addUserForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="fname" required>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lname" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="librarian">Librarian</option>
                                <option value="member">Member</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="is_active" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addUserForm" class="btn btn-primary">Add User</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="assets/js/utility/toast-notifications.js"></script>
    <script src="assets/js/utility/formSubmit.js"></script>
    
    <script>
        handleFormSubmission('addUserForm', '/admin/user-management'); 
    </script>

<?php include $footerPath; ?>


