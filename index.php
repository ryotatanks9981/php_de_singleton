<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require "vendor/autoload.php";

$key = "secret_key";
$payload = [
    "iss" => "http://localhost/phpprac",
    "aud" => "http://localhost/phpprac",
    "iat" => 1356999524,
    "nbf" => 1357000000,
];

// tokenの生成
// encode関数の中でヘッダーは設定されているから変更不可
$jwt = JWT::encode($payload, $key, "HS256");
// 
$decoded = JWT::decode($jwt, new key($key, "HS256"));

echo $jwt."\n";
print_r($decoded);

$decoded_array = (array) $decoded;

JWT::$leeway = 60;
$decoded = JWT::decode($jwt, new Key($key, "HS256"));

// $jwt = preg_split("/\s+/", $_SERVER["HTTP_AYTHORIZATION"][0]);

// try {
//     $decoded = JWT::decode($jwt, $key, ["HS256"]);
//     $status = 200;
//     $msg = "ok";
// } catch (Exception $e) {
//     $status = 401;
//     $msg = $e -> getMessage();
// }

// header("Content-Type: application/json");
// http_response_code($status);
// echo json_encode(["msg" => $msg]);