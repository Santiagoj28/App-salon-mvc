<?php 
namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioControllers{
    public static function index(Router $router){
        session_start();
        isAdmin();
        $servicio = Servicio::all();
        
        
        $router->render('servicio/index',[
            'nombre'=> $_SESSION['nombre'],
            'servicios'=>$servicio
        ]);
    }
    public static function crear(Router $router){
        session_start();
        isAdmin();
        $alertas = [];
        $servicio = new Servicio;
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if(empty($alertas)){
                $servicio->guardar();
                header('location:/servicios');
            }
        }
       
        $router->render('servicio/crear',[
            'nombre'=> $_SESSION['nombre'],
            'servicio'=>$servicio,
            'alertas'=> $alertas
        ]);
      
    }
    public static function actualizar(Router $router){
        session_start();
        isAdmin();
            $alertas = [];
            if(!is_numeric ($_GET['id']))return;
            $servicio =  Servicio::find(($_GET['id']));
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $servicio->sincronizar($_POST);
               $alertas = $servicio->validar();

               if(empty($alertas)){
                $servicio->guardar();
                header('location:/servicios');
               }
            
                
            }
            
        
        
        $router->render('servicio/actualizar',[
            'nombre'=> $_SESSION['nombre'],
            'servicio'=>$servicio,
            'alertas'=>$alertas
        ]);

    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
          $id = $_POST['id'];
          $servicio = Servicio::find($id);
          $servicio->eliminar();
          header('location:/servicios')  ;
                 }
        
           

    }
}