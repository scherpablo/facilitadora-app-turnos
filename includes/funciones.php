<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Funcio para luego obtener ela suma de todos los turnos
function esUltimo($actual, $proximo) : bool {
    if($actual !== $proximo) {
        return true;
    }
    return false;    
}

// Revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function isAdmin() : void {
    if (!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}