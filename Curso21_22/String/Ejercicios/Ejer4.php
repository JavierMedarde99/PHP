<?php


   function es_romano_correcto($texto){
  
 return letras_bien($texto) && orden_bueno($texto) && repite_bien($texto);

    } 
   
   
   
   if(isset($_POST["btnComparar"])){

        $error_texto1=$_POST["texto1"]=="" || ! es_romano_correcto(strtoupper($_POST["texto1"])) ;
    }

    function letras_bien($texto){
      
        $letras_validas["M"]=true;
        $letras_validas["D"]=true;
        $letras_validas["C"]=true;
        $letras_validas["L"]=true;
        $letras_validas["X"]=true;
        $letras_validas["V"]=true;
        $letras_validas["I"]=true;

        $bien=true;
        for($i=0;$i<strlen($texto);$i++){
            if(!isset($letras_validas[$texto[$i]])){
                    $bien=false;
                    break;
            }
        }
        return $bien;
    }

        function orden_bueno($texto){
         
         $letras_orden["M"]=1000;
         $letras_orden["D"]=500;
         $letras_orden["C"]=100;
         $letras_orden["L"]=50;
         $letras_orden["X"]=10;
         $letras_orden["V"]=5;
         $letras_orden["I"]=1;
            $correcto=true;
            for($i=0;$i<strlen($texto)-1;$i++){
                if($letras_orden[$texto[$i]]<$letras_orden[$texto[$i+1]]){
                    $correcto=false;
                        break;
                }
            }
            return $correcto;
        }

        function repite_bien($texto)
	{
	
		$veces["M"]=4;
		$veces["D"]=1;
		$veces["C"]=4;
		$veces["L"]=1;
		$veces["X"]=4;
		$veces["V"]=1;
		$veces["I"]=4;
		
		$correcto=true;
		for($i=0;$i<strlen($texto);$i++){
			$veces[$texto[$i]]--;
			if($veces[$texto[$i]]==-1){
				$correcto=false;
				break;
			}
		}
		return $correcto;
	}
        

        

?>

<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 4</title>
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
    <h2>Romanos a árabes-Formulario</h2>
    <form action="Ejer4.php" method="post">
        <p>Dime un numero en numeros romanos y lo convertire a cifras arabes</p>
        <p><label for="texto1">Numero:</label>
            <input type="text" name="texto1" id="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"];?>"/>
        </p>
        
        <?php
if(isset($_POST["btnComparar"]) && $error_texto1){


    if($_POST["texto1"]==""){
        echo "*Campo Vacio*";
    }else {
    echo "No esta bien escrito el numero romano";

    }
}

?>

            <p><button type="submit" name="btnComparar">Comparar</button></p>


    </form>

    </div>

<?php
    if(isset($_POST["btnComparar"]) && !$error_texto1){
        $valores["M"]=1000;
        $valores["D"]=500;
        $valores["C"]=100;
        $valores["L"]=50;
        $valores["X"]=10;
        $valores["V"]=5;
        $valores["I"]=1;

        $texto=strtoupper($_POST["texto1"]);
        $resultado=0;

        for($i=0;$i<strlen($_POST["texto1"]);$i++){
            $resultado+=$valores[$texto[$i]];
        }
    
?>
<div class="respuesta">
<h2>Arabes a romanos-Formulario</h2>
<p>El numero <strong><?php echo $_POST["texto1"]?></strong> se escribe en cifras arabe<strong> <?php echo $resultado?></strong></p>

</div>
<?php
    }
?>

</body>

</html>