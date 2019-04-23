<? include("seguridad.php"); ?>
<?php

   //funcion valida formato correcto de hora
   public function validateTime($time)
   {
      $pattern="/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])$/";
      if(preg_match($pattern,$time)){
         return true;
      }
      else �{
  	 return false;
      }
   }

 if(isset($_POST['guardar'])) {
	  $diasSemana = "";
	  $diasSemanaApagado = "";

	  if (isset($_POST['horaEncendido'])){
			if (validateTime($_POST['horaEncendido']) == 1){
				$HoraEncendido = $_POST['horaEncendido'];
			}
			else {
				echo "<script>alert('Formato de hora no valido...'); window.location.href=\"radio.php\"</script>";
			}
	  }
	  else {
			die("<script>alert(\'Debe indicar una hora de encendido...\');</script>");
	  }

	  if (isset($_POST['horaApagado'])){
			$HoraApagado = $_POST['horaApagado'];
	  }
	  else {
			//$HoraApagado = "";
			die("<script>alert(\'Debe indicar una hora de apagado...\');</script>");
	  }

	  if (isset($_POST['radio'])){
			$Radio = $_POST['radio'];
	  }
	  else {
			//$Radio = "";
			die("<script>alert(\'Debe indicar una radio...\');</script>");
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
		//$semana = "";
		exit("<script>alert(\"Debe indicar dias de encendido...\");</script>");
	  }
	  if (isset($_POST['formSemanaApagado'])){
		$semanaApagado = $_POST['formSemanaApagado'];
		$cantidadDias = count($semanaApagado);
		// Para saber si viene vacio o lleno
		if(empty($semanaApagado) or $cantidadDias == 7) {
			$diasSemanaApagado = "*";
		}
		else {
		// Concateno valores en una linea
			for($i=0; $i < $cantidadDias; $i++) {
				$diasSemanaApagado = implode($_POST['formSemanaApagado'], ",");
			}
		}
	  }
	  else {
		//$semanaApagado = "";
		exit("<script>alert(\'Debe indicar dias de apagado...\');</script>");
	  }
	  if (isset($_POST['nombreAlarma'])){
			$NombreAlarma = $_POST['nombreAlarma'];
	  }
	  else {
			//$NombreAlarma = "";
			exit("<script>alert(\'Debe indicar una Nombre de Alarma...\');</script>");
	  }
	//Creamos el archivo cron-file.txt
	//ponemos tipo 'a' para añadir lineas sin borrar
	$file=fopen("cron-file.txt","a") or die("<script>alert(\"Problemas con el archivo cron...\");</script>");

	// Obtengo los formatos necesarios para cron
	$minutoInicio = substr($HoraEncendido, 3, 4);
	$horaInicio = substr($HoraEncendido, 0, 2);

	$minutoTermino = substr($HoraApagado, 3, 4);
	$horaTermino = substr($HoraApagado, 0, 2);

	//vamos añadiendo el contenido linea por linea
	fputs($file, $minutoInicio . " " . $horaInicio . " * * " . $diasSemana . " python /home/pi/radio.py ". $Radio. " # ".$NombreAlarma);
	fputs($file,"\n");
	fputs($file, $minutoTermino." ". $horaTermino . " * * " . $diasSemanaApagado ." sudo echo 'quit' > ~/.mplayer/fifo # ".$NombreAlarma);
	fputs($file,"\n"); // este salto de linea siempre debe quedar en el archivo, para que se agreguen otros
	fclose($file);
?>
<?php
	exec('sudo fromdos -a cron-file.txt 2>&1', $salida);
        exec('sudo crontab /var/www/cron-file.txt 2>&1', $output);
	echo "<script>alert('Alarma guardada correctamente.'); window.location.href=\"radio.php\"</script>";
	//header('Location: radio.php');
?>
<?php
 }
?>
