<?php  
            $error_fecha1=!checkdate($_POST["meses"],$_POST["dias"],$_POST["anyos"]);
            $error_fecha2=!checkdate($_POST["meses2"],$_POST["dias2"],$_POST["anyos2"]);
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
    <h2>Fechas-Formulario2</h2>
    <form action="FechaEjer2.php" method="post">
        
        <p>Dia:
            <select name="dias" id="dias">
<?php
 for($i=1;$i<=31;$i++){
 echo "<option value='".$i."'> ".sprintf('%02d',$i)."</option>";
 }


?>
            </select>
            Mes:
            <select name="meses" id="meses">
<?php
$mesesarr=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 for($i=1;$i<=12;$i++){
 echo "<option value='".$i."'> ".$mesesarr[$i]."</option>";
 }


?>
</select>
            Año:
            <select name="anyos" id="anyos">
<?php
 for($i=date("Y")-50;$i<=date("Y");$i++){
 echo "<option value='".$i."'>" .$i." </option>";
 }
?>
            </select>
            <?php
            if(isset($_POST["btnComparar"]) && $error_fecha1){
                echo "no es una fecha correcta";
            }
            
            ?>
        </p>
       
        <p>Dia:
            <select name="dias2" id="dias2">
<?php
 for($i=1;$i<=31;$i++){
 echo "<option value='".$i."'> ".sprintf('%02d',$i)."</option>";
 }


?>
            </select>
            Mes:
            <select name="meses2" id="meses2">
<?php
$mesesarr2=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 for($i=1;$i<=12;$i++){
 echo "<option value='".$i."'> ".$mesesarr2[$i]."</option>";
 }


?>
</select>
            Año:
            <select name="anyos2" id="anyos2">
<?php
 for($i=date("Y")-50;$i<=date("Y");$i++){
 echo "<option value='".$i."'>" .$i." </option>";
 }
?>
            </select>
            <?php
            if(isset($_POST["btnComparar"]) && $error_fecha2){
                echo "no es una fecha correcta";
            }
            
            ?>
        
        </p>
       
            <p><button type="submit" name="btnComparar">Comparar</button></p>


    </form>
</div>
<?php
    if(isset($_POST["btnComparar"]) && !$errores){

        

        $seg1=mktime(0,0,0,$_POST["meses"],$_POST["dias"],$_POST["anyos"]);
        $seg2=mktime(0,0,0,$_POST["meses2"],$_POST["dias2"],$_POST["anyos2"]);

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