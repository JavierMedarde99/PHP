<?php
if(isset($_POST["btnEnviar"])){
 $error_euros=$_POST["euros"]=="" || !is_numeric($_POST["euros"])|| $_POST["euros"]<0;
 $errormoneda= !isset($_POST["moneda"]);
 $errores = $error_euros || $errormoneda;
}

if(isset($_POST["btnEnviar"]) && !$errores){
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SolucionEjer7</title>
        <meta charset="UTC-8"/>
    </head>
    <body>
        <?php
        if($_POST["moneda"]=="peseta"){
        $sol=$_POST["euros"]*166.3860;
        echo "<p>Los euros de ".$_POST["euros"]." en pesetas son ".$sol ;
        }else{
            $sol=$_POST["euros"]*1.16;
            echo "<p>Los euros de ".$_POST["euros"]." en pesetas son ".$sol ; 
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
<title>Ejer5</title>
<meta charset="UTC-8"/>
    </head>
    <body>

    <form action="Ejer7.php" method="post">

    <label for="euros">Euros</label>
    <input type="text" name="euros" id="euros" value="<?Php if(isset($_POST["euros"])) echo $_POST["euros"]?>"/>

    <?php
if(isset($_POST["btnEnviar"]) && $_POST["euros"]==""){
    echo "* campo vacio *";
}else if(isset($_POST["btnEnviar"]) && $error_euros){
    echo "escriba un numero";
}
?>

    <br/>
    <br/>

    <input type="radio" id="peseta" name="moneda" value="peseta">
  <label for="peseta">peseta</label>

  <input type="radio" id="dolares" name="moneda" value="dolares">
  <label for="dolares">dolares</label><br>

  <?php
if(isset($_POST["btnEnviar"]) && $errorestudiante){
    echo "* Elija una *";
}

?>

<br/>
    <br/>

<input type="submit" name="btnEnviar" value="Enviar"/>

    </form>
    <?php
}
?>
    </body>
</html>