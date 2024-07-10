import 'alpinejs';

document.addEventListener('alpine:init', () => {
    Alpine.data('darkMode', () => ({
        isDarkMode: JSON.parse(localStorage.getItem('darkMode')) || false,
        toggleDarkMode() {
            this.isDarkMode = !this.isDarkMode;
            localStorage.setItem('darkMode', this.isDarkMode);
            document.documentElement.classList.toggle('dark', this.isDarkMode);
        },
        init() {
            document.documentElement.classList.toggle('dark', this.isDarkMode);
        },
    }));
});
