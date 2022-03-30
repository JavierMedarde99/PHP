const DIR_SERV="http://localhost/Proyectos/PHP/Curso21_22/Servicios_Web/Actividad1/servicios_rest";

$(document).ready(function(){
   obtener_productos();
});

function editar(cod)
{
    $.ajax({
        url:encodeURI(DIR_SERV+'/producto/'+cod),
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
      
        if(data.producto)
        {
            montar_form_editar(data.producto);
        }    
        else if(data.mensaje)
        {
            $('#respuesta').html(data.mensaje);
        }
        else
        {
            cargar_vista_error(data.error);
        }


    })
    .fail(function(a,b){
        cargar_vista_error(error_ajax_jquery(a,b));
    });


}

function montar_form_editar(datos)
{
    $.ajax({
        url:DIR_SERV+"/familias",
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        
        if(data.no_auth)
        {
            saltar_a("index.html");
        }
        else if(data.familias)
        {
            var output="<h2>Formulario editando Producto "+datos["cod"]+"</h2>";
            output+="<form onsubmit='comprobar2(\""+datos["cod"]+"\");event.preventDefault();'>";
            if(datos["nombre"])
                output+="<p><label for='nombre'>Nombre:</label><input type='text' id='nombre' value='"+datos["nombre"]+"' required/></p>";
            else
                output+="<p><label for='nombre'>Nombre:</label><input type='text' id='nombre' required/></p>";

            output+="<p><label for='nombre_corto'>Nombre Corto:</label><input type='text' id='nombre_corto' value='"+datos["nombre_corto"]+"' required/><span id='error_nombre_corto'></span></p>";
            output+="<p><label for='descripcion'>Descripción:</label><textarea id='descripcion' required>"+datos["descripcion"]+"</textarea></p>";
            output+="<p><label for='PVP'>PVP:</label><input type='number' step='0.01' min='0.01' id='PVP' value='"+datos["PVP"]+"' required/></p>";
            output+="<p><label for='familia'>Seleccione la familia: </label><select id='familia'>";
            $.each(data.familias, function(key,value){
                if(datos["familia"]==value["cod"])
                    output+="<option selected value='"+value["cod"]+"'>"+value["nombre"]+"</option>";
                else
                    output+="<option value='"+value["cod"]+"'>"+value["nombre"]+"</option>";
            });
            output+="</select></p>";
            output+="<p><button onclick='volver()';>Volver</button> <button>Enviar</button></p>";
            output+="</form>";
            $('#respuesta').html(output);
        }
        else
        {
            cargar_vista_error(data.error);
        }

        

    })
    .fail(function(a,b){
        cargar_vista_error(error_ajax_jquery(a,b));
    });
}

