<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Control de Luz</title>

        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="assets/css/styles.css" />

		<!-- Font Awesome Stylesheet -->
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css" />

		<!-- Including Open Sans Condensed from Google Fonts -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700,300italic" />

        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    
    <body>

    	<nav id="colorNav">
			<ul>
				<li class="green">
					<a href="#" class="icon-home"></a>
					<ul>
						<li><a href="inicio.php">Inicio</a></li>
						
					</ul>
				</li>
				<li class="red">
					<a href="#" class="icon-star"></a>
					<ul>
						<li><a href="switch.php">Switch</a></li>
					</ul>
				</li>
				<li class="blue">
					<a href="#" class="icon-calendar"></a>
					<ul>
						<li><a href="horario.php">Horario Semanal</a></li>
					</ul>
				</li>
				<li class="sky">
					<a href="#" class="icon-calendar"></a>
					<ul>
						<li><a href="#">Horario Especifico</a></li>
					</ul>
				</li>
				<li class="yellow">
					<a href="#" class="icon-music"></a>
					<ul>
						<li><a href="historial.php">Historial</a></li>

					</ul>
				</li>
				<li class="purple">
					<a href="#" class="icon-signout"></a>
					<ul>
						<li><a href="salir.php">Salir</a></li>
					</ul>
				</li>
			</ul>
		</nav>
<br><br><br>
 <form ACTION="procesar_radio.php" METHOD="post" NAME="radio">
 <p class="pe">Alarma con Radio</p>
<hr>
<br>
<table class="semana">	 
     <tr>
		<td class="a1"><p class="po">Hora de Encendido: </p></td>
		<td class="a1"><input type='time' name='horaEncendido' value='' required/></td>
     </tr>	
	 
	 <tr>	
		<td class="a1"><p class="po">Dias Encendido: </p></td>
		<td>
			<input type="checkbox" name="formSemana[]" value="1" title="Lunes"/><b>L</b>
			<input type="checkbox" name="formSemana[]" value="2" title="Martes"/><b>M</b>
			<input type="checkbox" name="formSemana[]" value="3" title="Miercoles"/><b>X</b>
			<input type="checkbox" name="formSemana[]" value="4" title="Jueves"/><b>J</b>
			<input type="checkbox" name="formSemana[]" value="5" title="Viernes"/><b>V</b>
			<input type="checkbox" name="formSemana[]" value="6" title="Sabado"/><b>S</b>
			<input type="checkbox" name="formSemana[]" value="7" title="Domingo"/><b class="domingo">D</b>
		</td>
	 </tr>
	 
	 <tr>	
		<td class="a1"><p class="po">Hora de Apagado: </p></td>
		<td class="a1"><input type='time' name='horaApagado' value='' required/></td>
	 </tr>
	 
	 <tr>	
		<td class="a1"><p class="po">Dias Apagado: </p></td>
		<td>
			<input type="checkbox" name="formSemanaApagado[]" value="1" title="Lunes"/><b>L</b>
			<input type="checkbox" name="formSemanaApagado[]" value="2" title="Martes"/><b>M</b>
			<input type="checkbox" name="formSemanaApagado[]" value="3" title="Miercoles"/><b>X</b>
			<input type="checkbox" name="formSemanaApagado[]" value="4" title="Jueves"/><b>J</b>
			<input type="checkbox" name="formSemanaApagado[]" value="5" title="Viernes"/><b>V</b>
			<input type="checkbox" name="formSemanaApagado[]" value="6" title="Sabado"/><b>S</b>
			<input type="checkbox" name="formSemanaApagado[]" value="7" title="Domingo"/><b class="domingo">D</b>
		</td>
	 </tr>
	
	 <tr>
		<td class="a1"><p class="po">Radio: </p></td>
		<td class="a1">
			<select name="radio">
				<option value="seleccione" disabled selected>Seleccionar...</option>
				<option value="Activa">Activa</option>
				<option value="Adn">Adn</option>
				<option value="Agricultura">Agricultura</option>
				<option value="Caramelo">Caramelo</option>
				<option value="Carolina">Carolina</option>
				<option value="Cooperativa">Cooperativa</option>
				<option value="Corazon">Corazón</option>
				<option value="Futuro">Futuro</option>
				<option value="LaClave">La Clave</option>
				<option value="Rockaxis">Rockaxis</option>
			</select>
		</td>
	 </tr>
	 <tr>
		<td class="a1"><p class="po">Nombre Alarma: </p></td>
		<td class="a1"><input type='text' name='nombreAlarma' placeholder="Radio..." required/></td>
	 </tr>

	</table>
	<br>
	<hr>
	<br>
		<input type="submit" id="boton" name="guardar" value=" Guardar ">
	<br>
	<br>
	<br>
	<br>
	<br>
</form>
        <footer>
	        <h2><i>Sofogal&copy;</i> Todos los derechos reservados, 2015.</h2>
            <a class="tzine" href="http://www.sofogal.cl" target="_blank"><i>Desarrollado por: </i><b>Sofogal.cl</b></a>
        </footer>   
    </body>
</html>
