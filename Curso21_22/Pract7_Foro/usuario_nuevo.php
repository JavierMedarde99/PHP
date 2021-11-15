<?php
function salto_con_POST($ruta,$name)
{
    echo "<html><body onload='document.form_post.submit();'>";
    echo "<form action='".$ruta."' method='post' name='form_post'><input type='hidden' name='".$name."' value=''/></form>";
    echo "</body></html>";
}


if(isset($_POST["btnInsertar"]))
{


    $error_nombre=$_POST["nombre"]=="";
    $error_usuario=$_POST["usuario"]=="";

    if(!$error_usuario)
    {
        require "src/ctes_funciones.php";
        @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        if(!$conexion)
            die(error_page("Primer CRUD - Nuevo Usuario","<h1>Nuevo Usuario</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
        
        mysqli_set_charset($conexion,"utf8");

        $error_usuario=repetido($conexion,"usuarios","usuario", $_POST["usuario"]);
        if(is_array($error_usuario))
        {
            mysqli_close($conexion);
            die(error_page("Primer CRUD - Nuevo Usuario","<h1>Nuevo Usuario</h1><p>".$error_usuario["error"]."</p>"));
        }


    }

    $error_clave=$_POST["clave"]=="";
    $error_email=$_POST["email"]=="" || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);

    if(!$error_email)
    {
        if(!isset($conexion))
        {
            require "src/ctes_funciones.php";
            @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            if(!$conexion)
                die(error_page("Primer CRUD - Nuevo Usuario","<h1>Nuevo Usuario</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
        
            mysqli_set_charset($conexion,"utf8");
        }
        $error_email=repetido($conexion,"usuarios","email", $_POST["email"]);
        if(is_array($error_email))
        {
            mysqli_close($conexion);
            die(error_page("Primer CRUD - Nuevo Usuario","<h1>Nuevo Usuario</h1><p>".$error_email["error"]."</p>"));
        }

    }
    $error_formulario=$error_nombre||$error_usuario|| $error_clave || $error_email;

    if(!$error_formulario)
    {
            $consulta="insert into usuarios (nombre,usuario,clave,email) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."')";
            $resultado=mysqli_query($conexion,$consulta);
            if($resultado)
            {
                mysqli_close($conexion);
                salto_con_POST("index.php","insertado");
                //header("Location:index.php?insertado=ok");
                exit;
            }
            else
            {
                $body="<h1>Nuevo Usuario</h1><p>Imposible realizar la consulta. Nº".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
                mysqli_close($conexion);
                die(error_page("Primer CRUD - Nuevo Usuario",$body));
            }
            
            
    }


    if(isset($conexion))
        mysqli_close($conexion);
    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer CRUD - Nuevo Usuario</title>
</head>
<body>
   
    <h1>Nuevo usuario</h1>
    <form action="usuario_nuevo.php" method="post">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
            <?php
            if(isset($_POST["btnInsertar"]) && $error_nombre)
                echo "<span class='error'> * Campo Obligatorio *</span>";
            ?>
            
            <br/>
            <label for ="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
            if(isset($_POST["btnInsertar"]) && $error_usuario)
                if($_POST["usuario"]=="")
                    echo "<span class='error'> * Campo Obligatorio *</span>";
                else
                    echo "<span class='error'> * Usuario repetido *</span>";
            ?>
            <br/>
            <label for ="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if(isset($_POST["btnInsertar"]) && $error_clave)
                echo "<span class='error'> * Campo Obligatorio *</span>";
            ?>
            <br/>
            <label for ="email">Email: </label>
            <input type="text" name="email" id="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"];?>"/>
            <?php
            if(isset($_POST["btnInsertar"]) && $error_email)
                if($_POST["email"]=="")
                    echo "<span class='error'> * Campo Obligatorio *</span>";
                elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                    echo "<span class='error'> * Email sintácticamente incorrecto *</span>";
                else
                    echo "<span class='error'> * Email repetido *</span>";

            ?>
            <br/>
            <input type="submit" name="btnInsertar" value="Continuar" />
            <input type="submit" name="btnVolver" formaction="index.php" value="Volver"/>
        </p>
    </form>
</body>
</html>