<h1 class="nombre-pagina">Crea una cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario</p>

<form action="/crearCuenta" class="formulario" method="POST">

    <div class="campo">
        <label for="text">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre">
    </div>

    <div class="campo">
        <label for="text">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu apellido">
    </div>

    <div class="campo">
        <label for="tel">Telefono</label>
        <input type="phone" id="telefono" name="telefono" placeholder="Ingresa tu telefono">
    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email">
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Ingresa un password">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">

</form>

<div class="acciones">

    <a href="/">¿Ya tienes una cuenta? Inicia Sesión...</a>
    <a href="/olvide">¿Olvidaste tu password?</a>

</div>

<!-- <div class="footer">

    <p class="copyright">Creado y Desarrolalado por: <a class="link" href="http://facilitadora.com.ar">facilitadora.com.ar</a></p>

</div> -->