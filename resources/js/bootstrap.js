import axios from 'axios';
import Pusher from 'pusher-js';
import Echo from 'laravel-echo';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('[name="csrf-token"]').getAttribute('content');

window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'eeb63050d73b3c199ba3',
  cluster: 'eu',
  forceTLS: true,
});

Pusher.logToConsole = true;
