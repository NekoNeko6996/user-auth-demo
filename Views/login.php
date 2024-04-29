<!DOCTYPE html>
<html lang="en">
<!-- https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js -->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="../libraries/jquery.min.js"></script>
  <script src="js/loginPage.js" defer></script>
  <link rel="stylesheet" href="css/loginPage.css">
  <title>Login</title>
</head>

<?php
include "../libraries/libraries.php";

if (isset($_COOKIE['JWT'])) {
  if (!JWT::check($_COOKIE['JWT'])) {
    setcookie("JWT", "", time() - 1, "/");
  } else {
    header("Location: dashboard.php");
    exit();
  }
}
?>


<body>
  <nav></nav>
  <div class="container" id="container">
    <div class="form-container sign-up-container">
      <form onsubmit="signup(event)" id="signupForm">
        <h1>Create Account</h1>
        <input type="text" placeholder="Nickname" id="signup-nickname" />
        <input type="email" placeholder="Email" id="signup-email" />
        <input type="password" placeholder="Password" autocomplete="on" id="signup-password" />
        <button>Sign Up</button>
      </form>
    </div>
    <div class="form-container sign-in-container">
      <form onsubmit="login(event)" id="loginForm" method="post">
        <h1>Sign in</h1>
        <input type="email" placeholder="Email" id="login-email" autofocus />
        <input type="password" placeholder="Password" autocomplete="on" id="login-password" />
        <a href="#">Forgot your password?</a>
        <button type="submit">Sign In</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login with your personal info</p>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Hello, Friend!</h1>
          <p>Enter your personal details and start journey with us</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>