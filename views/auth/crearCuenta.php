<h1 class="nombre-pagina">Crea una cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario</p>

<?php
    include_once __DIR__ . '/../tamplates/alertas.php';

    
    
?>

<form action="/crearCuenta" class="formulario" method="POST">

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" value="<?php echo s($usuario->nombre); ?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu apellido" value="<?php echo s($usuario->apellido); ?>">
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Ingresa tu telefono" value="<?php echo s($usuario->telefono); ?>">
    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email" value="<?php echo s($usuario->email); ?>">
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Ingresa un password">
    </div>

    <div class="campo captcha">
        <div class="g-recaptcha" class="rc-imageselect" data-sitekey="6LeOwN8iAAAAAPWDQX1XbuTtEYxfLDHIESejzlIj"></div>
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">

</form>

<div class="acciones">

    <a href="/">¿Ya tienes una cuenta? Inicia Sesión...</a>
    <a href="/olvide">¿Olvidaste tu password?</a>

</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>