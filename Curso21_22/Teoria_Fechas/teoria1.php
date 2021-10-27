<!DOCTYPE html>
<html lang="es">

<head>
<title> Mi primera pagina </title>
<meta charset="UTF-8"/>
</head>

<body>
   <?php
        $tiempo =time();
        echo $tiempo."<br/>";

        $fecha=date("h:i:s d/m/Y",$tiempo);
        echo $fecha."<br/>";

        $cumpl=mktime(0,0,0,06,20,1996);
        echo $cumpl."<br/>";
        
        $fecha=date("h:i:s d/m/Y",$cumpl);
        echo $fecha."<br/>";

        if(checkdate(02,28,1999))
        echo "verdadero";
        else
        echo "falsa";

        echo"<br/>";

        $fecha_inv="1996/06/20";
        echo strtotime($fecha_inv)."<br/>";

        echo floor(5.6);
        echo "<br/>";
        echo ceil(5.6);
        echo "<br/>";
        echo abs(floor(5.6)-ceil(5.6));
        echo "<br/>";
   ?>
   
</body>

</html>