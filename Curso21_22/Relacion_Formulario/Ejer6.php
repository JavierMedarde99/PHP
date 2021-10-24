<?php
if(isset($_POST["btnEnviar"])){
 $error_euros=$_POST["euros"]=="" || !is_numeric($_POST["euros"]);
}

if(isset($_POST["btnEnviar"])){
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SolucionEjer6</title>
        <meta charset="UTC-8"/>
    </head>
    <body>
        <?php
        $sol=$_POST["euros"]*166.3860;
        echo "<p>Los euros de ".$_POST["euros"]." en pesetas son ".$sol ;
        
       
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

    <form action="Ejer6.php" method="post">

    <label for="euros">Euros</label>
    <input type="text" name="euros" id="euros"/>
    <br/>
    <br/>

<input type="submit" name="btnEnviar" value="Enviar"/>

    </form>
    <?php
}
?>
    </body>
</html>