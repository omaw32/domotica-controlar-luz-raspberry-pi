<?php

    if (isset($_GET['id'])) {
       	$id = $_GET['id'];
    }

    require_once('conexion.php');
    // Consulta a la base de datos para obtener el nombre del Horario para eliminarlo del archivo cron
	$sql = "SELECT nombreHorario FROM horarios WHERE IdHorario = '".$id."'"; 
	$resultado = mysqli_fetch_assoc($conn->query($sql));
	$nombreHorario = $resultado['nombreHorario']; 	

	// Eliminar Horario de archivo cron
	$lineas = file("cron-file.txt");
	$palabra= $nombreHorario; // parametro identificador de lineas a eliminar    
	$aux = array();

    // Recorro linea por linea
    foreach($lineas as $linea){
    
		if (strstr($linea,$palabra) == FALSE){ // si no encuentra la palabra, agrega la linea al array auxiliar
 
            //echo "Se agrega al nuevo archivo la linea: $linea <br>"; // comentar
			$aux[] = $linea; 
        
		}
	}

	// Convertimos el arreglo(array) en una cadena de texto (string) para guardarlo.
	$aux = implode($aux, '');

	// Reemplazamos el contenido del archivo con la cadena de texto (sin las lineas eliminadas)
	file_put_contents('cron-file.txt', $aux);
 
?>
<?php
	// Despues, ejecutar exec(); para transformarlo en un archivo de linux
	exec('sudo fromdos -a cron-file.txt 2>&1', $salida);
	exec('sudo crontab /var/www/cron-file.txt 2>&1', $output); 
?>
<?php

   // sql to delete a record
   $sqlHorarios = "DELETE FROM horarios WHERE IdHorario = '".$id."'";
   $sqlDiasInicio = "DELETE FROM DiasInicio WHERE idNombre = '".$id."'";
   $sqlDiasTermino = "DELETE FROM DiasTermino WHERE idNombreTermino = '".$id."'";

   if ($conn->query($sqlHorarios) === TRUE and $conn->query($sqlDiasInicio) === TRUE and $conn->query($sqlDiasTermino) === TRUE) {
      echo"<script>alert('Horario eliminado correctamente.');
	       window.location.href=\"historial.php\"</script>";
   } 
   else 
   {
      echo "Error eliminando registro: " . $conn->error;
   }

   $conn->close();
?>
