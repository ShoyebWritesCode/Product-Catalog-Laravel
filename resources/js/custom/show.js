const swiper = new Swiper(".swiper", {
    direction: "horizontal",
    loop: true,

    pagination: {
        el: ".swiper-pagination",
    },

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    scrollbar: {
        el: ".swiper-scrollbar",
    },
});

$(document).ready(function () {
    $("#addToCartForm").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    $("#successMessage").html(response.message);
                    $("#successMessage").show();
                    setTimeout(function () {
                        $("#successMessage").fadeOut(500);
                    }, 3000);
                } else {
                    console.error("Error adding product to cart:", response);
                }
            },
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const sizeInputs = document.querySelectorAll(".size-option-input");
    const colorInputs = document.querySelectorAll(".color-option-input");

    sizeInputs.forEach((input) => {
        input.addEventListener("change", function () {
            resetSizeOptions();
            if (this.checked) {
                this.nextElementSibling.classList.add("bg-black", "text-white");
            }
        });
    });

    colorInputs.forEach((input) => {
        input.addEventListener("change", function () {
            resetColorOptions();
            if (this.checked) {
                this.nextElementSibling.classList.add("bg-black", "text-white");
            }
        });
    });

    function resetSizeOptions() {
        document.querySelectorAll(".size-option").forEach((option) => {
            option.classList.remove("bg-black", "text-white");
        });
    }

    function resetColorOptions() {
        document.querySelectorAll(".color-option").forEach((option) => {
            option.classList.remove("bg-black", "text-white");
        });
    }
});
