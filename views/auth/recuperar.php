<h1 class="titulo-pagina">Restablecer password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password aqui</p>
<?php 
@include_once __DIR__. "../../templates/alertas.php";

?>

<?php if($error) return; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input 
        type="password"
        id="password"
        name="password"
        placeholder="Nuevo password">

    </div>
    <input type="submit" class="boton" value="Guardar nuevo password">
</form>

<div class="acciones">
    <a href="/">Ya tienes cuenta?Inicia Sesion</a>

</div>