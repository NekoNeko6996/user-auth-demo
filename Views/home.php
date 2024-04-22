<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<?php
include "../Server/database/connect.php";
include "../libraries/libraries.php";

JWT(["id" => 1, "name" => "admin"]);

?>

<body>
  <p>This is Home Page</p>
</body>

</html>