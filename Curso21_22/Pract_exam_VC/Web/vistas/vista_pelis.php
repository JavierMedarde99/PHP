<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExamenVideoclub</title>
</head>
<body>
    <h1>Video Club</h1>
    <div>
    <p>Bienvenido: <strong><?php echo $_SESSION["usuario"]?></strong>- <form action="index.php" method="post">
        <input type="submit" value="Salir" name="btnvolverPrincipal" />
    </form></p>
    <h2>Listado de Peliculas</h2>
    <?php
    $url=DIR_SERV."/obtenerPeliculas";
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("ExamenVideoclub","<h1>Video Club</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
    }

    if(isset($obj->error)){
        session_destroy();
        die(error_page("ExamenVideoclub","<h1>Video Club</h1><p>".$obj->error."</p>"));
    }
    if(isset($obj->peliculas)){
        echo "<table>";
        echo "<tr><th>id</th><th>Titulo</th><th>Caratula</th></tr>";
        echo "<tr>";
        foreach($obj->peliculas as $lista){
            echo "<td>".$lista->idPelicula."</td>";
            echo "<td>".$lista->titulo."</td>";
            echo "<td><img src='Img/".$lista->caratula."'/></td>";
        }
        echo "</tr>";
        echo "</table>";
    }
    ?>
</div>
</body>
</html>