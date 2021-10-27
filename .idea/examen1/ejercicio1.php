<?php
    function mi_strlen($texto){
        $resp=0;
        while(isset($texto[$resp]))
        $resp++;
        return $resp;
    }


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
</head>
<body>
    <h1>Ejercicio1</h1>
    <form action="ejercicio1.php" method="post">
        <p><label for="">instroduzca una frase:</label></p>
        <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"]?>" />

        <p><input type="submit" value="Contar" name="btnEnviar"></p>
    </form>

    <?php
    
    if(isset($_POST["btnEnviar"])){
        echo "<h2>Restpuesta:</h2>";
        echo "<p>la longitud del texto instroducido es de : ".mi_strlen($_POST["texto"])."</p>";
    }
    ?>
</body>
</html>