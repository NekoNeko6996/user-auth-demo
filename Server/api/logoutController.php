<?php
include "../../libraries/libraries.php";

if (isset($_COOKIE['JWT'])) {
  setcookie("JWT", "", time() - 1, "/");
}
header("Location: ../../Views/login.php");
exit();
