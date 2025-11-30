<?php
namespace Classes;
class ResistanceTemperatureDetector
{
    public $types_link = [
        'pt10' => 0,
        'pt50' => 1,
        'pt100' => 2,
        'pt500' => 3,
        'pt1000' => 4,
        '10p' => 5,
        '50p' => 6,
        '100p' => 7,
        '500p' => 8,
        '1000p' => 9,
        '10m' => 10,
        '50m' => 11,
        '100m' => 12,
        '50n' => 13,
        '100n' => 14,
        '500n' => 15,
        '1000n' => 16,
    ];
    public $list_type = array(
        array('case' => 'pt385', 'type' => 'Pt10', 'a' => 0.00385, 'r' => 10, 'start' => -200, 'end' => 850),
        array('case' => 'pt385', 'type' => 'Pt50', 'a' => 0.00385, 'r' => 50, 'start' => -200, 'end' => 850),
        array('case' => 'pt385', 'type' => 'Pt100', 'a' => 0.00385, 'r' => 100, 'start' => -200, 'end' => 850),
        array('case' => 'pt385', 'type' => 'Pt500', 'a' => 0.00385, 'r' => 500, 'start' => -200, 'end' => 850),
        array('case' => 'pt385', 'type' => 'Pt1000', 'a' => 0.00385, 'r' => 1000, 'start' => -200, 'end' => 850),
        array('case' => 'pt391', 'type' => '10П', 'a' => 0.00391, 'r' => 10, 'start' => -200, 'end' => 850),
        array('case' => 'pt391', 'type' => '50П', 'a' => 0.00391, 'r' => 50, 'start' => -200, 'end' => 850),
        array('case' => 'pt391', 'type' => '100П', 'a' => 0.00391, 'r' => 100, 'start' => -200, 'end' => 850),
        array('case' => 'pt391', 'type' => '500П', 'a' => 0.00391, 'r' => 500, 'start' => -200, 'end' => 850),
        array('case' => 'pt391', 'type' => '1000П', 'a' => 0.00391, 'r' => 1000, 'start' => -200, 'end' => 850),
        array('case' => 'cu428', 'type' => '10М', 'a' => 0.00428, 'r' => 10, 'start' => -180, 'end' => 200),
        array('case' => 'cu428', 'type' => '50М', 'a' => 0.00428, 'r' => 50, 'start' => -180, 'end' => 200),
        array('case' => 'cu428', 'type' => '100М', 'a' => 0.00428, 'r' => 100, 'start' => -180, 'end' => 200),
        array('case' => 'ni617', 'type' => '50Н', 'a' => 0.00617, 'r' => 50, 'start' => -60, 'end' => 180),
        array('case' => 'ni617', 'type' => '100Н', 'a' => 0.00617, 'r' => 100, 'start' => -60, 'end' => 180),
        array('case' => 'ni617', 'type' => '500Н', 'a' => 0.00617, 'r' => 500, 'start' => -60, 'end' => 180),
        array('case' => 'ni617', 'type' => '1000Н', 'a' => 0.00617, 'r' => 1000, 'start' => -60, 'end' => 180),
    );
    public function c_to_om($type, $value){
        switch ($type['case']) {
            case 'pt385':
                $a = 3.9083E-3;
                $b = -5.775E-7;
                $c = -4.183E-12;
                if($value >= -200 && $value < 0){
                    return $type['r']*(1+$a*$value+$b*$value**2+$c*($value-100)*$value**3);
                } elseif ($value >= 0 && $value <= 850) {
                    return $type['r']*(1+$a*$value+$b*$value**2);
                } else {
                    return false;
                }
            case 'pt391':
                $a = 3.9690E-3;
                $b = -5.841E-7;
                $c = -4.330E-12;
                if($value >= -200 && $value < 0){
                    return $type['r']*(1+$a*$value+$b*$value**2+$c*($value-100)*$value**3);
                } elseif ($value >= 0 && $value <= 850) {
                    return $type['r']*(1+$a*$value+$b*$value**2);
                } else {
                    return false;
                }
            case 'cu428':
                $a = 4.28E-3;
                $b = -6.2032E-7;
                $c = 8.5154E-10;
                if($value >= -180 && $value < 0){
                    return $type['r']*(1+$a*$value+$b*$value*($value+6.7)+$c*$value**3);
                } elseif ($value >= 0 && $value <= 200) {
                    return $type['r']*(1+$a*$value+$b*$value**2);
                } else {
                    return false;
                }
            case 'ni617':
                $a = 5.4963E-3;
                $b = 6.7556E-6;
                $c = 9.2004E-9;
                if($value >= -60 && $value < 100){
                    return $type['r']*(1+$a*$value+$b*$value**2);
                } elseif ($value >= 100 && $value <= 180) {
                    return $type['r']*(1+$a*$value+$b*$value**2+$c*($value-100)*$value**2);
                } else {
                    return false;
                }
        }
    }
    public function om_to_c($type, $value){
        $result = 0;
        switch($type['case']){
            case 'pt385':
                $resistance = [
                    10 => ['min' => 1.852, 'max' => 39.0481],
                    50 => ['min' => 9.26, 'max' => 195.24],
                    100 => ['min' => 18.52, 'max' => 390.48],
                    500 => ['min' => 92.60, 'max' => 1952.41],
                    1000 => ['min' => 185.2, 'max' => 3904.81],
                ];
                $a = 3.9083E-3;
                $b = -5.775E-7;
                $d = array(255.819, 9.14550, -2.92363, 1.79090);
                if ($value >= $resistance[$type['r']]['min'] && $value <= $resistance[$type['r']]['max']){
                    if(($value/$type['r']) < 1){
                        for ($i = 0; $i < 4; $i++){
                            $result += $d[$i]*($value/$type['r']-1)**($i+1); 
                        }
                    } else {
                        $result = (sqrt($a**2-4*$b*(1-$value/$type['r']))-$a)/(2*$b);
                    }
                } else {
                    $result = false;
                }
                return $result;
            case 'pt391':
                $resistance = [
                    10 => ['min' => 1.72, 'max' => 39.52],
                    50 => ['min' => 8.62, 'max' => 197.58],
                    100 => ['min' => 17.24, 'max' => 395.16],
                    500 => ['min' => 86.22, 'max' => 1975.82],
                    1000 => ['min' => 172.44, 'max' => 3951.64],
                ];
                $a = 3.9690E-3;
                $b = -5.841E-7;
                $d = array(255.903, 8.80035, -2.91506, 1.67611);
                if ($value >= $resistance[$type['r']]['min'] && $value <= $resistance[$type['r']]['max']){
                    if(($value/$type['r']) < 1){
                        for ($i = 0; $i < 4; $i++){
                            $result += $d[$i]*($value/$type['r']-1)**($i+1); 
                        }
                    } else {
                        $result = (sqrt($a**2-4*$b*(1-$value/$type['r']))-$a)/(2*$b);
                    }
                } else {
                    $result = false;
                }
                return $result;
            case 'cu428':
                $resistance = [
                    10 => ['min' => 2.05, 'max' => 18.56],
                    50 => ['min' => 10.26, 'max' => 92.80],
                    100 => ['min' => 20.53, 'max' => 185.60],
                ];
                $a = 4.28E-3;
                $d = array(233.87, 7.9370, -2.0062, -0.3953);
                if ($value >= $resistance[$type['r']]['min'] && $value <= $resistance[$type['r']]['max']){
                    if(($value/$type['r']) < 1){
                        for ($i = 0; $i < 4; $i++){
                            $result += $d[$i]*($value/$type['r']-1)**($i+1); 
                        }
                    } else {
                        $result = ($value/$type['r']-1)/$a;
                    }
                } else {
                    $result = false;
                }
                return $result;
            case 'ni617':
                $resistance = [
                    50 => ['min' => 34.73, 'max' => 111.60, 't100' => 80.8593],
                    100 => ['min' => 69.45, 'max' => 223.21, 't100' => 161.7186],
                    500 => ['min' => 347.27, 'max' => 1116.03, 't100' => 808.593],
                    1000 => ['min' => 694.54, 'max' => 2232.06, 't100' => 1617.186],
                ];
                $a = 5.4963E-3;
                $b = 6.7556E-6;
                $d = array(144.096, -25.502, 4.4876);
                if ($value >= $resistance[$type['r']]['min'] && $value <= $resistance[$type['r']]['max']){
                    if($value <= $resistance[$type['r']]['t100']){
                        $result = (sqrt($a**2-4*$b*(1-$value/$type['r']))-$a)/(2*$b);
                    } else {
                        $result = 100;
                        for ($i = 0; $i < 3; $i++){
                            $result += $d[$i]*($value/$type['r']-1.6172)**($i+1); 
                        }
                    }
                } else {
                    $result = false;
                }
                return $result;
        }
    }
}