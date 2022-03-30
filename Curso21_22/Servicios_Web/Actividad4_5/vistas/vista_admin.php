<?php
    if(isset($_POST["btnContEditar"]))
    {
        $error_nombre=$_POST["nombre"]=="";
        $error_usuario=$_POST["usuario"]=="";
        if(!$error_usuario)
        {
            $url=DIR_SERV."/repetido/usuarios/usuario/".urlencode($_POST["usuario"])."/id_usuario/".urlencode($_POST["btnContEditar"]);
            $respuesta=consumir_servicios_REST($url,"GET");
            $obj=json_decode($respuesta);
            if(!$obj)
            {
                session_destroy();
                die(error_page("Actividad 4 y 5","<h1>Actividad 4 y 5</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
            }
            if(isset($obj->error))
            {
                session_destroy();
                die(error_page("Actividad 4 y 5","<h1>Actividad 4 y 5</h1><p>".$obj->error."</p>"));
            }
            $error_usuario=$obj->repetido;
        }
        $error_email=$_POST["email"]==""||!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
        if(!$error_email)
        {
            $url=DIR_SERV."/repetido/usuarios/email/".urlencode($_POST["email"])."/id_usuario/".urlencode($_POST["btnContEditar"]);
            $respuesta=consumir_servicios_REST($url,"GET");
            $obj=json_decode($respuesta);
            if(!$obj)
            {
                session_destroy();
                die(error_page("Actividad 4 y 5","<h1>Actividad 4 y 5</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
            }
            if(isset($obj->error))
            {
                session_destroy();
                die(error_page("Actividad 4 y 5","<h1>Actividad 4 y 5</h1><p>".$obj->error."</p>"));
            }
            $error_email=$obj->repetido;
        }

        $errores_form_editar=$error_nombre||$error_usuario||$error_email;
        if(!$errores_form_editar)
        {   
            $url=DIR_SERV."/actualizarUsuario/".urlencode($_POST["btnContEditar"]);
            $respuesta=consumir_servicios_REST($url,"PUT",$_POST);
            $obj=json_decode($respuesta);
            if(!$obj)
            {
                session_destroy();
                die(error_page("Actividad 4 y 5","<h1>Actividad 4 y 5</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
            }
            if(isset($obj->error))
            {
                session_destroy();
                die(error_page("Actividad 4 y 5","<h1>Actividad 4 y 5</h1><p>".$obj->error."</p>"));
            }
            $_SESSION["accion"]=$obj->mensaje;
            header("Location:index.php");
            exit;
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 4 y 5</title>
    <style>
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        .enlinea{display:inline}
    </style>
</head>
<body>
    <h1>Actividad 4 y 5</h1>
    <div>
        Bienvenido <strong><?php echo $_SESSION["usuario"];?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <?php
        if(isset($_SESSION["accion"]))
        {
            echo "<p class='mensaje_accion'>".$_SESSION["accion"]."</p>";
            unset($_SESSION["accion"]);
        }

        $url=DIR_SERV."/usuarios";
        $respuesta=consumir_servicios_REST($url,"GET");
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            session_destroy();
            die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta);
        }
        if(isset($obj->error))
        {
            session_destroy();
            die("<p>".$obj->error."</p></body></html>");
        }
    
        echo "<h2>Listado de Usuarios (no admin)</h2>";
        echo "<table>";
            echo"<tr><th>Nombre de usuario</th><th>Borrar</th><th>Editar</th></tr>";
    
                foreach($obj->usuarios as $fila)
                {
                    if($fila->tipo=="normal")
                    {
                        echo "<tr><td><form action='index.php' method='post'><button name='btnListar' value='".$fila->id_usuario."'>".$fila->nombre."</button></form></td><td><form action='index.php' method='post'><button name='btnBorrar' value='".$fila->id_usuario."'><img src='images/borrar.png'/></button></form></td><td><form action='index.php' method='post'><button name='btnEditar' value='".$fila->id_usuario."'><img src='images/editar.png'/></button></form></td></tr>";
                    }
                }

        echo "</table>";
        
        if(isset($_POST["btnListar"]))
        {
            echo "<h2>Detalles del Usuario ".$_POST["btnListar"]."</h2>";
        }

        if(isset($_POST["btnEditar"]) ||(isset($_POST["btnContEditar"]) && $errores_form_editar))
        {
            if(isset($_POST["btnEditar"]) )
            {
                $id_usuario=$_POST["btnEditar"];
                $url=DIR_SERV."/usuario/".urlencode($id_usuario);
                $respuesta=consumir_servicios_REST($url,"GET");
                $obj=json_decode($respuesta);
                if(!$obj)
                {
                    session_destroy();
                    die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta);
                }
                if(isset($obj->error))
                {
                    session_destroy();
                    die("<p>".$obj->error."</p></body></html>");
                }

                if(isset($obj->usuario))
                {
                    $nombre=$obj->usuario->nombre;
                    $usuario=$obj->usuario->usuario;
                    $email=$obj->usuario->email;
                }
            }
            else
            {
                $id_usuario=$_POST["btnContEditar"];
                $nombre=$_POST["nombre"];
                $usuario=$_POST["usuario"];
                $email=$_POST["email"];
            }
            
            echo "<h2>Editando el Usuario ".$id_usuario."</h2>";
            if(isset($obj->mensaje))
            {
                echo "<form action='index.php' method='post'>";
                echo "<p>".$obj->mensaje."</p>";
                echo "<button>Volver</button>";
                echo "</form>";
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
                        <input type="submit" value="Volver"/>
                    </p>
                </form>


            <?php
            }


        }     

    ?>
        


</body>
</html>