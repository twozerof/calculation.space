<?php
namespace Classes;
class Thermocouples
{
    public $types_link = [
        'type_r' => 0,
        'type_s' => 1,
        'type_b' => 2,
        'type_j' => 3,
        'type_t' => 4,
        'type_e' => 5,
        'type_k' => 6,
        'type_n' => 7,
       'type_a1' => 8,
       'type_a2' => 9,
       'type_a3' => 10,
        'type_c' => 11,
        'type_g' => 12,
        'type_l' => 13,
        'type_m' => 14,
    ];
    public $list_type = [
        array('case' => 'type_r', 'type' => 'ТПП(R)', 'start' => -50, 'end' => 1768.1),
        array('case' => 'type_s', 'type' => 'ТПП(S)', 'start' => -50, 'end' => 1768.1),
        array('case' => 'type_b', 'type' => 'ТПР(B)', 'start' => 0, 'end' => 1820),
        array('case' => 'type_j', 'type' => 'ТЖК(J)', 'start' => -210, 'end' => 1200),
        array('case' => 'type_t', 'type' => 'ТМК(T)', 'start' => -270, 'end' => 400),
        array('case' => 'type_e', 'type' => 'ТХКн(E)', 'start' => -270, 'end' => 1000),
        array('case' => 'type_k', 'type' => 'ТХА(K)', 'start' => -270, 'end' => 1372),
        array('case' => 'type_n', 'type' => 'ТНН(N)', 'start' => -270, 'end' => 1300),
        array('case' => 'type_a1', 'type' => 'ТВР(A1)', 'start' => 0, 'end' => 2500),
        array('case' => 'type_a2', 'type' => 'ТВР(A2)', 'start' => 0, 'end' => 1800),
        array('case' => 'type_a3', 'type' => 'ТВР(A3)', 'start' => 0, 'end' => 1800),
        array('case' => 'type_c', 'type' => 'Type C', 'start' => 0, 'end' => 2315),
        array('case' => 'type_g', 'type' => 'Type G', 'start' => 1000, 'end' => 2315),
        array('case' => 'type_l', 'type' => 'ТХК(L)', 'start' => -200, 'end' => 800),
        array('case' => 'type_m', 'type' => 'ТМК(M)', 'start' => -200, 'end' => 100),
    ];
    public function getDelta($data)
    {
        switch($data['type'])
        {
            case 'type_r':
            case 'type_s':
                if($data['temperature'] >= 0 && $data['temperature'] <= 600) $result[2] = 1.5;
                if($data['temperature'] > 600 && $data['temperature'] <= 1600) $result[2] = $data['temperature']*0.0025;
                if($data['temperature'] >= 0 && $data['temperature'] <= 1100) $result[1] = 1.0;
                if($data['temperature'] > 1100 && $data['temperature'] <= 1600) $result[1] = 1+0.003*($data['temperature']-1100);
                break;
            case 'type_b':
                if($data['temperature'] >= 600 && $data['temperature'] <= 800) $result[3] = 4;
                if($data['temperature'] > 800 && $data['temperature'] <= 1800) $result[3] = $data['temperature']*0.005;
                if($data['temperature'] >= 600 && $data['temperature'] <= 1800) $result[2] = $data['temperature']*0.0025;
                break;
            case 'type_l':
                if($data['temperature'] >= -200 && $data['temperature'] <= -100) $result[3] = 1.5+0.01*abs($data['temperature']);
                if($data['temperature'] > -100 && $data['temperature'] <= 100) $result[3] = 2.5;
                if($data['temperature'] >= -40 && $data['temperature'] <= 360) $result[2] = 2.5;
                if($data['temperature'] > 360 && $data['temperature'] <= 800) $result[2] = 0.7+0.005*$data['temperature'];
                break;
            case 'type_e':
                if($data['temperature'] >= -200 && $data['temperature'] <= -167) $result[3] = 0.015*abs($data['temperature']);
                if($data['temperature'] > -167 && $data['temperature'] <= 40) $result[3] = 2.5;
                if($data['temperature'] >= -40 && $data['temperature'] <= 333) $result[2] = 2.5;
                if($data['temperature'] > 333 && $data['temperature'] <= 900) $result[2] = 0.0075*$data['temperature'];
                if($data['temperature'] >= -40 && $data['temperature'] <= 375) $result[1] = 1.5;
                if($data['temperature'] > 375 && $data['temperature'] <= 800) $result[1] = 0.004*$data['temperature'];
                break;
            case 'type_k':
            case 'type_n':
                if($data['temperature'] >= -250 && $data['temperature'] <= -167) $result[3] = 0.015*abs($data['temperature']);
                if($data['temperature'] > -167 && $data['temperature'] <= 40) $result[3] = 2.5;
                if($data['temperature'] >= -40 && $data['temperature'] <= 333) $result[2] = 2.5;
                if($data['temperature'] > 333 && $data['temperature'] <= 1300) $result[2] = 0.0075*$data['temperature'];
                if($data['temperature'] >= -40 && $data['temperature'] <= 375) $result[1] = 1.5;
                if($data['temperature'] > 375 && $data['temperature'] <= 1300) $result[1] = 0.004*$data['temperature'];
                break;
            case 'type_t':
                if($data['temperature'] >= -200 && $data['temperature'] <= -66) $result[3] = 0.015*abs($data['temperature']);
                if($data['temperature'] > -66 && $data['temperature'] <= 40) $result[3] = 1.0;
                if($data['temperature'] >= -40 && $data['temperature'] <= 135) $result[2] = 1.0;
                if($data['temperature'] > 135 && $data['temperature'] <= 400) $result[2] = 0.0075*$data['temperature'];
                if($data['temperature'] >= -40 && $data['temperature'] <= 125) $result[1] = 0.5;
                if($data['temperature'] > 125 && $data['temperature'] <= 350) $result[1] = 0.004*$data['temperature'];
                break;
            case 'type_j':
                if($data['temperature'] >= 0 && $data['temperature'] <= 333) $result[2] = 2.5;
                if($data['temperature'] > 333 && $data['temperature'] <= 900) $result[2] = 0.0075*$data['temperature'];
                if($data['temperature'] >= -40 && $data['temperature'] <= 375) $result[1] = 1.5;
                if($data['temperature'] > 375 && $data['temperature'] <= 750) $result[1] = 0.004*$data['temperature'];
                break;
            case 'type_m':
                if($data['temperature'] >= -200 && $data['temperature'] <= 0) $result['-'] = 1.3+0.001*abs($data['temperature']);
                if($data['temperature'] > 0 && $data['temperature'] <= 100) $result['-'] = 1.0;
                break;
            case 'type_a1':
            case 'type_a2':
            case 'type_a3':
                if($data['temperature'] >= 1000 && $data['temperature'] <= 2500)
                {
                    $result[3] = 0.007*$data['temperature'];
                    $result[2] = 0.005*$data['temperature'];
                }
                break;
        }
        return $result ?? false;
    }
    public function c_to_mv($type, $value){
        switch ($type) {
            case "type_r":
                if ($value >= -50 && $value < 1064.18){
                    return array(
                        0,
                        5.28961729765E-3,
                        1.39166589782E-5,
                        -2.38855693017E-8,
                        3.56916001063E-11,
                        -4.62347666298E-14,
                        5.00777441034E-17,
                        -3.73105886191E-20,
                        1.57716482367E-23,
                        -2.81038625251E-27,
                    );
                } elseif ($value >= 1064.18 && $value < 1664.5){
                    return array(
                        2.95157925316,
                        -2.52061251332E-3,
                        1.59564501865E-5,
                        -7.64085947576E-9,
                        2.05305291024E-12,
                        -2.93359668173E-16,
                    );
                } elseif ($value >= 1664.5 && $value <= 1768.1){
                    return array(
                        1.52232118209E2,
                        -2.68819888545E-1,
                        1.71280280471E-4,
                        -3.45895706453E-8,
                        -9.34633971046E-15,
                    );
                } else {
                    return false;
                }
            case "type_s":
                if ($value >= -50 && $value < 1064.18){
                    return array(
                        0,
                        5.40313308631E-3,
                        1.25934289740E-5,
                        -2.32477968689E-8,
                        3.22028823036E-11,
                        -3.31465196389E-14,
                        2.55744251786E-17,
                        -1.25068871393E-20,
                        2.71443176145E-24,
                    );
                } elseif ($value >= 1064.18 && $value < 1664.5){
                    return array(
                        1.32900444085,
                        3.34509311344E-3,
                        6.54805192818E-6,
                        -1.64856259209E-9,
                        1.29989605174E-14,
                    );
                } elseif ($value >= 1664.5 && $value < 1768.1){
                    return array(
                        1.46628232636E2,
                        -2.58430516752E-1,
                        1.63693574641E-4,
                        -3.30439046987E-8,
                        -9.43223690612E-15,
                    );
                } else {
                    return false;
                }
            case "type_b":
                if ($value >= 0 && $value < 630.615){
                    return array(
                        0,
                        -2.4650818346E-4,
                        5.9040421171E-6,
                        -1.3257931636E-9,
                        1.5668291901E-12,
                        -1.6944529240E-15,
                        6.2990347094E-19,
                    );
                } elseif ($value >= 630.615 && $value <= 1820){
                    return array(
                        -3.8938168621,
                        2.8571747470E-2,
                        -8.4885104785E-5,
                        1.5785280164E-7,
                        -1.6835344864E-10,
                        1.1109794013E-13,
                        -4.4515431033E-17,
                        9.8975640821E-21,
                        -9.3791330289E-25,
                    );
                } else {
                    return false;
                }
            case "type_j":
                if ($value >= -210 && $value < 760){
                    return array(
                        0,
                        5.0381187815E-2,
                        3.0475836930E-5,
                        -8.5681065720E-8,
                        1.3228195295E-10,
                        -1.7052958337E-13,
                        2.0948090697E-16,
                        -1.2538395336E-19,
                        1.5631725697E-23,
                    );
                } elseif ($value >= 760 && $value <= 1200){
                    return array(
                        2.9645625681E2,
                        -1.4976127786,
                        3.1787103924E-3,
                        -3.1847686701E-6,
                        1.5720819004E-9,
                        -3.0691369056E-13,
                    );
                } else {
                    return false;
                }
            case "type_t":
                if ($value >= -270 && $value < 0){
                    return array(
                        0,
                        3.8748106364E-2,
                        4.4194434347E-5,
                        1.1844323105E-7,
                        2.0032973554E-8,
                        9.0138019559E-10,
                        2.2651156593E-11,
                        3.6071154205E-13,
                        3.8493939883E-15,
                        2.8213521925E-17,
                        1.4251594779E-19,
                        4.8768662286E-22,
                        1.0795539270E-24,
                        1.3945027062E-27,
                        7.9795153927E-31,
                    );
                } elseif ($value >= 0 && $value <= 400){
                    return array(
                        0,
                        3.8748106364E-2,
                        3.3292227880E-5,
                        2.0618243404E-7,
                        -2.1882256846E-9,
                        1.0996880928E-11,
                        -3.0815758772E-14,
                        4.5479135290E-17,
                        -2.7512901673E-20,
                    );
                } else {
                    return false;
                }
            case "type_e":
                if ($value >= -270 && $value < 0){
                    return array(
                        0,
                        5.8665508708E-2,
                        4.5410977124E-5,
                        -7.7998048686E-7,
                        -2.5800160843E-8,
                        -5.9452583057E-10,
                        -9.3214058667E-12,
                        -1.0287605534E-13,
                        -8.0370123621E-16,
                        -4.3979497391E-18,
                        -1.6414776355E-20,
                        -3.9673619516E-23,
                        -5.5827328721E-26,
                        -3.4657842013E-29,
                    );
                } elseif ($value >= 0 && $value <= 1000){
                    return array(
                        0,
                        5.8665508710E-2,
                        4.5032275582E-5,
                        2.8908407212E-8,
                        -3.3056896652E-10,
                        6.5024403270E-13,
                        -1.9197495504E-16,
                        -1.2536600497E-18,
                        2.1489217569E-21,
                        -1.4388041782E-24,
                        3.5960899481E-28,
                    );
                } else {
                    return false;
                }
            case "type_k":
                if ($value >= -270 && $value < 0){
                    return array(
                        0,
                        3.9450128025E-2,
                        2.3622373598E-5,
                        -3.2858906784E-7,
                        -4.9904828777E-9,
                        -6.7509059173E-11,
                        -5.7410327428E-13,
                        -3.1088872894E-15,
                        -1.0451609365E-17,
                        -1.9889266878E-20,
                        -1.6322697486E-23,
                    );
                } elseif ($value >= 0 && $value <= 1372){
                    return array(
                        -1.7600413686E-2,
                        3.8921204975E-2,
                        1.8558770032E-5,
                        -9.9457592874E-8,
                        3.1840945719E-10,
                        -5.6072844889E-13,
                        5.6075059059E-16,
                        -3.2020720003E-19,
                        9.7151147152E-23,
                        -1.2104721275E-26,
                    );
                } else {
                    return false;
                }
            case "type_n":
                if ($value >= -270 && $value < 0){
                    return array(
                        0,
                        2.6159105962E-2,
                        1.0957484228E-5,
                        -9.3841111554E-8,
                        -4.6412039759E-11,
                        -2.6303357716E-12,
                        -2.2653438003E-14,
                        -7.6089300791E-17,
                        -9.3419667835E-20,
                    );
                } elseif ($value >= 0 && $value <= 1300){
                    return array(
                        0,
                        2.5929394601E-2,
                        1.5710141880E-5,
                        4.3825627237E-8,
                        -2.5261169794E-10,
                        6.4311819339E-13,
                        -1.0063471519E-15,
                        9.9745338992E-19,
                        -6.0863245607E-22,
                        2.0849229339E-25,
                        -3.0682196151E-29,
                    );
                } else {
                    return false;
                }
            case "type_a1":
                if ($value >= 0 && $value <= 2500){
                    return array(
                        7.1564735E-4,
                        1.1951905E-2,
                        1.6672625E-5,
                        -2.8287807E-8,
                        2.8397839E-11,
                        -1.8505007E-14,
                        7.3632123E-18,
                        -1.6148878E-21,
                        1.4901679E-25,
                    );
                } else {
                    return false;
                }
            case "type_a2":
                if ($value >= 0 && $value <= 1800){
                    return array(
                        -1.0850558E-4,
                        1.1642292E-2,
                        2.1280289E-5,
                        -4.4258402E-8,
                        5.5652058E-11,
                        -4.3801310E-14,
                        2.0228390E-17,
                        -4.9354041E-21,
                        4.8119846E-25,
                    );
                } else {
                    return false;
                }
            case "type_a3":
                if ($value >= 0 && $value <= 1800){
                    return array(
                        -1.0649133E-4,
                        1.1686475E-2,
                        1.8022157E-5,
                        -3.3436998E-8,
                        3.7081688E-11,
                        -2.5748444E-14,
                        1.0301893E-17,
                        -2.0735944E-21,
                        1.4678450E-25,
                    );
                } else {
                    return false;
                }
            case "type_c":
                if ($value >= 0 && $value <= 2315){
                    /*return array(
                        0,
                        0.7190027E-2,
                        0.3956443E-5,
                        -0.1842722E-8,
                        0.3471851E-12,
                        -0.2616792E-16,
                    );*/
                    return array(
                        -2.8508982068349564E-4,
                        1.3399269198668894E-2,
                        1.2214353922012759E-5,
                        -1.0439621409504520E-8,
                        3.5767945903631794E-12,
                        -4.9058085554296805E-16,
                    );
                } else {
                    return false;
                }
            case "type_g":
                if ($value >= 1000 && $value <= 2315){
                    /*return array(
                        0,
                        0.2883146E-3,
                        0.6783829E-5,
                        -0.1795965E-8,
                        0.2125270E-12,
                        -0.1176051E-16,
                    );*/
                    return array(
                        -3.3574095900471903E1,
                         1.1564386507106311E-1,
                        -1.2702462843405211E-4,
                         8.1848147796417868E-8,
                        -2.5419185264133758E-11,
                         3.0112926792421263E-15,
                    );
                } else {
                    return false;
                }
            case "type_l":
                if ($value >= -200 && $value < 0){
                    return array(
                        -5.8952244E-5,
                        6.3391502E-2,
                        6.7592964E-5,
                        2.0672566E-7,
                        5.5720884E-9,
                        5.7133860E-11,
                        3.2995593E-13,
                        9.9232420E-16,
                        1.2079584E-18,
                    );
                } elseif ($value >= 0 && $value <= 800){
                    return array(
                        -1.8656953E-5,
                        6.3310975E-2,
                        6.0153091E-5,
                        -8.0073134E-8,
                        9.6946071E-11,
                        -3.6047289E-14,
                        -2.4694775E-16,
                        4.2880341E-19,
                        -2.0725297E-22,
                    );
                } else {
                    return false;
                }
            case "type_m":
                if ($value >= -200 && $value <= 100){
                    return array(
                        2.4455560E-6,
                        4.2638917E-2,
                        5.0348392E-5,
                        -4.4974485E-8,
                    );
                } else {
                    return false;
                }
        }
    }
    public function mv_to_c($type, $value){
        switch ($type) {
            case "type_r":
                if ($value >= -0.226 && $value < 1.923){ //-50...250
                    return array(
                        0.0000000E0,
                        1.8891380E2,
                        -9.3835290E1,
                        1.3068619E2,
                        -2.2703580E2,
                        3.5145659E2,
                        -3.8953900E2,
                        2.8239471E2,
                        -1.2607281E2,
                        3.1353611E1,
                        -3.3187769E0,
                    );
                } elseif ($value >= 1.923 && $value < 11.361) { //250...1064
                    return array(
                        1.334584505E1,
                        1.472644573E2,
                        -1.844024844E1,
                        4.031129726E0,
                        -6.249428360E-1,
                        6.468412046E-2,
                        -4.458750426E-3,
                        1.994710149E-4,
                        -5.313401790E-6,
                        6.481976217E-8,
                    );
                } elseif ($value >= 11.361 && $value < 19.739) { //1064...1664.5
                    return array(
                        -8.199599416E1,
                        1.553962042E2,
                        -8.342197663E0,
                        4.279433549E-1,
                        -1.191577910E-2,
                        1.492290091E-4,
                    );
                } elseif ($value >= 19.739 && $value <= 21.103) { //1664...1768.1
                    return array(
                        3.406177836E4,
                        -7.023729171E3,
                        5.582903813E2,
                        -1.952394635E1,
                        2.560740231E-1,
                    );
                } else {
                    return false;
                }
            case "type_s":
                if ($value >= -0.235 && $value < 1.874){ //-50...250
                    return array(
                        0.00000000E0,
                        1.84949460E2,
                        -8.00504062E1,
                        1.02237430E2,
                        -1.52248592E2,
                        1.88821343E2,
                        -1.59085941E2,
                        8.23027880E1,
                        -2.34181944E1,
                        2.79786260E0,
                    );
                } elseif ($value >= 1.874 && $value < 10.332) { //250...1064
                    return array(
                        1.291507177E1,
                        1.466298863E2,
                        -1.534713402E1,
                        3.145945973E0,
                        -4.163257839E-1,
                        3.187963771E-2,
                        -1.291637500E-3,
                        2.183475087E-5,
                        -1.447379511E-7,
                        8.211272125E-9,
                    );
                } elseif ($value >= 10.332 && $value < 17.536) { //1064...1664.5
                    return array(
                        -8.087801117E1,
                        1.621573104E2,
                        -8.536869453E0,
                        4.719686976E-1,
                        -1.441693666E-2,
                        2.081618890E-4,

                    );
                } elseif ($value >= 17.536 && $value <= 18.693) { //1664...1768.1
                    return array(
                        5.333875126E4,
                        -1.235892298E4,
                        1.092657613E3,
                        -4.265693686E1,
                        6.247205420E-1,
                    );
                } else {
                    return false;
                }
            case "type_b":
                if ($value >= 0.291 && $value < 2.431){ //250...700
                    return array(
                        9.8423321E1,
                        6.9971500E2,
                        -8.4765304E2,
                        1.0052644E3,
                        -8.3345952E2,
                        4.5508542E2,
                        -1.5523037E2,
                        2.9886750E1,
                        -2.4742860E0,
                    );
                } elseif ($value >= 2.431 && $value <= 13.820) { //700...1820
                    return array(
                        2.1315071E2,
                        2.8510504E2,
                        -5.2742887E1,
                        9.9160804E0,
                        -1.2965303E0,
                        1.1195870E-1,
                        -6.0625199E-3,
                        1.8661696E-4,
                        -2.4878585E-6,
                    );
                }  else {
                    return false;
                }
            case "type_j":
                if ($value >= -8.095 && $value < 0){ //-210...0
                    return array(
                        0.0000000E0,
                        1.9528268E1,
                        -1.2286185E0,
                        -1.0752178E0,
                        -5.9086933E-1,
                        -1.7256713E-1,
                        -2.8131513E-2,
                        -2.3963370E-3,
                        -8.3823321E-5,
                    );
                } elseif ($value >= 0 && $value < 42.919) { //0...760
                    return array(
                        0.000000E0,
                        1.978425E1,
                        -2.001204E-1,
                        1.036969E-2,
                        -2.549687E-4,
                        3.585153E-6,
                        -5.344285E-8,
                        5.099890E-10,
                    );
                } elseif ($value >= 42.919 && $value <= 69.553) { //760...1200
                    return array(
                        -3.11358187E3,
                        3.00543684E2,
                        -9.94773230E0,
                        1.70276630E-1,
                        -1.43033468E-3,
                        4.73886084E-6,
                    );
                } else {
                    return false;
                }
            case "type_t":
                if ($value >= -5.603 && $value < 0){ //-200...0
                    return array(
                        0.0000000E0,
                        2.5949192E1,
                        -2.1316967E-1,
                        7.9018692E-1,
                        4.2527777E-1,
                        1.3304473E-1,
                        2.0241446E-2,
                        1.2668171E-3,
                    );
                } elseif ($value >= 0 && $value <= 20.872) { //0...400
                    return array(
                        0.000000E0,
                        2.592800E1,
                        -7.602961E-1,
                        4.637791E-2,
                        -2.165394E-3,
                        6.048144E-5,
                        -7.293422E-7,
                    );
                } else {
                    return false;
                }
            case "type_e":
                if ($value >= -8.825 && $value < 0){ //-200...0
                    return array(
                        0.0000000E0,
                        1.6977288E1,
                        -4.3514970E-1,
                        -1.5859697E-1,
                        -9.2502871E-2,
                        -2.6084314E-2,
                        -4.1360199E-3,
                        -3.4034030E-4,
                        -1.1564890E-5,
                    );
                } elseif ($value >= 0 && $value <= 76.373) { //0...1000
                    return array(
                        0.0000000E0,
                        1.7057035E1,
                        -2.3301759E-1,
                        6.5435585E-3,
                        -7.3562749E-5,
                        -1.7896001E-6,
                        8.4036165E-8,
                        -1.3735879E-9,
                        1.0629823E-11,
                        -3.2447087E-14,
                    );
                } else {
                    return false;
                }
            case "type_k":
                if ($value >= -5.891 && $value < 0){ //-200...0
                    return array(
                        0.000000E0,
                        2.5173462E1,
                        -1.1662878E0,
                        -1.0833638E0,
                        -8.9773540E-1,
                        -3.7342377E-1,
                        -8.6632643E-2,
                        -1.0450598E-2
                        -5.1920577E-4,

                    );
                } elseif ($value >= 0 && $value < 20.644) { //0...500
                    return array(
                        0.000000E0,
                        2.508355E1,
                        7.860106E-2,
                        -2.503131E-1,
                        8.315270E-2,
                        -1.228034E-2,
                        9.804036E-4,
                        -4.413030E-5,
                        1.057734E-6,
                        -1.052755E-8,
                    );
                } elseif ($value >= 20.644 && $value <= 54.886) { //500...1372
                    return array(
                        -1.318058E2,
                        4.830222E1,
                        -1.646031E0,
                        5.464731E-2,
                        -9.650715E-4,
                        8.802193E-6,
                        -3.110810E-8,
                    );
                } else {
                    return false;
                }
            case "type_n":
                if ($value >= -3.990 && $value < 0){ //-200...0
                    return array(
                        0.0000000E0,
                        3.8436847E1,
                        1.1010485E0,
                        5.2229312E0,
                        7.2060525E0,
                        5.8488586E0,
                        2.7754916E0,
                        7.7075166E-1,
                        1.1582665E-1,
                        7.3138868E-3,
                    );
                } elseif ($value >= 0 && $value < 20.613) { //0...600
                    return array(
                        0.00000E0,
                        3.86896E1,
                        -1.08267E0,
                        4.70205E-2,
                        -2.12169E-6,
                        -1.17272E-4,
                        5.39280E-6,
                        -7.98156E-8,
                    );
                } elseif ($value >= 20.613 && $value <= 47.513) { //600...1300
                    return array(
                        1.972485E1,
                        3.300943E1,
                        -3.915159E-1,
                        9.855391E-3,
                        -1.274371E-4,
                        7.767022E-7,
                    );
                } else {
                    return false;
                }
            case "type_a1":
                if ($value >= 0 && $value <= 33.640){ //0...2500
                    return array(
                        0.9643027,
                        7.9495086*10,
                        -4.9990310,
                        0.6341776,
                        -4.7440967E-2,
                        2.1811337E-3,
                        -5.8324228E-5,
                        8.2433725E-7,
                        -4.5928480E-9,
                    );
                } else {
                    return false;
                }
            case "type_a2":
                if ($value >= 0 && $value <= 27.232){ //0...1800
                    return array(
                        1.1196428,
                        8.0569397*10,
                        -6.2279122,
                        0.9337015,
                        -8.2608051E-2,
                        4.4110979E-3,
                        -1.3610551E-4,
                        2.2183851E-6,
                        -1.4527698E-8,
                    );
                } else {
                    return false;
                }
            case "type_a3":
                if ($value >= 0 && $value <= 26.773){ //0...1800
                    return array(
                        0.8769216,
                        8.1483231*10,
                        -5.9344173,
                        0.8699340,
                        -7.6797687E-2,
                        4.1814387E-3,
                        -1.3439670E-4,
                        2.342409E-6,
                        -1.6988727E-8,
                    );
                } else {
                    return false;
                }
            case "type_c":
                if ($value >= 0 && $value <= 37.070){ //0...2315
                    return array(
                        1.0296628317468555E+0,
                        7.0605666587756133E+1,
                       -2.4379417766489446E+0,
                        1.3615720688375876E-1,
                       -3.4276988567046060E-3,
                        3.6848981973459947E-5,
                    );
                } else {
                    return false;
                }
            case "type_g":
                if ($value >= 14.5 && $value <= 38.8){ //1000...2315
                    return array(
                        6.5562209205627346E+2,
                        -2.9397528517211391E+1,
                         6.3095685124938310E+0,
                        -2.3529148721096049E-1,
                         4.0014645264978711E-3,
                        -2.3163256620155347E-5
                    );
                } else {
                    return false;
                }

            case "type_l":
                if ($value >= -9.488 && $value <= 66.466){ //-200...800
                    return array(
                        3.1116085E-2,
                        1.5632542*10,
                        -0.2281310,
                        1.6061658E-2,
                        -1.2036818E-3,
                        5.7602230E-5,
                        -1.6144584E-6,
                        2.5988757E-8,
                        -2.2286755E-10,
                        7.8910747E-13,
                    );
                }  else {
                    return false;
                }
            case "type_m":
                if ($value >= -6.154 && $value <= 4.722){ //-200...100
                    return array(
                        0.4548090,
                        2.2657698E-2,
                        -7.7935652E-7,
                        1.1786931E-10,
                    );
                } else {
                    return false;
                }
            }
    }
    public function get_poli($value, $type, $convert, $list_type){

        $type = $list_type[$type];
        $poli = $convert ? $this->mv_to_c($type['case'], $value) : $this->c_to_mv($type['case'], $value);
        $count = $poli ? count($poli) : 0;
        $append = $type['case'] == "type_k" && $value >= 0 ? 1.185976E-1 * 2.718281828459045 ** (-1.183432E-4 * ($value - 126.9686) ** 2) : 0;
        return [
            'type' => $type,
            'poli' => $poli,
            'count' => $count,
            'append' => $append,
        ];

    }

    public function get_result($value, $poli, $count, $append){
        $result = 0;
        for ($i = 0; $i < $count; $i++) {
            $result += $poli[$i]*$value**$i+$append;
        }
        return $result;

    }
}