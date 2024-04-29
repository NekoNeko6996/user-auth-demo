// current url + parameter
function loadBody(body, element) {
  if (element) {
    element = $(element);
    $(".aside-pages").each((idx, element) => {
      if ($(element).hasClass("aside-pages-active")) {
        $(element).removeClass("aside-pages-active");
      }
    });
    element.addClass("aside-pages-active");
  }

  var bodyUrl = `components/body_${body}.php`;
  $(".middle-section").load(bodyUrl);
}

//------------------ onload page --------------------//
$(document).ready(() => {
  // load dashboard body
  loadBody("dashboard", $(".aside-pages").first()[0]);
});
