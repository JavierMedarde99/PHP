<?php
session_name("Acy 2_SW_21_22");
session_start();
function consumir_servicios_REST($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

define("DIR_SERV", "http://localhost/Proyectos/PHP/Curso21_22/Servicios_Web/Actividad1/servicios_rest");

if(isset($_POST["btnContBorrar"])){
    $url=DIR_SERV."/borrar/".urlencode($_POST["btnContBorrar"]);
    $respuesta=consumir_servicios_REST($url,"DELETE");
    $obj =json_decode($respuesta);
    if(!$obj){
         session_destroy();
    die(error_page("CRUD Actividad 2","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));
    }
   
    if(isset($obj->error))
    {
    session_destroy();
    die(error_page("CRUD Actividad 2","<p>".$obj->error."</p>"));
    }

    $_SESSION["accion"]=$obj->mensaje;
    header("LOCATION:index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Actividad 2</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            text-align: center;
            padding: 0.25em;
        }

        th {
            background-color: #CCC;
        }

        table {
            border-collapse: collapse;
        }

        .no_boton {
            background: transparent;
            border: none;
            color: blue;
            cursor: pointer;
            text-decoration: underline;
        }
        .text_centrado{text-align: center;}
    </style>
</head>

<body>
    
    <h1>Listado de los productos de mi tienda</h1>
    <h2>Listado de los productos</h2>
    <?php
if(isset($_SESSION["accion"])){
    echo "<p>".$_SESSION["accion"]."</p>";
    session_destroy();
}
    if(isset($_POST["btnListar"])){
        $url=DIR_SERV."/producto/".urlencode($_POST["btnListar"]);
        $respuesta=consumir_servicios_REST($url,"GET");
        $obj=json_decode($respuesta);
        if(!$obj)
        die("<p>Error consumiendo el servicio: ".$url."</p>");
        if(isset($obj->error))
        die("<p>".$obj->error."</p></body></html>");

        echo "<h2>Detalles del Producto ".$_POST["btnListar"]."</h2>";
        if(isset($obj->mensaje))
        echo "<p>El prducto seleccionado ya no se encunetra en la BD</p>";
        else{
            echo "<p><strong>Nombre: </strong>".$obj->producto->nombre."</p>";
            echo "<p><strong>Nombre Corto: </strong>".$obj->producto->nombre_corto."</p>";
            echo "<p><strong>Descripcion: </strong>".$obj->producto->descripcion."</p>";
            echo "<p><strong>PVP: </strong>".$obj->producto->PVP."</p>";
            echo "<p><strong>Familia: </strong>".$obj->producto->familia."</p>";
        }
        
    }

    if(isset($_POST["btnBorrar"])){
        echo "<form class='text_centrado' action='index.php' method='post'>";
        echo "<p>¿Estás seguro que quieres borrar el producto con el código: ".$_POST["btnBorrar"]."?</p>";
        echo "<p><button>Cancelar</button><button name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Aceptar</button></p>";
        echo "</form>";
    }
    if(isset($_POST["BtnEditar"])){
        echo "Hago el Editar";
    }

    if(isset($_POST["btnNuevo"])){

        $url=DIR_SERV."/familias";
        $respuesta=consumir_servicios_REST($url,"GET");
        $obj=json_decode($respuesta);
        if(!$obj){
            session_destroy();
            die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta);
        }

        if(isset($obj->error)){
            session_destroy();
            die("<p>".$obj->error."</p></body></html>");
        }

        echo "<h2>Formulario nuevo Producto</h2>";
        echo "<form action='index.php' method='post'>";
        echo "<p><label for='nombre'>Nombre: </label><input type='text' name='nombre' id='nombre' value=''/></p>";
        echo "<p><label for='nombre_corto'>Nombre Corto: </label><input type='text' name='nombre_corto' id='nombre_corto' value=''/></p>";
        echo "<p><label for='descripcion'>Descripcion: </label><textarea name='descripcion' id='descripcion' value=''></textarea></p>";
        echo "<p><label for='pvp'>PVP: </label><input type='text' name='pvp' id='pvp' value=''/></p>";
        echo "<p><label for='familia'>Familia:</label><select name='familia' id='familia'>";
        
        foreach($obj->familias as $fila){
            if(isset($_POST["familia"]) && $_POST["familia"]==$fila->cod)
            echo "<option selected value='".$fila->cod."'>".$fila->nombre."</option>";
            else
            echo "<option value='".$fila->cod."'>".$fila->nombre."</option>";
        }
        echo "</select>";
        echo "</p>";
        echo "<p><button>Atras</button><button name='btnContNuevo' value='".$_POST["btnNuevo"]."'>Enviar</button></p>";
        echo "</form>";
    }

    //lista la tabla de los productos
    $url = DIR_SERV . "/productos";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servivio: " . $url . "</p>" . $respuesta);

    if (isset($obj->error))
        die("<p>" . $obj->error . "</p>");

    echo "<table><tr><th>Código</th><th>Nombre corto</th><th>PVP</th><th>
            <form action='index.php' method='post'><button name='btnNuevo'>+</button></form> Acción</th></tr>";
    foreach ($obj->productos as $fila) {
        echo "<tr>
                <td><form action='index.php' method='post'><button class='no_boton' name='btnListar' value='" . $fila->cod . "'>" . $fila->cod . "</button></form></td>
                <td>" . $fila->nombre_corto . "</td>
                <td>" . $fila->PVP . "</td>
                <td><form action='index.php' method='post'><button class='no_boton' name='btnBorrar' value='" . $fila->cod . "'>Borrar</button></form>-<form action='index.php' method='post'><button class='no_boton' name='btnEditar' value='" . $fila->cod . "'>Editar</button></form></td></tr>";
    }

    echo "</table>";
    /*
            $url=DIR_SERV."/producto/EEEPC1005PXD";
            $respuesta=consumir_servicios_REST($url,"GET");
            $obj= json_decode($respuesta);
            if(!$obj)
                die("<p>Error consumiendo el servivio: ".$url."</p>".$respuesta);
            
            if(isset($obj->error))
                die("<p>".$obj->error."</p>");
            
            if(isset($obj->mensaje))
                echo "<p>".$obj->mensaje."</p>";
            else
            {
                echo "<p><strong>Nombre Corto: </strong>".$obj->producto->nombre_corto."</p>";
            }

            /*$datos["cod"]="FHFJMDU";
            $datos["nombre"]="Nombre";
            $datos["nombre_corto"]="Nombre Corto";
            $datos["descripcion"]="Producto inventado";
            $datos["PVP"]=23.99;
            $datos["familia"]="CONSOL";
            $url=DIR_SERV."/insertar";
            $respuesta=consumir_servicios_REST($url,"POST",$datos);
            $obj= json_decode($respuesta);
            if(!$obj)
                die("<p>Error consumiendo el servivio: ".$url."</p>".$respuesta);
            
            if(isset($obj->error))
                die("<p>".$obj->error."</p>");
            
            echo "<p>".$obj->mensaje."</p>";

            
            $datos["nombre"]="Nombre";
            $datos["nombre_corto"]="Nombre Corto 2";
            $datos["descripcion"]="Producto inventado";
            $datos["PVP"]=30.00;
            $datos["familia"]="CONSOL";
            $url=DIR_SERV."/actualizar/FHFJMDU";
            $respuesta=consumir_servicios_REST($url,"PUT",$datos);
            $obj= json_decode($respuesta);
            if(!$obj)
                die("<p>Error consumiendo el servivio: ".$url."</p>".$respuesta);
            
            if(isset($obj->error))
                die("<p>".$obj->error."</p>");
            
            echo "<p>".$obj->mensaje."</p>";


            $url=DIR_SERV."/borrar/FHFJMDU";
            $respuesta=consumir_servicios_REST($url,"DELETE");
            $obj= json_decode($respuesta);
            if(!$obj)
                die("<p>Error consumiendo el servivio: ".$url."</p>".$respuesta);
            
            if(isset($obj->error))
                die("<p>".$obj->error."</p>");
            
            echo "<p>".$obj->mensaje."</p>";


            $url=DIR_SERV."/familias";
            $respuesta=consumir_servicios_REST($url,"GET");
            $obj= json_decode($respuesta);
            if(!$obj)
                die("<p>Error consumiendo el servivio: ".$url."</p>".$respuesta);
            
            if(isset($obj->error))
                die("<p>".$obj->error."</p>");

            echo "<select>";
            foreach($obj->familias as $fila)
            {
                echo "<option value='".$fila->cod."'>".$fila->nombre."</option>";
            }
            echo "</select>";


            $url=DIR_SERV."/repetido/producto/nombre_corto/".urlencode("Canon Pixma MP252")."/cod/3DSNG";
            $respuesta=consumir_servicios_REST($url,"GET");
            $obj= json_decode($respuesta);
            if(!$obj)
                die("<p>Error consumiendo el servivio: ".$url."</p>".$respuesta);
            
            if(isset($obj->error))
                die("<p>".$obj->error."</p>");

            if($obj->repetido)
                echo "<p>Está repetido</p>";
            else
                echo "<p>No está repetido</p>"*/
    ?>


</body>

</html>