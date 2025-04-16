</div>
</div>

<footer class="py-3 bg-white border-top sticky-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <span class="fw-bold fs-5 me-2">BookSync</span>
                    <span class="text-muted">© 2025 All rights reserved</span>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-decoration-none text-muted me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="View our privacy policy">Privacy Policy</a>
                <a href="#" class="text-decoration-none text-muted me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Read our terms of service">Terms of Service</a>
                <a href="#" class="text-decoration-none text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Get in touch with us">Contact Us</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Initialize Tooltips -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize dropdowns
        var dropdownTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
        dropdownTriggerList.forEach(function(dropdownTriggerEl) {
            new bootstrap.Dropdown(dropdownTriggerEl);
        });

        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');

        // Check for saved state
        const sidebarState = localStorage.getItem('sidebarState');
        if (sidebarState === 'collapsed') {
            sidebar.classList.add('collapsed');
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();

                // Toggle sidebar state
                sidebar.classList.toggle('collapsed');

                // Save state to localStorage
                if (sidebar.classList.contains('collapsed')) {
                    localStorage.setItem('sidebarState', 'collapsed');
                } else {
                    localStorage.setItem('sidebarState', 'expanded');
                }

                // Update tooltips on sidebar items when collapsed
                const tooltips = document.querySelectorAll('.sidebar [data-bs-toggle="tooltip"]');
                tooltips.forEach(tooltip => {
                    const instance = bootstrap.Tooltip.getInstance(tooltip);
                    if (instance) {
                        instance.dispose();
                    }

                    // Re-initialize with appropriate placement based on sidebar state
                    new bootstrap.Tooltip(tooltip, {
                        placement: sidebar.classList.contains('collapsed') ? 'right' : 'right',
                        trigger: 'hover'
                    });
                });
            });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="assets/js/utility/toast-notifications.js"></script>
<script src="assets/js/utility/form-handler.js"></script>

</body>

</html>