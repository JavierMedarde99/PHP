<?php
   

    require "src/ctes_funciones.php";

    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        die(error_page("Primer CRUD - Index","<h1>Listado de Usuarios</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
    mysqli_set_charset($conexion,"utf8");

    if(isset($_POST["btnInsertar"]))
    {
    
    
        $error_nombre=$_POST["nombre"]=="";
        $error_usuario=$_POST["usuario"]=="";
    
        if(!$error_usuario)
        {
            
    
            $error_usuario=repetido($conexion,"usuarios","usuario", $_POST["usuario"]);
            if(is_array($error_usuario))
            {
                mysqli_close($conexion);
                die(error_page("Primer CRUD - Index","<h1>Lsitado Usuarios</h1><p>".$error_usuario["error"]."</p>"));
            }
    
    
        }
    
        $error_clave=$_POST["clave"]=="";
        $error_email=$_POST["email"]=="" || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
    
        if(!$error_email)
        {
            if(!isset($conexion))
            {
                 if(!$conexion)
                    die(error_page("Primer CRUD - Index","<h1>Listado usuario</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
            
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
                    $accion="Usuario insertado con exito";
                }
                else
                {
                    $body="<h1>Nuevo Usuario</h1><p>Imposible realizar la consulta. Nº".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
                    mysqli_close($conexion);
                    die(error_page("Primer CRUD - Index",$body));
                }
                
                
        }
    
    
        
    }
    if(isset($_POST["btnContEditar"]))
    {
        $error_nombre=$_POST["nombre"]=="";
        $error_usuario=$_POST["usuario"]=="";
        if(!$error_usuario)
        {
            $error_usuario=repetido($conexion,"usuarios","usuario", $_POST["usuario"],"id_usuario",$_POST["btnContEditar"]);
            if(is_array($error_usuario))
            {
                mysqli_close($conexion);
                die(error_page("Primer CRUD - Index","<h1>Listado de Usuarios</h1><p>".$error_usuario["error"]."</p>"));
            }
        }

        $error_email=$_POST["email"]=="" || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
        if(!$error_email)
        {

            $error_email=repetido($conexion,"usuarios","email", $_POST["email"],"id_usuario",$_POST["btnContEditar"]);
            if(is_array($error_email))
            {
                mysqli_close($conexion);
                die(error_page("Primer CRUD - Index","<h1>Listado de Usuarios</h1><p>".$error_email["error"]."</p>"));
            }

        }
        $error_form_editar=$error_nombre||$error_usuario|| $error_email;
        if(!$error_form_editar)
        {
            if($_POST["clave"]=="")
                $consulta="update usuarios set nombre='".$_POST["nombre"]."',usuario='".$_POST["usuario"]."',email='".$_POST["email"]."' where id_usuario=".$_POST["btnContEditar"];
            else
                $consulta="update usuarios set nombre='".$_POST["nombre"]."',usuario='".$_POST["usuario"]."',clave='".md5($_POST["clave"])."',email='".$_POST["email"]."' where id_usuario=".$_POST["btnContEditar"];
            
            $resultado=mysqli_query($conexion,$consulta);
            if($resultado)
                $accion="Usuario editado con éxito";
            else
            {
                $body="<h1>Listado de Usuarios</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                mysqli_close($conexion);
                die(error_page("Primer CRUD - Index",$body)); 
            }
        }

    }


    if(isset($_POST["btnContBorrar"]))
    {
        $consulta="delete from usuarios where id_usuario=".$_POST["btnContBorrar"];
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            $accion="El usuario seleccionado ha sido borrado con éxito";
        }
        else
        {
             $body="<h1>Listado de Usuarios</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
             mysqli_close($conexion);
             die(error_page("Primer CRUD - Index",$body)); 
        }
    }


    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer CRUD - Index</title>
    <style>
        .centrar{text-align:center}
        .form_nuevo, .mensaje,.resultado {width:60%;margin:1.5em auto;}
        table,th,td{border:1px solid black}
        table{border-collapse:collapse; width:60%;margin:0 auto}
        .sin_boton{background:transparent;border:none;color:blue;text-decoration:underline;cursor:pointer}
    </style>
</head>
<body>
    <h1 class="centrar">Listado de los Usuarios</h1>
    
    <?php
    

    $consulta="select * from usuarios";

    $resultado=mysqli_query($conexion,$consulta);
    if($resultado)
    {
        echo "<table class='centrar'><tr><th>Nombre de Usuario
        <form class='form_nuevo' action='index.php' method='post'>
        <input type='submit' name='btnNuevo' value='+'/>
    </form>
        </th><th>Borrar</th><th>Editar</th></tr>";

        while($datos=mysqli_fetch_assoc($resultado))
        {
            echo "<tr>";
            echo "<td><form action='index.php' method='post'><button class='sin_boton' title='Detalles Usuario' name='btnListar' value='".$datos["id_usuario"]."'>".$datos["nombre"]."</button></form></td>";
            echo "<td><form action='index.php' method='post'><button class='sin_boton' name='btnBorrar' value='".$datos["id_usuario"]."'><img src='images/borrar.png' title='Borrar Usuario' alt='Borrar'/></button><input type='hidden' name='nombreBorrar' value='".$datos["nombre"]."'/></form></td>";
            echo "<td><form action='index.php' method='post'><button class='sin_boton' name='btnEditar' value='".$datos["id_usuario"]."'><img src='images/editar.png' title='Editar Usuario' alt='Editar'/></button></form></td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($resultado);
        

        
        if(isset($accion))
            echo "<p class='mensaje'>".$accion."</p>";

        if(isset($_POST["btnNuevo"]) || (isset($_POST["btnNuevo"]) && $error_formulario))
        {
?>

    <h1>Agregar Nuevo Usuario</h1>
    <form action="index.php" method="post">
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

            <label for="dni">DNI:</label>
            <input type="text" name="dni" id="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>"/>

            <br/>
            
            <label for="sexo">Sexo</label>
            <input type="radio" name="hombre" id="sexo">
            <input type="radio" name="mujer" id="sexo">

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
            <input type="submit" name="btnInsertar" value="Insertar" />
            
        </p>
    </form>


<?php
        }

        if(isset($_POST["btnEditar"]) || (isset($_POST["btnContEditar"])&& $error_form_editar) )
        {  
            echo "<div class='resultado'>";

            if(isset($_POST["btnEditar"]))
            {
                $id_usuario=$_POST["btnEditar"];
                $consulta="select * from usuarios where id_usuario=".$id_usuario;
                $resultado=mysqli_query($conexion,$consulta);
                if($resultado)
                {
                    if($datos=mysqli_fetch_assoc($resultado))
                    {
                        $nombre=$datos["nombre"];
                        $usuario=$datos["usuario"];
                        $email=$datos["email"];
                    }
                    else
                    {
                        $error_concurrencia="<p>El usuario seleccionado ya no se encuentra en la BD</p>";
                    }
                    mysqli_free_result($resultado);
                }
                else
                {
                    $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></div></body></html>";
                    mysqli_close($conexion);
                    die($error);
                }
            }
            else
            {
                $id_usuario= $_POST["btnContEditar"];   
                $nombre=$_POST["nombre"];
                $usuario=$_POST["usuario"];
                $email=$_POST["email"];
            }

            echo "<h2>Editando el Usuario con Id ".$id_usuario."</h2>";
            if(isset($error_concurrencia))
            {
                echo $error_concurrencia;
                echo "<form action='index.php' method='post'><input type='submit' value='Volver'/></form>";
            }
            else 
            {
            ?>    

                <form action="index.php" method="post">
                    <p>
                        <label for="nombre">Nombre: </label>
                        <input type="text" name="nombre" id="nombre" value="<?php echo $nombre;?>"/>
                        <?php
                        if(isset($_POST["btnContEditar"]) && $error_nombre)
                            echo "<span class='error'> * Campo Obligatorio *</span>";
                        ?>
                        
                        <br/>
                        <label for ="usuario">Usuario: </label>
                        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario;?>"/>
                        <?php
                        if(isset($_POST["btnContEditar"]) && $error_usuario)
                            if($_POST["usuario"]=="")
                                echo "<span class='error'> * Campo Obligatorio *</span>";
                            else
                                echo "<span class='error'> * Usuario repetido *</span>";
                        ?>
                        <br/>
                        <label for ="clave">Contraseña: </label>
                        <input type="password" name="clave" id="clave" placeholder="Editar contraseña">
                        
                        <br/>
                        <label for ="email">Email: </label>
                        <input type="text" name="email" id="email" value="<?php echo $email;?>"/>
                        <?php
                        if(isset($_POST["btnContEditar"]) && $error_email)
                            if($_POST["email"]=="")
                                echo "<span class='error'> * Campo Obligatorio *</span>";
                            elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                                echo "<span class='error'> * Email sintácticamente incorrecto *</span>";
                            else
                                echo "<span class='error'> * Email repetido *</span>";

                        ?>
                        <br/>
                        <button type="submit" name="btnContEditar" value="<?php echo $id_usuario;?>">Continuar</button>
                        <input type="submit" name="btnVolver" formaction="index.php" value="Volver"/>
                    </p>
                </form>

            <?php
            }
            echo "</div>";

        }
       if(isset($_POST["btnBorrar"]))
        {
            echo "<div class='resultado'>";
            echo "<h2>Borrado del usuario ".$_POST["btnBorrar"]."</h2>";
            echo "<form action='index.php' method='post'>";
            echo "<p class='centrar'>Se dispone ha borrar al usuario con nombre: <strong>".$_POST["nombreBorrar"]."</strong></p>";
            echo "<p class='centrar'><button type='submit' name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button> <input type='submit' value='Cancelar'/></p>";
            echo "</form>";
        }    
      if(isset($_POST["btnListar"]))
        {
            echo "<div class='resultado'>";
            echo "<h2>Detalles del usuario ".$_POST["btnListar"]."</h2>";
            $consulta="select nombre,usuario,email from usuarios where id_usuario=".$_POST["btnListar"];
            $resultado=mysqli_query($conexion,$consulta);
            if($resultado)
            {
                if($datos=mysqli_fetch_assoc($resultado))
                {
                    
                    echo "<p><strong>Nombre : </strong>".$datos["nombre"]."</p>";
                    echo "<p><strong>Usuario : </strong>".$datos["usuario"]."</p>";
                    echo "<p><strong>Email : </strong>".$datos["email"]."</p>";
                }
                else
                {
                  echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
                }
                mysqli_free_result($resultado);
                echo "<form action='index.php' method='post'><input type='submit' value='Volver'/></form>";
                echo "</div>";
            }
            
            else
            {
                $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></div></body></html>";
                mysqli_close($conexion);
                die($error);
            }
            
        }
        else 
        {    
        
        
        }
        mysqli_close($conexion);
    }
    else
    {
        $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
        mysqli_close($conexion);
        die($error);
    }

    ?>
  
</body>
</html>