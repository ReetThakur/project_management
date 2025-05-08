import './bootstrap';
import { createApp } from 'vue';
import Alpine from 'alpinejs';

// Import Vue components
import NotificationCenter from './components/NotificationCenter.vue';

// Create Vue app
const app = createApp({});

// Register components
app.component('notification-center', NotificationCenter);

// Mount Vue app
app.mount('#app');

// Initialize Alpine
window.Alpine = Alpine;
Alpine.start();
