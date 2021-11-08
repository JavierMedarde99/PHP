<?php


function repetido($usuario,$conexion){
        $consulta="SELECT usuario FROM usuarios WHERE usuario='".$usuario."'";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            $respuesta=mysqli_num_rows($resultado)>0;
            mysqli_free_result($resultado);

        }else{
            $respuesta[1]="Imposible conectar consulta. Numero".mysqli_errno($conexion)." : ".mysqli_error($conexion);
        }
    }
       
       

if(isset($_POST["btnContinuar"])){
    $error_Nombre= $_POST["nombre"]=="";
 $error_Usuario_Vacio=$_POST["usuario"]=="";

    require "src/config.php";
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NAME_BD);
   
      if($conexion){
           mysqli_set_charset($conexion,"utf8");
         $error_Usuario_Repetido= repetido($_POST["usuario"],$conexion);
        if(!is_array($error_Usuario_Repetido)) echo "no error";
        };

    $error_Contraseña= $_POST["contraseña"]=="" ;
    $error_Email=$_POST["email"]==""|| filter_var($email,FILTER_VALIDATE_EMAIL);
    $errores=$error_Nombre|| $error_Usuario || $error_Contraseña || $error_Email;

        if(!$errores){
            mysqli_close($conexion);
        }

}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario</title>
</head>

<body>
    <?php 
    if(isset($_POST["btnContinuar"]) && !$conexion)
    die("Imposible conectar. Error Numero: ".mysqli_connect_errno()." : ".mysqli_connect_error());
    ?>

    <?php
   echo "<p>".$respuesta."</p>";
    ?>
    <h1>Nuevo Usuario</h1>

    <form action="usuario_nuevo.php" method="post">

        <br />
        <br />
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>">
        <?php
if(isset($_POST["btnContinuar"]) && $error_Nombre){
    echo "<p>*Campo vacio*</p>";
}

?>
        <br />
        <br />
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
        <?php
if(isset($_POST["btnContinuar"])&& $error_Usuario_Vacio){
    if($error_Usuario_Vacio)
    echo "<p>*Campo vacio*</p>";
    else
    echo "usuario repetido";
}
?>
        <br />
        <br />
        <label for="contraseña">Contraseña</label>
        <input type="password" name="contraseña" id="contraseña"
            value="<?php if(isset($_POST["contraseña"])) echo $_POST["contraseña"];?>">
        <?php
if(isset($_POST["btnContinuar"]) && $error_Contraseña){
    echo "<p>*Campo vacio*</p>";
}

?>
        <br />
        <br />
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"];?>">
        <?php
if(isset($_POST["btnContinuar"])&& $error_Email){
    if($_POST["email"]=="")
    echo "<p>*Campo vacio*</p>";
    else
    echo "email incorrecto";
}

?>
        <br />
        <br />
        <input type="submit" value="Continuar" name="btnContinuar">
        <input type="submit" value="Volver" name="btnVolver" formaction="index.php">
    </form>
</body>

</html>