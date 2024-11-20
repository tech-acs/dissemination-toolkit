import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.ajaxBaseURL = import.meta.env.VITE_AJAX_URL || ''