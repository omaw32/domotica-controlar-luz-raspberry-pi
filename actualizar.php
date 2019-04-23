<?php
   if (isset($_POST['id'])) {
       	$id = $_POST['id'];
   }
   if(isset($_POST['NombreHorario'])) {
	      $nombreHorario = $_POST['NombreHorario'];
   }
      if(isset($_POST['NombreHorarioOriginal'])) {
        $nombreHorarioOriginal = $_POST['NombreHorarioOriginal'];
   }
   if(isset($_POST['checkInicio'])) {
        $checkInicio = $_POST['checkInicio'];
   }
   if(isset($_POST['checkTermino'])) {
	      $checkTermino = $_POST['checkTermino'];
   }
   if(isset($_POST['ArregloDiasInicio'])) {
        $arregloDiasInicio = $_POST['ArregloDiasInicio'];
   }
   if(isset($_POST['ArregloDiasTermino'])) {
        $arregloDiasTermnio = $_POST['ArregloDiasTermino'];
	//echo count($arregloDiasTermnio)."<br>";
   }
   if(isset($_POST['HoraInicio'])) {
        $horaInicio = $_POST['HoraInicio'];
   }
   if(isset($_POST['NombreHorario'])) {
        $horaTermino = $_POST['HoraTermino'];
   }

   // Funcion que deserializa un string, a array
   function array_recibe($url_array) { 

        $tmp = stripslashes($url_array); 
        $tmp = urldecode($tmp); 
        $tmp = unserialize($tmp); 

        return $tmp; 
   }

    // Eliminar Horario de archivo cron
  $lineas = file("cron-file.txt");
  $palabra= $nombreHorarioOriginal; // parametro identificador de lineas a eliminar    
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
  //Creamos el archivo cron-file.txt
  //ponemos tipo 'a' para añadir lineas sin borrar
  $file=fopen("cron-file.txt","a") or die("Error abriendo archivo cron-file.txt");

  $horaMinutosInicio = $_REQUEST['HoraInicio'];
  $horaMinutosTermino = $_REQUEST['HoraTermino'];
  
  $minutoInicioCron = substr($horaMinutosInicio, 3, 2); 
  $horaInicioCron = substr($horaMinutosInicio, 0, 2); 
  // echo $minutoInicioCron."<br>";
  $minutoTerminoCron = substr($horaMinutosTermino, 3, 2); 
  $horaTerminoCron = substr($horaMinutosTermino, 0, 2); 
  // echo $minutoTerminoCron."<br>";
  $array = array('0' => 'Domingo', 
                 '1' => 'Lunes', 
                 '2' => 'Martes', 
                 '3' => 'Miercoles', 
                 '4' => 'Jueves', 
                 '5' => 'Viernes', 
                 '6' => 'Sabado');
  
  // Los dias que llegan del checkInicio, los convierte en numeros para concatenarlos 
  $arrayDiasInicio = array();

  for($x=0; $x < count($checkInicio); $x++) {
      $clave = array_search($checkInicio[$x], $array); 
      $arrayDiasInicio[] = $clave;
  }
    // Concateno valores en una linea
  for($i=0; $i < count($arrayDiasInicio); $i++) {
      $diasSemana = implode($arrayDiasInicio, ",");
  }

  // Los dias que llegan del checkTermino, los convierte en numeros para concatenarlos 
  $arrayDiasTermnio = array();

  for($x=0; $x < count($checkTermino); $x++) {
      $clave = array_search($checkTermino[$x], $array); 
      $arrayDiasTermnio[] = $clave;
  }
    // Concateno valores en una linea
  for($i=0; $i < count($arrayDiasTermnio); $i++) {
      $diasSemanaTermino = implode($arrayDiasTermnio, ",");
  }
  
  //vamos añadiendo el contenido
  fputs($file, $minutoInicioCron . " " . $horaInicioCron . " * * " . $diasSemana . " sudo python /home/pi/encender_luz.py # ".$nombreHorario);
  fputs($file,"\n");
  fputs($file, $minutoTerminoCron." ". $horaTerminoCron . " * * " . $diasSemanaTermino ." sudo python /home/pi/apagar_luz.py # ".$nombreHorario);
  fputs($file,"\n");
  fclose($file);
  
  exec('sudo fromdos -a cron-file.txt 2>&1', $salida);
  exec('sudo crontab /var/www/cron-file.txt 2>&1', $output); 
 
   $sqlDiasInicio="";
   $sqlDiasTermino = "";
   $arregloDiasInicio = array_recibe($arregloDiasInicio); 
   $arregloDiasTermnio = array_recibe($arregloDiasTermnio);

   require_once('conexion.php');
   $sql = "UPDATE horarios SET NombreHorario ='".$nombreHorario."', HoraInicio='".$horaInicio."', HoraTermino='".$horaTermino."' WHERE IdHorario='".$id."'";

   $conn->query($sql) or die("Error actualizando en tabla horarios.");

   if ($checkInicio != $arregloDiasInicio) {
	
         $sqlDiasInicio = "DELETE FROM DiasInicio WHERE idNombre = '".$id."'";
	       if ($conn->query($sqlDiasInicio) === TRUE) {
            // Guardo dias de inicio
            if(is_array($_POST['checkInicio'])) {
       	       // Guardo solo los marcados
       	       while(list($key,$diaCheckInicio) = each($_POST['checkInicio'])) {
                   $sqlDiasInicio="INSERT INTO DiasInicio (idNombre, diaInicio) VALUES ('".$id."', '".$diaCheckInicio."')";
                   $sqlDiasInicio = $conn->query($sqlDiasInicio) or die ("Error actualizando en tabla DiasInicio");
       	       }
            }
	       }
	
    }

   if ($checkTermino != $arregloDiasTermnio) {

	      $sqlDiasTermino = "DELETE FROM DiasTermino WHERE idNombreTermino = '".$id."'";	
        if ($conn->query($sqlDiasTermino) === TRUE) {
         // Guardo dias de termino
         if(is_array($_POST['checkTermino'])) {
       	   // Guardo solo los marcados
     	   while(list($key,$diaCheckTermino) = each($_POST['checkTermino'])) {
	           $sqlDiasTermino = "INSERT INTO DiasTermino (idNombreTermino, diaTermino) VALUES ('".$id."', '".$diaCheckTermino."')";
             $sqlDiasTermino = $conn->query($sqlDiasTermino) or die ("Error actualizando en tabla DiasTermino");
       	   }
         }
	      }
   }
   
   // Cierro la conexion con Base de Datos
   $conn->close();

   // Confirmacion

	 echo"<script>alert('Horario actualizado correctamente.');
	       window.location.href=\"historial.php\"</script>";

?>
