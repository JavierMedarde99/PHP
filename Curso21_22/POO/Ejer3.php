<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejer3</title>
</head>
<body>
    <?php
   class fruta{
    private $color;
    private $tamaño;
       static private $n_frutas=0;

       public function __construct($color,$tamaño){
        $this->color=$color;
        $this->tamaño=$tamaño;
        $this->imprimir();
        fruta::$n_frutas++;
       }

       public function __destruct() {
        echo 'Destroying: ', $this->color, PHP_EOL;
        echo 'Destroying: ', $this->tamaño, PHP_EOL;
        fruta::$n_frutas--;
    }

       public function imprimir(){
        echo "Esta es una fruta de color ".$this->color." de tamaño ".$this->tamaño;
       }

       public static function cuentaFruta(){
           echo "hay ".fruta::$n_frutas." frutas";
       }
   } 

   $pera = new fruta("verde","pequeña");
   echo "</br>";
   $manzana = new fruta("verde","grande");
   echo "</br>";
   echo fruta::cuentaFruta();
   echo "</br>";

    ?>
</body>
</html>