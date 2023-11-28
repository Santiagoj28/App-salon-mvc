<?php 
namespace Controllers;

use Clasess\Email;
use Model\Usuario;
use MVC\Router;
use Model\ActiveRecord;


class LoginControllers{

    public static function login(Router $router) {
        $alertas = [];
        $auth = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);
                if($usuario) {
                    // Verificar el password
                    if( $usuario->comprobarPasswordAndVerificado($auth->password) ) {
                        // Autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        // Redireccionamiento
                        if($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                           
                        }    else {
                        header('Location: /cita');
                         }
                         debuguear($_SESSION);

                       
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }

            }
            
        }
        $alertas = Usuario::getAlertas();
        
        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth'=>$auth
        ]);
    }
   
    
    public static function logout(){
        session_start();
        $_SESSION = [];
       header('Location:/');        
    }
    public static function olvide(Router $router){
        $alertas=[];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if(empty($alertas)){
                $usuario = Usuario::where('email',$auth->email);
                if($usuario && $usuario->confirmado === "1"){

                $usuario->crearToken();
                $usuario->guardar();
                //enviar email 
                $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                $email->enviarInstrucciones();
                Usuario::setAlerta('exito','Revisa tu email');
                }else{
                    Usuario::setAlerta('error','El usuario no existe o no esta confirmado.');
                 
                }


            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide',[
            'alertas'=>$alertas
        ]);
        
    }

    public static function recuperar_password(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $error = false;
       
        $usuario= Usuario::where('token',$token);
       
        if(empty($usuario)){
            Usuario::setAlerta('error','Token no valido');
            $error=true;
        }
        if($_SERVER["REQUEST_METHOD"]==='POST'){
            //leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

           if(empty($alertas)){
            $usuario->password = null;
            $usuario->password = $password->password;
            $usuario->hashPassword();
            $usuario->token = null;

            $resultado = $usuario->guardar();
            if($resultado){
                header('Location:/');
            }
            
           }

        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar',[
        'alertas'=>$alertas,
        'error'=>$error
        ]);

    }
    public static function create(Router $router){
       
        //alertas vacias
        $alertas = [];
        $usuarios = new Usuario();
        if($_SERVER['REQUEST_METHOD']==='POST'){
            // una manera para que  se guarden los cambios $usuarios = new Usuario( $_POST);

            //sincronizar el objeto que esta vacio con los datos nuevos datos de post
            $usuarios->sincronizar($_POST);

            $alertas = $usuarios->validar();
            //revisar que el arreglo este vacio
            if(empty($alertas)){

                $resultado = $usuarios->existeUsuario();
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    //hashearpassword
                    $usuarios->hashPassword();
                    //crear token
                    $usuarios->crearToken();
                    //enviar el email y instanciarlo en email 
                    $email = new Email($usuarios->nombre,$usuarios->email,$usuarios->token);
                    //enviar confirmacion 
                    $email->enviarConfirmacion();
                    //crear el usuario 
                    $resultado = $usuarios->guardar();
                    if($resultado){
                       header('Location:/mensaje');
                    }
                  //debuguear($email);
                  
                }
            }
        }
        $router->render('auth/crear',[
            'usuario'=> $usuarios,
            'alertas'=>$alertas,
           
        ]);
       
    }
    public static function mensaje( Router $router){
        $router->render('auth/mensaje');
      
    }
    public static function confirmar(Router $router){
      
        $alertas =[];
        $token = s($_GET['token']);
        
       
       $usuarios = Usuario::where('token',$token);
       if(empty($usuarios)){
         ///mostrar mensaje de error
        Usuario::setAlerta('error','El token no es valido');  
       }else{
        $usuarios->confirmado ="1";
        $usuarios->token = null;
        $usuarios->guardar();
        Usuario::setAlerta('exito','Cuenta comprobada exitosamente');
       }
      
       
       $alertas = Usuario::getAlertas();
       
        $router->render('auth/confirmar_cuenta',[
            'alertas'=> $alertas
            
        ]);


    }
}

