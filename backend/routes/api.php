<?php

use Controllers\AuthController;
use Controllers\FaturasController;

// Configuração dos headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Verifica a requisição
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];


if ($uri === "/public/index.php/api/login" && $method === "POST") {
    $controller = new AuthController();
    $controller->login();

} elseif ($uri === "/public/index.php/api/invoices" && $method === "POST") {
    $controller = new FaturasController();
    $controller->addInvoice();

} elseif (strpos($uri, "/public/index.php/api/invoices") === 0 && $method === "GET") {
    $userId = basename($uri);
    $controller = new FaturasController();
    $controller->getUserInvoices($userId);

} elseif ($uri === "/public/index.php/api/invoices" && $method === "DELETE") {
    $controller = new FaturasController();
    $controller->removeInvoice();

} else {
    echo json_encode(value: ["success" => false, "message" => "Rota não encontrada", "uri" => $uri]);
}

?>