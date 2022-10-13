<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Reestablecelo escribiendo tu email a continuación...</p>

<?php
include_once __DIR__ . '/../tamplates/alertas.php';
?>

<form action="/olvide" class="formulario" method="POST">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email">
    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones">

</form>

<div class="acciones">

    <a href="/">¿Ya tienes una cuenta? Inicia Sesión...</a>
    <a href="/crearCuenta">¿Aún no tienes cuenta? Crea una...</a>

</div>

<!-- <div class="footer">

    <p class="copyright">Creado y Desarrolalado por: <a class="link" href="http://facilitadora.com.ar">facilitadora.com.ar</a></p>

</div> -->