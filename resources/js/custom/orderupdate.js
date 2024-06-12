$(document).ready(function () {
    $(".update-btn").click(function () {
        var orderId = $(this).closest(".update-form").data("order-id");
        var formId = "#updateForm_" + orderId;
        var formData = $(formId).serialize();

        $.ajax({
            url: $(formId).attr("action"),
            type: "POST",
            data: formData,
            success: function (response) {
                $("#row_" + orderId).remove();
            },
            error: function (xhr) {
                console.error("Error submitting form:", xhr.responseText);
            },
        });
    });
});
