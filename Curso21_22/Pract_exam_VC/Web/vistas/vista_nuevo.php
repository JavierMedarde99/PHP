<?php
function LetraNIF ($dni) {
    $valor= (int) ($dni / 23);
    $valor *= 23;
    $valor= $dni - $valor;
    $letras= "TRWAGMYFPDXBNJZSQVHLCKEO";
    $letraNif= substr ($letras, $valor, 1);
    return $letraNif;
    }

if(isset($_POST["btnNuevo"])){
    $error_usuario=$_POST["usuario"]=="";

if(!$error_usuario){
    $url=DIR_SERV."/usuarioNombre/".urlencode($_POST["usuario"]);
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("ExamenVideoclub","<h1>Video Club</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
    }

    if(isset($obj->error)){
        session_destroy();
        die(error_page("ExamenVideoclub","<h1>Video Club</h1><p>".$obj->error."</p>"));
    }

    if(isset($obj->usuario)){
       $error_usuario=true;
    }
    
}
$error_clave=$_POST["clave"]=="" || $_POST["clave"]<>$_POST["reClave"];
    $error_reClave=$_POST["reClave"]=="";
    $error_dni=$_POST["dni"]=="" || !LetraNIF($_POST["dni"]) || strlen($_POST["telefono"])!=9;
if(!$error_dni){
    $url=DIR_SERV."/usuarioDni/".urlencode($_POST["dni"]);
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("ExamenVideoclub","<h1>Video Club</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
    }

    if(isset($obj->error)){
        session_destroy();
        die(error_page("ExamenVideoclub","<h1>Video Club</h1><p>".$obj->error."</p>"));
    }

    if(isset($obj->usuario)){
       $error_dni=true;
    }
} 
$error_email=$_POST["email"]=="" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $error_telefono=$_POST["telefono"]=="" || !is_numeric($_POST["telefono"])||strlen($_POST["telefono"])!=9;
    $error_form=$error_usuario||$error_clave||$error_reClave||$error_dni||$error_email||$error_telefono;

    if(!$error_form){
        $url=DIR_SERV."/crearUsuario";
        $datos_usu["DNI"]=$_POST["dni"];
        $datos_usu["usuario"]=$_POST["usuario"];
        $datos_usu["clave"]=md5($_POST["clave"]);
        $datos_usu["telefono"]=$_POST["telefono"];
        $datos_usu["email"]=$_POST["email"];
        foreach($datos_usu as $lista){
            echo $lista;
        }
        $respuesta=consumir_servicios_REST($url,"POST",$datos_usu);
        $obj=json_decode($respuesta);
        if(!$obj){
            session_destroy();
            die(error_page("ExamenVideoclub","<h1>Video Club</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
        }
    
        if(isset($obj->error)){
            session_destroy();
            die(error_page("ExamenVideoclub","<h1>Video Club</h1><p>".$obj->error."</p>"));
        }
    
        if(isset($obj->ult_id)){
            $_SESSION["usuario"]=$datos_usu["usuario"];
            $_SESSION["clave"]=$datos_usu["clave"];
            $_SESSION["tiempo"]=time();
            header("Location:index.php");
            exit;
            
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
    <title>ExamenVideoclub</title>
</head>
<body>
    <h1>Video Club</h1>
    <form action="index.php" method="post">
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]?>"/>
        <?php
        if(isset($_POST["btnNuevo"]) && $error_usuario){
            if($_POST["usuario"]=="")
            echo "*campo vacio*";
            else
            echo "Usuario repetido";
        }
        ?>
        <br/>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave" >
        <?php
        if(isset($_POST["btnNuevo"]) && $error_clave){
            if($_POST["clave"]=="")
            echo "*campo vacio*";
            else
            echo "contraseña no igual";
        }
        ?>
        <br/>
        <label for="reClave">Repita la contraseña:</label>
        <input type="password" name="reClave" id="reClave">
        <?php
        if(isset($_POST["btnNuevo"]) && $error_reClave){
            echo "*campo vacio*";
        }
        ?>
        <br/>
        <label for="dni">DNI</label>
        <input type="text" name="dni" id="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"]?>">
        <?php
        if(isset($_POST["btnNuevo"]) && $error_dni){
            if($_POST["dni"]=="")
            echo "*campo vacio*";
            else
            echo "dni no valido";
        }
        ?>
        <br/>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]?>">
        <?php
        if(isset($_POST["btnNuevo"]) && $error_email){
            if($_POST["email"]=="")
            echo "*campo vacio*";
            else
            echo "email no valido";
        }
        ?>
        <br/>
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono" value="<?php if(isset($_POST["telefono"])) echo $_POST["telefono"]?>">
        <?php
        if(isset($_POST["btnNuevo"]) && $error_telefono){
            if($_POST["telefono"]=="")
            echo "*campo vacio*";
            else
            echo "telefono no valido";
        }
        ?>
        <br/>
        <input type="submit" value="Volver" name="btnvolverPrincipal">
        <input type="submit" value="Continuar" name="btnNuevo">
    </form>
</body>
</html>