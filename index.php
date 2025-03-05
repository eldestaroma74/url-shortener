<?php

session_start(); // Start the session

class UrlShortener {
    private string $baseUrl = "http://short.est/";

    public function encode(string $longUrl): string {
        if (!isset($_SESSION["urlDatabase"])) {
            $_SESSION["urlDatabase"] = [];
        }

        $shortCode = substr(md5($longUrl), 0, 6);
        $_SESSION["urlDatabase"][$shortCode] = $longUrl;

        return json_encode(["short_url" => $this->baseUrl . $shortCode]);
    }

    public function decode(string $shortCode): string {
        $longUrl = $_SESSION["urlDatabase"][$shortCode] ?? null;
        return json_encode(["long_url" => $longUrl]);
    }
}

$shortener = new UrlShortener();
$requestUri = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];

header("Content-Type: application/json");

if ($requestMethod === "POST" && strpos($requestUri, "/encode") === 0) {
    $data = json_decode(file_get_contents("php://input"), true);
    echo $shortener->encode($data["url"] ?? "");
} elseif ($requestMethod === "POST" && strpos($requestUri, "/decode") === 0) {
    $data = json_decode(file_get_contents("php://input"), true);
    $shortCode = str_replace("http://short.est/", "", $data["short_url"] ?? "");
    echo $shortener->decode($shortCode);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Endpoint not found"]);
}
