import axios from 'axios';
window.axios = axios;

// resources/js/bootstrap.js
window.Echo = new Echo({
    // ... konfigurasi lainnya ...
});

// Catatan: Jika Anda menggunakan Private Channel, pastikan Anda 
// mengimpor dan menggunakan 'pusher-js' yang sudah diinisialisasi 
// dengan token otentikasi (Axios/HTTP Client)

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
