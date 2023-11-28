<h1 class="nombre-pagina">Panel de administracion</h1>

<?php

include_once __DIR__ . '/../templates/barrAdmin.php';
include_once __DIR__ . '/../templates/barra.php'
?>
<h2>Buscar citas</h2>
<div class="busqueda">
    <form class="formulario" method="POST">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date"
            id="fecha"
            name="fecha"
            value="<?php echo $fecha;?>"
            >
        </div>
    </form>
</div>
<?php if(count($citas)===0){
  echo '<h2>No hay citas</h2>';
}?>

<div id="citas-admin">
  <ul class="citas">
    <?php
    $idcita = '';
    foreach($citas as $key =>  $cita){
        //debuguear($cita);
        if($idcita !== $cita->id){
            $total = 0;
    ?>
     <li>     
          <h3 class="titulo-cita">Cita:</h3>
          <p>ID: <span><?php echo $cita->id ?></span></p>
          <p>Hora:<span><?php echo $cita->hora ?></span></p>
          <p>Cliente: <span><?php echo $cita->cliente ?></span> </p>
          <p>Email:<span><?php echo $cita->email ?></span> </p>
          <p>Telefono: <span><?php echo $cita->telefono ?></span> </p>
         <h4>Servicios</h4>
        <?php 
          $idcita=$cita->id; 
         } //FIN DE IF 
         $total += $cita->precio;
          ?>
 
        <p class="servicio"> <?php echo $cita->servicios. " <span class='precio'>$" . $cita->precio; ?></span></p>
        <?php  
         $actual = $cita->id;
         $proximo = $citas[$key + 1 ]->id??0;
         ?>
         
        <?php  if(esUltimo($actual,$proximo)){ ?>
          <div class="total-eliminar">
            <p class="total">Total: <span class="precio">$<?php echo $total; ?></span></p>

               <form action="/api/eliminar" method="POST">
                <input type="hidden" 
                 name="id"
                 value="<?php echo $cita->id ?>">
                 <input type="submit" 
                 class="boton-eliminar"
                 value="eliminar">
              </form>
            
          </div>
             

         <?php } //fin del ultimo ?>
    </li>     
       
     <?php }//fin de foreach ?>
  </ul>
    
</div>

<?php
  $script = "<script src='build/js/buscador.js'></script>"
?>

