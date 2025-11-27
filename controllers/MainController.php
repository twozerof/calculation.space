<?php
namespace Controllers;
class MainController
{
    public function main()
    {
        $data = [
            'title' => '',
            'description' => '',
        ];
        include 'views/main/index.php';
    }
}