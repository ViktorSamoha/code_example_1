$(document).ready(function () {
    $('input[name="REGISTER[EMAIL]"]').on( "keyup", function() {
        $('input[name="REGISTER[LOGIN]"]').val($(this).val());
    });
    $('input[name="REGISTER[PASSWORD]"]').on( "keyup", function() {
        $('input[name="REGISTER[CONFIRM_PASSWORD]"]').val($(this).val());
    });
});