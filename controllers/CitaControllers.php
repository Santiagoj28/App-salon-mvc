<?php
namespace Controllers;

use MVC\Router;

class Citacontrollers{
    public static function index(Router $router){
        session_start();

        isAuth();
       
        $router->render('cita/cita',[
        'nombre'=> $_SESSION['nombre'],
        'id'=>$_SESSION['id']
        ]);
    }
}