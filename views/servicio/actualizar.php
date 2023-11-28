<h1 class="nombre-pagina">Actualizar servicio</h1>
<p class="descripcion-pagina">Modifica el servicio</p>


  
<?php


include_once __DIR__ . '/../templates/alertas.php';
?>



<form class="formulario" method="POST">
   <?php
    include_once __DIR__ . '/formulario.php';
   ?>
   <input type="submit"  class="boton" value="Actualizar servicio">
</form>
<div class="acciones">
   <a href="/admin">Volver</a>
</div>
