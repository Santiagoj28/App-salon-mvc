<h1 class="nombre-pagina">Olvide mi password</h1>
<p class="descripcion-pagina">Restablecer tu password escribiendo tu email a continuacion</p>
<?php 
@include_once __DIR__. "../../templates/alertas.php";

?>


<form action="" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email:</label>
        <input type="email"
        name="email"
        id="email"
        placeholder="Coloca el email de tu cuenta"
        >
    </div>
    <input type="submit" class="boton" value="Enviar instrucciones">
</form>


<div class="acciones">
    <a href="/">Volver</a>
    <a href="/">Aun no tienes una cuenta? Crea una</a>
    
</div>