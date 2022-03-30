<form action="index.php" method="post">
        <p>Se dispone usted a borrar al usuario con id <?php echo $_POST["btnBorrar"];?></p>
        <p><input type="hidden" name="foto" value="<?php echo $_POST["foto"];?>"/><button type="submit" name="btnContBorrar" value="<?php echo $_POST["btnBorrar"];?>">Continuar</button>
        <input type="submit" value="Atrás"/>
        </form>