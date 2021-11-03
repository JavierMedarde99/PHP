<?php
  function mi_strlen($texto){
    $resp=0;
    while(isset($texto[$resp]))
    $resp++;
    return $resp;
}

function mi_explode($sep,$texto){
$aux =[];
$long_texto=mi_strlen($texto);
$i=0;
while($i<$long_texto && $texto[$i]==$sep)
$i++;

if($i<$long_texto){
    $j=0;
    $aux[$j]=$texto[$i];
    for($k=$i+1; $k<$long_texto;$k++){
        if($texto[$k]!=$sep){
            $aux[$j].=$texto[$k];
        }else{
            $k++;
            while($k<$long_texto && $texto[$k]==$sep){
                $k++;
            }
            if($k<$long_texto){
$j++;
$aux[$j]=$texto[$k];
            }
        }
    }
}
return $aux;
}
if(isset($_POST["btnContar"]))
$error_texto= $_POST["texto"]=="";


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3</title>
    <style>
        .error{color:red;}
    </style>
</head>
<body>
    <h1>Ejercicio3</h1>
    <form action="ejercicio3.php" method="post">
        <p><label for="texto">Elija separador</label></p>
<section name="sep" id="sep">
<option <?php if(isset($_POST["sep"]) && $_POST["sep"]==",") echo "selected" ?> value=",">,(coma)</option>
<option <?php if(isset($_POST["sep"]) && $_POST["sep"]==";") echo "selected" ?> value=";">;(punto y coma)</option>
<option <?php if(isset($_POST["sep"]) && $_POST["sep"]==" ") echo "selected" ?> value=" ">,(espacio)</option>
<option <?php if(isset($_POST["sep"]) && $_POST["sep"]==":") echo "selected" ?> value=":">:(dos puntos)</option>
</section>

<label for="texto">instroduzca una frase</label>
<input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"]?>">
<?php
if(isset($_POST["btnContar"]) && $error_texto)
echo "<span class='error'>*Campo obligatorio*</span>";
?>
<input type="submit" value="Contar" name="btnContar">
    </form>

    <?php
    if(isset($_POST["btnContar"]) && !$error_texto){
        echo "<h2>Respuesta</h2>";
        echo "<p>El texto introducido separado con el separador seleccionado contiene ".count(mi_explode($_POST["seo"],$_POST["texto"]))." palabras</p>";
    }
    ?>


</body>
</html>