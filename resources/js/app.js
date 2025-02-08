// Import Laravel's default bootstrap file
import './bootstrap';

// Import Alpine.js
import Alpine from 'alpinejs';

// Make Alpine.js globally available
window.Alpine = Alpine;

// Initialize Alpine.js
Alpine.start();

// Optional: Add custom JavaScript logic here
document.addEventListener('DOMContentLoaded', () => {
    console.log('App initialized successfully!');
});
document.querySelectorAll('form').forEach(form => {
    // Exclude the "Save Changes" form
    if (form.id === 'save-changes-form') {
        return; // Do nothing for this form
    }

    form.addEventListener('submit', function (e) {
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE'; // Overrides the form method
        form.appendChild(methodField);
    });
});
// Example: Exclude specific forms from being modified
document.addEventListener('submit', (event) => {
    const form = event.target;

    // Exclude the "Save Changes" form from adding _method
    if (form.id === 'save-changes-form') {
        return; // Do nothing for this form
    }

    // Debugging: Log all form submissions
    console.log('Form submitted:', form);
});