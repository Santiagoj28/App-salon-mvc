

let paso = 1;
const pasoInicial = 1 ;
const pasoFinal = 3;

const cita ={
    id:'',
    nombre: '',
    fecha: '',
    hora:'',
    servicios:[]

}

document.addEventListener('DOMContentLoaded',function(){
    iniciarApp();
})

function iniciarApp(){

    mostrarSeccion()//muestra y oculta las secciones
    tabs();//cambiar la seccion cuando se presione 
    botonesPaginador();//Agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();
    nombrePagina();

    //Consultar APi
    idCliente();
    consultarApi();//consulta la api en el backend de php
    nombreCliente();//anadir el nombre a el objeto de cita
    seleccionaFecha();//anadir fecha a el objeto
    seleccionarHora();
    muestraResumen();//Muestra el resumen de la cita
    
}
function mostrarSeccion(){
    //ocultar la que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    const tabAnterior = document.querySelector('.actual');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
        tabAnterior.classList.remove('actual');
    }
   
    //seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`
     const seccion = document.querySelector(pasoSelector);
     seccion.classList.add('mostrar');

     //resalta el tab actual 
     const tab = document.querySelector(`[data-paso="${paso}"]`);
     tab.classList.add('actual');
}
//registrar eventos a los tabs
function tabs(){
    const botones = document.querySelectorAll('.tabs button');
    //itera en el tabs y anadir el evento
    botones.forEach(boton =>{
        boton.addEventListener('click',function (e){
             //convertir en int
           paso =parseInt (e.target.dataset.paso);
           mostrarSeccion();
           botonesPaginador();
          
        })

    })//utilizando arrow funtions
}
function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1 ){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    else if(paso === 3){
        muestraResumen();
        paginaAnterior.classList.remove('ocultar')
        paginaSiguiente.classList.add('ocultar');
    }
    else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
   
}
function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click',function(){
        if(paso <= pasoInicial) return;
        paso-- ;
        botonesPaginador();
       
        
    })

}
function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click',function(){
        if(paso >= pasoFinal) return;
        paso++ ;
        botonesPaginador();
    })

}
 async function consultarApi(){
    //obtener datos servidor
    try {
        //http://localhost:3000
        //url api
        const url = `/api/servicios`;
        const resultado = await fetch(url);
         const servicios = await resultado.json();
         mostrarServicios(servicios);
       //el await espera hasta que se ejecute ese codigo para seguir ejecutando codigo
       // mostrarServicios();

       //console.log(servicios);//cuando es 200 significa que es correcto
      
        
    } catch (error) {
        console.log(error);
        
    }
}

//crear los servicios en html
function mostrarServicios(servicios){
    servicios.forEach( servicio=>{
        const{id , nombre , precio} = servicio;
       
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent=nombre;
        
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent=`$ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio=id;
        //pasar un dato de una funcion a otra se hace con un callback
        servicioDiv.onclick = function(){
            selecionarServicio(servicio)
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
 
        document.querySelector('#servicios').appendChild(servicioDiv);
    })

}
function selecionarServicio(servicio){
    const { id } = servicio;
    //extraer el arreglo de servicios en cita en la parte superior
    const { servicios }=cita;
    //identica el elemento a dar click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    
    //comprobar si un servicio fue agregado
    if(servicios.some( agregado => agregado.id === id ) ){
        cita.servicios = servicios.filter( agregado => agregado.id !== id );
        divServicio.classList.remove('seleccionado');
    }else{ 
        //agrearlo
         //toma copia de los servicios ... y agrego el servicio
         cita.servicios = [...servicios,servicio];
         divServicio.classList.add('seleccionado');
        
    }
    //console.log(cita);
}
function idCliente(){
    cita.id = document.querySelector('#id').value;
}
function nombreCliente(){
    const nombre = document.querySelector('#nombre').value;
    cita.nombre = nombre;

}
function seleccionaFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input',function(e){
       const dia = new Date(e.target.value).getUTCDay();
       //console.log(dia);
       if([0].includes(dia)){
        e.target.value = '';
        mostrarAlerta('Fecha no valida','error','.formulario');
       }else{
        cita.fecha = e.target.value;
       }
    })
}
function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input',function(e){
        const horaCita = e.target.value;
        //nos permite separar una cadena de textos y vamos seleccionar solo la hora
        const hora = horaCita.split(':')[0];
        //console.log(hora);
        if(hora < 8 || hora > 19){
            e.target.value = '';
            mostrarAlerta('Hora no valida','error','.formulario');
        }else{
            cita.hora = e.target.value;
        }
        })
}
function muestraResumen(){
    const resumen = document.querySelector('.contenido-resumen');
     
    //limpiar el contenido de resumen para quitar la alerta
     while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
     } 
     
    //itera en los valores
    //console.log(Object.values(cita));
    if(Object.values(cita).includes('') || cita.servicios.length === 0 ){
        mostrarAlerta('Debes completar todos los campos','error','.contenido-resumen',false)
        return;
    }
    //formatear el div de resumen luego pasar la validacion
    const {nombre, fecha, hora, servicios } = cita;
   
    const headingServicio = document.createElement('H3');
    headingServicio.textContent = 'Resumen de Servicios';

    resumen.appendChild(headingServicio);
    
    servicios.forEach(servicio => {
        const {id , precio ,nombre} = servicio
        const contenedorServicios = document.createElement('DIV');
        contenedorServicios.classList.add('contenedor-servicios');

        const textoServicios = document.createElement('P');
        textoServicios.textContent = nombre;
        
        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span>$${precio}`;

        contenedorServicios.appendChild(textoServicios);
        contenedorServicios.appendChild(precioServicio);

        resumen.appendChild(contenedorServicios);
    })
    const headingCita= document.createElement('H3');
    headingCita.textContent = 'Resumen de cita';
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    //formatear la fecha en espanol
    const fechaobj = new Date (fecha) ;
    const mes = fechaobj.getMonth();
    const dia = fechaobj.getDate()+2;
    const year = fechaobj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year,mes,dia));
    const opciones = { weekday : 'long', year:'numeric',month:'long', day:'numeric'}
    const fechaformateada = fechaUTC.toLocaleDateString('es-CO',opciones)
    //console.log(fechaformateada)
    
    const fechaCliente = document.createElement('P');
    fechaCliente.innerHTML = `<span>Fecha:</span> ${fechaformateada}`;


    const horaCliente = document.createElement('P');
    horaCliente.innerHTML = `<span>Hora:</span> ${hora}`;

    //boton para crear una cita
    const botonReservar = document.createElement('BUTTON')
    botonReservar.classList.add('boton');
    botonReservar.textContent='Reserva cita'
    botonReservar.onclick = reservarCita;
    
    
    resumen.appendChild(headingCita);
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCliente);
    resumen.appendChild(horaCliente);
    resumen.appendChild(botonReservar);
   
}

