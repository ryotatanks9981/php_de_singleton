<?php

use Firebase\JWT\JWT;

require "vendor/autoload.php";

$users = [
    ["id" => "foo", "hash" => password_hash("bar", PASSWORD_DEFAULT)],
];
$jwt = "";

if (!isset($_POST["id"]) || !isset($_POST["pass"])) {
    header("Content-Type: application/json");
    http_response_code(400);
    echo json_encode([
        "msg" => "did not send user id or password",
        "jwt" => $jwt
    ]);
    exit();
}

$status = 400;
$msg = "not match user id or password";

foreach ($users as $user) {
    if ($user["id"] === $_POST["id"] && password_verify($_POST["pass"], $user["pass"])) {
        $status = 200;
        $msg = "ok";
        break;
    }
}

$token = [
    "iss" => "example.com",
    "name" => $_POST["id"],
    "exp" => time() + 3600,
];

$key = "secret_key";
$jwt = JWT::encode($token, $key);

header("Content-Type: application/json");
http_response_code($status);
echo json_encode([
    "msg" => $msg,
    "jwt" => $jwt,
    $_POST
]);

