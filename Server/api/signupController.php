<?php
include "../../libraries/libraries.php";
include "../database/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['nickname']) && isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['nickname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $nickname = convertString($_POST['nickname']);
    $email = strtolower(convertString($_POST['email']));
    $password = $_POST['password'];

    // check email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(["status" => "fail", "message" => "Invalid email!"]);
      exit();
    }

    // check existing email
    $exitingEmails = DBQuery("SELECT userEmail FROM users", [], $connect)['result'];
    if (in_array($email, $exitingEmails)) {
      echo json_encode(["status" => "fail", "message" => "Email already exists!"]);
      exit();
    }

    //hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    //user id
    $exitingIDs = DBQuery("SELECT userID FROM users", [], $connect)['result'];
    $userID = createRandomID(10, $exitingIDs);

    //insert into database
    $status = DBQuery("INSERT INTO users (userID, userEmail, hashString) VALUES (?, ?, ?)", [$userID, $email, $hash], $connect)['status'];

    if ($status[0] === "00000") {
      $status = DBQuery("INSERT INTO users_info (userID, userName) VALUES (?, ?)", [$userID, $nickname], $connect)['status'];
    }

    if ($status[0] === "00000") {
      $expiry = time() + 3600 * 24;

      $JWT = JWT::create([
        "email" => $email,
        "permissionID" => $GLOBALS['CONFIG']['default-permission'],
        "userID" => $userID,
        "expiry" => $expiry
      ]);

      if (setcookie("JWT", $JWT, $expiry, "/", $GLOBALS['CONFIG']['web-domain'])) {
        echo json_encode(["status" => "success"]);
        $_POST["nickname"] = "";
        $_POST["email"] = "";
        $_POST["password"] = "";
      } else {
        echo json_encode(["status" => false, 'message' => "Something went wrong!"]);
      }
    } else {
      echo json_encode(["status" => false, 'message' => "[SQL ERROR] Code: " . $status[0] . " Message: " . $status[1]]);
    }
  }
}