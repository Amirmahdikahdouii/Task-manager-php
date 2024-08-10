const accordions = document.querySelectorAll(".accordion");

accordions.forEach((accordion) => {
    const header = accordion.querySelector(".accordion-header");
    const body = accordion.querySelector(".accordion-body");
    const toggleButton = accordion.querySelector(".toggle-button");

    // Toggle accordion body on header click
    header.addEventListener("click", function () {
        const isOpen = body.classList.contains("open");
        if (isOpen) {
            body.classList.remove("open");
            toggleButton.innerHTML = "▼";
        } else {
            body.classList.add("open");
            toggleButton.innerHTML = "▲";
        }
    });
});
