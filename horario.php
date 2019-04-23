<? include("seguridad.php"); ?>
<?php
 if(isset($_POST['enviar']))
 {
  require_once('conexion.php');
  // Funcion que devuelve verdadero si encuentra un nombre de horario que ya existe en la base de datos
  function Existe($conn, $nombreHorario)
  {
	// Consulto cuantos nombres de horarios hay en la tabla
	$sqlSelectId = "SELECT count(*) as existe FROM horarios WHERE NombreHorario = '".$nombreHorario."'"; 
	$result = mysqli_fetch_assoc($conn->query($sqlSelectId));
	$existe = $result['existe'];
	if ($existe == 1)
		return TRUE; 
	else
		return FALSE;
  }
		
  $diasSemana = "";
  $diasSemanaTermino = "";
  $sqlDiasInicio = "";

  if (isset($_POST['nombreHorario'])){
	 $nombreHorario = $_POST['nombreHorario'];
	 if (Existe($conn, $nombreHorario)) {
		die("<script>alert('Nombre de horario ya existe en la agenda...');
	        window.location.href=\"horario.php\"</script>");
		exit();
	 }
  } 
  else {
	 $nombreHorario = "";
  }

  if (isset($_POST['horaInicio'])){
	 $horaInicio = $_POST['horaInicio'];
  } 
  else {
	 $horaInicio = "";
  }

  if (isset($_POST['horaTermino'])){
	 $horaTermino = $_POST['horaTermino'];
  } 
  else {
	 $horaTermino = "";
  }

  if (isset($_POST['formSemana'])){
	 $semana = $_POST['formSemana'];
  	 $N = count($semana);
	 // Para saber si viene vacio o lleno
  	 if(empty($semana) or $N == 7) {
	 	$diasSemana = "*";
  	 } 
  	 else {
		// Concateno valores en una linea
    		for($i=0; $i < $N; $i++) {
			$diasSemana = implode($_POST['formSemana'], ",");
    	 	}
	 }
  } 
  else {
	 $semana = "";
  }

  if (isset($_POST['formSemanaTermino'])){
	 $semanaTermino = $_POST['formSemanaTermino'];
         $NT = count($semanaTermino);
  
  	 if(empty($semanaTermino) or $NT == 7) {
		$diasSemanaTermino = "*";
  	 } 
  	 else {
		for($i=0; $i < $NT; $i++) {
			$diasSemanaTermino = implode($_POST['formSemanaTermino'], ",");
        }
	 }
  } 
  else {
	 $semanaTermino = "";
  }

	//Creamos el archivo cron-file.txt
	//ponemos tipo 'a' para añadir lineas sin borrar
	$file=fopen("cron-file.txt","a") or die("Problemas");

	$horaMinutosInicio = $horaInicio;
	$horaMinutosTermino = $horaTermino;
	
	$minutoInicioCron = substr($horaMinutosInicio, 3, 4); 
	$horaInicioCron = substr($horaMinutosInicio, 0, 2); 
	
	$minutoTerminoCron = substr($horaMinutosTermino, 3, 4); 
	$horaTerminoCron = substr($horaMinutosTermino, 0, 2); 
	
	//vamos añadiendo el contenido
	fputs($file, $minutoInicioCron . " " . $horaInicioCron . " * * " . $diasSemana . " sudo python /home/pi/encender_luz.py # ".$nombreHorario);
	fputs($file,"\n");
	fputs($file, $minutoTerminoCron." ". $horaTerminoCron . " * * " . $diasSemanaTermino ." sudo python /home/pi/apagar_luz.py # ".$nombreHorario);
	fputs($file,"\n");
	fclose($file);
  ?>
<?php
	exec('sudo fromdos -a cron-file.txt 2>&1', $salida);
	exec('sudo crontab /var/www/cron-file.txt 2>&1', $output); 
?>
<?php
	$semanaCompleta = array('Domingo','Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');

	// Inserto horario	
	$sqlHorarios = "INSERT INTO horarios (NombreHorario, HoraInicio, HoraTermino) VALUES ('".$nombreHorario."', '". $horaMinutosInicio ."', '". $horaMinutosTermino ."')";
	$sqlHorarios = $conn->query($sqlHorarios);

	// Consulto id de horario
	$sqlSelectId = "SELECT IdHorario FROM horarios WHERE NombreHorario = '".$nombreHorario."'"; 
	$resultId = mysqli_fetch_assoc($conn->query($sqlSelectId));
	$idHorario = $resultId['IdHorario'];

	// Guardo dias de inicio
  if(is_array($semana))
  {
       	// Guardo solo los marcados
       	while(list($key,$diaCheckInicio) = each($_POST['formSemana'])) 
        {
          $indiceInicio = (int) $diaCheckInicio;
          $sqlDiasInicio="INSERT INTO DiasInicio (idNombre, diaInicio) VALUES ('".$idHorario."', '".$semanaCompleta[$indiceInicio]."')";
          $sqlDiasInicio = $conn->query($sqlDiasInicio);
       	}
  }

	// Guardo dias de termino
	if(is_array($semanaTermino))
    {
       		// Guardo solo los marcados
     	 while(list($key,$diaCheckTermino) = each($_POST['formSemanaTermino'])) 
         {
		  $indiceTermino = (int)$diaCheckTermino;
		  $sqlDiasTermino = "INSERT INTO DiasTermino (idNombreTermino, diaTermino ) VALUES ('" . $idHorario . "', '". $semanaCompleta[$indiceTermino] ."' )";
		  $sqlDiasTermino = $conn->query($sqlDiasTermino);
       	 }
   	}

	if ( $sqlHorarios == TRUE and $resultId == TRUE and $idHorario == TRUE and $sqlDiasInicio == TRUE and $sqlDiasTermino == TRUE) {
    		echo "<script>alert('Horario guardado correctamente.'); window.location.href=\"historial.php\"</script>";
	} 
	else {
    		echo $conn->error;
	}

 $conn->close();
 }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Horario</title>

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
                                <li class="orange">
                                        <a href="#" class="icon-time"></a>
                                        <ul>
                                                <li><a href="timer.php">Timer</a></li>
                                        </ul>
                                </li>
				<li class="blue">
					<a href="#" class="icon-calendar"></a>
					<ul>
						<li><a href="horario.php">Horarios</a></li>
					</ul>
				</li>
				<li class="sky">
					<a href="#" class="icon-calendar"></a>
					<ul>
						<li><a href="horario_especifico.php">Horario Especifico</a></li>
					</ul>
				</li>
				<li class="yellow">
					<a href="#" class="icon-table"></a>
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
<br><br><br><p class="pe">Horario Semanal</p>
<hr>
<br>
	<p class="pa">
		<?php
   			$hoy = date("d-m-Y");
   			$hora = date ("H:i");
   			print_r("Fecha: ". $hoy . " | Hora: " . $hora);
		?>
	</p>
