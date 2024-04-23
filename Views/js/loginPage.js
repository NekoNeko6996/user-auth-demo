// animation
$("#signUp").on("click", () => {
  $("#container").addClass("right-panel-active");
  $("#signup-nickname").focus();
});

$("#signIn").on("click", () => {
  $("#container").removeClass("right-panel-active");
  $("#login-email").focus();
});

$("document").ready(() => {
  var url = new URL(window.location.href);
  var tab = url.searchParams.get("tab");

  if (tab == "signup") {
    $("#container").addClass("right-panel-active");
    $("#signup-nickname").focus();
  }
});

// login form
function login(event) {
  event.preventDefault();

  var email = $("#login-email").val();
  var password = $("#login-password").val();

  $.ajax({
    type: "POST",
    url: "../Server/api/loginController.php",
    data: {
      email,
      password,
    },
    success: (response) => {
      try {
        response = JSON.parse(response);
        if (response.status == "success") {
          window.location.reload();
        } else {
          alert(response.message);
        }
      } catch (error) {
        console.log(response);
      }
    },
  });
}

// signup form
function signup(event) {
  event.preventDefault();

  var nickname = $("#signup-nickname").val();
  var email = $("#signup-email").val();
  var password = $("#signup-password").val();

  $.ajax({
    type: "POST",
    url: "../Server/api/signupController.php",
    data: {
      nickname,
      email,
      password,
    },
    success: (response) => {
      try {
        response = JSON.parse(response);
        if (response.status == "success") {
          window.location.reload();
        } else {
          alert(response.message);
        }
      } catch (error) {
        console.log(response);
      }
    },
  });
}
