<?php
    if(isset($_POST["btnComparar"])){
        $error_texto1=$_POST["texto1"]=="" || strlen($_POST["texto1"])<3;
        $error_texto2=$_POST["texto2"]=="" || strlen($_POST["texto2"])<3;

        $errores=$error_texto1||$error_texto2;
    }





?>

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 1</title>
<meta charset="UTF-8"/>
<style>

    .formulario{background-color:cyan;border:2px solid black;}
    .respuesta{background-color:green;border:2px solid black;margin-top: 2em;}
    h2{text-align:centre}
    form, .respuesta p{margin-left: 2em;}

</style>
</head>

<body>
    <div class="formulario">
    <h2>Ripios-Formulario</h2>
    <form action="Ejer1.php" method="post">
        <p>Dime dos palabras y te dire si riman o no</p>
        <p><label for="texto1">Primera palabra:</label>
            <input type="text" name="texto1" id="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"];?>"/>

<?php
if(isset($_POST["btnComparar"]) && $error_texto1){


    if($_POST["texto1"]==""){
        echo "*Campo Vacio";
    }else{
        echo "La palabra debe tener al menos tres letras";
    }
}

?>


        </p>
        <p><label for="texto2">Segunda palabra:</label>
            <input type="text" name="texto2" id="texto2" value="<?php if(isset($_POST["texto2"])) echo $_POST["texto2"];?>"/></p>
        
            <?php
if(isset($_POST["btnComparar"]) && $error_texto2){


    if($_POST["texto2"]==""){
        echo "*Campo Vacio";
    }else{
        echo "La palabra debe tener al menos tres letras";
    }
}

?>
        
        
            <p><button type="submit" name="btnComparar">Comparar</button></p>


    </form>
</div>

<?php
    if(isset($_POST["btnComparar"]) && !$errores){
$long1=strlen($_POST["texto1"]);
$long2=strlen($_POST["texto2"]);
$text1=strtolower($_POST["texto1"]);
$text2=strtolower($_POST["texto2"]);

$riman="no riman";
if($text1[$long1-1]==$text2[$long2-1]){

    if($text1[$long1-2]==$text2[$long2-2]){

            if($text1[$long1-3]==$text2[$long2-3]){
                $riman="riman";
            }else{

            $riman="riman un poco";
            
    }
}
}
?>
<div class="respuesta">
<h2>Ripios-Resouesta</h2>
<p>Las palabras<strong><?php echo $_POST["texto1"]?></strong> y <strong><?php echo $_POST["texto2"]?></strong> <?php echo $riman;?></p>

</div>
<?php
    }
?>
</body>

</html>