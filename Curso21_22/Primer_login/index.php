<?php
require "src/ctes_funciones.php";
session_name("primer_login_21_22");
session_start();
if(isset($_SESSION["usuario"])&& isset($_SESSION["clave"])&& isset($_SESSION["ultimo_acceso"]))
{
        @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        if(!$conexion)
            die(error_page("Primer Login - Principal","<h1>Primer Login</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
        mysqli_set_charset($conexion,"utf8");

        $consulta="select * from usuarios where usuario='".$_SESSION["usuario"]."' and clave='".$_SESSION["clave"]."'";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            if($datos_usuario=mysqli_fetch_assoc($resultado))
            {
                mysqli_free_result($resultado);


                $tiempo_act=time();
                if($tiempo_act-$_SESSION["ultimo_acceso"]>INACTIVIDAD*60)
                {
                    //unset($_SESSION["usuario"]);
                    //unset($_SESSION["clave"]);
                    session_unset();
                    $_SESSION["tiempo"]="* Su tiempo de sesión ha caducado. Vuelva a loguearse *";
                    mysqli_close($conexion);
                    header("Location:index.php");
                    exit;
                }
                else
                {
                    $_SESSION["ultimo_acceso"]=time();
                    require "vistas/vista_principal.php";
                    mysqli_close($conexion);
                }
            }
            else
            {
                unset($_SESSION["usuario"]);
                unset($_SESSION["clave"]);
                $_SESSION["restringida"]="* Vuelva a loguearse. Está usted accediendo a una zona restringida *";
                mysqli_free_result($resultado);
                mysqli_close($conexion);
                header("Location:index.php");
                exit;
            }
            
        }
        else
        {
            $body="<h1>Primer Login</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
            mysqli_close($conexion);
            die(error_page("Primer Login - Principal",$body));
        }

    
}
elseif(isset($_POST["btnRegistro"])|| isset($_POST["btnContNuevo"]))
{
    require "vistas/vista_registro.php";
}
else
{
    require "vistas/vista_login.php";
}
?>