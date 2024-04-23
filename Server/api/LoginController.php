<?php
include "../../libraries/libraries.php";
include "../database/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $User = DBQuery("SELECT * FROM users WHERE userEmail = ?", [$email], $connect)['result'];
    if (isset($User[0]) && password_verify($password, $User[0]['hashString'])) {
      $expiry = time() + 3600 * 24;

      $JWT = JWT::create([
        "email" => $User[0]['userEmail'],
        "nickname" => $User[0]['nickname'],
        "permissionID" => $User[0]['permissionID'],
        "userID" => $User[0]['userID'],
        "expiry" => $expiry
      ]);

      if (setcookie("JWT", $JWT, $expiry, "/", $GLOBALS['CONFIG']['web-domain'])) {
        echo json_encode(["status" => "success"]);
        $_POST["email"] = "";
        $_POST["password"] = "";
      } else {
        echo json_encode(["status" => false, 'message' => "Something went wrong!"]);
      }
    } else {
      echo json_encode(["status" => false, 'message' => "Wrong email or password!"]);
    }
  }
}