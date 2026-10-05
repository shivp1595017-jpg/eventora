<script>
document.querySelectorAll('form[data-live-search]').forEach(form => {
    let timer;
    form.querySelectorAll('input[type="search"], input[name="search"], select').forEach(control => {
        control.addEventListener(control.tagName === 'SELECT' ? 'change' : 'input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => form.requestSubmit(), 300);
        });
    });
});
</script>
