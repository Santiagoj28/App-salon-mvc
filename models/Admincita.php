<?php
namespace Model;

class Admincita extends ActiveRecord{
    protected static $tabla = 'citasservicios';
    protected static $columnasDb = ['id','hora','cliente','email','telefono','servicios','precio'];

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicios;
    public $precio;
   
   public function __construct($args = []) {
    $this->id=$args['id']??null;
    $this->id=$args['hora']??'';
    $this->id=$args['cliente']??'';
    $this->id=$args['email']??'';
    $this->id=$args['telefono']??'';
    $this->id=$args['servicios']??'';
    $this->id=$args['precio']??'';
}     
     
}   