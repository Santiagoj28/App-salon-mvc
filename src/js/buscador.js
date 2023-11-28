document.addEventListener('DOMContentLoaded',function(){
    iniciarApp();
})

function iniciarApp(){
    searchDate();
}

function searchDate(){
   const fecha = document.querySelector('#fecha');
   fecha.addEventListener('input',function(e){
    //console.log(e);
    //console.log(e.target);
    const fechaSeleccionada = e.target.value;

    //redireccionar
    window.location = `?fecha=${fechaSeleccionada}`;

    console.log(fechaSeleccionada);
    })
    
}

