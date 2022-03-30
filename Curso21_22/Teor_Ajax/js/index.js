const DIR_SERV="http://localhost/Proyectos/PHP/Curso21_22/Servicios_Web/Teor_SW/servicios_rest_teor";

/*$(document).ready(function(){
   //onload
});*/

function obtener_productos()
{
    $.ajax({
        url:"http://localhost/Proyectos/PHP/Curso21_22/Servicios_Web/Actividad1/servicios_rest/productos",
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        var output;
        if(data.productos)
        {
            output="<table><tr><th>COD</th><th>Nombre Corto</th><th>PVP</th></tr>";
            $.each(data.productos, function(key,value){
                output+="<tr>";
                output+="<td>"+value['cod']+"</td>";
                output+="<td>"+value['nombre_corto']+"</td>";
                output+="<td>"+value['PVP']+"</td>";
                output+="</tr>";
            });
            output+="</table>";
        }
        else
        {
            output=data.error;
        }

        $('#respuesta').html(output);

    })
    .fail(function(a,b){
        $('#respuesta').html(error_ajax_jquery(a,b));
    });

}

function error_ajax_jquery( jqXHR, textStatus) 
{
    var respuesta;
    if (jqXHR.status === 0) {
  
      respuesta='Not connect: Verify Network.';
  
    } else if (jqXHR.status == 404) {
  
      respuesta='Requested page not found [404]';
  
    } else if (jqXHR.status == 500) {
  
      respuesta='Internal Server Error [500].';
  
    } else if (textStatus === 'parsererror') {
  
      respuesta='Requested JSON parse failed.';
  
    } else if (textStatus === 'timeout') {
  
      respuesta='Time out error.';
  
    } else if (textStatus === 'abort') {
  
      respuesta='Ajax request aborted.';
  
    } else {
  
      respuesta='Uncaught Error: ' + jqXHR.responseText;
  
    }
    return respuesta;
}