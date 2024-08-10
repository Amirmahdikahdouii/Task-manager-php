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


let searchButton = document.querySelector(".search-button");
let searchInput = document.querySelector(".search-input");

document.addEventListener("DOMContentLoaded", () => {
    // Set Initial search input value from URL
    let params = new URLSearchParams(window.location.search);
    if (params.has("search"))
        searchInput.value = params.get("search");
})

const addSearchQueryParamToURL = (value) => {
    // Function to set value on "search" key in QueryParams
    let params = new URLSearchParams(window.location.search);
    params.set("search", value)
    window.location = `${window.location.pathname}?${params.toString()}`;
}
searchButton.addEventListener("click", () => {
    // Add search param after click on search button
    addSearchQueryParamToURL(searchInput.value);
});

searchInput.addEventListener("keyup", (e) => {
    // Handle press Enter after fill the input
    if (e.key === "Enter") {
        addSearchQueryParamToURL(searchInput.value);
    }
})

const filterButton = document.querySelector('.filter-button');
const filterMenu = document.getElementById('filterMenu');
const checkboxes = [...document.getElementsByClassName("filter-checkbox")];

filterButton.addEventListener('mouseover', () => {
    // Open Filter menu
    filterMenu.classList.add('open');
});

filterButton.addEventListener('mouseout', (e) => {
    // Close Filter menu
    if (!filterMenu.contains(e.relatedTarget)) {
        filterMenu.classList.remove('open');
    }
});

filterMenu.addEventListener('mouseleave', () => {
    // Close Filter menu
    filterMenu.classList.remove('open');
});

checkboxes.forEach(checkbox => {
    const params = new URLSearchParams(window.location.search);
    checkbox.addEventListener("change", () => {
        if (checkbox.checked) {
            params.set(checkbox.name, checkbox.value)
        } else {
            params.delete(checkbox.name)
        }
        const newURL = `${window.location.pathname}?${params.toString()}`;
        window.location = newURL;
    })
    if (params.has(checkbox.name) && params.get(checkbox.name) === checkbox.value) {
        checkbox.checked = true;
    }
});
