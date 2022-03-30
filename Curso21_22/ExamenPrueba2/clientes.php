<?php
use UI\Controls\Form;
require "src/ctes_funciones.php";
session_name("examenPrueba2");
session_start();
if(isset($_POST["btnBorrarFoto"])){
    $consulta="UPDATE clientes SET foto='".IMAGEN_DEFECTO."' WHERE usuario='".$_SESSION["usuario"]."' AND clave='".$_SESSION["clave"]."'";
    $resultado=mysqli_query($conexion,$consulta);
    if($resultado){
        unlink("Img/".$_POST["fotoaAnt"]);
        $_POST["fotoaAnt"]=IMAGEN_DEFECTO;
    }
}

if(isset($_POST["btnCambiarFoto"])){
    $consulta="UPDATE clientes SET foto='".$_POST["btnCambiarFoto"]."' WHERE usuario='".$_SESSION["usuario"]."' AND clave='".$_SESSION["clave"]."'";
    $resultado=mysqli_query($conexion,$consulta);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>videoClub</title>
</head>
<body>
    
    <h1>Video Club</h1>
    <p>Bienvenido <strong><?php echo $_SESSION["usuario"];?></strong> - <a href="cerrar_sesion.php">Salir</a></p>
    <?php
     @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
     if (!$conexion)
         die(error_page("Primer Login - Registro", "<h1>Primer Login</h1><p>Error en la conexión Nº: " . mysqli_connect_errno() . " : " . mysqli_connect_error() . "</p>"));
     mysqli_set_charset($conexion, "utf8");
    $consulta = "SELECT * FROM clientes WHERE usuario='".$_SESSION["usuario"]."' AND clave='".$_SESSION["clave"]."'";
    $resultado = mysqli_query($conexion,$consulta);
    if($resultado){
        while ($datos = mysqli_fetch_assoc($resultado)) {
            if($datos["tipo"]=="normal"){
                echo "<p><strong>Foto de perfil</strong></p>";
                echo "<img src='Img/".$datos["foto"]."'>";
                if($datos["foto"]!="no_imagen.jpg"){
                    echo "<form action='clientes.php' method='post'>";
                    echo "<input type='hidden' name='fotoAnt' value='".$datos["foto"]."' ";
                    echo "<input type='submit' value='borrar foto' name='btnBorrarFoto'>";
                    echo "</form>";
                }
                echo "<form action='clientes.php' method='post'>";
                echo "<label for='foto'>Inserte una nueva foto</label>";
                echo "<input type='file' name='foto' accept='image/*' />";
                echo "<br><br>";
                echo "<input type='submit' value='Cambiar foto' name='btnCambiarFoto'>";
                echo "</form>";

            }else{
                echo "admin";
            }
        }
    }
    ?>
</body>
</html>