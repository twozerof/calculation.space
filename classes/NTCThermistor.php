<?php

namespace Classes;

class NTCThermistor
{
    public array $err = [];

    public function calculateB($r1, $r2, $t1, $t2)
    {
        return round((log($r1) - log($r2))/(1/($t1+273.15) - 1/($t2+273.15)));
    }

    public function calculateT($r1, $r2, $b, $t2)
    {
        return round(1/((log($r1)-log($r2))/$b + 1/($t2+273.15))-273.5, 1);
    }
    public function calculateR($r2, $b, $t1, $t2)
    {
        return round($r2 * exp($b * (1/($t1+273.15) - 1/($t2+273.15))), 1);
    }
    public function getParameter($name)
    {
        if(!is_numeric($_POST[$name])) return false;

        switch($name){
            default:
                return false;
            case 't1':
            case 't2':
                if($_POST[$name] < -100 || $_POST[$name] > 1000) return 25;
                break;
            case 'r1':
            case 'r2':
                if($_POST[$name] < 0 || $_POST[$name] > 300001) return 10000;
                break;
            case 'b':
                if($_POST[$name] < 0 || $_POST[$name] > 9999) return 3950;
                break;
            case 'tol':
                if($_POST[$name] <= 0 || $_POST[$name] >= 50) return 5;
                break;
        }
        return floatval($_POST[$name]); 
    }

    public function ntc(){
        $result = [];
        if(isset($_POST['calculateB']))
        {
            $result['calculateB']['r1'] = $this->getParameter('r1');
            $result['calculateB']['r2'] = $this->getParameter('r2');
            $result['calculateB']['t1'] = $this->getParameter('t1');
            $result['calculateB']['t2'] = $this->getParameter('t2');
            $result['calculateB']['b'] = $this->calculateB($result['calculateB']['r1'], $result['calculateB']['r2'], $result['calculateB']['t1'], $result['calculateB']['t2']);
        }
        elseif(isset($_POST['calculateR']))
        {
            $result['calculateR']['r1'] = $this->getParameter('r1');
            $result['calculateR']['b'] = $this->getParameter('b');
            $result['calculateR']['t1'] = $this->getParameter('t1');
            $result['calculateR']['t2'] = $this->getParameter('t2');
            $result['calculateR']['tol'] = $this->getParameter('tol');
            $result['calculateR']['r'] = $this->calculateR($result['calculateR']['r1'], $result['calculateR']['b'], $result['calculateR']['t2'], $result['calculateR']['t1']);
        }
        elseif(isset($_POST['calculateT']))
        {
            $result['calculateT']['r1'] = $this->getParameter('r1');
            $result['calculateT']['r2'] = $this->getParameter('r2');
            $result['calculateT']['b'] = $this->getParameter('b');
            $result['calculateT']['t1'] = $this->getParameter('t1');
            $result['calculateT']['tol'] = $this->getParameter('tol');
            $result['calculateT']['tmax'] = $this->calculateT($result['calculateT']['r2']-$result['calculateT']['r2']*$result['calculateT']['tol']/100, $result['calculateT']['r1'], $result['calculateT']['b'], $result['calculateT']['t1']);
            $result['calculateT']['tmin'] = $this->calculateT($result['calculateT']['r2']+$result['calculateT']['r2']*$result['calculateT']['tol']/100, $result['calculateT']['r1'], $result['calculateT']['b'], $result['calculateT']['t1']);
            $result['calculateT']['t'] = $this->calculateT($result['calculateT']['r2'], $result['calculateT']['r1'], $result['calculateT']['b'], $result['calculateT']['t1']);
        }
    }
}