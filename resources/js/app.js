import './bootstrap';
import Alpine from 'alpinejs';

// Import the auth module
import './auth';

// Initialize Alpine
window.Alpine = Alpine;
Alpine.start();

// Check for token in URL (if coming from OAuth or similar)
const urlParams = new URLSearchParams(window.location.search);
const token = urlParams.get('token');
if (token) {
    // Store the token and remove it from the URL
    auth.setToken(token);
    window.history.replaceState({}, document.title, window.location.pathname);
}
