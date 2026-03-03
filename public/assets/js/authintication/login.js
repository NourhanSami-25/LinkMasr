
// Validation logic
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email format regex
    return emailRegex.test(email);
}

function showErrorMessage(inputName, message) {
    const errorElement = document.getElementById(`${inputName}-error`);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
}

function hideErrorMessage(inputName) {
    const errorElement = document.getElementById(`${inputName}-error`);
    if (errorElement) {
        errorElement.style.display = 'none';
    }
}

function validateForm(event) {
    let isValid = true;

    // Validate email
    const email = document.querySelector('input[name="email"]');
    if (!email || email.value.trim() === '') {
        showErrorMessage('email', 'Email is required.');
        isValid = false;
    } else if (!validateEmail(email.value)) {
        showErrorMessage('email', 'Enter a valid email address.');
        isValid = false;
    } else {
        hideErrorMessage('email');
    }

    // Validate password
    const password = document.querySelector('input[name="password"]');
    if (!password || password.value.trim() === '') {
        showErrorMessage('password', 'Password is required.');
        isValid = false;
    } else if (password.value.length < 8) {
        showErrorMessage('password', 'Password must be at least 8 characters.');
        isValid = false;
    } else {
        hideErrorMessage('password');
    }

    // Prevent form submission if any validation fails
    if (!isValid) {
        event.preventDefault();
    }
}

// Attach validation to the form
document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('#login-form'); // Replace with your form ID or selector
    if (loginForm) {
        loginForm.addEventListener('submit', validateForm);
    }
});
