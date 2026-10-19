// DOM Elements
const signupForm = document.getElementById('signupForm');
const submitBtn = document.querySelector('.submit-btn');
const loadingSpinner = document.getElementById('loadingSpinner');
const successMessage = document.getElementById('successMessage');
const loginLink = document.getElementById('loginLink');

// Form Data Storage
let formData = {};

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    initializeForm();
});

// Initialize Form
function initializeForm() {
    // Add form submission handler
    signupForm.addEventListener('submit', handleSubmit);
    
    // Add input validation handlers
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('blur', validateInput);
        input.addEventListener('input', clearValidation);
    });
    
    // Add login link handler
    loginLink.addEventListener('click', handleLoginClick);
    
    // Add success message click handler (close on click)
    successMessage.addEventListener('click', hideSuccessMessage);
}

// Handle Form Submission
async function handleSubmit(e) {
    e.preventDefault();
    
    // Validate all inputs
    if (!validateForm()) {
        return;
    }
    
    // Collect form data
    collectFormData();
    
    // Show loading state
    showLoading();
    
    try {
        // Simulate API call
        await simulateApiCall();
        
        // Success
        showSuccess();
        
    } catch (error) {
        // Handle error
        showError('Terjadi kesalahan. Silakan coba lagi.');
    } finally {
        // Hide loading state
        hideLoading();
    }
}

// Validate Individual Input
function validateInput(e) {
    const input = e.target;
    const inputGroup = input.parentElement;
    const value = input.value.trim();
    
    // Remove existing validation classes
    inputGroup.classList.remove('error', 'success');
    
    // Validate based on input type
    let isValid = false;
    
    switch(input.type) {
        case 'text':
            isValid = validateName(value);
            break;
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
    const inputGroup = e.target.parentElement;
    inputGroup.classList.remove('error', 'success');
}

// Validate Entire Form
function validateForm() {
    const inputs = document.querySelectorAll('input');
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
function validateName(name) {
    return name.length >= 2 && name.length <= 50;
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function validatePassword(password) {
    return password.length >= 6;
}

// Collect Form Data
function collectFormData() {
    const inputs = document.querySelectorAll('input');
    formData = {};
    
    inputs.forEach(input => {
        formData[input.name] = input.value.trim();
    });
    
    console.log('Form Data:', formData);
}

// Simulate API Call
function simulateApiCall() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            // Simulate random success/failure (90% success rate)
            if (Math.random() > 0.1) {
                resolve({ success: true, message: 'Account created successfully' });
            } else {
                reject(new Error('Server error'));
            }
        }, 2000); // 2 second delay
    });
}

// Show Loading State
function showLoading() {
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
}

// Hide Loading State
function hideLoading() {
    submitBtn.classList.remove('loading');
    submitBtn.disabled = false;
}

// Show Success Message
function showSuccess() {
    successMessage.classList.add('show');
    
    // Auto hide after 3 seconds
    setTimeout(() => {
        hideSuccessMessage();
    }, 3000);
}

// Hide Success Message
function hideSuccessMessage() {
    successMessage.classList.remove('show');
    
    // Reset form after success
    setTimeout(() => {
        resetForm();
    }, 300);
}

// Show Error Message
function showError(message) {
    alert(message); // Simple alert for now
    // In a real app, you'd show a proper error message
}

// Reset Form
function resetForm() {
    signupForm.reset();
    
    // Clear validation classes
    const inputGroups = document.querySelectorAll('.input-group');
    inputGroups.forEach(group => {
        group.classList.remove('error', 'success');
    });
    
    // Clear form data
    formData = {};
}

// Handle Login Link Click
function handleLoginClick(e) {
    e.preventDefault();
    
    // Add a subtle animation to the card
    const formCard = document.querySelector('.form-card');
    formCard.style.transform = 'scale(0.98)';
    
    setTimeout(() => {
        formCard.style.transform = 'scale(1)';
        alert('Fitur login akan segera hadir!');
    }, 150);
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Enhanced UX Features
function addEnhancedUX() {
    // Add focus effects
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-1px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });
    
    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.ctrlKey) {
            signupForm.dispatchEvent(new Event('submit'));
        }
    });
}

// Initialize enhanced UX when DOM is loaded
document.addEventListener('DOMContentLoaded', addEnhancedUX);

// Export functions for potential external use
window.SignupForm = {
    validateForm,
    resetForm,
    collectFormData,
    showSuccess,
    showError
};