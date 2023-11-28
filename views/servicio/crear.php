<h1 class="nombre-pagina">Crear un nuevo servicio</h1>
<p class="descripcion-pagina">Llena todos los campos para crear un nuevo servicio</p>

<?php 
 // include_once __DIR__ .'/../templates/barra.php';
?>

<?php
 include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">
  <?php
   include_once  __DIR__ .'/formulario.php';
  ?>
  <input type="submit" class="boton" value="Guardar servicio">
</form>

<div class="acciones">
    <a href="/admin">Volver</a>
   
    
</div>