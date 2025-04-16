// Reusable function to handle form submission with Axios
function handleFormSubmission(formId, actionUrl) {
    // Select the form element
    const form = document.getElementById(formId);

    // Add an event listener for form submission
    form.addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent the default form submission

        // Get form data
        const formData = new FormData(form);

        // Convert form data to a plain object
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        // Make a POST request to the backend PHP script with custom headers
        axios.post(actionUrl, data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response:', response.data);
            
            // Show success toast
            showToast('Success', response.data.message || 'Operation completed successfully', 'success');
            
            // Check if response contains a redirect URL
            if (response.data.success && response.data.data && response.data.data.redirect_url) {
                // Redirect to the specified URL after a short delay to allow toast to be seen
                setTimeout(() => {
                    window.location.href = response.data.data.redirect_url;
                }, 1500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Display error message if available
            const errorMessage = error.response && error.response.data && error.response.data.message 
                ? error.response.data.message 
                : 'An error occurred. Please try again.';
            
            // Show error toast
            showToast('Error', errorMessage, 'danger');
        });
    });
}

// Function to create and show Bootstrap toast notifications with Font Awesome icons
function showToast(title, message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '1050';
        document.body.appendChild(toastContainer);
    }
    
    // Create a unique ID for the toast
    const toastId = 'toast-' + Date.now();
    
    // Determine icon and color based on type
    let icon, bgColor;
    switch(type) {
        case 'success':
            icon = '<i class="fas fa-check-circle me-2"></i>';
            bgColor = 'bg-success';
            break;
        case 'danger':
        case 'error':
            icon = '<i class="fas fa-exclamation-circle me-2"></i>';
            bgColor = 'bg-danger';
            type = 'danger'; // Normalize type
            break;
        case 'warning':
            icon = '<i class="fas fa-exclamation-triangle me-2"></i>';
            bgColor = 'bg-warning';
            break;
        case 'info':
        default:
            icon = '<i class="fas fa-info-circle me-2"></i>';
            bgColor = 'bg-info';
            type = 'info'; // Normalize type
            break;
    }
    
    // Create toast element
    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center border-0 text-white ${bgColor}`;
    toastEl.id = toastId;
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.style.marginBottom = '10px'; // Add margin between stacked toasts
    
    // Create toast content with icon
    toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${icon}<strong>${title}:</strong> ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    // Add toast to container
    toastContainer.appendChild(toastEl);
    
    // Initialize and show the toast
    const toast = new bootstrap.Toast(toastEl, {
        animation: true,
        autohide: true,
        delay: 5000
    });
    toast.show();
    
    // Remove toast from DOM after it's hidden
    toastEl.addEventListener('hidden.bs.toast', function() {
        toastEl.remove();
    });
}

// Example of how to use the toast without form submission
function showInfoToast(message) {
    showToast('Information', message, 'info');
}

function showSuccessToast(message) {
    showToast('Success', message, 'success');
}

function showWarningToast(message) {
    showToast('Warning', message, 'warning');
}

function showErrorToast(message) {
    showToast('Error', message, 'danger');
}

// Make sure Bootstrap and Font Awesome are loaded before using toasts
document.addEventListener('DOMContentLoaded', function() {
    // Check if Bootstrap is loaded
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap is required for toast notifications. Please include Bootstrap JS.');
    }
    
    // Check if Font Awesome is loaded (simplified check)
    const faCheck = document.querySelector('i.fas, i.fa, i.fab, i.far');
    if (!faCheck && !document.querySelector('link[href*="font-awesome"], script[src*="font-awesome"]')) {
        console.warn('Font Awesome may not be loaded. Icons might not display correctly.');
    }
});