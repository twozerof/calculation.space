<?php
namespace Controllers;
use Classes\Thermocouples;
class ThermocouplesController
{
    public function index()
    {
        $class = new Thermocouples();
        $data = [
            'title' => '',
            'description' => '',
            'list_type' => $class->list_type,
        ];
        include 'views/thermocouples/index.php';
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
        $class = new Thermocouples();
        if (isset($input['value']) && $input['type'] <= count($class->list_type) && $input['type'] >= 0){
            $value = is_numeric($input['value']) ? floatval($input['value']) : 0;
            $compensation = is_numeric($input['compensation']) ? floatval($input['compensation']) : 0;
            $convert = boolval($input['convert']);
            $cj = 0;
            $err = [];
            if ($convert){
                if ($compensation != 0){
                    $polinom_for_cj = $class->get_poli($compensation, $input['type'], false, $class->list_type);
                    $cj = $polinom_for_cj['count'] > 0 ? $class->get_result($compensation, $polinom_for_cj['poli'], $polinom_for_cj['count'], $polinom_for_cj['append']) : 0;
                }
                $polinom = $class->get_poli($value-$cj, $input['type'], $convert, $class->list_type);
                if ($polinom['count'] > 0) {
                    $temperature = $class->get_result($value+$cj, $polinom['poli'], $polinom['count'], $polinom['append']);
                    $delta = $class->getDelta([
                        'temperature' => $temperature,
                        'type' => $class->list_type[$input['type']]['case'],
                    ]);
                    $result = [
                        'success' => false,
                        'emf' => $value,
                        'temperature' => round($temperature, 1),
                        'type' => $polinom['type']['type'],
                    ];
                } else {
                    $err[] = "Вне диапазона";
                }
            } else {
                $polinom = $class->get_poli($value, $input['type'], $convert, $class->list_type);
                if ($polinom['count'] > 0) {
                    if ($compensation != 0){
                        $polinom_for_cj = $class->get_poli($compensation, $input['type'], $convert, $class->list_type);
                        $cj = $polinom_for_cj['count'] > 0 ? $class->get_result($compensation, $polinom_for_cj['poli'], $polinom_for_cj['count'], $polinom_for_cj['append']) : 0;
                    }
                    $emf = $class->get_result($value, $polinom['poli'], $polinom['count'], $polinom['append'])-$cj;
                    $delta = $class->getDelta([
                        'temperature' => $value,
                        'type' => $class->list_type[$input['type']]['case'],
                    ]);
                    $result = [
                        'success' => false,
                        'emf' => round($emf, 4),
                        'temperature' => $value,
                        'type' => $polinom['type']['type'],
                    ];
                } else {
                    $err[] = "Вне диапазона";
                }
            }
            if(is_array($delta))
            {
                $html = '<table><thead><tr><th>Класс допуска</th><th>Допускаемое отклонение</th></tr></thead>';
                foreach($delta as $k => $item)
                {
                    $item = round($item, 2);
                    $html .= "<tr><td>$k</td><td>$item °C</td></tr>";
                }
                $html .= '</table>';
                $result['delta'] = $html;
            }
            else
            {
                $result['delta'] = '';
            }
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        } elseif (isset($input['ok'])) {
            $err[] = "Одно или несколько полей заполнено некорректно";
        }
    }
}