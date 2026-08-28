import './bootstrap';

// Import Bootstrap CSS and Icons
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

// Import Bootstrap JS Bundle
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Import & Start Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;

Alpine.start();