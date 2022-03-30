<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejer2</title>
</head>
<body>
    <?php
   class fruta{
       private $color;
       private $tamaño;

       public function __construct($color,$tamaño){
        $this->color=$color;
        $this->tamaño=$tamaño;
        $this->imprimir();
       }

       public function imprimir(){
        echo "Esta es una fruta de color ".$this->color." de tamaño ".$this->tamaño;
       }
   } 

   $pera = new fruta("verde","pequeña");

  

    ?>
</body>
</html>