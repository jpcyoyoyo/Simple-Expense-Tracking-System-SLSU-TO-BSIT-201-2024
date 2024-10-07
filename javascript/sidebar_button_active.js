document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".nav-item .nav-link");

    // Check if there is any active nav-link stored in localStorage
    const activeLink = localStorage.getItem("activeNavLink");
    if (activeLink) {
        document.querySelector(activeLink).classList.add("active");
        document.querySelector(activeLink).parentElement.classList.add("active");
    }

    // Loop through each nav-link and add event listeners
    links.forEach(link => {
        link.addEventListener("click", function() {
            // Remove the active class from all nav-links
            links.forEach(link => {
                link.classList.remove("active");
                link.parentElement.classList.remove("active");
            });

            // Add the active class to the clicked nav-link and its parent nav-item
            this.classList.add("active");
            this.parentElement.classList.add("active");

            // Store the active nav-link in localStorage
            localStorage.setItem("activeNavLink", `.${this.classList[1]}`);
        });
    });
});
