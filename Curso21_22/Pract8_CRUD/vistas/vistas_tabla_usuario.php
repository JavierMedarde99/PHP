<?php
echo "<h3>Listado de los usuarios</h3>";
?>
<form id='form_reg_bus' name='form_reg_bus' action='index.php' method='post'>
    <div>
        <label for='registros'>Registros a mostrar</label>
        <select name='registros' id='registros' onchange='document.form_reg_bus.submit();'>
            <option <?php if ($_SESSION["registros"] == 3) echo "selected"; ?> value="3">3</option>
            <option <?php if ($_SESSION["registros"] == 6) echo "selected"; ?> value="6">6</option>
            <option <?php if ($_SESSION["registros"] == -1) echo "selected"; ?> value="-1">TODOS</option>
        </select>
    </div>
    <div>
        <input type="text" name="buscar" value="<?php echo $_SESSION["buscar"]; ?>">
        <input type="submit" value="Buscar" />
    </div>
</form>
<?php
$inicio = ($_SESSION["pagina"] - 1) * $_SESSION["registros"];
if ($_SESSION["registros"] > 0)
    if ($_SESSION["buscar"] == "")
        $consulta = "select * from usuarios limit " . $inicio . "," . $_SESSION["registros"];
    else
        $consulta = "select * from usuarios where nombre LIKE '%" . $_SESSION["buscar"] . "%' limit " . $inicio . "," . $_SESSION["registros"];
else
    if ($_SESSION["buscar"] == "")
    $consulta = "select * from usuarios";
else
    $consulta = "select * from usuarios where nombre LIKE '%" . $_SESSION["buscar"] . "%'";


$resultado = mysqli_query($conexion, $consulta);
if ($resultado) {
    echo '<table class="centrar"><tr>
        <th>#</th>
        <th>Foto</th>
            <th>Nombre</th>
            <th><form action="index.php" method="post"><input class="sin_boton" type="submit" name="btnNuevo" value="Usuario+"/></form></th>
            </tr>';
    while ($datos = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $datos["id_usuario"] . "</td>";
        echo "<td><img src='Img/" . $datos["foto"] . "' alt='Foto usuario " . $datos["id_usuario"] . "' title='Foto usuario " . $datos["id_usuario"] . "'/></td>";
        echo "<td><form method='post' action='index.php'><button class='sin_boton' name='btnListar' value='" . $datos["id_usuario"] . "'>" . $datos["nombre"] . "</button></form></td>";
        echo "<td><form class='enlinea' action='index.php' method='post'><button class='sin_boton' name='btnBorrar' value='" . $datos["id_usuario"] . "'>Borrar</button><input type='hidden' name='foto' value='" . $datos["foto"] . "'/></form> - <form class='enlinea' action='index.php' method='post'><button class='sin_boton' name='btnEditar' value='" . $datos["id_usuario"] . "'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    if ($_SESSION["buscar"] == "")
        $consulta = "select * from usuarios";
    else
        $consulta = "select * from usuarios where nombre LIKE '%" . $_SESSION["buscar"] . "%'";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        $total_registros = mysqli_num_rows($resultado);
        mysqli_free_result($resultado);
        $paginas = ceil($total_registros / $_SESSION["registros"]);
        if ($paginas > 1) {
            echo "<form id='form_pags' action='index.php' method='post'>";
            if ($_SESSION["pagina"] > 1) {
                echo "<button type='submit' name='pagina' value='1'>|<</button>";
                echo "<button type='submit' name='pagina' value='" . ($_SESSION["pagina"] - 1) . "'><</button>";
            }
            for ($i = 1; $i <= $paginas; $i++) {
                if ($_SESSION["pagina"] == $i)
                    echo "<button disabled type='submit' name='pagina' value='" . $i . "'>" . $i . "</button>";
                else
                    echo "<button type='submit' name='pagina' value='" . $i . "'>" . $i . "</button>";
            }
            if ($_SESSION["pagina"] < $paginas) {
                echo "<button type='submit' name='pagina' value='" . ($_SESSION["pagina"] + 1) . "'>></button>";
                echo "<button type='submit' name='pagina' value='" . $paginas . "'>>|</button>";
            }

            echo "</form>";
        }
    } else {
        $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></body></html>";
        session_destroy();
        mysqli_close($conexion);
        die($error);
    }
    mysqli_close($conexion);
} else {
    $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></body></html>";
    mysqli_close($conexion);
    die($error);
}

if(isset($_SESSION["accion"]))
{
        echo "<p class='mensaje'>".$_SESSION["accion"]."</p>";
        unset($_SESSION["accion"]);
}