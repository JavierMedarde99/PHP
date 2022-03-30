<form action="index.php" method="post">
            <p>Se dispone usted a borrar la pelicula con id <?php echo $_POST["btnBorrar"]; ?></p>
            <p><input type="hidden" name="caratula" value="<?php echo $_POST["caratula"]; ?>" /><button type="submit" name="btnContBorrar" value="<?php echo $_POST["btnBorrar"]; ?>">Continuar</button>
                <input type="submit" value="Atrás" />
        </form>