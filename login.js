// DOM Elements
const loginForm = document.getElementById('loginForm');
const submitBtn = document.querySelector('.submit-btn');
const loadingSpinner = document.getElementById('loadingSpinner');
const successMessage = document.getElementById('successMessage');
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');
const forgotPasswordLink = document.getElementById('forgotPassword');
const signupLink = document.getElementById('signupLink');
const googleLoginBtn = document.getElementById('googleLogin');
const forgotModal = document.getElementById('forgotModal');
const closeModal = document.getElementById('closeModal');
const forgotForm = document.getElementById('forgotForm');
const resetSpinner = document.getElementById('resetSpinner');

// Form Data Storage
let loginData = {};

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    initializeForm();
});

// Initialize Form
function initializeForm() {
    // Add form submission handler
    loginForm.addEventListener('submit', handleLogin);
    
    // Add input validation handlers
    const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
    inputs.forEach(input => {
        input.addEventListener('blur', validateInput);
        input.addEventListener('input', clearValidation);
    });
    
    // Add password toggle handler
    togglePassword.addEventListener('click', handlePasswordToggle);
    
    // Add link handlers
    forgotPasswordLink.addEventListener('click', showForgotModal);
    signupLink.addEventListener('click', handleSignupClick);
    googleLoginBtn.addEventListener('click', handleGoogleLogin);
    
    // Add modal handlers
    closeModal.addEventListener('click', hideForgotModal);
    forgotModal.addEventListener('click', handleModalBackdropClick);
    forgotForm.addEventListener('submit', handleForgotPassword);
    
    // Add success message click handler
    successMessage.addEventListener('click', hideSuccessMessage);
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', handleKeyboardShortcuts);
}

// Handle Login Form Submission
async function handleLogin(e) {
    e.preventDefault();
    
    // Validate all inputs
    if (!validateLoginForm()) {
        return;
    }
    
    // Collect form data
    collectLoginData();
    
    // Show loading state
    showLoading();
    
    try {
        // Simulate API call
        await simulateLoginApi();
        
        // Success
        showSuccess();
        
    } catch (error) {
        // Handle error
        showError('Email atau password salah. Silakan coba lagi.');
    } finally {
        // Hide loading state
        hideLoading();
    }
}

// Validate Individual Input
function validateInput(e) {
    const input = e.target;
    const inputGroup = input.parentElement.classList.contains('password-wrapper') 
        ? input.parentElement.parentElement 
        : input.parentElement;
    const value = input.value.trim();
    
    // Remove existing validation classes
    inputGroup.classList.remove('error', 'success');
    
    // Validate based on input type
    let isValid = false;
    
    switch(input.type) {
        case 'email':
            isValid = validateEmail(value);
            break;
        case 'password':
            isValid = validatePassword(value);
            break;
    }
    
    // Add validation class
    if (value !== '') {
        inputGroup.classList.add(isValid ? 'success' : 'error');
    }
    
    return isValid;
}

// Clear Validation on Input
function clearValidation(e) {
    const input = e.target;
    const inputGroup = input.parentElement.classList.contains('password-wrapper') 
        ? input.parentElement.parentElement 
        : input.parentElement;
    inputGroup.classList.remove('error', 'success');
}

// Validate Login Form
function validateLoginForm() {
    const inputs = document.querySelectorAll('#loginForm input[type="email"], #loginForm input[type="password"]');
    let isFormValid = true;
    
    inputs.forEach(input => {
        const isInputValid = validateInput({ target: input });
        if (!isInputValid) {
            isFormValid = false;
        }
    });
    
    return isFormValid;
}

// Validation Functions
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email) && email.length > 0;
}

function validatePassword(password) {
    return password.length >= 6;
}

// Collect Login Data
function collectLoginData() {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const remember = document.getElementById('remember').checked;
    
    loginData = {
        email,
        password,
        remember
    };
    
    console.log('Login Data:', { email, remember }); // Don't log password
}

// Simulate Login API Call
function simulateLoginApi() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            // Simulate login validation (90% success rate)
            if (Math.random() > 0.1) {
                resolve({ 
                    success: true, 
                    message: 'Login successful',
                    user: { email: loginData.email }
                });
            } else {
                reject(new Error('Invalid credentials'));
            }
        }, 1500);
    });
}

// Password Toggle Handler
function handlePasswordToggle() {
    const eyeIcon = togglePassword.querySelector('.eye-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
        `;
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        `;
    }
    
    // Add a subtle animation
    togglePassword.style.transform = 'scale(0.9)';
    setTimeout(() => {
        togglePassword.style.transform = 'scale(1)';
    }, 150);
}

// Show/Hide Loading State
function showLoading() {
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
}

function hideLoading() {
    submitBtn.classList.remove('loading');
    submitBtn.disabled = false;
}

// Show Success Message
function showSuccess() {
    successMessage.classList.add('show');
    
    // Auto hide after 3 seconds and redirect
    setTimeout(() => {
        hideSuccessMessage();
        // In a real app, redirect to dashboard
        console.log('Redirecting to dashboard...');
    }, 3000);
}
