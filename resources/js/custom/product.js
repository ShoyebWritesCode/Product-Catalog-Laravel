document.addEventListener("DOMContentLoaded", function () {
    var parentCategories = document.querySelectorAll(".parent-category");
    parentCategories.forEach(function (parentCategory) {
        parentCategory.addEventListener("change", function () {
            var subcategoryDiv = document.getElementById(
                "subcategories_" + this.value
            );
            if (this.checked) {
                subcategoryDiv.classList.remove("hidden");
            } else {
                subcategoryDiv.classList.add("hidden");
                var subcategories = subcategoryDiv.querySelectorAll(
                    'input[type="checkbox"]'
                );
                subcategories.forEach(function (subcategory) {
                    subcategory.checked = false;
                });
            }
        });
    });
});

const searchInput = document.getElementById("searchInput");
const productList = document.getElementById("productList");

searchInput.addEventListener("input", function (event) {
    const searchQuery = event.target.value.trim();

    fetch(`/products/search?search=${encodeURIComponent(searchQuery)}`)
        .then((response) => response.text())
        .then((htmlContent) => {
            productList.innerHTML = htmlContent;
        })
        .catch((error) => {
            console.error("Error fetching content:", error);
        });
});

let page = 1;
let isLoading = false;

window.addEventListener("scroll", () => {
    if (
        window.innerHeight + window.scrollY >=
            document.body.offsetHeight - 500 &&
        !isLoading
    ) {
        loadMoreProducts();
    }
});

function loadMoreProducts() {
    isLoading = true;
    page++;
    document.getElementById("loading-indicator").classList.remove("hidden");

    fetch(`/products/fetch?page=${page}`)
        .then((response) => response.text())
        .then((html) => {
            const container = document.getElementById("product-container");
            container.insertAdjacentHTML("beforeend", html);
            isLoading = false;
            document
                .getElementById("loading-indicator")
                .classList.add("hidden");
        })
        .catch((error) => {
            console.error("Error fetching more products:", error);
            isLoading = false;
            document
                .getElementById("loading-indicator")
                .classList.add("hidden");
        });
}
