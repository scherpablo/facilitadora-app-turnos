let paso=1;const pasoInicial=1,pasoFinal=3,cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarAPI(),idCliente(),nombreCliente(),seleccionarFecha(),seleccionarHora(),mostrarResumen()}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");const t="#paso-"+paso;document.querySelector(t).classList.add("mostrar");const o=document.querySelector(".actual");o&&o.classList.remove("actual");const n=`[data-paso="${paso}"]`;document.querySelector(n).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})}function botonesPaginador(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente");1===paso?(e.classList.add("ocultar"),t.classList.remove("ocultar")):3===paso?(e.classList.remove("ocultar"),t.classList.add("ocultar"),mostrarResumen()):(e.classList.remove("ocultar"),t.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,botonesPaginador())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,botonesPaginador())}))}async function consultarAPI(){try{const e="http://localhost:3000/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:o,precio:n}=e,a=document.createElement("P");a.classList.add("nombre-servicio"),a.textContent=o;const r=document.createElement("P");r.classList.add("precio-servicio"),r.textContent="$"+n;const c=document.createElement("DIV");c.classList.add("servicio"),c.dataset.idServicio=t,c.onclick=function(){seleccionarServicio(e)},c.appendChild(a),c.appendChild(r),document.querySelector("#servicios").appendChild(c)})}function seleccionarServicio(e){const{id:t}=e,{servicios:o}=cita,n=document.querySelector(`[data-id-servicio="${t}"]`);o.some(e=>e.id===t)?(cita.servicios=o.filter(e=>e.id!==t),n.classList.remove("seleccionado")):(cita.servicios=[...o,e],n.classList.add("seleccionado"))}function idCliente(){const e=document.querySelector("#id").value;cita.id=e}function nombreCliente(){const e=document.querySelector("#nombre").value;cita.nombre=e}function seleccionarFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[0,1].includes(t)?(e.target.value="",mostrarAlerta("Domingos y Lunes Cerrado","error",".formulario")):cita.fecha=e.target.value}))}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":")[0];t<9||t>19?(e.target.value="",mostrarAlerta("Hora no válida","error",".formulario")):cita.hora=e.target.value}))}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("Faltan datos de servicios, fecha u hora","error",".contenido-resumen",!1);const{nombre:t,fecha:o,hora:n,servicios:a}=cita,r=document.createElement("H3");r.textContent="Resumen de Servicios",e.appendChild(r),a.forEach(t=>{const{id:o,nombre:n,precio:a}=t,r=document.createElement("DIV");r.classList.add("contenedor-servicio");const c=document.createElement("P");c.textContent=n;const i=document.createElement("P");i.innerHTML="<span>Precio:</span> $"+a,r.appendChild(c),r.appendChild(i),e.appendChild(r)});const c=document.createElement("H3");c.textContent="Resumen de Turnos",e.appendChild(c);const i=document.createElement("P");i.innerHTML="<span>Nombre:</span> "+t;const s=new Date(o),d=s.getDate()+2,l=s.getMonth(),u=s.getFullYear(),m=new Date(Date.UTC(u,l,d)).toLocaleDateString("es-AR",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),p=document.createElement("P");p.innerHTML="<span>Fecha:</span> "+m;const v=document.createElement("P");v.innerHTML=`<span>Hora:</span> ${n} hs`;const h=document.createElement("BUTTON");h.classList.add("boton"),h.textContent="Reservar Turno",h.onclick=reservarTurno,e.appendChild(i),e.appendChild(p),e.appendChild(v),e.appendChild(h)}async function reservarTurno(){const{nombre:e,fecha:t,hora:o,servicios:n,id:a}=cita,r=n.map(e=>e.id),c=new FormData;c.append("fecha",t),c.append("hora",o),c.append("usuarioId",a),c.append("servicios",r);try{const e=location.origin+"/api/citas",t=await fetch(e,{method:"POST",body:c});(await t.json()).resultado&&Swal.fire({icon:"success",title:"Turno Reservado!!!",text:"Muchas gracias por elegirnos"}).then(()=>{setTimeout(()=>{window.location.reload()},1e3)})}catch(e){Swal.fire({icon:"error",title:"Error de Conexión",text:"Hubo un error al guardar el turno"})}}function mostrarAlerta(e,t,o,n=!0){const a=document.querySelector(".alerta");a&&a.remove();const r=document.createElement("DIV");r.textContent=e,r.classList.add("alerta"),r.classList.add(t);document.querySelector(o).appendChild(r),n&&setTimeout(()=>{r.remove()},3e3)}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));