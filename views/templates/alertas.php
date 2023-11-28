<?php 
//acceder a la llave del arreglo
foreach ($alertas as $key => $mensajes):
    
    //acceder a los mensajes de alertas 
      foreach($mensajes as $mensaje){

        //div con la key de la alerta y el mensaje de la alerta
 ?>   

 <div class="alerta <?php echo $key ?>">
 <?php echo $mensaje; ?>
</div>    

<?php
      }
endforeach;
?>

