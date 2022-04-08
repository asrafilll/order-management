$(function () {
    $("form").on("submit", function () {
        const $form = $(this);
        const $submit = $form.find('button[type="submit"]');
        $submit.attr("disabled", true);
    });
});
