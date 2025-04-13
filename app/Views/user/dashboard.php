<!-- Include Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Include the script -->
<script src="/assets/js/utility/ajaxForm.js"></script>


<!-- Your login form -->
<form id="login-form" method="GET">
    <input type="email" name="email" required placeholder="Email"> <br>
    <input type="password" name="password" required placeholder="Password"> <br>
    <label>
        <input type="checkbox" name="remember"> Remember Me
    </label>
    <button type="submit">Login</button>
    <p id="login-error" style="color: red;"></p>
</form>

<script>
    // Call the function to handle form submission via Axios
    handleAjaxFormSubmit(
        'login-form', // Form ID
        '/login',     // Action URL
        (data) => {   // Success callback
            window.location.href = data.redirect; // Redirect to dashboard on success
        },
        (message) => { // Error callback
            document.getElementById('login-error').textContent = message; // Show error message
        }
    );
</script>
