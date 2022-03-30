var xInic;
var yInic;
var estaPulsado = false;


function ratonPulsado(obj,evt) { 
    //Obtener la posición de inicio
    xInic = evt.clientX;
    yInic = evt.clientY;    
    estaPulsado = true;
    //Para Internet Explorer: Contenido no seleccionable
    obj.unselectable = true;
   
}

function ratonMovido(obj,evt) {
   
    if(estaPulsado) {
        //Calcular la diferencia de posición
        var xActual = evt.clientX;
        var yActual = evt.clientY;    
        var xInc = xActual-xInic;
        var yInc = yActual-yInic;
        xInic = xActual;
        yInic = yActual;
        
        //Establecer la nueva posición
        //var elemento = document.getElementById("cuadro");
        var position = getPosicion(obj);
        obj.style.top = (position[0] + yInc) + "px";
        obj.style.left = (position[1] + xInc) + "px";
  
    
    }
}

function ratonSoltado(evt) {
  
    estaPulsado = false;
   
}

/*
 * Función para obtener la posición en la que se encuentra el
 * elemento indicado como parámetro.
 * Retorna un array con las coordenadas x e y de la posición
 */
function getPosicion(elemento) {
    var posicion = new Array(2);
    if(document.defaultView && document.defaultView.getComputedStyle) {
        posicion[0] = parseInt(document.defaultView.getComputedStyle(elemento, null).getPropertyValue("top"))
        posicion[1] = parseInt(document.defaultView.getComputedStyle(elemento, null).getPropertyValue("left"));
    } else {
        //Para Internet Explorer
        posicion[0] = parseInt(elemento.currentStyle.top);             
        posicion[1] = parseInt(elemento.currentStyle.left);               
    }      
    return posicion;
}

function abrir_modal_general(contenido)
{
    document.getElementById("tvesModalGeneral").classList.remove("oculta");
    document.getElementById("modal_move_general").style.top="0px";
    document.getElementById("modal_move_general").style.left="0px";
    document.getElementById("modal_contenido_general").innerHTML=contenido;

}

function cerrar_modal_general()
{
    document.getElementById("modal_contenido_general").innerHTML="";
    document.getElementById('tvesModalGeneral').classList.add('oculta');
}