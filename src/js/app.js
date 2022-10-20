let paso = 1;

const pasoInicial = 1;
const pasoFinal = 3;

const cita = { 
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function () {
    iniciarApp(); 
});

function iniciarApp() { 
    mostrarSeccion();//Muestra y oculta las secciones
    tabs(); //Cambia la secion cunado se presionan los tabs
    botonesPaginador(); //Agrega o quita los botones asnterior y siguiente
    paginaSiguiente(); //Muestra la seccion siguiente
    paginaAnterior(); //Muestra la seccion anterior

    consultarAPI(); //Consulta la API en el backend de PHP

    idCliente();
    nombreCliente(); //Guardamos el nombre del cliente en el objeto cita
    seleccionarFecha(); //Seleeccionamos la fecha de del turno y la añadimos al objeto cita
    seleccionarHora(); //Seleccionamos la hora del turno y la añadimos al objeto cita

    mostrarResumen(); //Muestra el resumen de la cita
}

function mostrarSeccion() {   
    // Ocultar la seccion que tenga la clase de nostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior) { 
        seccionAnterior.classList.remove('mostrar');
    }

    // Seleccionar la seccion con el paso  
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);       
    seccion.classList.add('mostrar'); 

    // Quita la clase de actual al tab
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }
    
    // Resalta la seccion
    const tabActual = `[data-paso="${paso}"]`;
    // const tab = document.querySelector(`[data-paso="${paso}"]`);
    const tab = document.querySelector(tabActual);
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) { 
            paso = parseInt(e.target.dataset.paso);
            
            mostrarSeccion();
            botonesPaginador();
        })
    });
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if(paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    } else { 
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {

        if(paso <= pasoInicial) return;
        paso--;

        botonesPaginador();
    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {

        if(paso >= pasoFinal) return;
        paso++;

        botonesPaginador();
    });
}

async function consultarAPI() {
    
    try {   
        const url = 'https://facilitadora-app-de-turnos.herokuapp.com/api/servicios';
        // const url = 'http://localhost:3000/api/servicios';
        const resultado = await fetch(url); //Funcion que nos permite consumir la url
        const servicios = await resultado.json(); //Obtenemos los resultados como json

        mostrarServicios(servicios);
        
    } catch (error) {
        console.log(error);
        
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;// Aplicamos destructuring a servicios

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;
        
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function () { 
            seleccionarServicio(servicio);
        } 

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);        
    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita; //Extraemos los servicios del objeto de cita creado arriba de todo

    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si el servicio ya esdta agregado
    if (servicios.some(agregado => agregado.id === id)) {
        // Eliminamos el servicio
        cita.servicios = servicios.filter(agregado => agregado.id !== id);  
        divServicio.classList.remove('seleccionado');
    } else { 
        // Agregamos el servicio
        cita.servicios = [...servicios, servicio]; //Tomamos una copia de los servicios y le agregamos el nuevo servicio        
        divServicio.classList.add('seleccionado');
    }        
}

function idCliente() {
    const id = document.querySelector('#id').value; //Seleccionamos el id nombre del formulario y le asignamos el valor ingresado en el value
    cita.id = id;
}

function nombreCliente() {
    const nombre = document.querySelector('#nombre').value; //Seleccionamos el id nombre del formulario y le asignamos el valor ingresado en el value
    cita.nombre = nombre;
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha')
    inputFecha.addEventListener('input', function (e) {
        const dia = new Date(e.target.value).getUTCDay(); //Almacenamos en la constante dia el valor del dia seleccionado

        if ([0, 1].includes(dia)) { //Si el día seleccionado es domingo ([0] esto lo sabemos por el getUTCDay) 
            e.target.value = ''; // Enviamos al input fecha un string vacio
            mostrarAlerta('Domingos y Lunes Cerrado', 'error', '.formulario'); //Creamos la funcion para mostrar el alerta, lleva un mensaje y un tipo de mensaje           
        } else { 
            cita.fecha = e.target.value;            
        }        
    })
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {
        
        const horaCita = e.target.value;
        const hora = horaCita.split(':')[0];

        if (hora < 9 || hora > 19) {
            e.target.value = '';
            mostrarAlerta('Hora no válida', 'error', '.formulario');            
        } else { 
            cita.hora = e.target.value;            
        }
    })    
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar la seccion de resumen
    while (resumen.firstChild) { 
        resumen.removeChild(resumen.firstChild);
    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de servicios, fecha u hora', 'error', '.contenido-resumen', false); 
        
        return;
    }
    // Formatear el DIV de resumen
    const { nombre, fecha, hora, servicios } = cita;    

    // Heading para servicios en resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    // Itereando y mostrando los servicios
    servicios.forEach(servicio => { 
        const { id, nombre, precio } = servicio;

        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    })

    // Heading para servicios en resumen
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Turnos';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear la fecha en español  ej (10-12-2022)
    const fechaObj = new Date(fecha); // Creamos un objeto de ueva fecha (new date tiene es desfasaje de un dia con la fecha actual)
    const dia = fechaObj.getDate() + 2; //Le pónemos + 2 xq utilizamos dos veces el new Date
    const mes = fechaObj.getMonth();
    const anio = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(anio, mes, dia)); //Volvemos a usar new date por lo tanto tenemos un desfasaje de dos dias con respecto a la fecha actual

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormateada = fechaUTC.toLocaleDateString('es-AR', opciones);
    // console.log(fechaFormateada);
    

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} hs`;

    // Boton para crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Turno';
    botonReservar.onclick = reservarTurno;
    
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);   
    
    resumen.appendChild(botonReservar);   
}

async function reservarTurno() {

    const { nombre, fecha, hora, servicios, id } = cita;

    const idServicios = servicios.map(servicio => servicio.id);

    const datos = new FormData();
    
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    // console.log([...datos]);

    try {
        // Peticion a la API
    const url = 'https://facilitadora-app-de-turnos.herokuapp.com/api/citas';
    // const url = 'http://localhost:3000/api/citas';

    const respuesta = await fetch(url, {
        method: 'POST',
        body: datos
    });

    const resultado = await respuesta.json();

    // console.log(resultado.resultado);    

    if (resultado.resultado) { 
        Swal.fire({
            icon: 'success',
            title: 'Turno Reservado!!!',
            text: 'Muchas gracias por elegirnos',
            // button: 'OK'
        }).then(() => {             
            setTimeout(() =>{;
                window.location.reload();
            }, 1000);
        } )
    }
        
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error de Conexión',
            text: 'Hubo un error al guardar el turno',
        })        
    }    

    // console.log([...datos]); //De esta manera podemos con el console log ver el contenido del Form Data, sino no se puede...   
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    // Verificamos si hay un alerta previo y evitamos que se repitan 
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) { 
        alertaPrevia.remove();
    }  

    // Scripting para generar la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) { 
        // Eliminamos la laerta despues de 3 segundos
    setTimeout(() =>{;
        alerta.remove();
    }, 3000); 
    }       
}



