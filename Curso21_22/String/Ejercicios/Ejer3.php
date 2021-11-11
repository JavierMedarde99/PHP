<?php
    if(isset($_POST["btnComparar"])){

        $error_texto1=$_POST["texto1"]=="" || !strpos($_POST["texto1"], " ");

        
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 3</title>
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
    <h2>Frases palindromas-Formulario</h2>
    <form action="Ejer3.php" method="post">
        <p>Dime una frase y te dire si es una frase palindroma</p>
        <p><label for="texto1">Frase:</label>
            <input type="text" name="texto1" id="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"];?>"/>
        </p>
        <?php
        if(isset($_POST["btnComparar"]) && $error_texto1){
            if($_POST["texto1"]==""){
                echo "*Campo Vacio";
            }else{
                echo "es una palabra";
            }
        } 
        ?>
            <p><button type="submit" name="btnComparar">Comparar</button></p>


    </form>
</div>
<?php
    if(isset($_POST["btnComparar"]) && !$error_texto1){
        $long1=strlen($_POST["texto1"])-1;
        $i=0;
        $text1=$_POST["texto1"];
        $text1= trim($text1);
        $text1=strtolower($_POST["texto1"]);
         $resul="no es palindromo";
        while($i<$long1){
            if($text1[$i]==$text1[$long1]){
                $resul= "es palindormo";
                break;
            }
            $i++;
            $long1--;
        
    }
       
?>
<div class="respuesta">
<h2>Palindromos / capicuas-Resultado</h2>
<p><?php echo $_POST["texto1"]?>  <?php echo $resul;?></p>

</div>

<?php
}
?>
</body>

</html>