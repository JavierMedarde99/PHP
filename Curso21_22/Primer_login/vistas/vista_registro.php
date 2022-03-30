<?php
if(isset($_POST["btnContNuevo"]))
    {
        


        $error_nombre=$_POST["nombre"]=="";
	    $error_usuario=$_POST["usuario"]=="";

        if(!$error_usuario)
        {
            @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            if(!$conexion)
                die(error_page("Primer Login - Registro","<h1>Primer Login</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
            mysqli_set_charset($conexion,"utf8");

            $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);
            if(is_array($error_usuario))
            {
                mysqli_close($conexion);
                die(error_page("Primer Login - Registro","<p>".$error_usuario["error"]."</p>"));
            }
        }
	    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
        
        if(!$error_dni)
        {
            if(!isset($conexion))
            {
                @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
                if(!$conexion)
                    die(error_page("Primer Login - Registro","<h1>Primer Login</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
                mysqli_set_charset($conexion,"utf8");
            }
            
            $error_dni=repetido($conexion,"usuarios","dni",strtoupper($_POST["dni"]));
            if(is_array($error_dni))
            {
                session_destroy();
                mysqli_close($conexion);
                die(error_page("Primer Login - Registro","<p>".$error_dni["error"]."</p>"));
            }
        }
    
        $error_clave=$_POST["clave"]=="";
	
	    $error_sexo=!isset($_POST["sexo"]);
	
	    $error_foto=$_FILES["foto"]["name"]!="" && ( $_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"])|| $_FILES["foto"]["size"]>500*1000 );

	    $errores_form_nuevo=$error_nombre ||$error_usuario||$error_clave||$error_dni||$error_sexo||$error_foto;
        
        if(!$errores_form_nuevo)
        {
            $consulta="insert into usuarios (nombre,usuario,clave,dni,sexo) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".strtoupper($_POST["dni"])."','".$_POST["sexo"]."')";
            $resultado=mysqli_query($conexion,$consulta);
            if($resultado)
            {
                
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
                    @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nombre_img);
				    if($var)
                    {
                       $consulta="update usuarios set foto='".$nombre_img."' where id_usuario=".$ult_id;
                       $resultado=mysqli_query($conexion,$consulta);
                       if(!$resultado)
                       {
                            $body="<h1>Primer Login</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                            mysqli_close($conexion);
                            session_destroy();
                            die(error_page("Primer Login - Registro",$body));
                       }
            
                    }
                    else
                        $_SESSION["accion"]="Usuario registrado con la foto por defecto, debido a que no ha podido moverse a la carpeta destino";			
                }

                $_SESSION["usuario"]=$_POST["usuario"];
                $_SESSION["clave"]=md5($_POST["clave"]);
                $_SESSION["ultimo_acceso"]=time();
                header("Location:index.php");
                exit;
            }
            else
            {
                $body="<h1>Primer Login</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                mysqli_close($conexion);
                die(error_page("Primer Login - Registro",$body));
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
        <title>Primer Login - Registro</title>
    </head>
    <body>
        <h2>Agregar Nuevo Usuario </h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <p><label for="nombre">Nombre:</label><br/>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"]; ?>"/>
            <?php
            if(isset($_POST["btnContNuevo"])&& $error_nombre)
            {
                echo "<span class='error'>* Campo vacío *</span>";
            }	
            ?>
            </p>
            <p><label for="usuario">Usuario:</label><br/>
            <input type="text" placeholder="Usuario" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>"/>
            <?php
            if(isset($_POST["btnContNuevo"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Usuario repetido *</span>";
            }	
            ?>
            </p>
            <p><label for="clave">Contraseña:</label><br/>
            <input type="password" name="clave" id="clave" placeholder="Contraseña"/>
            <?php
            if(isset($_POST["btnContNuevo"])&& $error_clave)
            {
                echo "<span class='error'>* Campo vacío *</span>";
            }	
            ?>
            </p>
            <p><label for="dni">DNI:</label><br/>
            <input type="text" placeholder="DNI: 11223344Z" name="dni" id="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"]; ?>"/>
            <?php
            if(isset($_POST["btnContNuevo"])&& $error_dni)
            {
                if($_POST["dni"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                elseif(!dni_bien_escrito($_POST["dni"]))
                    echo "<span class='error'>* Debes rellenar un DNI con ocho dígitos seguidos de una letra *</span>";
                    
                elseif(!dni_valido($_POST["dni"]))
                    echo "<span class='error'>* DNI no válido *</span>";
                else
                    echo "<span class='error'>* DNI repetido *</span>";
            }	
            ?>
            </p>
            <p><label>Sexo:</label>
            <?php
            if(isset($_POST["btnContNuevo"])&& $error_sexo)
            {
                echo "<span class='error'>* Debes de elegir un sexo *</span>";
            }	
            ?>
            </p>
            <p><input type="radio" name="sexo" id="hombre" value="hombre" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="hombre") echo "checked";?>/>
            <label for="hombre">Hombre</label><br/>
            <input type="radio" name="sexo" id="mujer"  value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?>/>
            <label for="mujer">Mujer</label><br/><br/>
            <label for="foto">Incluir mi foto (Archivo imagen Máx 500 KB): </label>
            <input type="file" name="foto" accept="image/*"/><br/>
            <?php
                if(isset($_POST["btnContNuevo"])&& $error_foto)
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
            <input type="submit" name="btnContNuevo" value="Guardar Cambios"/>
            <input type="submit" value="Atrás"/>
            </p>
        </form>
    </body>
    </html>