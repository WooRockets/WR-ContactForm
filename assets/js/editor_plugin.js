(function ($) {
    $("#wr_contactform_btn_add_fied").click(function () {
        var form_id = jQuery("select.wr-contactform-list-form").val();
        if (form_id == "" || form_id == "undefined") {
            alert("Please select a form");
            return;
        }
        window.send_to_editor("[wr_contactform id=" + form_id + "]");
    })
})(jQuery);
