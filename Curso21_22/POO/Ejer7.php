<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejer7</title>
</head>
<body>
<?php
function dias_pasados($fecha_inicial,$fecha_final)
{
$dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
$dias = abs($dias); $dias = floor($dias);
return $dias;
}
class peliculas{

    private $titulo;
    private int $anyo;
    private $director;
    private bool $alquilada;
    private float $precio;
    private $fechaDevolucion;

    public function __construct($titulo,$anyo,$director,$alquilada,$precio,$fechaDevolucion){
        $this->titulo=$titulo;
        $this->anyo=$anyo;
        $this->director=$director;
        $this->alquilada=$alquilada;
        $this->precio=$precio;
        $this->fechaDevolucion=$fechaDevolucion;
        $this->nombre();
        $this->anyoYDirector();
        $this->precio();
        $this->alquilada();
        $this->fecha();
        $this->recargo();
    }

    public function nombre(){
        echo  "<p>el titulo es ".$this->titulo."</p>";
    }

    public function anyoYDirector(){
        echo  "<p>el año de la peli es ".$this->anyo." y el director es ".$this->director."</p>";
    }

    public function precio(){
        echo "El precio es de ".$this->precio." de euros";
    }

    public function alquilada(){
        if($this->alquilada){
            echo "<p>La pelicula esta alquilada</p>";
        }else{
            echo "<p>La pelicula no esta alquilada</p>"; 
        }
    }

    public function fecha(){
        echo "<p>hay que devolverla ".$this->fechaDevolucion."</p>";
    }

    public function recargo(){
       $diff = dias_pasados(date('d-m-Y'),$this->fechaDevolucion);
        $resul = $diff*1.2;
        echo "La devolucion sale a ".$resul," euros";

    }
}

$peli= new peliculas("dune",2020,"Denis Villeneuve",true,20.5,date('2022/01/01'));

?>
</body>
</html>