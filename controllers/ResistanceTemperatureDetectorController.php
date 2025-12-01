<?php
namespace Controllers;

use Classes\ResistanceTemperatureDetector;

class ResistanceTemperatureDetectorController
{
    public function index()
    {
        $class = new ResistanceTemperatureDetector;
        $data = [
            'title' => '',
            'description' => '',
            'list_type' => $class->list_type,
        ];
        include 'views/resistance_temperature_detector/index.php';
    }
    public function handler()
    {
        $err = [];
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
        $class = new ResistanceTemperatureDetector;
        if(isset($input['value']) && isset($input['type'])){
            $value = is_numeric($input['value']) ? floatval($input['value']) : 0;
            $compensation = isset($input['compensation']) ? floatval($input['compensation']) : 0;
            $convert = boolval($input['convert']);
            $type = is_numeric($input['type']) ? $class->list_type[intval($input['type'])] : $class->list_type[0];
            $cj = 0;
            if ($convert) {
                $result = $class->om_to_c($type, $value);
                if ($result === false) $err[] = "Значение выходит за пределы измерения датчика";
                $result += $compensation == 0 ? 0 : $compensation;
                $result = [
                    'resistance' => $value,
                    'temperature' => round($result, 1),
                ];
            } else {
                $result = $class->c_to_om($type, $value);
                if ($result === false) $err[] = "Значение выходит за пределы измерения датчика";
                $result += $compensation == 0 ? 0 : $compensation;
                $result = [
                    'resistance' => round($result, 4),
                    'temperature' => $value,
                ];
            }
            if(!empty($err)) $result['error'] = implode(',', $err);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            die;
        } else {
            $err[] = "Неверно заполнена форма";
        }
    }
}