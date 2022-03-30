<?php

require "src/ctes_funciones.php";
session_name("pract_examen3_21_22");
session_start();

if(isset($_SESSION["usuario"]))
{
    header("Location:clientes.php");
    exit;

}

if(isset($_POST["btnLogin"]))
{
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form_login=$error_usuario||$error_clave;
    if(!$error_form_login)
    {
        @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        if(!$conexion)
            die(error_page("Práctica Examen 3","<h1>Práctica Examen 3</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
        mysqli_set_charset($conexion,"utf8");

        $consulta="select * from clientes where usuario='".$_POST["usuario"]."' and clave='".md5($_POST["clave"])."'";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            if(mysqli_num_rows($resultado)>0)
            {
                $_SESSION["usuario"]=$_POST["usuario"];
                $_SESSION["clave"]=md5($_POST["clave"]);
                $_SESSION["ultimo_acceso"]=time();
                mysqli_free_result($resultado);
                mysqli_close($conexion);
                header("Location:clientes.php");
                exit;
            }
            else
            {
                $error_usuario=true;
            }
        }
        else
        {
            $body="<h1>Práctica Examen 3</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
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
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <h1>Práctica Examen 3</h1>
    <?php
    if(isset($_SESSION["restringida"]))
    {
        echo "<p class='error'>".$_SESSION["restringida"]."</p>";
        session_destroy();
    }
    if(isset($_SESSION["tiempo"]))
    {
        echo "<p class='error'>".$_SESSION["tiempo"]."</p>";
        session_destroy();
    }
    ?>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>"/>
            <?php
            if(isset($_POST["btnLogin"])&& $error_usuario)
                if($_POST["usuario"]=="")
                    echo "<span class='error'> * Campo Vacío * </span>";
                else
                    echo "<span class='error'> * Usuario/Contraseña no registrado en la BD * </span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" id="clave" name="clave" />
            <?php
            if(isset($_POST["btnLogin"])&& $error_clave)
                echo "<span class='error'> * Campo Vacío * </span>";
            ?>
        </p>
        <p>
            <input type="submit" name="btnLogin" value="Login"/> <input type="submit" name="btnRegistro" formaction="registro_usuario.php" value="Registrar"/>
        </p>
    </form>
</body>
</html>