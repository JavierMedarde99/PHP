<?php
   
   
   if(isset($_POST["btnComparar"])){

        $error_texto1=$_POST["texto1"]=="" || !is_numeric($_POST["texto1"]) || $_POST["texto1"]<=0 || $_POST["texto1"]>=5000;
    }

    function eliminar_tilde($cadena){
        $cadena =str_replace(array('á','é','í','ó','ú'),array('a','e','i','o','u'),$cadena);
        $cadena =str_replace(array('à','è','ì','ò','ù'),array('a','e','i','o','u'),$cadena);

        $cadena =str_replace(array('Á','É','Í','Ó','Ú'),array('A','E','I','O','U'),$cadena);
        $cadena =str_replace(array('À','È','Ì','Ò','Ù'),array('A','E','I','O','U'),$cadena);

        $cadena =str_replace(array('Ü','ü'),array('U','u'),$cadena);

        return $cadena;
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 6</title>
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
    <h2>Quita acentos -Formulaio</h2>
    <form action="Ejer6.php" method="post">
        <p>Escribe un texto y le quitaré los acentos</p>
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





</body>

</html>