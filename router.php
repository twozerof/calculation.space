<?php

use Controllers\ResistanceTemperatureDetectorController;
use Controllers\MainController;
use Controllers\ThermocouplesController;
use Controllers\NTCThermistorController;


class Router{
    public function run(){
        $page = $_GET['page'] ?? 'main';
        $action = $_GET['action'] ?? '';
        switch($page) {
            default:
            case 'main':
                $controller = new MainController();
                $controller->main();
                break;
            case 'thermocouples':
                $controller = new ThermocouplesController();
                switch($action)
                {
                    case 'index':
                        $controller->index();
                        break;
                    case 'handler':
                        $controller->handler();
                        break;
                }
                break;
            case 'resistance_temperature_detector':
                $controller = new ResistanceTemperatureDetectorController;
                switch($action)
                {
                    case 'index':
                        $controller->index();
                        break;
                    case 'handler':
                        $controller->handler();
                        break;
                }
                break;
            case 'ntc_thermistor':
                $controller = new NTCThermistorController;
                switch($action)
                {
                    case 'index':
                        $controller->index();
                        break;
                    case 'handler':
                        $controller->handler();
                        break;
                }
                break;
            }
        }
    }