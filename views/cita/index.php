<h1 class="nombre-pagina">Crear Nuevo Turno</h1>
<p class="descripcion-pagina">Elige tus servicios y completa tus datos a continuación</p>

<div id='app'>
    <nav class='tabs'>
        <button class='actual' type='button' data-paso='1'>Servicios</button>
        <button type='button' data-paso='2'>Info Turnos</button>
        <button type='button' data-paso='3'>Resumen</button>
    </nav>
    <div id='paso-1' class='seccion mostrar'>
        <h2>Servicios</h2>
        <p class='text-center'>Selecciona tus servicios y haz click en siguiente...</p>
        <div id='servicios' class='listado-servicios'></div>
    </div>
    <div id='paso-2' class='seccion'>
        <h2>Datos y Turnos</h2>
        <p class='text-center'>Coloca tus datos y fecha del turno</p>
        <form class='formulario'>
            <div class='campo'>
                <label for="nombre">Nombre</label>
                <input type="text" id='nombre' placeholder='ingresa tu nombre' value='<?php echo $nombre; ?>' disabled>
            </div>
            <div class='campo'>
                <label for='fecha'>Fecha</label>
                <input type='date' id='fecha' min='<?php echo date('Y-m-d', strtotime('+1 day')); ?>'>
            </div>
            <div class='campo'>
                <label for='hora'>Hora</label>
                <input type='time' id='hora' placeholder='ingresa una hora'>
            </div>
        </form>
    </div>
    <div id='paso-3' class='seccion contenido-resumen'>
        <h2>Resumen</h2>
        <p>Verifica que la información ingresada se correcta</p>
    </div>
    <div class='paginacion'>
        <button id='anterior' class='botons'>&laquo; Anterior</button>
        <button id='siguiente' class='botons'>Siguiente &raquo;</button>
    </div>
</div>

<?php

$script = "<script src='build/js/app.js'></script>";

?>