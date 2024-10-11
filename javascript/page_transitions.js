document.addEventListener("DOMContentLoaded", function() {
    const links = document.querySelectorAll('a'); // Select all anchor tags

    links.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default navigation
            const href = this.getAttribute('href'); // Get the target page

            // Apply the fade-leave class to the body
            document.body.classList.add('fade-leave');

            // Wait for the transition to finish, then navigate
            setTimeout(() => {
                window.location.href = href; // Redirect to the target page
            }, 500); // Wait for 500ms (duration of the transition)
        });
    });
});

