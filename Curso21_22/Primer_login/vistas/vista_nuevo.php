<h2>Agregar Nuevo Usuario </h2>
		<form action="index.php" method="post" enctype="multipart/form-data">
			<p><label for="nombre">Nombre:</label><br/>
			<input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"]; ?>"/>
			<?php
			if(isset($_POST["btnContNuevo"])&& $error_nombre)
			{
				echo "<span class='error'>* Campo vacío *</span>";
			}	
			?>
			</p>
			<p><label for="usuario">Usuario:</label><br/>
			<input type="text" placeholder="Usuario" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>"/>
			<?php
			if(isset($_POST["btnContNuevo"])&& $error_usuario)
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
			<?php
			if(isset($_POST["btnContNuevo"])&& $error_clave)
			{
                echo "<span class='error'>* Campo vacío *</span>";
			}	
			?>
			</p>
			<p><label for="dni">DNI:</label><br/>
			<input type="text" placeholder="DNI: 11223344Z" name="dni" id="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"]; ?>"/>
			<?php
			if(isset($_POST["btnContNuevo"])&& $error_dni)
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
			if(isset($_POST["btnContNuevo"])&& $error_sexo)
			{
				echo "<span class='error'>* Debes de elegir un sexo *</span>";
			}	
			?>
			</p>
			<p><input type="radio" name="sexo" id="hombre" value="hombre" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="hombre") echo "checked";?>/>
			<label for="hombre">Hombre</label><br/>
			<input type="radio" name="sexo" id="mujer"  value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?>/>
			<label for="mujer">Mujer</label><br/><br/>
			<label for="foto">Incluir mi foto (Archivo imagen Máx 500 KB): </label>
			<input type="file" name="foto" accept="image/*"/><br/>
			<?php
				if(isset($_POST["btnContNuevo"])&& $error_foto)
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
			<input type="submit" name="btnContNuevo" value="Guardar Cambios"/>
			<input type="submit" value="Atrás"/>
			</p>
		</form>