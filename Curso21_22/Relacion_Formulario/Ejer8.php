<?php
if(isset($_POST["btnEnviar"])){
    $erroredad= $_POST["edad"]=="" || !is_numeric($_POST["edad"]) || $_POST["edad"]<0;
    $errorentradas= $_POST["entradas"]=="" || !is_numeric($_POST["entradas"]) || $_POST["entradas"]<0;
    $errorestudiante=!isset($_POST["usu"]);
    $errores =$errorestudiante || $erroredad || $errorentradas;
}

if(isset($_POST["btnEnviar"]) && !$errores){
 ?>
 <!DOCTYPE html>
 <html>
 <head>
        <title>SolucionEjer8</title>
        <meta charset="UTC-8"/>
    </head>
  <body>
      <?php
      if($_POST["edad"]<=12 || $_POST["usu"]=="estudiante"){
echo "<p>El precio de la entrada es de ".$_POST["entradas"]*3.5." euros";
      }else{
        echo "<p>El precio de la entrada es de ".$_POST["entradas"]*5 ." euros";
      }
      ?>

</body>
 </html>
 <?php   
}else{
?>


<!DOCTYPE html>
<html>
<head>
<title>Formulario8</title>
<meta charset="UTC-8"/>
</head>

<body>
    <form action= "Ejer8.php" method="post">
        <label for="edad">Insertar edad</label>
        <input type="text" id="edad" name="edad" value="<?Php if(isset($_POST["edad"])) echo $_POST["edad"]?>" />

<?php
if(isset($_POST["btnEnviar"]) && $_POST["edad"]==""){
    echo "* campo vacio *";
}else if(isset($_POST["btnEnviar"]) && $erroredad){
    echo "escriba un numero";
}
?>


<br/>
<br/>
     
<input type="radio" id="estudiante" name="usu" value="estudiante">
  <label for="estudiante">Estudiante</label>

  <input type="radio" id="noEstudiante" name="usu" value="noEstudiante">
  <label for="noEstudiante">No Estudiante</label><br>

  <?php
if(isset($_POST["btnEnviar"]) && $errorestudiante){
    echo "* Elija una *";
}

?>

  <br/>
<br/>

<label for="entradas">Insertar cantidad de entradas</label>
        <input type="text" id="entradas" name="entradas" value="<?Php if(isset($_POST["entradas"])) echo $_POST["entradas"]?>" />

<?php
if(isset($_POST["btnEnviar"]) && $_POST["entradas"]==""){
    echo "* campo vacio *";
}else if(isset($_POST["btnEnviar"]) && $errorentradas){
    echo "escriba un numero";
}
?>


<br/>
<br/>

<input type="submit" name="btnEnviar" value="enviar"/>
<input type="submit" name="btnBorrar" value="borrar"/>
    </form>
<?php
}
    ?>
</body>

</html>