import "bootstrap";
import $ from "jquery";
window.$ = window.jQuery = $;

// when any form is submitted, disable the submit button and change the text to "Processing...
$(document).on("submit", "form", function () {
    $(this)
        .find("button[type=submit]")
        .attr("disabled", true)
        .text("Processing...");
});
