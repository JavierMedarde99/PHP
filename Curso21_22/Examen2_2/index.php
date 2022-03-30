<?php
    require "src/ctes_funciones.php";
   
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        die(error_page("Examen2 PHP","<h1>Examen2 PHP</h1><p>Error en la conexión Nº: ".mysqli_connect_errno(). " : ".mysqli_connect_error()."</p>"));
    mysqli_set_charset($conexion,"utf8");

    session_name("Examen2_php_21_22");
    session_start();

    $dias[1]="Lunes";
    $dias[2]="Martes";
    $dias[3]="Miércoles";
    $dias[4]="Jueves";
    $dias[5]="Viernes";

    if(isset($_POST["btnCambiarAula"]))
    {
        $consulta="update horario_lectivo set aula=".$_POST["aula_cambio"]." where dia=".$_POST["dia"]." and hora=".$_POST["hora"]." and grupo=".$_POST["grupo_cambio"]." and aula=".$_POST["aula"];
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            $consulta="insert into horario_lectivo (usuario,dia,hora,grupo,aula) values (".$_POST["profesor"].",".$_POST["dia"].",".$_POST["hora"].",".$_POST["grupo"].",".$_POST["aula"].")";
            $resultado=mysqli_query($conexion,$consulta);
            if($resultado)
            {
                $_SESSION["accion"]["mensaje"]="Grupo insertado con éxito con intercambio de aulas";
                $_SESSION["accion"]["dia"]=$_POST["dia"];
                $_SESSION["accion"]["hora"]=$_POST["hora"];
                $_SESSION["accion"]["profesor"]=$_POST["profesor"];
                header("Location:index.php");
                exit;
            }
            else
            {
                $body="<h1>Examen2 PHP</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                mysqli_close($conexion);
                session_destroy();
                die(error_page("Examen2 PHP",$body));
            }
        }
        else
        {
            $body="<h1>Examen2 PHP</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Examen2 PHP",$body));
        }
    }

    if(isset($_POST["btnComprobarAula"]))
    {
        
        $consulta="select grupos.id_grupo,grupos.nombre,horario_lectivo.usuario from horario_lectivo,grupos where horario_lectivo.grupo=grupos.id_grupo and dia=".$_POST["dia"]." and hora=".$_POST["hora"]." and aula=".$_POST["aula"];
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
           if( mysqli_num_rows($resultado))
           {
                $datos_comprobar=mysqli_fetch_assoc($resultado);
                if($datos_comprobar["id_grupo"]!=$_POST["grupo"])
                {
                    $contenido="<h2 class='centrar relleno'>Confirmación cambio de aula del ".$dias[$_POST["dia"]]." a ".$_POST["hora"]."º Hora</h2>";
                    $contenido.="<p class='centrar relleno'>Has seleccionado un aula que está siendo usada por el profesor ".$datos_comprobar["usuario"]." en el grupo ".$datos_comprobar["nombre"]."</p>";
                    $contenido.="<p class='centrar relleno'>Para añadirle este aula a ".$_POST["btnComprobarAula"].", debes cambiarle antes el aula a ".$datos_comprobar["nombre"]."</p>";
                    $contenido.="<p class='centrar relleno'><button onclick='cerrar_modal_general();'>Cancelar</button> <button onclick='montar_modal_confirmar_aula(".$datos_comprobar["id_grupo"].",\"".$datos_comprobar["nombre"]."\",\"".$dias[$_POST["dia"]]."\",".$_POST["hora"].");'>Continuar</button></p>";
                    $_SESSION["accion"]["modal"]=$contenido;
                    $_SESSION["accion"]["grupo"]=$_POST["grupo"];
                    $_SESSION["accion"]["aula"]=$_POST["aula"];
                    $_SESSION["accion"]["dia"]=$_POST["dia"];
                    $_SESSION["accion"]["hora"]=$_POST["hora"];
                    $_SESSION["accion"]["profesor"]=$_POST["profesor"];
                    
                    mysqli_free_result($resultado);
                    header("Location:index.php");
                    exit;
                }
                else
                {
                    $consulta="insert into horario_lectivo (usuario,dia,hora,grupo,aula) values (".$_POST["profesor"].",".$_POST["dia"].",".$_POST["hora"].",".$_POST["grupo"].",".$_POST["aula"].")";
                    $resultado=mysqli_query($conexion,$consulta);
                    if($resultado)
                    {
                        $_SESSION["accion"]["mensaje"]="Grupo insertado con éxito";
                        $_SESSION["accion"]["dia"]=$_POST["dia"];
                        $_SESSION["accion"]["hora"]=$_POST["hora"];
                        $_SESSION["accion"]["profesor"]=$_POST["profesor"];
                        header("Location:index.php");
                        exit;
                    }
                    else
                    {
                        $body="<h1>Examen2 PHP</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                        mysqli_close($conexion);
                        session_destroy();
                        die(error_page("Examen2 PHP",$body));
                    }
                }
           }
           else
           {
                $consulta="insert into horario_lectivo (usuario,dia,hora,grupo,aula) values (".$_POST["profesor"].",".$_POST["dia"].",".$_POST["hora"].",".$_POST["grupo"].",".$_POST["aula"].")";
                $resultado=mysqli_query($conexion,$consulta);
                if($resultado)
                {
                    $_SESSION["accion"]["mensaje"]="Grupo insertado con éxito";
                    $_SESSION["accion"]["dia"]=$_POST["dia"];
                    $_SESSION["accion"]["hora"]=$_POST["hora"];
                    $_SESSION["accion"]["profesor"]=$_POST["profesor"];
                    header("Location:index.php");
                    exit;
                }
                else
                {
                    $body="<h1>Examen2 PHP</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                    mysqli_close($conexion);
                    session_destroy();
                    die(error_page("Examen2 PHP",$body));
                }
           }
        }
        else
        {
            $body="<h1>Examen2 PHP</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Examen2 PHP",$body));
        }
    }

    if(isset($_POST["btnBorrarGrupo"]))
    {
        $consulta="delete from horario_lectivo where id_horario=".$_POST["btnBorrarGrupo"];
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            $_SESSION["accion"]["mensaje"]="Grupo borrado con éxito";
            $_SESSION["accion"]["dia"]=$_POST["dia"];
            $_SESSION["accion"]["hora"]=$_POST["hora"];
            $_SESSION["accion"]["profesor"]=$_POST["profesor"];
            header("Location:index.php");
            exit;
        }
        else
        {
            $body="<h1>Examen2 PHP</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Examen2 PHP",$body));
        }
    }
    
    if(isset($_POST["btnNuevoGrupo"]))
    {
        $consulta="insert into horario_lectivo (usuario,dia,hora,grupo,aula) values (".$_POST["profesor"].",".$_POST["dia"].",".$_POST["hora"].",".$_POST["grupo"].",".$_POST["aula"].")";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
            $_SESSION["accion"]["mensaje"]="Grupo insertado con éxito";
            $_SESSION["accion"]["dia"]=$_POST["dia"];
            $_SESSION["accion"]["hora"]=$_POST["hora"];
            $_SESSION["accion"]["profesor"]=$_POST["profesor"];
            header("Location:index.php");
            exit;
        }
        else
        {
            $body="<h1>Examen2 PHP</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Examen2 PHP",$body));
        }
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
    <script src="js/index.js"></script>
    <script src="js/modal.js"></script>
    <style>
        .centrar{text-align:center}
        table,th,td{border:1px solid black}
        th{background-color:#CCC}
        table{border-collapse:collapse; }
        #t1{width:80%;margin:0 auto;}
        #t2{width:40%;}
        .sin_boton{background:transparent;border:none;color:blue;text-decoration:underline;cursor:pointer}
        #form_anadir{display:flex;justify-content:center;width:40%;margin-top:2em;}
        #form_anadir div{padding:0 2em}
        .error_form{width:40%;text-align:center;color:red;margin-top:0.5em;}
        .oculta{display:none}
        .visible{display:block}
        .relleno{padding:0.5em}

        /*Css para modal*/
        .modalContainer{
    
    position: fixed; 
    z-index: 3;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.4);
}
.modalContainer .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding-bottom: 0.75em;
    border: 1px solid lightgray;
    width: 60%;
    position: relative;
    top:0;
    left:0;
    border-radius:0.7em;
    resize:both;
    overflow:auto;
    max-width:  100%;
}

