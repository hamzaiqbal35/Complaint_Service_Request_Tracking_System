import { auth } from './auth';

// Handle login form submission
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(loginForm);
            const submitButton = loginForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            
            try {
                // Show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = 'Signing in...';
                
                const response = await window.axios.post(loginForm.action, {
                    email: formData.get('email'),
                    password: formData.get('password'),
                    remember: formData.get('remember')
                });
                
                // Store the token
                if (response.data.token) {
                    auth.setToken(response.data.token);
                    
                    // Redirect based on user role (customize as needed)
                    const redirectTo = response.data.redirect_to || '/dashboard';
                    window.location.href = redirectTo;
                }
            } catch (error) {
                console.error('Login error:', error);
                let errorMessage = 'An error occurred during login';
                
                if (error.response) {
                    if (error.response.data.message) {
                        errorMessage = error.response.data.message;
                    } else if (error.response.status === 422) {
                        errorMessage = 'Invalid email or password';
                    }
                }
                
                // Show error message (using SweetAlert2)
                if (window.Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: errorMessage,
                        confirmButtonColor: '#3085d6',
                    });
                } else {
                    alert(errorMessage);
                }
            } finally {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
    }
});

// Handle logout
window.handleLogout = function() {
    if (window.Swal) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will be signed out of your account.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, sign out',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                performLogout();
            }
        });
    } else if (confirm('Are you sure you want to sign out?')) {
        performLogout();
    }
};

async function performLogout() {
    try {
        // Remove token from storage first
        auth.removeToken();
        
        // Send logout request to server
        await window.axios.post('/logout');
        
        // Redirect to login page
        window.location.href = '/login';
    } catch (error) {
        console.error('Logout error:', error);
        // Still redirect to login even if server logout fails
        window.location.href = '/login';
    }
}

// Export for testing
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { auth };
}