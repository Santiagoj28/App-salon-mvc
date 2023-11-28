<?php 
namespace Model;

class Usuario extends ActiveRecord{
    //nombre de la tabla
    protected static $tabla = 'usuarios';
    //itera sobre todos los registros y los inserta en el objeto en memoria
    protected static $columnasDB = ['id','nombre','apellido','email','password','telefono','confirmado','admin','token'];

    //colocar todos los atributos,para acceder a ellos en la clase o en el objeto instanciado 
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $password;
    public $confirmado;
    public $admin;
    public $token;
    

    public function __construct($args = []){
        //una vez se instancie el objeto que cree una nueva instancia de usuario
        //para agregar los argumentos con los atributos de nuestra clase 
        $this->id=$args ['id']??null;
        //base de datos $this = name [nombre]
        $this->nombre=$args['nombre']??'';
        $this->apellido=$args['apellido']??'';
        $this->telefono=$args['telefono']??'';
        $this->email=$args['email']??'';
        $this->password=$args['password']??'';
        
        $this->confirmado=$args['confirmado']??0;
        $this->admin=$args['admin']??0;
        $this->token=$args['token']??'';
        
    }

    public function validar(){
        if(!$this->nombre){
            self::$alertas['error'] []="Debes colocar tu nombre ";
        }
        if(!$this->apellido){
            self::$alertas['error'][]="Debes colocar tu apellido ";
        }
        if(!$this->telefono){
            self::$alertas['error'][]="El telefono es obligatorio  ";
        } else if(!preg_match('/^[0-9]+$/',$this->telefono)){
            self::$alertas['error'][]="Ingresa un numero de telefono valido";
        }
        if(!$this->email){
            self::$alertas['error'][]="Email es obligatorio ";
        }
        if(!$this->password){
            self::$alertas['error'][]="El password es obligatorio  ";
        }
        else if (strlen( $this->password)<6){
            self::$alertas['error'][]="Debe contener minimo 6 caracteres";
        }
        return self::$alertas;
    }
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][]="El email es obligatorio";
        }
        if(!$this->password){
            self::$alertas['error'][]="El password es obligatorio";
        }
        return self::$alertas;
    }
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][]="Debes colocar el email de tu cuenta";
        }
        return self::$alertas;
    }
    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][]='El password es obligatorio';
        }else if (strlen( $this->password < 6)){
            self::$alertas['error'][]='El password debe tener minimo 6 caracteres';

        }
        return self::$alertas;
    }
    //revisar si el usuario ya existe
    public function existeUsuario(){
          //si estuviera dentro de login puedo acceder con usuarios
        $query =" SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "'LIMIT 1";
        //leer los usuarios que tengo en memoria
        $resultado = self::$db->query($query);
       //utilizo una sintaxis de flecha porque es un object
        if($resultado->num_rows){
            self::$alertas['error'][]="El usuario esta registrado";
        }
        return $resultado;
    }
    public function hashPassword(){
        $this->password = password_hash($this->password , PASSWORD_BCRYPT);
    }   
    public function crearToken(){
        $this->token = uniqid();
    }
    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password,$this->password);
       
        if(!$this->confirmado||!$resultado){
            self::$alertas['error'][]='Password incorrecto o tu cuenta no ha sido confirmada.';
        }else{
            return true;
        }
        
    }
    
}
