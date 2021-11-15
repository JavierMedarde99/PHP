<?php
   
   
   if(isset($_POST["btnComparar"])){

        $error_texto1=$_POST["texto1"]=="" || !is_numeric($_POST["texto1"]) || $_POST["texto1"]<=0 || $_POST["texto1"]>=5000;
    }

    

?>

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 5</title>
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
    <h2>Romanos a árabes-Formulario</h2>
    <form action="Ejer5.php" method="post">
        <p>Dime un numero en numeros romanos y lo convertire a cifras arabes</p>
        <p><label for="texto1">Numero:</label>
            <input type="text" name="texto1" id="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"];?>"/>
        </p>
        
        <?php
if(isset($_POST["btnComparar"]) && $error_texto1){


    if($_POST["texto1"]==""){
        echo "*Campo Vacio*";
    }else if (!is_numeric($_POST["texto1"])) {
        echo "debe ser un numero";
    } else {
        echo "El numero debe estar entre 0 y 5000 no incluidos";
    }
     
}

?>

            <p><button type="submit" name="btnComparar">Comparar</button></p>


    </form>

    </div>


    <?php
    if(isset($_POST["btnComparar"]) && !$error_texto1){
        
        $numero =$_POST["texto1"];

        while($numero>0){

        switch($numero){
            case $numero>1000:
                $numero-= 1000;
                $resultado.="M";
                break;
            case $numero>=500:
                $numero-= 500;
                $resultado.="D";
                break;
            case $numero>=100:
                $numero-= 100;
                $resultado.="C";
                break;    
            case $numero>=50:
                $numero-= 50;
                $resultado.="L";
                break; 
            case $numero>=10:
                $numero-= 10;
                $resultado.="X";
                break; 
            case $numero>=5:
                $numero-= 5;
                $resultado.="V";
                break; 
                case $numero>=1:
            $numero-= 1;
                $resultado.="I";

        }
        }
?>
<div class="respuesta">
<h2>Arabes a romanos-Formulario</h2>
<p>El numero <strong><?php echo $_POST["texto1"]?></strong> se escribe en Romano <strong> <?php echo $resultado?></strong></p>

</div>
<?php
    }
?>


</body>

</html>