function listar(cod)
{
    $.ajax({
        url:encodeURI(DIR_SERV+'/producto/'+cod),
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        var output;
        if(data.producto)
        {
            output="<h2>Detalles del producto "+cod+"</h2>";
            output+="<p><strong>Nombre: </strong>"+data.producto["nombre"]+"</p>";
            output+="<p><strong>Nombre corto: </strong>"+data.producto["nombre_corto"]+"</p>";
            output+="<p><strong>Descripción: </strong>"+data.producto["descripcion"]+"</p>";
            output+="<p><strong>PVP: </strong>"+data.producto["PVP"]+" €</p>";
            output+="<p><strong>Familia: </strong>"+data.producto["nombre_familia"]+"</p>";
        }
        else if(data.mensaje)
        {
            output=data.mensaje;
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

function borrar(cod)
{
    if(confirm("¿Estás seguro de que desea borrar el producto con código "+cod+"?"))
    {
        $.ajax({
            url:encodeURI(DIR_SERV+'/borrar/'+cod),
            type:"DELETE",
            dataType:"json"
        })
        .done(function(data){
            
            if(data.mensaje)
            {
                output=data.mensaje;
                obtener_productos();
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
}

function comprobar()
{
    var cod=$('#cod').val();
    var nombre_corto=$('#nombre_corto').val();
    
    $.ajax({
        url:encodeURI(DIR_SERV+'/repetido/producto/cod/'+cod),
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        var output;
        if(data.repetido)
        {
            $('#error_cod').html("Error Código repetido");
            $.ajax({
                url:encodeURI(DIR_SERV+'/repetido/producto/nombre_corto/'+nombre_corto),
                type:"GET",
                dataType:"json"
            })
            .done(function(data){
                if(data.repetido)
                {
                    $('#error_nombre_corto').html("Error Nombre corto repetido");
                }
                else if(!data.repetido)
                {
                    $('#error_nombre_corto').html("");

                }
                else
                {
                    output=data.error;
                }
            })
            .fail(function(a,b){
                $('#respuesta').html(error_ajax_jquery(a,b));
            });

        }
        else if(!data.repetido)
        {
            $('#error_cod').html("");
            $.ajax({
                url:encodeURI(DIR_SERV+'/repetido/producto/nombre_corto/'+nombre_corto),
                type:"GET",
                dataType:"json"
            })
            .done(function(data){
                if(data.repetido)
                {
                    $('#error_nombre_corto').html("Error Nombre corto repetido");
                }
                else if(!data.repetido)
                {
                    $('#error_nombre_corto').html("");
                    var nombre=$('#nombre').val();
                    var descripcion=$('#descripcion').val();
                    var PVP=$('#PVP').val();
                    var familia=$('#familia').val();

                    $.ajax({
                        url:DIR_SERV+'/insertar',
                        type:"POST",
                        dataType:"json",
                        data:{"cod":cod,"nombre":nombre,"nombre_corto":nombre_corto,"descripcion":descripcion,"PVP":PVP,"familia":familia}
                    })
                    .done(function(data){
                        if(data.mensaje)
                        {
                            output=data.mensaje;
                            obtener_productos();
                        }
                        else
                        {
                            output=data.error;
                        }

                    })
                    .fail(function(a,b){
                        $('#respuesta').html(error_ajax_jquery(a,b));
                    });
                }
                else
                {
                    output=data.error;
                }
            })
            .fail(function(a,b){
                $('#respuesta').html(error_ajax_jquery(a,b));
            });

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


    
    return false;
}

function montar_form_insert()
{
    $.ajax({
        url:DIR_SERV+"/familias",
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        var output;
        if(data.familias)
        {
            output="<h2>Formulario nuevo Producto</h2>";
            output+="<form onsubmit='return comprobar();'>";
            output+="<p><label for='cod'>Código:</label><input type='text' id='cod' required/><span id='error_cod'></span></p>";
            output+="<p><label for='nombre'>Nombre:</label><input type='text' id='nombre' required/></p>";
            output+="<p><label for='nombre_corto'>Nombre Corto:</label><input type='text' id='nombre_corto' required/><span id='error_nombre_corto'></span></p>";
            output+="<p><label for='descripcion'>Descripción:</label><textarea id='descripcion' required></textarea></p>";
            output+="<p><label for='PVP'>PVP:</label><input type='number' step='0.01' min='0.01' id='PVP' required/></p>";
            output+="<p><label for='familia'>Seleccione la familia: </label><select id='familia'>";
            $.each(data.familias, function(key,value){
                output+="<option value='"+value["cod"]+"'>"+value["nombre"]+"</option>";
            });
            output+="</select></p>";
            output+="<p><button>Enviar</button></p>";
            output+="</form>";
            
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

function obtener_productos()
{
    $.ajax({
        url:DIR_SERV+"/productos",
        type:"GET",
        dataType:"json"
    })
    .done(function(data){
        var output;
        if(data.productos)
        {
            output="<h2>Listado de los productos</h2>";
            output+="<table><tr><th>COD</th><th>Nombre Corto</th><th>PVP</th><th>Acción <button onclick='montar_form_insert();'>+</button></th></tr>";
            $.each(data.productos, function(key,value){
                output+="<tr>";
                output+="<td><button class='enlace' onclick='listar(\""+value['cod']+"\")'>"+value['cod']+"</button></td>";
                output+="<td>"+value['nombre_corto']+"</td>";
                output+="<td>"+value['PVP']+"</td>";
                output+="<td><button class='enlace' onclick='borrar(\""+value['cod']+"\")'>Borrar</button> - <button class='enlace' onclick='editar(\""+value['cod']+"\")'>Editar</button></td>";
                output+="</tr>";
            });
            output+="</table>";
        }
        else
        {
            output=data.error;
        }

        $('#productos').html(output);

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