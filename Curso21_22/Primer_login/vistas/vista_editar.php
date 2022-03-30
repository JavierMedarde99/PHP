<?php
if(isset($_POST["btnEditar"]))
        {
            $id_usuario=$_POST["btnEditar"];
            $consulta="select * from usuarios where id_usuario=".$id_usuario;
            $resultado=mysqli_query($conexion,$consulta);
            if($resultado)
            {
                if($datos=mysqli_fetch_assoc($resultado))
                {
                    $nombre=$datos["nombre"];
                    $usuario=$datos["usuario"];
                    $dni=$datos["dni"];
                    $sexo=$datos["sexo"];
                    $foto=$datos["foto"];
                }
                else
                {
                    $error_concurrencia="<p>El usuario seleccionado ya no se encuentra en la BD</p>";
                }
                mysqli_free_result($resultado);
            }
            else
            {
                $error="<p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p></div></body></html>";
                mysqli_close($conexion);
                die($error);
            }
        }
        else
        {
            $id_usuario= $_POST["id_usuario"];   
            $nombre=$_POST["nombre"];
            $usuario=$_POST["usuario"];
            $dni=$_POST["dni"];
            $sexo=$_POST["sexo"];
            $foto=$_POST["foto_ant"];
        }

        echo "<h2>Editando el Usuario con Id ".$id_usuario."</h2>";
        if(isset($error_concurrencia))
        {
            echo $error_concurrencia;
            echo "<form action='index.php' method='post'><input type='submit' value='Volver'/></form>";
        }
        else 
        {
        ?>
            <form id="form_editar" action="index.php" method="post" enctype="multipart/form-data">
            <div>
                <p><label for="nombre">Nombre:</label><br/>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>"/>
                <?php
                if(isset($_POST["btnContEditar"])&& $error_nombre)
                {
                    echo "<span class='error'>* Campo vacío *</span>";
                }	
                ?>
                </p>
                <p><label for="usuario">Usuario:</label><br/>
                <input type="text" placeholder="Usuario" name="usuario" id="usuario" value="<?php  echo $usuario; ?>"/>
                <?php
                if(isset($_POST["btnContEditar"])&& $error_usuario)
                {
                    if($_POST["usuario"]=="")
                        echo "<span class='error'>* Campo vacío *</span>";
                    else
                        echo "<span class='error'>* Usuario repetido *</span>";
                }	
                ?>
                </p>
                <p><label for="clave">Contraseña:</label><br/>
                <input type="password" name="clave" id="clave" placeholder="Contraseña"/>
            
                </p>
                <p><label for="dni">DNI:</label><br/>
                <input type="text" placeholder="DNI: 11223344Z" name="dni" id="dni" value="<?php echo $dni; ?>"/>
                <?php
                if(isset($_POST["btnContEditar"])&& $error_dni)
                {
                    if($_POST["dni"]=="")
                        echo "<span class='error'>* Campo vacío *</span>";
                    elseif(!dni_bien_escrito($_POST["dni"]))
                        echo "<span class='error'>* Debes rellenar un DNI con ocho dígitos seguidos de una letra *</span>";
                    elseif(!dni_valido($_POST["dni"]))
                        echo "<span class='error'>* DNI no válido *</span>";
                    else
                        echo "<span class='error'>* DNI repetido *</span>";
                }	
                ?>
                </p>
                <p><label>Sexo:</label>
                <?php
                if(isset($_POST["btnContEditar"])&& $error_sexo)
                {
                    echo "<span class='error'>* Debes de elegir un sexo *</span>";
                }	
                ?>
                </p>
                <p><input type="radio" name="sexo" id="hombre" value="hombre" <?php if($sexo=="hombre") echo "checked";?>/>
                <label for="hombre">Hombre</label><br/>
                <input type="radio" name="sexo" id="mujer"  value="mujer" <?php if($sexo=="mujer") echo "checked";?>/>
                <label for="mujer">Mujer</label><br/><br/>
                <label for="foto">Incluir mi foto (Archivo imagen Máx 500 KB): </label>
                <input type="file" name="foto" accept="image/*"/><br/>
                <?php
                    if(isset($_POST["btnContEditar"])&& $error_foto)
                    {
                        if($_FILES["foto"]["error"])
                            echo "<span class='error'>* Error en la subida del archivo al servidor *</span>";
                        elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
                            echo "<span class='error'>* Error: no has seleccionado un archivo imagen *</span>";
                        else
                            echo "<span class='error'>* Error: el tamaño del archico seleccionado supera los 500 KB *</span>";
                    }
                
                ?>
                </p>
                
                <p>
                <input type="hidden" name="id_usuario" value="<?php echo $id_usuario;?>"/>
                <input type="hidden" name="foto_ant" value="<?php echo $foto;?>"/>
                <input type="submit" name="btnContEditar" value="Guardar Cambios"/>
                <input type="submit" value="Atrás"/>
                </p>
                </div>
                <div class="centrar">
                    <img src="Img/<?php echo $foto;?>" alt="Imagen del usuario <?php echo $id_usuario;?>" title="Imagen del usuario <?php echo $id_usuario;?>"/><br/>
                    <?php
                        
                        if(isset($_POST["btnBorrarFoto"]))
                        {
                            echo "<p>¿Estás seguro que desea borrar la foto?</p>";
                            echo "<input type='submit' name='btnContBorrarFoto' value='Continuar'/>&nbsp;&nbsp;";
                            echo "<input type='submit' name='btnNoContBorrarFoto' value='Atrás'/>";
                        }
                        elseif($foto!=IMAGEN_DEFECTO)
                            echo "<input type='submit' name='btnBorrarFoto' value='Borrar'/>";
                    ?>
                </div>
            </form>
        <?php
        }
        ?>