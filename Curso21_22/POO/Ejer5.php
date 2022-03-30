<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejer5</title>
</head>
<body>
    <?php
    class empleado{
        private $nombre;
        private int $sueldo;

        public function __construct($nombre,$sueldo){
            $this->nombre=$nombre;
            $this->sueldo=$sueldo;
            $this->impuesto();
        }

        public function impuesto(){
            if($this->sueldo>3000){
                echo "el empleado ".$this->nombre." tiene que pagar impuestos";
            }else{
                echo "el empleado ".$this->nombre." no tiene que pagar impuestos";
            }
        }
    }

    $juan = new empleado("Juan", 400000);
    echo "</br>";
    $ivan = new empleado("Ivan", 200);


    ?>
</body>
</html>