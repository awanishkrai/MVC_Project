import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
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
