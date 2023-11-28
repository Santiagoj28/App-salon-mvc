<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Iniciar sesion</p>

<?php 
@include_once __DIR__. "../../templates/alertas.php";

?>

<form method="POST" class="formulario" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input 
        type="email"
        name="email"
        id="email"
        placeholder="Tu email"
        value="<?php echo s($auth->email);?>"
        >
    </div>
    <div class="campo">
    <label for="password">Password</label>
        <input 
        type="password"
        name="password"
        id="password"
        placeholder="Tu password"
        >

    </div>
    <input type="submit" class="boton" value="Iniciar sesion">
</form>

<div class="acciones">
    <a href="/crear_cuenta">Aun no tienes una cuenta? Crea una</a>
    <a href="/olvide_password">Olvidaste tu password</a>
    
</div>
