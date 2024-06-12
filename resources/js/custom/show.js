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
