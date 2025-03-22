<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once 'vendor/autoload.php';  // Carrega as dependências do Composer
require_once 'config.php';  // Inclui a configuração do banco de dados

use Dotenv\Dotenv;

// Carregar o arquivo .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Recebe os dados JSON da requisição
$data = json_decode(file_get_contents("php://input"));

// Verifica se os campos de usuário e senha estão preenchidos
if (!empty($data->username) && !empty($data->password)) {
    $username = $data->username;
    // $password = md5($data->password);  // Criptografa a senha (use bcrypt para mais segurança)
    $password = $data->password;  

    try {
        // Preparar a consulta SQL para evitar SQL Injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();

        // Verifica se encontrou um usuário
        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "Login bem-sucedido"]);
        } else {
            echo json_encode(["success" => false, "message" => "Usuário ou senha incorretos"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erro na execução da consulta: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Preencha todos os campos"]);
}
?>
