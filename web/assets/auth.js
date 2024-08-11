$(document).ready(function () {
  // Example: Show password toggle functionality
  $("#password").on("input", function () {
    if ($(this).val().length > 0) {
      $("#password").attr("type", "text");
    } else {
      $("#password").attr("type", "password");
    }
  });
});
