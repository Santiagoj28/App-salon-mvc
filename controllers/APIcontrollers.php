<?php
namespace Controllers;

use Model\Cita;
use Model\CitaServicios;
use Model\Servicio;

class APIcontrollers{
    public static function index(){
       $servicio = Servicio::all();
      echo json_encode($servicio);
    }
    
    public static function save(){

      //almacenar la cita y obtener citaid
      $cita = new Cita($_POST);
      $resultado = $cita->guardar();

      $citaid = $resultado['id'];
     
    //separar con explode 1er parametro el separador y el segundo lo que se quiere separar
      $servicioid = explode(",",$_POST['servicios']);
     
      //itera y va a ir guardando cada uno de los servicios y las citas (relacion muchos a muchos)
      foreach($servicioid as $idservicio){
        $args = [
          'citaid'=> $citaid,
          'servicioid'=>$idservicio
        ];
        $citaServicios=new CitaServicios($args);
        $citaServicios->guardar();
      }
      
      //retornamos una respuesta
     

      echo json_encode(['resultado'=>$resultado]);
    }
    public static function eliminar(){
      if($_SERVER['REQUEST_METHOD']==='POST'){
        
        $cita = Cita::find( $_POST['id']);
        $cita->eliminar();
        header('location:' .  $_SERVER["HTTP_REFERER"]);

      }
     
    }
}
