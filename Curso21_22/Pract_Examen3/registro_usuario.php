<?php
    require "src/ctes_funciones.php";

    if(isset($_POST["btnVolver"]))
    {
        header("Location:index.php");
        exit;
    }
    
    if(isset($_POST["btnContRegistro"]))
    {
        
	    $error_usuario=$_POST["usuario"]=="";

        if(!$error_usuario)
        {
            @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            if(!$conexion)
                die(error_page("Práctica Examen 3","<h1>Práctica Examen 3</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
            mysqli_set_charset($conexion,"utf8");

            $error_usuario=repetido($conexion,"clientes","usuario",$_POST["usuario"]);
            if(is_array($error_usuario))
            {
                mysqli_close($conexion);
                die(error_page("Práctica Examen 3","<p>".$error_usuario["error"]."</p>"));
            }
        }
        $error_clave=$_POST["clave"]==""|| $_POST["clave"]!=$_POST["clave2"];

        $error_foto=$_FILES["foto"]["name"]!="" && ( $_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"])|| $_FILES["foto"]["size"]>500*1000 );

	    $errores_form_nuevo=$error_usuario||$error_clave||$error_foto;
        
        if(!$errores_form_nuevo)
        {
            $consulta="insert into clientes (usuario,clave) values ('".$_POST["usuario"]."','".md5($_POST["clave"])."')";
            $resultado=mysqli_query($conexion,$consulta);
            if($resultado)
            {
                session_name("pract_examen3_21_22");
                session_start();
                
                $_SESSION["accion"]="Usuario registrado con éxito";
                if($_FILES["foto"]["name"]!="")
                {
                    $ult_id=mysqli_insert_id($conexion);

                    $array_aux=explode(".",$_FILES["foto"]["name"]);
				    if(count($array_aux)==1)
					    $extension="";
				    else
					    $extension=".".end($array_aux);

				    $nombre_img="img".$ult_id.$extension;
                    @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Images/".$nombre_img);
				    if($var)
                    {
                       $consulta="update clientes set foto='".$nombre_img."' where id_cliente=".$ult_id;
                       $resultado=mysqli_query($conexion,$consulta);
                       if(!$resultado)
                       {
                            $body="<h1>Práctica Examen 3</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                            mysqli_close($conexion);
                            session_destroy();
                            die(error_page("Práctica Examen 3",$body));
                       }
            
                    }
                    else
                        $_SESSION["accion"]="Usuario registrado con la foto por defecto, debido a que no ha podido moverse a la carpeta destino";			
                }

                $_SESSION["usuario"]=$_POST["usuario"];
                $_SESSION["clave"]=md5($_POST["clave"]);
                $_SESSION["ultimo_acceso"]=time();
                mysqli_close($conexion);
                header("Location:clientes.php");
                exit;
            }
            else
            {
                $body="<h1>Primer Login</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                mysqli_close($conexion);
                die(error_page("Práctica Examen 3",$body));
            }
            
        }
        
    
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Examen 3</title>
</head>
<body>
    <h1>Práctica Examen 3</h1>
    <h2>Registro de un nuevo usuario</h2>
    <form action="registro_usuario.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>"/>
            <?php
            if(isset($_POST["btnContRegistro"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> * Campo Vacío * </span>";
                else
                    echo "<span class='error'> * Usuario repetido * </span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" id="clave" name="clave" />
            <?php
            if(isset($_POST["btnContRegistro"])&& $error_clave)
            {
                if($_POST["clave"]=="")
                    echo "<span class='error'> * Campo Vacío * </span>";
                else
                    echo "<span class='error'> * No has repetido bien la contraseña * </span>";
            }
            ?>
        </p>
        <p>
            <label for="clave2">Repetir Contraseña: </label>
            <input type="password" id="clave2" name="clave2" />
        </p>
        <p>
            <label for="foto">Foto (Max 500KB): </label><input type="file" name="foto" id="foto" accept="image/*"/><br/>
            <?php
                if(isset($_POST["btnContRegistro"])&& $error_foto)
                {
                    if($_FILES["foto"]["error"])
                        echo "<span class='error'>* Error en la subida del archivo al servidor *</span>";
                    elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
                        echo "<span class='error'>* Error: no has seleccionado un archivo imagen *</span>";
                    else
                        echo "<span class='error'>* Error: el tamaño del archico seleccionado supera los 500 KB *</span>";
                }
            
            ?>
        </p>
        <p>
            <input type="submit" name="btnVolver" value="Volver"/> <input type="submit" name="btnContRegistro" value="Continuar"/>
        </p>
    </form>
</body>
</html>