function mostrarAlerta(mensaje,tipo, elemento, tiempo = true){
    //previene que se generen mas de 1 alerta
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    };
    //scripting para generar la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta')
    alerta.classList.add(tipo);
    
    const formulario = document.querySelector(elemento);
    formulario.appendChild(alerta);
    //console.log(alerta)
    
    //despues de 3 segundos desaparece la alerta
    if(tiempo){
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
 }

 async function reservarCita(){
    const {nombre, fecha, hora , servicios,id} = cita;

   const idServicio = servicios.map(servicio => servicio.id);
   //console.log(idServicio);
 
    const datos = new FormData();
    
    datos.append('fecha',fecha);
    datos.append('hora',hora);
    datos.append('usuarioid',id);
    datos.append('servicios',idServicio);

    try {
        //peticion para la api 
    const url = '/api/citas';

    const respuesta =  await fetch(url,{
        method: 'POST',
        body: datos
    });
    
    const resultado = await respuesta.json();

    //console.log(resultado.resultado);

    if(resultado.resultado){
        Swal.fire({
            icon: "succes",
            title: "Cita creada",
            text: "Tu cita fue creada correctamente",
            button: 'OK'
          }).then( ()=> {
            setTimeout(() => {
                window.location.reload();
            },3000 );
           
          })
    }
        
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al guardar la cita"
           
          });
        
    }
}
function nombrePagina(){
    const letters = document.querySelector('.letters');
    const textContainer = document.getElementById('contenido-animado');
    const textContent = textContainer.textContent.trim();

    //split separa las cadenas de texto 

  // Limpia el contenido del contenedor de texto
   textContainer.innerHTML = '';
 
  // Itera sobre cada carácter del texto y crea un nuevo span para cada letra
  textContent.split('').forEach((char, index) => {
    
    const charSpan = document.createElement('span');
    
    charSpan.textContent = char;
    // Agrega la clase 'letter' al span para aplicar estilos
    charSpan.classList.add('letter');

    // Agrega el span al contenedor de texto
    textContainer.appendChild(charSpan);
    
    // Calcula el retraso multiplicando el índice por 100 milisegundos
    const delay = index * 100;

    // Establece el retraso y la duración de la animación en el estilo de la letra
    charSpan.style.animationDelay = `${delay}ms`;
   
    charSpan.style.animationDuration = '1s';
    //return console.log(charSpan);
  });
    
}
 

//en el e viene mucha informacion del elemnto con el target trae informacion importante y accedo a el dataset que cree
//nota:addevenlistener solo se puede usar click cuando es un solo elemento para poder hacerlo con un all debo iterar en cada uno de los elementos