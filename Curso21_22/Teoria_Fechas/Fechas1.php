<?php  

function  no_buena_fecha($fecha){
            $error_fecha=strlen($fecha)!=10;
            if(!$error_fecha){
                $dia=substr($fecha,0,2);
                $sep1=substr($fecha,2,1);
                $mes=substr($fecha,3,2);
                $sep2=substr($fecha,5,1);
                $anno=substr($fecha,6,4);

                $error_sep=$sep1!="/"||$sep2!="/";
                $error_numero= !is_numeric($dia) || !is_numeric($mes) || !is_numeric($anno);
                $error_fecha= $error_sep || $error_numero || !checkdate($mes,$dia,$anno);           
            }
            return$error_fecha;
        }
    if(isset($_POST["btnComparar"])){
        $error_fecha1=$_POST["fecha1"]=="" ||  no_buena_fecha($_POST["fecha1"]);
        $error_fecha2=$_POST["fecha2"]=="" ||  no_buena_fecha($_POST["fecha2"]);
        $errores = $error_fecha1 || $error_fecha2;

      
        
    }





?>



<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio fecha 1</title>
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
    <h2>Fechas-Formulario</h2>
    <form action="Fechas1.php" method="post">
        
        <p><label for="fecha1">Introduzca una fecha:(DD/MM/YYYY)</label>
            <input type="text" name="fecha1" id="fecha1" value="<?php if(isset($_POST["fecha1"])) echo $_POST["fecha1"];?>"/>
        </p>
       
        <?php
        if(isset($_POST["btnComparar"]) && $error_fecha1){
            if($_POST["fecha1"]==""){
                echo "*Campo Vacio*";
            }else{
                echo "La fecha no esta bien";
            }
        }
        ?>
         <p><label for="fecha2">Introduzca una fecha:(DD/MM/YYYY)</label>
            <input type="text" name="fecha2" id="fecha2" value="<?php if(isset($_POST["fecha2"])) echo $_POST["fecha2"];?>"/>
        </p>
        <?php
        if(isset($_POST["btnComparar"]) && $error_fecha2){
            if($_POST["fecha1"]==""){
                echo "*Campo Vacio*";
            }else{
                echo "La fecha no esta bien";
            }
        }
        
        ?>
            <p><button type="submit" name="btnComparar">Comparar</button></p>


    </form>
</div>
<?php
    if(isset($_POST["btnComparar"]) && !$errores){

        $fecha1=explode("/",$_POST["fecha1"]);
        $fecha2=explode("/",$_POST["fecha2"]);

        $seg1=mktime(0,0,0,$fecha1[1],$fecha1[0],$fecha1[2]);
        $seg2=mktime(0,0,0,$fecha2[1],$fecha2[0],$fecha2[2]);

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