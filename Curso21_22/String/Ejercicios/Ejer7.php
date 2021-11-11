<?php
   
   
   if(isset($_POST["btnComparar"])){
function sonnumero($cadena){
$cadena = str_replace(".","",$cadena);
$cadena = str_replace(",","",$cadena);
$cadena = str_replace(" ","",$cadena);
return $cadena;  
}

        $error_texto1=$_POST["texto1"]=="" || !is_numeric( sonnumero($_POST["texto1"])) ;
    
} 

?>

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 7</title>
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
    <h2>Unifica separador decimal-Formulario</h2>
    <form action="Ejer7.php" method="post">
        <p>Escribe varios números separados por espacios y unificaré el separador decimal a punto</p>
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
        
       $resul= str_replace(",",".",$_POST["texto1"])
    
?>
<div class="respuesta">
<h2>Unifica separador decimal-Resultado</h2>
<p>Números originales</p><br/>
<p><?php echo $_POST["texto1"]?></p>
<p>Numeros corregidos</p> 
<p> <?php echo $resul;?></p>

</div>

<?php
}
?>
   


</body>

</html>