<h1 class='nombre-pagina'>Editar Servicio</h1>
<p class='descripcion-pagina'>Modifica los datos del formulario</p>

<?php

include_once __DIR__ . '/../tamplates/barra.php';
include_once __DIR__ . '/../tamplates/alertas.php';

?>

<form class='formulario' method="POST">
    <?php include_once __DIR__ . '/formulario.php'; ?>

    <input class='boton' type='submit' value='Actualizar'>
</form>