.modalContainer .close {
    
    color: #000;
    float:right;
    font-size: 1.8em;
    font-weight: bold;
    padding-right:0.5em;
    
}
.modalContainer .cerrar_modal{
    
    cursor:move;
    overflow:auto;
    background-color:#58abb7;
    
}
.modalContainer .close:hover,
.modalContainer .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.movida{position:fixed;padding:10em 0;width:100%;overflow:hidden;}
    </style>
</head>
<body>
    <div id="tvesModalGeneral" class="modalContainer <?php if(!isset($_SESSION["accion"]["modal"])) echo "oculta";?>" onclick="if(event.target==this || event.target==document.getElementById('modal_move_general')){cerrar_modal_general();}">
        <div id="modal_move_general"  class="movida" onmousemove="ratonMovido(this,event);" >
            <div class="modal-content" >
                <div class="cerrar_modal" onmousedown="ratonPulsado(this.parentNode,event);" onmouseup="ratonSoltado(event);">
                    <span class="close" onclick="cerrar_modal_general();">×</span>
                </div>
                
                <div id="modal_contenido_general">
                    <?php 
                        if(isset($_SESSION["accion"]["modal"]))
                        {
                            echo $_SESSION["accion"]["modal"];
                        }
                    ?>
                </div>
                    
            </div>
        </div>
    </div>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <?php
        $consulta="select id_usuario, nombre from usuarios";
        $resultado=mysqli_query($conexion,$consulta);
        if($resultado)
        {
        ?>
            <form action="index.php" method="post">
                <p>
                    <label for="profesor">Seleccione el Profesor:</label>
                    <select name="profesor" id="profesor">
                    <?php
                        while($datos=mysqli_fetch_assoc($resultado))
                        {
                            if((isset($_POST["profesor"]) && $_POST["profesor"]==$datos["id_usuario"]) || (isset($_SESSION["accion"]["profesor"]) && $_SESSION["accion"]["profesor"]==$datos["id_usuario"]) )
                            {
                                echo "<option selected value='".$datos["id_usuario"]."'>".$datos["nombre"]."</option>";
                                $nombre=$datos["nombre"];
                            }
                            else
                                echo "<option value='".$datos["id_usuario"]."'>".$datos["nombre"]."</option>";
                        }
                        mysqli_free_result($resultado);
                        
                    ?>
                    </select>
                   <input type="submit" value="Ver Horario"/>
                </p>
            </form> 
        <?php
            if(isset($_POST["profesor"])|| isset($_SESSION["accion"]))
            {
                if(!isset($nombre))
                {
                    mysqli_close($conexion);
                    session_destroy();
                    die("<p>El Profesor seleccionado ya no se encuentra en la BD.</p></body></html>");
                }

                if(isset($_SESSION["accion"]))
                    $profesor=$_SESSION["accion"]["profesor"];
                else
                    $profesor=$_POST["profesor"];

                echo "<h3 class='centrar'>Horario del Profesor: <em>".$nombre."</em></h3>";
                $consulta="select horario_lectivo.dia, horario_lectivo.hora, grupos.nombre as nombre_grupo, aulas.nombre as nombre_aula from horario_lectivo, grupos,aulas where horario_lectivo.grupo=grupos.id_grupo and horario_lectivo.aula=aulas.id_aula and horario_lectivo.usuario=".$profesor;
                $resultado=mysqli_query($conexion,$consulta);
                if($resultado)
                {
                    while($datos=mysqli_fetch_assoc($resultado))
                    {
                        if(isset($horario[$datos["dia"]][$datos["hora"]]))
                        {
                            
                                $horario[$datos["dia"]][$datos["hora"]]["grupos"].="/".$datos["nombre_grupo"];
                                echo $horario[$datos["dia"]][$datos["hora"]]["grupos"];
                                if(!in_array($datos["nombre_aula"],$horario[$datos["dia"]][$datos["hora"]]["aulas"]) && $datos["nombre_aula"]!="Sin asignar o sin aula")
                                    $horario[$datos["dia"]][$datos["hora"]]["aulas"][]=$datos["nombre_aula"];
                        }          
                        else
                        {
                            $horario[$datos["dia"]][$datos["hora"]]["grupos"]=$datos["nombre_grupo"];
                            if($datos["nombre_aula"]!="Sin asignar o sin aula")
                                $horario[$datos["dia"]][$datos["hora"]]["aulas"][]=$datos["nombre_aula"];
                        }
                    }
                    mysqli_free_result($resultado);
                   
                    $horas[1]="8:15 - 9:15";
                    $horas[2]="9:15 - 10:15";
                    $horas[3]="10:15 - 11:15";
                    $horas[4]="11:15 - 11:45";
                    $horas[5]="11:45 - 12:45";
                    $horas[6]="12:45 - 13:45";
                    $horas[7]="13:45 - 14:45";

                    echo "<table id='t1' class='centrar'><tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";

                    for($i=1;$i<=7;$i++)
                    {
                        echo "<tr><th>".$horas[$i]."</th>";
                        if($i==4)
                                echo  "<td colspan='5'>RECREO</td>";
                        else
                            for($j=1;$j<=5;$j++)
                                if(isset($horario[$j][$i]))
                                {
                                    echo "<td>".$horario[$j][$i]["grupos"]."<br/>";
                                    
                                    if(isset($horario[$j][$i]["aulas"]))
                                    {
                                        $aulas=$horario[$j][$i]["aulas"][0];
                                        for($p=1;$p<count($horario[$j][$i]["aulas"]);$p++)
                                            $aulas.="/".$horario[$j][$i]["aulas"][$p];
                                        echo "(".$aulas.")";
                                    }
                                    echo "<form action='index.php' method='post'><input type='hidden' value='".$j."' name='dia'/><input type='hidden' value='".$i."' name='hora'/><input type='hidden' value='".$profesor."' name='profesor'/><input class='sin_boton' type='submit' name='btnEditar' value='Editar'/></form></td>";
                                }
                                else
                                    echo "<td><form action='index.php' method='post'><input type='hidden' value='".$j."' name='dia'/><input type='hidden' value='".$i."' name='hora'/><input type='hidden' value='".$profesor."' name='profesor'/><input class='sin_boton' type='submit' name='btnEditar' value='Editar'/></form></td>";
        
                        echo "</tr>";
                    }
                    echo "</table>";
                    if(isset($_POST["btnEditar"])|| isset($_SESSION["accion"]))
                    {

                        

                        if(isset($_SESSION["accion"]))
                        {   
                            $dia=$_SESSION["accion"]["dia"];
                            $hora=$_SESSION["accion"]["hora"];
                            echo "<h2>Editando la ".$hora."º hora (".$horas[$hora].") del ".$dias[$dia]."</h2>";
                            if(isset($_SESSION["accion"]["mensaje"]))
                                echo "<p>".$_SESSION["accion"]["mensaje"]."</p>";
                        }
                        else
                        {
                            $dia=$_POST["dia"];
                            $hora=$_POST["hora"];
                            echo "<h2>Editando la ".$hora."º hora (".$horas[$hora].") del ".$dias[$dia]."</h2>";
                        }
                        
                        $consulta="select horario_lectivo.id_horario,grupos.id_grupo,grupos.nombre as nombre_grupo,aulas.id_aula,aulas.nombre as nombre_aula from horario_lectivo, grupos,aulas where horario_lectivo.grupo=grupos.id_grupo and horario_lectivo.aula=aulas.id_aula and horario_lectivo.hora=".$hora." and horario_lectivo.dia=".$dia." and horario_lectivo.usuario=".$profesor;
                        $resultado=mysqli_query($conexion,$consulta);
                        if($resultado)
                        {
                            echo "<table class='centrar' id='t2'>";
                            echo "<tr><th>Grupo (Aula)</th><th>Acción</th></tr>";
                            while($datos=mysqli_fetch_assoc($resultado))
                            {
                                
                                echo "<tr><td>".$datos["nombre_grupo"]." (".$datos["nombre_aula"].")</td><td><form action='index.php' method='post'><button class='sin_boton' type='submit' name='btnBorrarGrupo' value='".$datos["id_horario"]."'>Quitar</button>";
                                echo '<input type="hidden" name="dia" value="'.$dia.'"/><input type="hidden" name="hora" value="'.$hora.'"/><input type="hidden" name="profesor" value="'.$profesor.'"/>';
                                echo "</form></td></tr>";
                                $id_grupo=$datos["id_grupo"];
                                $id_aula=$datos["id_aula"];
                                $nombre_aula=$datos["nombre_aula"];
                            }
                            echo "</table>";
                          
                            $clausula="";
                            $subconsulta="select grupos.id_grupo from horario_lectivo, grupos where horario_lectivo.grupo=grupos.id_grupo and horario_lectivo.hora=".$hora." and horario_lectivo.dia=".$dia." and horario_lectivo.usuario=".$profesor;
                            $sin_aula=false;
                            if(isset($id_grupo))
                            {
                                $aux=$id_grupo;
                                if(in_array($aux,GRUPOS_SIN_AULA))
                                {
                                    $sin_aula=true;
                                    
                                }
                                else
                                {
                                    for($i=0;$i<count(GRUPOS_SIN_AULA);$i++)
                                        $clausula.=" and id_grupo<>".GRUPOS_SIN_AULA[$i];
                                }  
                             
                            }
                            if($sin_aula)
                            {
                            ?>
                                <form id="form_anadir" action="index.php" method="post">
                                        <div>
                                            <label for="grupo">Grupo:</label>
                                            <select name="grupo" id="grupo" disabled>
                                           
                                            </select>
                                            
                                            
                                        </div>
                                        <div>
                                            <label for="aula">Aula:</label>
                                            <select name="aula" id="aula" disabled>
                                            
                                            </select>
                                            
                                            
                                        </div>
                                        <div>
                                            <input type="submit" name="btnNuevoGrupo" value="Añadir" disabled/>
                                        </div>

                                    </form>
                            <?php
                            }
                            else
                            {
                               
                                $consulta="select * from grupos where id_grupo NOT IN (".$subconsulta.")".$clausula;
                                
                                $resultado=mysqli_query($conexion,$consulta);
                                if($resultado)
                                {
                                    if(isset($nombre_aula))
                                    {
                                        ?>
                                            <form id="form_anadir" action="index.php" method="post">
                                                <div>
                                                    <label for="grupo">Grupo:</label>
                                                    <select name="grupo" id="grupo" >
                                                    <?php
                                                        while($datos=mysqli_fetch_assoc($resultado))
                                                        {
                                                            if(!isset($id_grupo) && $datos["id_grupo"]==GRUPOS_SIN_AULA[0])
                                                                echo "<option selected value='".$datos["id_grupo"]."'>".$datos["nombre"]."</option>";
                                                            else
                                                                echo "<option  value='".$datos["id_grupo"]."'>".$datos["nombre"]."</option>";
                                                        }
                                                    ?>
                                                    </select>
                                                    <input type="hidden" name="dia" value="<?php echo $dia;?>"/>
                                                    <input type="hidden" name="hora" value="<?php echo $hora;?>"/>
                                                    <input type="hidden" name="profesor" value="<?php echo $profesor;?>"/>
                                                    
                                                </div>
                                            
                                                <div>
                                                    <label for="aula">Aula:</label>
                                                    <select name="aula" id="aula">
                                                        <option value='<?php echo $id_aula;?>'><?php echo $nombre_aula;?></option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <input type="submit" name="btnNuevoGrupo" value="Añadir"/>
                                                </div>
    
                                            </form>
                                            
                                        <?php
                                            
                                    }
                                    else
                                    {
                                        $consulta="select DISTINCT aulas.id_aula,aulas.nombre from horario_lectivo, aulas where horario_lectivo.aula=aulas.id_aula and horario_lectivo.hora=".$hora." and horario_lectivo.dia=".$dia." and aulas.id_aula<>".AULA_VACIA." ORDER BY aulas.nombre";
                                        $aulas_ocupadas=mysqli_query($conexion,$consulta);
                                        if($aulas_ocupadas)
                                        {
                                            $consulta="select DISTINCT * from aulas where id_aula not in(select aulas.id_aula from horario_lectivo, aulas where horario_lectivo.aula=aulas.id_aula and horario_lectivo.hora=".$hora." and horario_lectivo.dia=".$dia." and aulas.id_aula<>".AULA_VACIA.") ORDER BY aulas.nombre";
                                            $aulas_libres=mysqli_query($conexion,$consulta);
                                            if($aulas_libres)
                                            {
                                            ?>
                                                <form id="form_anadir" action="index.php" method="post">
                                                    <div>
                                                        <label for="grupo">Grupo:</label>
                                                        <select name="grupo" id="grupo" onchange="comprobar_sin_aula(<?php echo json_encode(GRUPOS_SIN_AULA)?>,<?php echo AULA_VACIA;?>);">
                                                        <?php
                                                            $g_sin_aula="";
                                                            $g_con_aula="";
                                                            while($datos=mysqli_fetch_assoc($resultado))
                                                            {
                                                                if(in_array($datos["id_grupo"],GRUPOS_SIN_AULA))
                                                                    if((isset($_SESSION["accion"]["grupo"]) && ($_SESSION["accion"]["grupo"]==$datos["id_grupo"]) )||(isset($_POST["btnComprobarAula"]) && ($_POST["grupo"]==$datos["id_grupo"]) )|| (!isset($_SESSION["accion"]["grupo"]) && !isset($_POST["btnComprobarAula"])&&!isset($id_grupo) && $datos["id_grupo"]==GRUPOS_SIN_AULA[0]))
                                                                        $g_sin_aula.="<option selected value='".$datos["id_grupo"]."'>".$datos["nombre"]."</option>";
                                                                    else
                                                                        $g_sin_aula.="<option  value='".$datos["id_grupo"]."'>".$datos["nombre"]."</option>";
                                                                else
                                                                    if((isset($_SESSION["accion"]["grupo"]) && ($_SESSION["accion"]["grupo"]==$datos["id_grupo"]) )||(isset($_POST["btnComprobarAula"]) && ($_POST["grupo"]==$datos["id_grupo"]) )|| (!isset($_SESSION["accion"]["grupo"]) && !isset($_POST["btnComprobarAula"]) &&!isset($id_grupo) && $datos["id_grupo"]==GRUPOS_SIN_AULA[0]))
                                                                        $g_con_aula.="<option selected value='".$datos["id_grupo"]."'>".$datos["nombre"]."</option>";
                                                                    else
                                                                        $g_con_aula.="<option  value='".$datos["id_grupo"]."'>".$datos["nombre"]."</option>";
                                                            }
                                                            
                                                        ?>
                                                            <optgroup label="Con Aula">
                                                                <?php echo $g_con_aula;?>
                                                            </optgroup>
                                                            <optgroup label="Sin Aula">
                                                                <?php echo $g_sin_aula;?>
                                                            </optgroup>
                                                        </select>
                                                        <input type="hidden" name="dia" value="<?php echo $dia;?>"/>
                                                        <input type="hidden" name="hora" value="<?php echo $hora;?>"/>
                                                        <input type="hidden" name="profesor" value="<?php echo $profesor;?>"/>
                                                        
                                                    </div>
                                                
                                                    <div>
                                                        <label for="aula">Aula:</label>
                                                        <select name="aula" id="aula" onchange="comprobar_sin_aula(<?php echo json_encode(GRUPOS_SIN_AULA)?>,<?php echo AULA_VACIA;?>);">
                                                        <optgroup label="Libres">
                                                        <?php
                                                            $aulas_libres_confirmar="<div id='div_confirmar' class='oculta'><label for='select_confirmar'>Elija un nuevo aula:</label><select id='select_confirmar'>";
                                                            while($datos=mysqli_fetch_assoc($aulas_libres))
                                                                if((isset($_SESSION["accion"]["aula"]) && ($_SESSION["accion"]["aula"]==$datos["id_aula"]) )||(isset($_POST["btnComprobarAula"]) && ($_POST["aula"]==$datos["id_aula"]) )|| (!isset($_SESSION["accion"]["aula"]) && !isset($_POST["btnComprobarAula"]) && $datos["id_aula"]==AULA_VACIA))
                                                                    echo "<option selected value='".$datos["id_aula"]."'>".$datos["nombre"]."</option>";
                                                                else
                                                                {
                                                                    echo "<option value='".$datos["id_aula"]."'>".$datos["nombre"]."</option>";
                                                                    if($datos["id_aula"]!=AULA_VACIA)
                                                                        $aulas_libres_confirmar.="<option value='".$datos["id_aula"]."'>".$datos["nombre"]."</option>";
                                                                }
                                                                $aulas_libres_confirmar.="</select></div>";
                                                        ?>
                                                        </optgroup>
                                                        <optgroup label="Ocupadas">
                                                        <?php
                                                            while($datos=mysqli_fetch_assoc($aulas_ocupadas))
                                                                if((isset($_SESSION["accion"]["aula"]) && ($_SESSION["accion"]["aula"]==$datos["id_aula"]) )||(isset($_POST["btnComprobarAula"]) && ($_POST["aula"]==$datos["id_aula"]) )|| (!isset($_SESSION["accion"]["aula"]) && !isset($_POST["btnComprobarAula"]) && $datos["id_aula"]==AULA_VACIA))
                                                                    echo "<option selected value='".$datos["id_aula"]."'>".$datos["nombre"]."</option>";
                                                                else
                                                                    echo "<option value='".$datos["id_aula"]."'>".$datos["nombre"]."</option>";
                                                        ?>
                                                        </optgroup>
                                                        </select>
                                
                                                        <input type="hidden" name="dia" value="<?php echo $dia;?>"/>
                                                        <input type="hidden" name="hora" value="<?php echo $hora;?>"/>
                                                        <input type="hidden" name="profesor" value="<?php echo $profesor;?>"/>
                                                        <input type="hidden" id="grupo_cambio" name="grupo_cambio" value=""/>
                                                        <input type="hidden" id="aula_cambio" name="aula_cambio" value=""/>
                                                    </div>
                                                    <div>
                                                        <input class="oculta" type="submit" name="btnCambiarAula" id="btnCambiarAula" value="Cambiar Aula"/>
                                                        <input class="oculta" type="submit" name="btnComprobarAula" id="btnComprobarAula" value="Comprobar Aula"/>
                                                        <input type="submit" name="btnNuevoGrupo" value="Añadir" onclick="comprobar_anadir(<?php echo json_encode(GRUPOS_SIN_AULA)?>,<?php echo AULA_VACIA;?>);event.preventDefault();"/>
                                                    </div>
        
                                                </form>
                                                <div id="error_form_anadir" class="error_form"></div>
                                            <?php
                                                mysqli_free_result($aulas_libres);
                                            }
                                            else
                                            {
                                                $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
                                                mysqli_close($conexion);
                                                session_destroy();
                                                die($error);
                                            }
                                            mysqli_free_result($aulas_ocupadas);
                                        }
                                        else
                                        {
                                            $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
                                            mysqli_close($conexion);
                                            session_destroy();
                                            die($error);
                                        }
                                    }
                                    mysqli_free_result($resultado);
                                }
                                else
                                {
                                    $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
                                    mysqli_close($conexion);
                                    session_destroy();
                                    die($error);
                                }
                            }
                        }
                        else
                        {
                            $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
                            mysqli_close($conexion);
                            session_destroy();
                            die($error); 
                        }
                    }
                }
                else
                {
                    $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
                    mysqli_close($conexion);
                    session_destroy();
                    die($error);
                }
            }
            mysqli_close($conexion);
            session_destroy();
        }
        else
        {
            $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></body></html>";
            mysqli_close($conexion);
            session_destroy();
            die($error);
        }
        if(isset($_SESSION["accion"]))
            unset($_SESSION["accion"]);
        if(isset($aulas_libres_confirmar))   
            echo $aulas_libres_confirmar;
    ?>
    
</body>
</html>