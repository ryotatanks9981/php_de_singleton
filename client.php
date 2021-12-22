<?php
use Firebase\JWT\JWT;

$json = http_request_post(
    "http://localhost/jwt/auth.php",
    [
        "body" => [
            "id" => "foo",
            "pass" => "bar",
        ],
    ]
);

$jwt = json_decode($json, true)["jwt"];
$ret = http_request_get(
    "http://localhost/jwt",
    [
        "headers" => [
            "Authorization" => "Bearer" . $jwt
        ]
    ]
);

function http_request_get($url, $args = null) {
    $header = "";

    if (!empty($args["headers"])) {
        foreach ($args["headers"] as $key => $value) {
            $header .= $key . ": " . $value . "\r\n";
        }
    }

    $opts["http"] = [
        "method" => "GET",
        "header" => $header
    ];
    $context = stream_context_create($opts);

    return file_get_contents($url, false, $context);
}

function http_request_post($url, $args = null) {
    $opts["http"]["method"] = "POST";
    $header = "";

    if (!empty($args["headers"])) {
        foreach ($args["headers"] as $key => $value) {
            $header .= $key . ": " . $value . "\r\n";
        }
    }

    $opts["http"]["header"] = $header;

    if (is_array($args["body"])) {
        $body = http_build_query($args["body"], "", "&", PHP_QUERY_RFC3986);
        $opts["http"]["header"] .= "\r\nContent-Type: application/x-www-form-urlencoded";
        $opts["http"]["content"] = $body;
    } else {
        $opts["http"]["content"] = $args["body"];
    }

    $context = stream_context_create($opts);

    return file_get_contents($url, false, $context);
}
