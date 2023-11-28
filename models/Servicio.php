<?php 
namespace Model;

class Servicio extends ActiveRecord{
    //base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id','nombre','precio'];
    public $id;
    public $nombre;
    public $precio;

     public function __construct($args = []) {
        $this->id = $args['id']??null;
        $this->nombre = $args['nombre']??'';
        $this->precio = $args['precio']??''; 
    }
    public function validar(){
        if(!$this->nombre){
            self::$alertas['error'][]='Debes colocar el nombre de tu servicio';
        }
        if(!$this->precio){
            self::$alertas['error'][]='Debes colocar el precio del servicio';
        }
        elseif(!is_numeric($this->precio)){
            self::$alertas['error'][]='No es un formato valido de precios';
        }
        
        return self::$alertas;
        
        
    }

}