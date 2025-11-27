<?php

use Controllers\MainController;
use Controllers\ThermocouplesController;


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
            }
        }
    }