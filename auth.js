document.addEventListener('DOMContentLoaded', function() {
    // Check if user is logged in
    const checkAuthStatus = async () => {
        try {
            const response = await fetch('check-auth.php');
            const data = await response.json();
            
            if (data.loggedIn) {
                // Update UI for logged in user
                document.querySelector('.auth-buttons').innerHTML = `
                    <div class="user-profile">
                        <div class="user-avatar">${data.userInitial}</div>
                        <a href="logout.php" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error checking auth status:', error);
        }
    };

    // Check auth status on page load
    checkAuthStatus();

    // Handle logout
    document.addEventListener('click', function(e) {
        if (e.target.closest('.logout-btn')) {
            e.preventDefault();
            window.location.href = 'logout.php';
        }
    });
});