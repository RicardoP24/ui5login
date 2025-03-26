<?php

namespace Controllers;

use Models\Faturas;

class FaturasController {
    
    public function addInvoice() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['user_id'], $data['amount'], $data['description'])) {
            echo json_encode(["success" => false, "message" => "Dados incompletos"]);
            return;
        }

        $invoice = new Faturas();
        $result = $invoice->addInvoice($data['user_id'], $data['amount'], $data['description']);

        echo json_encode(["success" => $result]);
    }

    public function getUserInvoices($userId) {
        $invoice = new Faturas();
        $result = $invoice->getUserInvoices($userId);

        echo json_encode(["success" => true, "invoices" => $result]);
    }

    public function removeInvoice() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['invoice_id'], $data['user_id'])) {
            echo json_encode(["success" => false, "message" => "Dados incompletos"]);
            return;
        }

        $invoice = new Faturas();
        $result = $invoice->removeInvoice($data['invoice_id'], $data['user_id']);

        echo json_encode(["success" => $result]);
    }
}
