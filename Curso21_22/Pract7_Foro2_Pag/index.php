<?php

    session_name("pag_pract7_21_22");
    session_start();

    require "src/ctes_funciones.php";

    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
    {
        session_destroy();
        die(error_page("Primer CRUD - Index","<h1>Listado de Usuarios</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
    }
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
                session_destroy();
                mysqli_close($conexion);
                die(error_page("Primer CRUD - Index","<h1>Listado de Usuarios</h1><p>".$error_usuario["error"]."</p>"));
            }


        }

        $error_clave=$_POST["clave"]=="";
        $error_email=$_POST["email"]=="" || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);

        if(!$error_email)
        {
            
            $error_email=repetido($conexion,"usuarios","email", $_POST["email"]);
            if(is_array($error_email))
            {
                session_destroy();
                mysqli_close($conexion);
                die(error_page("Primer CRUD - Index","<h1>Listado de Usuarios</h1><p>".$error_email["error"]."</p>"));
            }

        }
        $error_formulario=$error_nombre||$error_usuario|| $error_clave || $error_email;

        if(!$error_formulario)
        {
                $consulta="insert into usuarios (nombre,usuario,clave,email) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."')";
                $resultado=mysqli_query($conexion,$consulta);
                if($resultado)
                {
                   $_SESSION["accion"]="Usuario insertado con éxito";
                   header("Location:index.php");
                   exit;
                }
                else
                {
                    $body="<h1>Listado de Usuarios</h1><p>Imposible realizar la consulta. Nº".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
                    mysqli_close($conexion);
                    session_destroy();
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
                session_destroy();
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
                session_destroy();
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
            {
                $_SESSION["accion"]="Usuario editado con éxito";
                header("Location:index.php");
                exit;
            }
            else
            {
                $body="<h1>Listado de Usuarios</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                mysqli_close($conexion);
                session_destroy();
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
            $_SESSION["pagina"]=1;
            $_SESSION["accion"]="El usuario seleccionado ha sido borrado con éxito";
            header("Location:index.php");
            exit;
            
        }
        else
        {
             $body="<h1>Listado de Usuarios</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
             session_destroy();
             mysqli_close($conexion);
             die(error_page("Primer CRUD - Index",$body)); 
        }
    }


    // Código para paginación
    if(!isset($_SESSION["registros"]))
    {
        $_SESSION["registros"]=3;
        $_SESSION["buscar"]="";

    }

    if(isset($_POST["registros"]))
    {
        $_SESSION["registros"]=$_POST["registros"];
        $_SESSION["buscar"]=$_POST["buscar"];
        $_SESSION["pagina"]=1;
    }

    if(!isset($_SESSION["pagina"]))
        $_SESSION["pagina"]=1;

    if(isset($_POST["pagina"]))
        $_SESSION["pagina"]=$_POST["pagina"];
    
        

    

    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer CRUD - Index</title>
    <style>
        .enlinea{display:inline;float:right}
        .centrar{text-align:center}
        .form_nuevo, .mensaje,.resultado {width:60%;margin:1.5em auto;}
        table,th,td{border:1px solid black}
        table{border-collapse:collapse; width:60%;margin:0 auto}
        .sin_boton{background:transparent;border:none;color:blue;text-decoration:underline;cursor:pointer}
        #form_pags{width:60%;margin:0 auto;text-align:center;margin-top:0.5em}
        #form_pags button{margin:0 0.25em}
        #form_reg_bus{width:60%;margin:0 auto;display:flex;justify-content:space-between}
    </style>
</head>
<body>
    <h1 class="centrar">Listado de los Usuarios</h1>
    <form id="form_reg_bus" name="form_reg_bus" action="index.php" method="post">
        <div>
            <label for="registros">Registros a mostrar: </label>
            <select name="registros" id="registros" onchange="document.form_reg_bus.submit();">
                <option <?php if($_SESSION["registros"]==3) echo "selected";?> value="3">3</option>
                <option <?php if($_SESSION["registros"]==6) echo "selected";?> value="6">6</option>
                <option <?php if($_SESSION["registros"]==-1) echo "selected";?> value="-1">TODOS</option>
            </select>
        </div>
        <div>
            <input type="text" name="buscar" value="<?php echo $_SESSION["buscar"];?>">
            <input type="submit" value="Buscar"/>
        </div>
    </form>    

    <?php
    
    $inicio=($_SESSION["pagina"]-1)*$_SESSION["registros"];

    if($_SESSION["registros"]>0)
        if($_SESSION["buscar"]=="")
            $consulta="select * from usuarios limit ".$inicio.",".$_SESSION["registros"];
        else
            $consulta="select * from usuarios where nombre LIKE '%".$_SESSION["buscar"]."%' limit ".$inicio.",".$_SESSION["registros"];
    else
        if($_SESSION["buscar"]=="")
            $consulta="select * from usuarios";
        else
            $consulta="select * from usuarios where nombre LIKE '%".$_SESSION["buscar"]."%'";

    $resultado=mysqli_query($conexion,$consulta);
    if($resultado)
    {
        echo "<table class='centrar'><tr><th>Nombre de Usuario <form class='enlinea' action='index.php' method='post'>
        <input type='submit' name='btnNuevo' value='+'/></form></th><th>Borrar</th><th>Editar</th></tr>";

        while($datos=mysqli_fetch_assoc($resultado))
        {
            echo "<tr>";
            echo "<td><form action='index.php' method='post'><button class='sin_boton' title='Detalles Usuario' name='btnListar' value='".$datos["id_usuario"]."'>".$datos["nombre"]."</button></form></td>";
            echo "<td><form action='index.php' method='post'><button class='sin_boton' name='btnBorrar' value='".$datos["id_usuario"]."'><img src='images/borrar.png' title='Borrar Usuario' alt='Borrar'/></button><input type='hidden' name='nombreBorrar' value='".$datos["nombre"]."'/></form></td>";
            echo "<td><form action='index.php' method='post'><button class='sin_boton' name='btnEditar' value='".$datos["id_usuario"]."'><img src='images/editar.png' title='Editar Usuario' alt='Editar'/></button></form></td>";
            echo "</tr>";
        }
        echo "</table>";
        //mysqli_free_result($resultado);
        
        if($_SESSION["buscar"]=="")
            $consulta="select * from usuarios";
        else
            $consulta="select * from usuarios where nombre LIKE '%".$_SESSION["buscar"]."%'";

        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            $total_registros=mysqli_num_rows($resultado);
            mysqli_free_result($resultado);
            $paginas=ceil($total_registros/$_SESSION["registros"]);
            if($paginas>1)
            {
                echo "<form id='form_pags' action='index.php' method='post'>";
                if($_SESSION["pagina"]>1)
                {
                    echo "<button type='submit' name='pagina' value='1'>|<</button>";
                    echo "<button type='submit' name='pagina' value='".($_SESSION["pagina"]-1)."'><</button>";
                }
                for($i=1;$i<=$paginas;$i++)
                {
                    if($_SESSION["pagina"]==$i)
                        echo "<button disabled type='submit' name='pagina' value='".$i."'>".$i."</button>";
                    else
                        echo "<button type='submit' name='pagina' value='".$i."'>".$i."</button>";
                }
                if($_SESSION["pagina"]<$paginas)
                {
                    echo "<button type='submit' name='pagina' value='".($_SESSION["pagina"]+1)."'>></button>";
                    echo "<button type='submit' name='pagina' value='".$paginas."'>>|</button>";
                }

                echo "</form>";
            }
        }
        else
        {
            $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
            session_destroy();
            mysqli_close($conexion);
            die($error);
        }
        
        if(isset($_SESSION["accion"]))
        {
                echo "<p class='mensaje'>".$_SESSION["accion"]."</p>";
                unset($_SESSION["accion"]);
        }


        if(isset($_POST["btnNuevo"]) || (isset($_POST["btnInsertar"])&& $error_formulario))
        {
        ?>
        <div class="resultado">
            <h2>Nuevo usuario</h2>
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
                    <input type="submit"  value="Volver"/>
                </p>
            </form>

        </div>
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
                    session_destroy();
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
                session_destroy();
                mysqli_close($conexion);
                die($error);
            }
            
        }
        
        mysqli_close($conexion);
    }
    else
    {
        $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
        session_destroy();
        mysqli_close($conexion);
        die($error);
    }

    ?>
  
</body>
</html>