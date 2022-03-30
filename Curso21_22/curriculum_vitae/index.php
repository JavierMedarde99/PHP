<?php
require "src/ctes_funciones.php";
session_name("primer_login_21_22");
session_start();
if (isset($_SESSION["usuario"]) && isset($_SESSION["contrasena"]) && isset($_SESSION["ultimo_acceso"])  ) {
    @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    if (!$conexion)
        die(error_page("Primer login - Form Acceso", "<h1>Primer Login</h1><p>Error en la conexión Nº: " . mysqli_connect_errno() . " : " . mysqli_connect_error() . "</p>"));

    mysqli_set_charset($conexion, "utf8");
    $consulta = "SELECT * FROM usuarios WHERE usuario='" . $_SESSION["usuario"] . "' AND clave='" . $_SESSION["contrasena"] . "'";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        if ($datos_usuario = mysqli_fetch_assoc($resultado)) {
            mysqli_free_result($resultado);
            $tiempo_act=time();
            if($tiempo_act-$_SESSION["ultimo_acceso"]>INACTIVIDAD*60){
                unset($_SESSION["usuario"]);
                unset($_SESSION["contrasena"]);
                $_SESSION["tiempo"] = "* Su timepo de sesion ha caducado. Vuelva a loguearse *";
                mysqli_free_result($resultado);
                mysqli_close($conexion);
                header("Location:index.php");
            }else{
                 require "vistas/vista_principal.php";
            mysqli_close($conexion);
            }
           
        } else {
            unset($_SESSION["usuario"]);
            unset($_SESSION["contrasena"]);
            $_SESSION["restringida"] = "* Vuelva a loguearse. Está usted accediendo a una zona restringida *";
            mysqli_free_result($resultado);
            mysqli_close($conexion);
            header("Location:index.php");
        }
    } else {
        $body = "<h1>Primer Login</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        die(error_page("Primer login - Form Acceso", $body));
    }
} else {
    require "vistas/vista_login.php";
}
