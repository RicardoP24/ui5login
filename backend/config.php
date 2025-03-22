<?php
require_once 'vendor/autoload.php';  // Carrega as dependências do Composer

use Dotenv\Dotenv;

// Carregar o arquivo .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Definir configurações do banco
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
$port = $_ENV['DB_PORT'];

// Conectar ao PostgreSQL usando PDO
try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["success" => false, "message" => "Erro na conexão: " . $e->getMessage()]));
}
?>
