const passwordToggles = document.querySelectorAll('.toggle-password');

// Password visibility toggle
passwordToggles.forEach(toggle => {
    toggle.addEventListener('click', function() {
        const targetId = this.dataset.target;
        const passwordInput = document.getElementById(targetId);
        const iconElement = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            iconElement.classList.remove('bi-eye-slash');
            iconElement.classList.add('bi-eye');
        } else {
            passwordInput.type = 'password';
            iconElement.classList.remove('bi-eye');
            iconElement.classList.add('bi-eye-slash');
        }
    });
});