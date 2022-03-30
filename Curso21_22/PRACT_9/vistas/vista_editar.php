<?php
 if (isset($_POST["btnEditar"])) {
    $idPeliculas = $_POST["btnEditar"];
    $consulta = "SELECT * FROM peliculas WHERE idPeliculas=" . $idPeliculas;
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        if ($datos = mysqli_fetch_assoc($resultado)) {
            $titulo = $datos["titulo"];
            $director = $datos["director"];
            $sinopsis = $datos["sinopsis"];
            $tematica = $datos["tematica"];
            $caratula = $datos["caratula"];
        } else {
            $error_concurrencia = "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
        }
        mysqli_free_result($resultado);
    } else {
        $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></div></body></html>";
        mysqli_close($conexion);
        die($error);
    }
} else {
    $idPeliculas = $_POST["idPeliculas"];
    $titulo = $_POST["titulo"];
    $director = $datos["director"];
    $sinopsis = $datos["sinopsis"];
    $tematica = $datos["tematica"];
    $caratula = $_POST["caratula_ant"];
}
if (isset($_POST["btnBorrarFoto"])) {
    echo "<divclass='centrar'> ";
    echo "<p>se dispone usted a borrar la carrtula con la IP= ".$idPeliculas."</p>";
    echo "<form action='index.php' method='post' enctype='multipart/form-data'>";
    ?>  
    <p>Cambiara esta caratula <img src="Img/<?php echo $caratula; ?>" alt="Caratula de la pelicula <?php echo $idPeliculas; ?>" title="Caratula de la pelicula <?php echo $idPeliculas; ?>" /> por esta otra <img src='Img/<?php echo IMAGEN_DEFECTO?>'></p>
    <?php
    echo "<input type='hidden' name='idPeliculas' value='".$idPeliculas."' />";
    echo "<input type='hidden' name='titulo' value='".$titulo."' />";
    echo "<input type='hidden' name='director' value='".$director."' />";
    echo "<input type='hidden' name='sinopsis' value='".$sinopsis."'/>";
    echo "<input type='hidden' name='tematica' value='".$tematica."' />";
    echo "<input type='hidden' name='caratula_ant' value='".$caratula."' />";
    echo "<input type='submit' name='btnContBorrarFoto' value='Continuar'/>&nbsp;&nbsp;";
    echo "<input type='submit' name='btnNoContBorrarFoto' value='Atrás'/>";
    echo "</form>";
    echo "</div>";
 } else{
echo "<h2>Editando el Usuario con Id " . $idPeliculas . "</h2>";
if (isset($error_concurrencia)) {
    echo $error_concurrencia;
    echo "<form action='index.php' method='post'><input type='submit' value='Volver'/></form>";
} else {
?>
    <form id="form_editar" action="index.php" method="post" enctype="multipart/form-data">
        
        <div>
            <p><label for="titulo">Titulo:</label><br />
                <input type="text" name="titulo" id="titulo" placeholder="Titulo" value="<?php echo $titulo; ?>" />
                <?php
                if (isset($_POST["btnContEditar"]) && $error_titulo) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p><label for="director">Director:</label><br />
                <input type="text" placeholder="Director" name="director" id="director" value="<?php echo $director; ?>" />
                <?php
                if (isset($_POST["btnContEditar"]) && $error_director) {

                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>

            <p><label for="sinopsis">Sinopsis</label><br />
                <textarea id="sinopsis" name="sinopsis"><?php echo $sinopsis; ?></textarea>
            </p>
            <?php
            if (isset($_POST["btnContEditar"]) && $error_sinopsis) {
                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
            <p><label for="tematica">Tematica:</label><br />
                <input type="text" placeholder="tematica" name="tematica" id="tematica" value="<?php echo $tematica; ?>" />
                <?php
                if (isset($_POST["btnContEditar"]) && $error_tematica) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
                <br><br>
                <label for="caratula">Incluir mi caratula (Archivo imagen Máx 500 KB): </label>
                <input type="file" name="caratula" accept="image/*" /><br />
                <?php
                if (isset($_POST["btnContEditar"]) && $error_foto) {
                    if ($_FILES["caratula"]["error"])
                        echo "<span class='error'>* Error en la subida del archivo al servidor *</span>";
                    elseif (!getimagesize($_FILES["caratula"]["tmp_name"]))
                        echo "<span class='error'>* Error: no has seleccionado un archivo imagen *</span>";
                    else
                        echo "<span class='error'>* Error: el tamaño del archico seleccionado supera los 500 KB *</span>";
                }

                ?>
            </p>

            <p>
                <input type="hidden" name="idPeliculas" value="<?php echo $idPeliculas; ?>" />
                <input type="hidden" name="caratula_ant" value="<?php echo $caratula; ?>" />
                <input type="submit" name="btnContEditar" value="Guardar Cambios" />
                <input type="submit" value="Atrás" />
            </p>
        </div>
        <div class="centrar">
            <img src="Img/<?php echo $caratula; ?>" alt="Caratula de la pelicula <?php echo $idPeliculas; ?>" title="Caratula de la pelicula <?php echo $idPeliculas; ?>" /><br />
            <?php
            if($caratula!=IMAGEN_DEFECTO)
            echo "<input type='submit' name='btnBorrarFoto' value='Borrar'/>";
            ?>
        </div>
    </form>
<?php
}

}
?>