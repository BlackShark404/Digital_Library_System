// init.js
// Initialization script to check dependencies and setup

document.addEventListener('DOMContentLoaded', function() {
    // Check if Bootstrap is loaded
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap is required for toast notifications. Please include Bootstrap JS.');
    }
    
    // Check if Font Awesome is loaded (simplified check)
    const faCheck = document.querySelector('i.fas, i.fa, i.fab, i.far');
    if (!faCheck && !document.querySelector('link[href*="font-awesome"], script[src*="font-awesome"]')) {
        console.warn('Font Awesome may not be loaded. Icons might not display correctly.');
    }
    
    // Check if Axios is loaded
    if (typeof axios === 'undefined') {
        console.error('Axios is required for form handling. Please include Axios JS.');
    }

    console.log('Toast notification and form handling system initialized.');
});