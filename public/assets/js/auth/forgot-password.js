document.addEventListener('DOMContentLoaded', function() {
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    const resetMessage = document.getElementById('resetMessage');
    const emailInput = document.getElementById('email');

    forgotPasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous messages
        resetMessage.style.display = 'none';
        resetMessage.classList.remove('alert-success', 'alert-danger');

        const email = emailInput.value.trim();

        // Basic email validation
        if (!validateEmail(email)) {
            showMessage('Please enter a valid email address.', 'danger');
            return;
        }

        // Simulate password reset request
        sendPasswordResetRequest(email);
    });

    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return re.test(String(email).toLowerCase());
    }

    function sendPasswordResetRequest(email) {
        // Disable submit button during request
        const submitButton = forgotPasswordForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = 'Sending...';

        // In a real application, this would be an AJAX call to your backend
        fetch('/api/forgot-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => {
            if (response.ok) {
                showMessage('Password reset link sent to your email. Please check your inbox.', 'success');
                forgotPasswordForm.reset();
            } else {
                showMessage('Failed to send password reset link. Please try again.', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred. Please try again later.', 'danger');
        })
        .finally(() => {
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.innerHTML = 'Reset Password';
        });
    }

    function showMessage(message, type) {
        resetMessage.textContent = message;
        resetMessage.classList.add(`alert-${type}`);
        resetMessage.style.display = 'block';
    }

    // Optional: Add real-time email validation
    emailInput.addEventListener('input', function() {
        const email = this.value.trim();
        if (email && !validateEmail(email)) {
            this.setCustomValidity('Please enter a valid email address');
        } else {
            this.setCustomValidity('');
        }
    });
});