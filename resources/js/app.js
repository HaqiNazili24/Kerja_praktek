import { createApp } from 'vue';
import '../sass/app.scss';

// Import Bootstrap JS
import 'bootstrap';

// Import Components
import WhatsAppBubble from './components/WhatsAppBubble.vue';

const app = createApp({});
app.component('WhatsAppBubble', WhatsAppBubble);
app.mount('#app');