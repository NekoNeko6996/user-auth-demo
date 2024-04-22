<?php
$CONFIG_PATH = "../config.json";
$CONFIG = json_decode(file_get_contents($CONFIG_PATH), true);


function DBQuery(string $sqlString, array $params, $connect)
{
  $stmt = $connect->prepare($sqlString);
  $stmt->execute($params);

  $numRows = $stmt->rowCount();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $status = $stmt->errorInfo();
  return ["result" => $result, "numRows" => $numRows, "status" => $status];
}

function JWT(array $payload)
{
  $key = $GLOBALS['CONFIG']['secret-key'];

  // create JWT
  function create($payload, $key)
  {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload = json_encode($payload);

    // payload
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    //signature
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
    $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    //jwt
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64Signature;

    return $jwt;
  }

  // check JWT
  

}