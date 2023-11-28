<h1 class="nombre-pagina">Crear una cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php 
@include_once __DIR__. "../../templates/alertas.php";

?>

<form  method="POST" class="formulario" >
    <div class="campo">
      <label for="nombre">Nombre</label>
      <input type="text"
       placeholder="Tu nombre"
       id= "nombre"
       name="nombre"
       value="<?php echo s($usuario->nombre); ?>"
       >
     
    </div>
    <div class="campo">
      <label for="apellido">Apellido</label>
      <input type="text"
       placeholder="Tu Apellido"
       id='apellido'
       name="apellido"
       value= "<?php echo s($usuario->apellido)?>"
       >
       
    </div>
    <div class="campo">
      <label for="telefono">Telefono</label>
      <input type="tel"
       placeholder="Tu Telefono"
       id="telefono"
       name="telefono"
       maxlength="10"
       value=  "<?php echo s($usuario->telefono) ?>"
  
       >
    </div>
   
    <div class="campo">
      <label for="email">Email</label>
      <input type="email"
       placeholder="Tu Email"
       id="email"
       name="email"
       value= "<?php echo s($usuario->email) ?> ">
    </div>
    <div class="campo">
      <label for="password">Password</label>
      <input type="password"
       placeholder="Tu password"
       id="password"
       name="password"
       value=""
       >
    </div>
   
    <input type="submit" class="boton" value="Crear cuenta">
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia sesion</a>
   
    
</div>