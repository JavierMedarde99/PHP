<?php

if(isset($_POST["btnBorrar"])){

    $url=DIR_SERV."/borrarGrupo/".json_decode($_POST["dia"])."/".json_decode($_POST["hora"])."/".json_decode($_POST["profesor"])."/".json_decode($_POST["grupo"]);
    $respuesta=consumir_servicios_REST($url,"DELETE");
    $obj=json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
    }
    if(isset($obj->error)){
        session_destroy();
        die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>".$obj->error."</p>"));
    }

    if($obj->mensaje){
        $_SESSION["mensaje"]=$obj->mensaje;
        header('Location: index.php');
        
    }
}

if(isset($_POST["btnInsertar"])){
    $url=DIR_SERV."/insertarGrupo/".json_decode($_POST["dia"])."/".json_decode($_POST["hora"])."/".json_decode($_POST["profesor"])."/".json_decode($_POST["grupo"]);
    $respuesta=consumir_servicios_REST($url,"POST");
    $obj=json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
    }
    if(isset($obj->error)){
        session_destroy();
        die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>".$obj->error."</p>"));
    }

    if($obj->mensaje){
        $_SESSION["mensaje"]=$obj->mensaje;
        header('Location: index.php');
        
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 PHP</title>
    <style>
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        .enlinea{display:inline}
    </style>
</head>
<body>
    <h1>Examen4 PHP</h1>
    <div>
        Bienvenido <strong><?php echo $_SESSION["usuario"];?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <?php
    $url=DIR_SERV."/usuarios";
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
    }
    if(isset($obj->error)){
        session_destroy();
        die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>".$obj->error."</p>"));
    }
    ?>

    <form action="index.php" method="post">
        <select name="profesor" id="profesor">
            <?php
                foreach($obj->usuarios as $profesores){
                    if(isset($_POST["btnProfesor"])  && $_POST["profesor"]==$profesores->id_usuario){
                        echo "<option selected value='".$profesores->id_usuario."'>".$profesores->nombre."</option>";
                        
                        $_SESSION["nombreProfesor"]=$profesores->nombre;
                    }else{
                       echo "<option value='".$profesores->id_usuario."'>".$profesores->nombre."</option>"; 
                    }
                    
                }
            ?>  
        </select>
        <input type="submit" value="Ver Horarios" name="btnProfesor">
    </form>
    <?php
    if(isset($_POST["btnProfesor"]) || isset($_POST["btnEditar"])){
        $url=DIR_SERV."/horario/".json_decode($_POST["profesor"]);
        $respuesta=consumir_servicios_REST($url,"GET");
        $obj=json_decode($respuesta);
        if(!$obj){
            session_destroy();
            die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
        }
        if(isset($obj->error)){
            session_destroy();
            die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>".$obj->error."</p>"));
        }

        if(isset($obj->horario)){
            $hora[1]="8:15-9:15";
            $hora[2]="9:15-10:15";
            $hora[3]="10:15-11:15";
            $hora[4]="11:15-11:45";
            $hora[5]="11:45-12:45";
            $hora[6]="12:45-13:45";
            $hora[7]="13:45-14:45";
            
            foreach($obj->horario as $horario){

                if(isset($tabla[$horario->hora][$horario->dia]))
                $tabla[$horario->hora][$horario->dia].="/".$horario->nombre;
                else 
                $tabla[$horario->hora][$horario->dia]=$horario->nombre;
                
            }
            echo "<h2>".$_SESSION["nombreProfesor"]."</h2>";
            echo "<table>";
            echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th></tr>";
            for($i=1;$i<=7;$i++){
                echo "<tr>";
                echo "<th>".$hora[$i]."</th>";
                if($i==4){
                    echo "<td colspan='5'>Recreo</td>";
                }else{
                     for($j=1;$j<=5;$j++){
                         if(isset($tabla[$i][$j])){
                            echo "<td>".$tabla[$i][$j]."
                            <form action='index.php' method='post'>"; 
                            echo " <input type='hidden' value='".$i."' name='hora'>";
                            echo "<input type='hidden' value='".$j."' name='dia'>
                            <input type='hidden' value='".$_SESSION["nombreProfesor"]."' name='nombreprofesor'>
                            <input type='hidden' value='".$_POST["profesor"]."' name='profesor'>
                            <input type='submit' value='editar' name='btnEditar'>
                            </form>
                            </td>";
                         }else{
                             echo "<td><form action='index.php' method='post'>"; 
                            echo " <input type='hidden' value='".$i."' name='hora'>";
                            echo  "<input type='hidden' value='".$j."' name='dia'>
                             <input type='hidden' value='".$_SESSION["nombreProfesor"]."' name='nombreProfesor'>
                             <input type='hidden' value='".$_POST["profesor"]."' name='profesor'>
                             <input type='submit' value='editar' name='btnEditar'>
                             </form></td>";
                         }
                   
                    } 
                } 
                echo "</tr>";
            }
            echo "</table>";
        }
        
        if(isset($_POST["btnEditar"])){
            if(isset($_SESSION["accion"])){
                echo $_SESSION["accion"];
                unset($_SESSION["accion"]);
            }
        $dia[1]="Lunes";
        $dia[2]="Martes";
        $dia[3]="Miercoles";
        $dia[4]="Jueves";
        $dia[5]="Viernes";
        if($_POST["hora"]<=3)
        echo "<h2>Editando la ".($_POST["hora"])."º hora ".$hora[$_POST["hora"]]." del ".$dia[$_POST["dia"]]." el profesor ".$_POST["profesor"]."</h2>";
        else
        echo "<h2>Editando la ".($_POST["hora"]-1)."º hora ".$hora[$_POST["hora"]]." del ".$dia[$_POST["dia"]]."</h2>";
        $url=DIR_SERV."/grupos/".json_decode($_POST["dia"])."/".json_decode($_POST["hora"])."/".json_decode($_POST["profesor"]);
        $respuesta=consumir_servicios_REST($url,"GET");
        $obj=json_decode($respuesta);
        if(!$obj){
            session_destroy();
            die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
        }
        if(isset($obj->error)){
            session_destroy();
            die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>".$obj->error."</p>"));
        }
        echo "<table>";
        echo "<tr><th>Grupo</th><th>Acción</th></tr>";
        foreach($obj->grupos as $grupos){
            echo "<tr><td>".$grupos->nombre."</td><td><form action='index.php' method='post'>
            <input type='hidden' value='".$_POST["hora"]."' name='hora'>
            <input type='hidden' value='".$_POST["dia"]."' name='dia'>
            <input type='hidden' value='".$_SESSION["nombreProfesor"]."' name='nombreProfesor'>
            <input type='hidden' value='".$_POST["profesor"]."' name='profesor'>
            <input type='hidden' value='".$grupos->id_grupo."' name='grupo'>
            <input type='submit' value='eliminar' name='btnBorrar'>
            </td></tr>";
        }
        echo "</table><br/>";

        echo " <form action='index.php' method='post'>
        <select name='grupo' id='grupo'>";
        $url=DIR_SERV."/gruposLibres/".json_decode($_POST["dia"])."/".json_decode($_POST["hora"])."/".json_decode($_POST["profesor"]);
        $respuesta=consumir_servicios_REST($url,"GET");
        $obj=json_decode($respuesta);
        if(!$obj){
            session_destroy();
            die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
        }
        if(isset($obj->error)){
            session_destroy();
            die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>".$obj->error."</p>"));
        }
        foreach($obj->gruposLibres as $grupoLibres){
            echo "<option value='".$grupoLibres->id_grupo."'>".$grupoLibres->nombre."</option>";
        }
        echo "</select>
        <input type='hidden' value='".$_POST["hora"]."' name='hora'>
        <input type='hidden' value='".$_POST["dia"]."' name='dia'>
        <input type='hidden' value='".$_SESSION["nombreProfesor"]."' name='nombreProfesor'>
        <input type='hidden' value='".$_POST["profesor"]."' name='profesor'>
        <input type='submit' value='Añadir Grupo' name='btnInsertar'>
    </form>";
    }
    }
    ?>
    
</body>
</html>