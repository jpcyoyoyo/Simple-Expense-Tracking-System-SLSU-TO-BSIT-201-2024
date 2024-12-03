<?php
    $theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'default';
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const theme = '<?php echo $theme; ?>';

    document.body.classList.remove('dark-theme', 'light-theme');
    // Set the selectors
    if (document.getElementById('theme-selector')) {
        document.getElementById('theme-selector').value = theme;
    }
    
    // Apply the styles
    if (theme === 'dark') document.body.classList.add('dark-theme');
    if (theme === 'light') document.body.classList.add('light-theme');
});
</script>
