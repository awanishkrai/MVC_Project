<script>
(function () {
    var key = 'craftnest-theme';
    var stored = localStorage.getItem(key);
    var defaultDark = {{ request()->routeIs('admin.*') ? 'true' : 'false' }};
    if (stored === 'dark' || (stored === null && defaultDark)) {
        document.documentElement.classList.add('dark');
    }
})();
</script>
