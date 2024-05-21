<?php
$CONFIG_PATH = __DIR__ . "/../config.json";
$CONFIG = json_decode(file_get_contents($CONFIG_PATH), true);


// create id
function createRandomID(int $length, array $exitingIDs)
{
  do {
    $id = bin2hex(random_bytes(ceil($length / 2)));
  } while (in_array($id, $exitingIDs));

  return $id;
}

function DBQuery(string $sqlString, array $params, $connect)
{
  $stmt = $connect->prepare($sqlString);
  $stmt->execute($params);

  $numRows = $stmt->rowCount();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $status = $stmt->errorInfo();
  return ["result" => $result, "numRows" => $numRows, "status" => $status];
}

function convertString(string $text)
{
  return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

class JWT
{
  private static function createSignature($header, $payload)
  {
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(hash_hmac('sha256', $header . "." . $payload, $GLOBALS['CONFIG']['secret-key'], true)));
  }

  // create JWT
  public static function create(array $payload)
  {
    // key 
    $key = $GLOBALS['CONFIG']['secret-key'];

    // header
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

    // payload
    $payload = json_encode($payload);
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    //signature
    $base64Signature = self::createSignature($base64UrlHeader, $base64UrlPayload);

    //jwt
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64Signature;

    return $jwt;
  }

  // check JWT
  public static function check(string $jwt)
  {
    [$base64UrlHeader, $base64UrlPayload, $base64Signature] = explode('.', $jwt);
    if ($base64Signature !== self::createSignature($base64UrlHeader, $base64UrlPayload)) {
      return false;
    }
    return true;
  }

  public static function decode(string $jwt)
  {
    [$base64UrlHeader, $base64UrlPayload, $base64Signature] = explode('.', $jwt);
    $header = base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlHeader));
    $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload));

    return ["header" => $header, "payload" => $payload];
  }
}