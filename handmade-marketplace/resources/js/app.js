import './bootstrap';

const THEME_KEY = 'craftnest-theme';

function applyTheme(theme) {
    const isDark = theme === 'dark';
    document.documentElement.classList.toggle('dark', isDark);
    localStorage.setItem(THEME_KEY, theme);
}

function initThemeToggle() {
    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const next = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(next);
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();

    document.querySelectorAll('[data-dismiss]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const alert = btn.closest('[data-alert]');
            if (alert) {
                alert.classList.add('opacity-0', 'translate-y-[-8px]');
                setTimeout(() => alert.remove(), 200);
            }
        });
    });
});