<br>
<hr>
<br>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

 Ingrese nombre del programa: <input type="text" name="nombreHorario" placeholder="Nombre del horario" required/> <br>
<br>
<hr>
<br>
 Hora de encendido: <input type="time" name="horaInicio" placeholder="00:00" required/> <br>
<br>
<p>Seleccione dias de encendido:</p>
<table class="semana">
<tr>
<td><input type="checkbox" name="formSemana[]" value="1" /></td>
<td><input type="checkbox" name="formSemana[]" value="2" /></td>
<td><input type="checkbox" name="formSemana[]" value="3" /></td>
<td><input type="checkbox" name="formSemana[]" value="4" /></td>
<td><input type="checkbox" name="formSemana[]" value="5" /></td>
<td><input type="checkbox" name="formSemana[]" value="6" /></td>
<td><input type="checkbox" name="formSemana[]" value="7" /></td>
</tr>
<tr>
<td>Lunes </td>
<td>Martes </td>
<td>Miercoles </td>
<td>Jueves </td>
<td>Viernes </td>
<td>Sabado </td>
<td>Domingo </td>
</tr>
</table>
<br>
<hr>
<br>
 Hora de apagado: <input type="time" name="horaTermino" placeholder="00:00" required /><br>
<br>
<p>Seleccione dias de apagado:</p>
<table class="semana">
<tr>
<td><input type="checkbox" name="formSemanaTermino[]" value="1" /></td>
<td><input type="checkbox" name="formSemanaTermino[]" value="2" /></td>
<td><input type="checkbox" name="formSemanaTermino[]" value="3" /></td>
<td><input type="checkbox" name="formSemanaTermino[]" value="4" /></td>
<td><input type="checkbox" name="formSemanaTermino[]" value="5" /></td>
<td><input type="checkbox" name="formSemanaTermino[]" value="6" /></td>
<td><input type="checkbox" name="formSemanaTermino[]" value="7" /></td>
</tr>
<tr>
<td>Lunes</td>
<td>Martes</td>
<td>Miercoles</td>
<td>Jueves</td>
<td>Viernes</td>
<td>Sabado</td>
<td>Domingo</td>
</tr>
</table>
<br>
<hr>
<br>
<input type="submit" name="enviar" value=" Enviar ">
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
