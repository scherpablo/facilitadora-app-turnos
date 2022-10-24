<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php
include_once __DIR__ . '/../tamplates/alertas.php';
?>

<form action="/" class="formulario" method="POST">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email">
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Ingresa un password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">

</form>

<div class="acciones">

    <a href="/crearCuenta">¿Aún no tienes cuenta? Crea una...</a>
    <a href="/olvide">¿Olvidaste tu password?</a>

</div>

<div class='datos'>
    <h4>Dirección</h4>
    <p class='datosP'>Diego Armando Maradona 3010</p>
    <p class='datosP'>Lomas de Zamora</p>
    <p class='datosP'>Buenos Aires, Argentina</p>
</div>

<div class='datos'>
    <h4>Días y Horarios</h4>
    <p class='datosP'>Martes a Sábados - 09:00 a 19:00 hs</p>
</div>