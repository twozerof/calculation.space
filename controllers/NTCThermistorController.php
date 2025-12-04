<?php
namespace Controllers;
use \Classes\NTCThermistor;
class NTCThermistorController
{
    public function index()
    {
        $class = new NTCThermistor();
        $data = [
            'title' => '',
            'description' => '',
        ];
        include 'views/ntc_thermistor/index.php';
    }
    public function handler()
    {
        header('Content-Type: application/json; charset=utf-8');
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);
        if ($input === null)
        {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Неверный JSON формат'
            ]);
            exit;
        }
        $class = new NTCThermistor();
    }
}