<?php
$CONFIG_PATH = "../config.json";
$CONFIG = json_decode(file_get_contents($CONFIG_PATH), true);

$host = $CONFIG['data-base']['host-name'];
$port = $CONFIG['data-base']['port'];
$database = $CONFIG['data-base']['db-name'];
$username = $CONFIG['data-base']['user'];
$password = $CONFIG['data-base']['password'];

try {
  $connect = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $connect->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
  die('[sql] Error connect' . $e->getMessage());
}