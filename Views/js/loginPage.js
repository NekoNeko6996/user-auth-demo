// animation
$("#signUp").on("click", () => {
  $("#container").addClass("right-panel-active");
});

$("#signIn").on("click", () => {
  $("#container").removeClass("right-panel-active");
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
