// Auth utilities for JWT token management
const AUTH_TOKEN_KEY = 'jwt_token';

export const auth = {
    // Store the JWT token
    setToken(token) {
        if (typeof window !== 'undefined') {
            localStorage.setItem(AUTH_TOKEN_KEY, token);
            if (window.axios) {
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            }
        }
    },

    // Get the stored JWT token
    getToken() {
        if (typeof window !== 'undefined') {
            return localStorage.getItem(AUTH_TOKEN_KEY);
        }
        return null;
    },

    // Remove the JWT token
    removeToken() {
        if (typeof window !== 'undefined') {
            localStorage.removeItem(AUTH_TOKEN_KEY);
            if (window.axios?.defaults?.headers?.common?.['Authorization']) {
                delete window.axios.defaults.headers.common['Authorization'];
            }
        }
    },

    // Check if user is authenticated
    isAuthenticated() {
        return !!this.getToken();
    },

    // Get the authorization header for API requests
    getAuthHeader() {
        const token = this.getToken();
        return token ? `Bearer ${token}` : '';
    }
};

// Initialize axios interceptors if axios is available
if (typeof window !== 'undefined' && window.axios) {
    // Add token to all axios requests
    window.axios.interceptors.request.use(
        (config) => {
            const token = auth.getToken();
            if (token && !config.headers.Authorization) {
                config.headers.Authorization = `Bearer ${token}`;
            }
            return config;
        },
        (error) => Promise.reject(error)
    );

    // Handle 401 Unauthorized responses
    window.axios.interceptors.response.use(
        (response) => response,
        (error) => {
            if (error.response?.status === 401) {
                auth.removeToken();
                window.location.href = '/login';
            }
            return Promise.reject(error);
        }
    );
}
