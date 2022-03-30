<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 PHP</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }

        .tabla,
        tr,
        th,
        td {

            border: 2px solid black;
        }

        .tabla,
        tr {

            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Examen4 PHP</h1>
    <div>
        Bienvenido <strong><?php echo $_SESSION["usuario"]; ?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <h2>Su horario</h2>
    <?php
    $url = DIR_SERV . "/horario/" . $datos_usuario_log->id_usuario;
    $respuesta = consumir_servicios_REST($url, "get");
    $obj = json_decode($respuesta);

    if (!$obj) {

        session_destroy();
        die("<p>Error al consumir el servicio: " . $url . "</p>" . $respuesta);
    }

    if (isset($obj->error)) {

        session_destroy();
        die("<p>" . $obj->error . "</p>");
    }

    echo "<h3 class='titTabla'>horario del Profesor: " . $datos_usuario_log->nombre . "</h3>";
    
    $dias_semana = array("-", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes");
    $horas_dia = array("8:15-9:15", "9:15-10:15", "10:15-11:15", "11:15-11-45", "11:45-12:45", "12:45-13:45", "13:45-14:45");

    echo "<table class='tabla'>";
    echo "<tr><th></th><th>" . $dias_semana[1] . "</th><th>" . $dias_semana[2] . "</th><th>" . $dias_semana[3] . "</th><th>" . $dias_semana[4] . "</th><th>" . $dias_semana[5] . "</th></tr>";

    for ($i = 1; $i <= 7; $i++) {
        echo "<tr>";

        if ($i > 4) {

            echo "<td>" . $horas_dia[($i - 1)] . "</td>";
        } else {

            echo "<td>" . $horas_dia[$i] . "</td>";
        }

        if ($i == 4) {

            echo "<td colspan='5'>RECREO</td>";
        } else {

            for ($j = 1; $j <= 5; $j++) {

                echo "<td>";
                foreach($obj->horario as $fila){

                    if($fila->dia == $j && $fila->hora == $i){

                        echo $fila->nombre."/";
                    }
                }
                echo "</td>";
            }
        }
        echo "</tr>";
    }

    echo "</table>";
    ?>

</body>

</html>