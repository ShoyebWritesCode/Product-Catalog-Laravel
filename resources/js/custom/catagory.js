document.addEventListener("DOMContentLoaded", function () {
    var checkbox = document.getElementById("subcat_checkbox");
    var subcatField = document.getElementById("subcat_field");
    checkbox.addEventListener("change", function () {
        if (checkbox.checked) {
            subcatField.style.display = "block";
        } else {
            subcatField.style.display = "none";
        }
    });
});
