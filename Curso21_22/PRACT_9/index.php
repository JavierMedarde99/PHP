<?php
require "src/ctes_funciones.php";

@$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
if (!$conexion)
    die(error_page("Práctica 9 - CRUD", "<h1>Pŕactica 9</h1><p>Error en la conexión Nº: " . mysqli_connect_errno() . " : " . mysqli_connect_error() . "</p>"));


mysqli_set_charset($conexion, "utf8");

if(isset($_POST["btnContEditar"]))
{
    $error_titulo=$_POST["titulo"]=="";

    $error_director=$_POST["director"]=="";

    $error_sinopsis=$_POST["sinopsis"]=="";
    
    $error_tematica=$_POST["tematica"]=="";

    $error_caratula=$_FILES["caratula"]["name"]!="" && ( $_FILES["caratula"]["error"] || !getimagesize($_FILES["caratula"]["tmp_name"])|| $_FILES["caratula"]["size"]>500*1000);

    $errores_form_editar=$error_titulo ||$error_director||$error_sinopsis||$error_tematica||$error_caratula;

    if(!$errores_form_editar)
    {
        
            $consulta="UPDATE peliculas SET titulo='".$_POST["titulo"]."', director='".$_POST["director"]."', sinopsis='".$_POST["sinopsis"]."', tematica='".$_POST["tematica"]."' where idPeliculas=".$_POST["idPeliculas"];
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            $accion="Pelucula editado con éxito";
            if($_FILES["caratula"]["name"]!="")
            {
                $array_aux=explode(".",$_FILES["caratula"]["name"]);
                if(count($array_aux)==1)
                    $extension="";
                else
                    $extension=".".end($array_aux);

                $nombre_img_nuevo="img".$_POST["idPeliculas"].$extension;

                @$var=move_uploaded_file($_FILES["caratula"]["tmp_name"],"Img/".$nombre_img_nuevo);
                if($var)
                {
                    if($_POST["caratula_ant"]!=$nombre_img_nuevo)
                    {
                        $consulta="update peliculas set caratula='".$nombre_img_nuevo."' where idPeliculas=".$_POST["idPeliculas"];
                        $resultado=mysqli_query($conexion,$consulta);
                        if($resultado)
                        {
                            if($_POST["caratula_ant"]!=IMAGEN_DEFECTO)
                                unlink("Img/".$_POST["caratula_ant"]);
                        }
                        else
                        {
                            $body="<h1>Práctica 9</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                            mysqli_close($conexion);
                            die(error_page("Práctica 9 - CRUD",$body));
                        }   
                    }
                }
                else
                {
                    $accion="Se actualizado el usuario dejando la foto anterior, ya que la nueva foto no se ha podido mover a la carpeta destino en el Servidor";
                }
            }
        }
        else
        {
            $body="<h1>Práctica 9</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
            mysqli_close($conexion);
            die(error_page("Práctica 9 - CRUD",$body));
        }
    }
}

if (isset($_POST["btnContBorrar"])) {
    $consulta = "DELETE FROM peliculas WHERE idPeliculas=" . $_POST["btnContBorrar"];
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {

        $accion = "pelicula borrado con éxito";
       
        if ($_POST["caratula"] != IMAGEN_DEFECTO)
            unlink("Img/img" . $_POST["btnContBorrar"] . ".jpg");
    } else {
        $body = "<h1>Práctica 9</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        die(error_page("Práctica 9 - CRUD", $body));
    }
}


if (isset($_POST["btnContNuevo"])) {

    $error_titulo = $_POST["titulo"] == "";

    $error_director = $_POST["director"] == "";

    $error_sinopsis = $_POST["sinopsis"] == "";

    $error_tematica = $_POST["tematica"] == "";

    $error_caratula = $_FILES["caratula"]["name"] != "" && ($_FILES["caratula"]["error"] || !getimagesize($_FILES["caratula"]["tmp_name"]) || $_FILES["caratula"]["size"] > 500 * 1000);

    $errores_form_nuevo = $error_titulo || $error_director || $error_sinopsis || $error_tematica || $error_caratula;

    if (!$errores_form_nuevo) {
        $consulta = "INSERT INTO peliculas (titulo,director,sinopsis,tematica) VALUES ('" . $_POST["titulo"] . "','" . $_POST["director"] . "','" . $_POST["sinopsis"] . "','" . $_POST["tematica"] . "')";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            $accion = "Pelicula insertada con éxito";
            if ($_FILES["caratula"]["name"] != "") {
                $ult_id = mysqli_insert_id($conexion);

                $array_aux = explode(".", $_FILES["caratula"]["name"]);
                if (count($array_aux) == 1)
                    $extension = "";
                else
                    $extension = "." . end($array_aux);

                $nombre_img = "img" . $ult_id . $extension;
                @$var = move_uploaded_file($_FILES["caratula"]["tmp_name"], "Img/" . $nombre_img);
                if ($var) {
                    $consulta = "UPDATE peliculas SET caratula='" . $nombre_img . "' WHERE idPeliculas=" . $ult_id;
                    $resultado = mysqli_query($conexion, $consulta);
                    if (!$resultado) {
                        $body = "<h1>Práctica 8</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
                        mysqli_close($conexion);
                        die(error_page("Práctica 8 - CRUD", $body));
                    }
                } else
                    $accion = "Pelicula insertada con la caratula por defecto, debido a que no ha podido moverse a la carpeta destino";
            }
        } else {
            $body = "<h1>Práctica 9</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
            mysqli_close($conexion);
            die(error_page("Práctica 9 - CRUD", $body));
        }
    }
}

if(isset($_POST["btnContBorrarFoto"]))
{
    $consulta="update peliculas set caratula='".IMAGEN_DEFECTO."' where idPeliculas=".$_POST["idPeliculas"];
    $resultado=mysqli_query($conexion,$consulta);
    if($resultado)
    {
       unlink("Img/".$_POST["caratula_ant"]);
       $_POST["caratula_ant"]=IMAGEN_DEFECTO;
    }
    else
    {
        $body="<h1>Práctica 9</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
        mysqli_close($conexion);
        die(error_page("Práctica 9 - CRUD",$body));
    }

}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        th{
            background-color: grey;
        }
        .error {
            color: red
        }

        .enlinea {
            display: inline
        }

        .centrar {
            text-align: center
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        td img {
            width: 100px;
        }

        table {
            border-collapse: collapse;
            width: 100%
        }

        .sin_boton {
            background: transparent;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        #form_editar,
        #listar {
            display: flex;
            justify-content: space-evenly;
            align-items: center
        }

        #form_editar div,
        #listar div {
            width: 50%;
        }

        #form_editar div img,
        #listar div img {
            height: 250px
        }
    </style>
    <title>Pract_9</title>
</head>

<body>
    <h1>Video Club</h1>
    <h2>Peliculas</h2>
    <h3>Listado de Peliculas</h3>
    <?php

  

    if (isset($_POST["btnListar"])) {
        require "vistas/vista_listar.php";
    }

    if (isset($_POST["btnNuevo"]) || (isset($_POST["btnContNuevo"]) && $errores_form_nuevo)) {
        require "vistas/vista_nuevo.php";
    }
    if (isset($_POST["btnBorrar"])) {
        require "vistas/vista_borrar.php";
    }
    
    if (isset($_POST["btnEditar"]) || (isset($_POST["btnContEditar"]) && $errores_form_editar) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnContBorrarFoto"]) || isset($_POST["btnNoContBorrarFoto"])) {
        require "vistas/vista_editar.php";
    }
    require "vistas/vista_tabla_peliculas.php";
    ?>
</body>

</html>