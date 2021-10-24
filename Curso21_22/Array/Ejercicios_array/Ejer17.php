<!DOCTYPE html>
<html lang="es">

<head>
<title> Ejercicio 17</title>
<meta charset="UTF-8"/>
</head>

<body>
    <h1>Ejercicio 17</h1>
    
    <?php
    $Familia["LosSimpson"]["padre"]="Homer";
    $Familia["LosSimpson"]["madre"]="Marge";
    $Familia["LosSimpson"]["hijos"]["hijo1"]="Bart";
    $Familia["LosSimpson"]["hijos"]["hijo2"]="Lisa";
    $Familia["LosSimpson"]["hijos"]["hijo3"]="Maggie";
    $Familia["LosGriffin"]["padre"]="Peter";
    $Familia["LosGriffin"]["madre"]="Lois";
    $Familia["LosGriffin"]["hijos"]["hijo1"]="Chris";
    $Familia["LosGriffin"]["hijos"]["hijo2"]="Meg";
    $Familia["LosGriffin"]["hijos"]["hijo3"]="Stewie";
    
    echo"<ul>";
    foreach($Familia as $serie=>$componentes){
        echo "<li>".$serie."<ul>";
        foreach($componentes as $i=>$valor){
            
                if($i=="hijos"){
                    echo"<li>";
                    echo $i.": ";
                    echo"</li>";
                    echo "<ol>";
                foreach($valor as $hijos=>$hijo){
                    echo "<li>".$hijo."</li>";
                }
                    echo "</ol>";
                }else{
                    echo"<li>";
                    echo $i.": ".$valor.".";
                    echo"</li>";
                }
            }
  echo"</ul>";
    }
    echo"</ul>";
            ?>
   
   
</body>

</html>