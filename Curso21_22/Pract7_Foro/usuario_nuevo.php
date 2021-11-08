<?php


function repetido($repetirdo){
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NAME_BD);
    if(!$conexion)
        die("Imposible conectar. Error Numero: ".mysqli_connect_errno()." : ".mysqli_connect_error());
   
        mysqli_set_charset($conexion,"utf8");
   
        $consulta="SELECT usuario FROM usuarios";
        $resultado=mysqli_query($conexion,$consulta);
}

if(isset($_POST["btnContinuar"])){
    $error_Nombre= $_POST["nombre"]=="";
    $error_Usuario=$_POST["usuario"]=="" || repetido($_POST["usuario"]);
    $error_Contraseña= $_POST["contraseña"]=="" ;
    $error_Email=$_POST["email"]==""|| !filter_var($email,FILTER_VALIDATE_EMAIL);
    $errores=$error_Nombre|| $error_Usuario || $error_Contraseña || $error_Email;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario</title>
</head>

<body>
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
        <input type="text" name="usuario" id="usuario"
            value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
        <?php
if(isset($_POST["btnContinuar"])&& $error_Usuario){
    if($_POST["usuario"]=="")
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