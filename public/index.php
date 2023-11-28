<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\Admincontrollers;
use Controllers\APIcontrollers;
use Controllers\Citacontrollers;
use Controllers\LoginControllers;
use Controllers\ServicioControllers;
use MVC\Router;


$router = new Router();

//login
$router->get('/',[LoginControllers::class,'login']);
$router->post('/',[LoginControllers::class,'login']);
$router->get('/logout',[LoginControllers::class,'logout']);

//Recuperar Password
$router->get('/olvide_password',[LoginControllers::class,'olvide']);
$router->post('/olvide_password',[LoginControllers::class,'olvide']);
$router->get('/recuperar_password',[LoginControllers::class,'recuperar_password']);
$router->post('/recuperar_password',[LoginControllers::class,'recuperar_password']);

//crear cuenta
$router->get('/crear_cuenta',[LoginControllers::class,'create']);
$router->post('/crear_cuenta',[LoginControllers::class,'create']);
//confirmar cuenta
$router->get('/confirmar_cuenta',[LoginControllers::class,'confirmar']);
$router->get('/mensaje',[LoginControllers::class,'mensaje']);

//area privada

$router->get('/cita',[Citacontrollers::class,'index']);
$router->get('/admin',[Admincontrollers::class,'index']);

//API Citas
$router->get('/api/servicios',[APIcontrollers::class,'index']);
$router->post('/api/citas',[APIcontrollers::class,'save']);
$router->post('/api/eliminar',[APIcontrollers::class,'eliminar']);

//CRUD SERVICIOS
$router->get('/servicios',[ServicioControllers::class,'index']);
$router->get('/servicios/crear',[ServicioControllers::class,'crear']);
$router->post('/servicios/crear',[ServicioControllers::class,'crear']);
$router->get('/servicios/actualizar',[ServicioControllers::class,'actualizar']);
$router->post('/servicios/actualizar',[ServicioControllers::class,'actualizar']);
$router->post('/servicios/eliminar',[ServicioControllers::class,'eliminar']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();