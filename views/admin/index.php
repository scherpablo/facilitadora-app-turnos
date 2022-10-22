<h1 class="nombre-pagina">Panel Administrador</h1>
<p class="descripcion-pagina">Administra todos tus turnos desde aqui</p>

<?php
include_once __DIR__ . '/../tamplates/barra.php';
?>

<h2>Buscar Turnos</h2>
<div class='busqueda'>
    <form class='formulario'>
        <div class='campo'>
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>

<?php
    if(count($citas) === 0) {
        echo '<h3>No hay turnos reservados en esta fecha</h3>';
    }
?>    

<div id='citas-admin'>
    <ul class='citas'>
        <?php
        $idCita = 0;
        foreach ($citas as $key => $cita) {
            if ($idCita !== $cita->id) {

                $total = 0;
        ?>
                <li>
                    <h3>Cliente</h3>
                    <p>ID: <span><?php echo $cita->id; ?></span></p>
                    <p>Nombre: <span><?php echo $cita->cliente; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Email: <span><?php echo $cita->email; ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>

                    <h3>Servicios</h3>
                <?php
                $idCita = $cita->id;
            } //Fin del If 
            $total += $cita->precio;
                ?>
                <p class='servicio'><?php echo $cita->servicio . ' - $' . $cita->precio; ?></p>
                <?php
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;

                if (esUltimo($actual, $proximo)) { ?>
                    
                    <p class='total'>Total: <span><?php echo $total; ?></span></p>

                    <form action='/api/eliminar' method='POST'>
                        <input type='hidden' name="id" value="<?php echo $cita->id; ?>">
                        <input type='submit' class='boton-eliminar' value='Eliminar'>
                    </form>

                <?php }
            } //Fin del For Each 
                ?>
    </ul>
</div>

<?php

$script = "<script src='build/js/buscador.js'></script>";

?>