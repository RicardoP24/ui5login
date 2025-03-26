<?php
namespace Models;
use PDO;
use PDOException;
use Config\Database;

class Faturas
{

    private $conn;
    public function __construct()
    {

        $db = new Database();
        $this->conn = $db->connect();
    }

    public function addInvoice($userId, $amount, $description) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO invoices (user_id, amount, description) VALUES (:user_id, :amount, :description)");
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":amount", $amount);
            $stmt->bindParam(":description", $description);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserInvoices($userId) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM invoices WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function removeInvoice($invoiceId, $userId) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM invoices WHERE id = :id AND user_id = :user_id");
            $stmt->bindParam(":id", $invoiceId);
            $stmt->bindParam(":user_id", $userId);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>