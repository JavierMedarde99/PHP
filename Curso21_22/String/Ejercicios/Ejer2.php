<?php
    if(isset($_POST["btnComparar"])){
        $error_texto1=$_POST["texto1"]=="" || strlen($_POST["texto1"])<2;

        
    }





?>



<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 2</title>
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
    <h2>Palindromos / capicuas-Formulario</h2>
    <form action="Ejer2.php" method="post">
        <p>Dime una palabra o un numero y te dire si es un palindromo o un numero capicua</p>
        <p><label for="texto1">Palabra o numero:</label>
            <input type="text" name="texto1" id="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"];?>"/>
        </p>
        <?php
        if(isset($_POST["btnComparar"]) && $error_texto1){
            if($_POST["texto1"]==""){
                echo "*Campo Vacio";
            }else{
                echo "La palabra debe tener al menos dos letras";
            }
        }
        
        
        ?>
            <p><button type="submit" name="btnComparar">Comparar</button></p>


    </form>
</div>
<?php
    if(isset($_POST["btnComparar"]) && !$error_texto1){
        $long1=strlen($_POST["texto1"]);
        $i=0;
       /* for($i=0;$i<$long1;$i++){
            for($j=$long1-1;$j<$long1;$j--){
            
                if($texto1[$i]!=$texto1[$j]){
                    $resul= "no es palindormo";
                }

            }
        }*/
        $resul="es palindromo";
        while($i>=$long1){
            if($texto1[$i]!=$texto1[$j]){
                $resul= "no es palindormo";
            }
            $i++;
            $long1--;
        }
?>
<div class="respuesta">
<h2>Ripios-Resouesta</h2>
<p><?php echo $_POST["texto1"]?><?php echo $_POST["texto2"]?></strong> <?php echo $riman;?></p>

</div>

<?php
}
?>
</body>

</html>