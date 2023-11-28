<?php
namespace Controllers;

use Model\Admincita;
use MVC\Router;

class Admincontrollers {
     public static function index(Router $router){
      session_start();
      isAdmin();
     $fecha = $_GET['fecha']?? date('Y-m-d');
     $fechas = explode('-',$fecha);

     if(!checkdate($fechas[1],$fechas[2],$fechas[0])){
      header('location:/404');
     };

      //$fecha = date('Y-m-d');
      //$imagen = true ;
      //$contenedor =true;
      
      //consultar a la base de datos
      $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
      $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicios, servicios.precio  ";
      $consulta .= " FROM citas  ";
      $consulta .= " LEFT OUTER JOIN usuarios ";
      $consulta .= " ON citas.usuarioId=usuarios.id  ";
      $consulta .= " LEFT OUTER JOIN citasServicios ";
      $consulta .= " ON citasservicios.citaid=citas.id ";
      $consulta .= " LEFT OUTER JOIN servicios ";
      $consulta .= " ON servicios.id=citasServicios.servicioId ";
      $consulta .= " WHERE fecha =  '${fecha}' ";

     $citas = Admincita::SQL($consulta);
     //debuguear($citas);
      $router->render('admin/index',[
        'nombre' =>$_SESSION['nombre'],
        'citas'=> $citas,
        'fecha'=>$fecha,
        //'imagen'=>$imagen,
        //'contenedor'=>$contenedor
      ]);
    }
}