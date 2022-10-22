<div class='barra'>
    <p>Hola: <?php echo $nombre ?? ''; ?></p>
    <a class='boton' href="/logout">Cerrar Sesión</a>
</div>

<?php if (isset($_SESSION['admin'])) { ?>

    <div class='barra-servicios'>
        <a class='tabs' href="/admin">Ver Turnos</a>
        <a class='tabs' href="/servicios">Ver Servicios</a>
        <a class='tabs' href="/servicios/crear">Nuevo Servicio</a>
    </div>

<?php } ?>