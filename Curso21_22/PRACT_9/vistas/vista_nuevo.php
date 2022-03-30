<h2>Agregar Nueva Pelicula </h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <p><label for="titulo">Titulo:</label><br />
                <input type="text" name="titulo" id="titulo" placeholder="titulo" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"]; ?>" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_titulo) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p><label for="director">Director:</label><br />
                <input type="text" placeholder="director" name="director" id="director" value="<?php if (isset($_POST["director"])) echo $_POST["director"]; ?>" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_director) {

                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p><label for="sinopsis">Sinopsis</label><br />
                <textarea id="sinopsis" name="sinopsis"><?php if (isset($_POST["sinopsis"])) echo $_POST["sinopsis"]; ?></textarea>
            </p>
            <?php
            if (isset($_POST["btnContNuevo"]) && $error_sinopsis) {
                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
            <p><label for="tematica">Tematica:</label><br />
                <input type="text" placeholder="tematica" name="tematica" id="tematica" value="<?php if (isset($_POST["tematica"])) echo $_POST["tematica"]; ?>" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_tematica) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
                <br /> <br />
                <label for="caratula">Incluir mi foto (Archivo imagen Máx 500 KB): </label>
                <input type="file" name="caratula" accept="image/*" /><br />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_caratula) {
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
                <input type="submit" name="btnContNuevo" value="Guardar Cambios" />
                <input type="submit" value="Atrás" />
            </p>
        </form>