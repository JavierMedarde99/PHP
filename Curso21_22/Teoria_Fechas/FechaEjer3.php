<?php  
            $error_fecha1= !isset($_POST["fecha1"]);
            $error_fecha2= !isset($_POST["fecha2"]);;
            $errores= $error_fecha || $error_fecha2;

?>



<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio fecha 2</title>
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
    <h2>Fechas-Formulario3</h2>
    <form action="FechaEjer3.php" method="post">
        <p>
       <label for="fecha1">Introduzca una fecha</label>
        <input type="date" name="fecha1" id="fecha1" value="<?php if(isset($_POST["fecha1"])) echo $_POST["fecha1"];?>"/>
        <?php
        if(isset($_POST["btnComparar"]) && $error_fecha1){
           
                echo "*Campo Vacio*";
           
        }
        ?>

        <label for="fecha2">Introduzca una fecha</label>
        <input type="date" name="fecha2" id="fecha2" value="<?php if(isset($_POST["fecha2"])) echo $_POST["fecha2"];?>"/>
        </p>

       
            <p><button type="submit" name="btnComparar">Comparar</button></p>


    </form>
</div>
<?php
    if(isset($_POST["btnComparar"]) && !$errores){

        
        $dia1=date("d",$_POST["fecha1"]);
        $mes1=date("m",$_POST["fecha1"]);
        $anyo1=date("Y",$_POST["fecha1"]);

        $dia2=date("d",$_POST["fecha2"]);
        $mes2=date("m",$_POST["fecha2"]);
        $anyo2=date("Y",$_POST["fecha2"]);

        $seg1=mktime(0,0,0,$mes1,$dia1,$anyo1);
        $seg2=mktime(0,0,0,$mes2,$dia2,$anyo2);

        $dias=($seg1-$seg2)/(3600*24);

        $dias=abs(floor($dias));

?>
<div class="respuesta">
<h2>Dias de diferencia</h2>
<p>La diferencias en dias entre las dos fechas elegidas es de <?php echo $dias?></p>

</div>
<?php
    }
?>
</body>

</html>