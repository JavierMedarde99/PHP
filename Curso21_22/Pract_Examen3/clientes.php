<?php
session_name("pract_examen3_21_22");
session_start();
require "src/ctes_funciones.php";

if(isset($_POST["btnCerrarSesion"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["usuario"])&& isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"]) )
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        if(!$conexion)
            die(error_page("Práctica Examen 3","<h1>Práctica Examen 3</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
        mysqli_set_charset($conexion,"utf8");

        $consulta="select * from clientes where usuario='".$_SESSION["usuario"]."' and clave='".$_SESSION["clave"]."'";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            if($datos_usuario=mysqli_fetch_assoc($resultado))
            {
                mysqli_free_result($resultado);

                $tiempo_act=time();
                if($tiempo_act-$_SESSION["ultimo_acceso"]>INACTIVIDAD*60)
                {
                    session_unset();
                    $_SESSION["tiempo"]="* Su tiempo de sesión ha caducado. Por favor, vuelva a loguearse. *";
                    mysqli_close($conexion);
                    header("Location:index.php");
                    exit;
                }
                
            }
            else
            {
                unset($_SESSION["usuario"]);
                unset($_SESSION["clave"]);
                $_SESSION["restringida"]="* Está usted accediendo a una zona restringida. Por favor, vuelva a loguearse. *";
                mysqli_free_result($resultado);
                mysqli_close($conexion);
                header("Location:index.php");
                exit;
            }
            
        }
        else
        {
            $body="<h1>Práctica Examen 3</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica Examen 3",$body));
        }

        $_SESSION["ultimo_acceso"]=time();
        
        require "vistas/vista_cliente.php";
        mysqli_close($conexion);

}
else
{
    $_SESSION["restringida"]="Esta usted accediendo a una zona restringida. Por favor logueese o registrese.";
    header("Location:index.php");
}
?>