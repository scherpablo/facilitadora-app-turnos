let paso = 1;

document.addEventListener('DOMContentLoaded', function () {
    iniciarApp(); 
});

function iniciarApp() {
    tabs(); //Cambia la secion cunado se presionan los tabs
}

function mostrarSeccion() {
    // Ocultar la seccion que tenga la clase de nostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) { 
        seccionAnterior.classList.add('mostrar');
    }

    // Seleccionar la seccion con el paso  
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);    
    seccion.classList.add('mostrar');       
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) { 
            paso = parseInt(e.target.dataset.paso);
            
            mostrarSeccion();
            
        })
    });
}


