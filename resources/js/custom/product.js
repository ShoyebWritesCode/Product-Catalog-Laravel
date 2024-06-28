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
