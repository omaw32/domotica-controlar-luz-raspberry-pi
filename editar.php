<? include("seguridad.php"); ?>
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
<br><br><br><br> <p class="pe">Editar Horario</p>
<hr>
<br>
<form method="post" action="actualizar.php">
<?php 

   require_once('conexion.php');
   if (isset($_GET['id'])) {
       	$id = $_GET['id'];
   }

   // Array dias de la semana
   $semanaCompleta = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');

   // consulta horario 
   $sqlHorarios = "SELECT NombreHorario, HoraInicio, HoraTermino FROM horarios WHERE IdHorario = '" . $id . "'";
   $resultHorarios = $conn->query($sqlHorarios);

  if ($resultHorarios->num_rows > 0) 
  {
?>
  <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Envio el id a actualizar.php  -->  
	<table class="semana">
<?php
    while($row = $resultHorarios->fetch_assoc()) {
		echo"<tr>";
?>
     <td class="a1"><p class="po">Nombre Horario: </p></td>
     <td class="a1">
        <?php echo "<input type='text' name='NombreHorario' value='".$row['NombreHorario']."' required/>"; ?>
        <input type="hidden" name="NombreHorarioOriginal" value="<?php echo $row['NombreHorario']; ?>">
     </td>
   <tr>
	 <td class="a1"><p class="po">Hora de Encendido: </p></td>
   <td class="a1">
     <?php echo "<input type='time' name='HoraInicio' value='".$row['HoraInicio']."' required/>"; ?>
   </td>
     </tr>	
	 <tr>	
	 <td class="a1"><p class="po">Hora de Apagado: </p></td>
   <td class="a1">
     <?php echo "<input type='time' name='HoraTermino' value='".$row['HoraTermino']."' required/>"; ?>
   </td>
	 </tr>
<?php
    }
?>
	</table>
<?php
  } 
  else 
  {
     echo "<br>No hay Horarios agendados.";
  }

   // consulta dias de inicio
   $sqlDiasInicio = "SELECT diaInicio FROM DiasInicio WHERE idNombre = '" . $id . "'";
   $resultDiasInicio = $conn->query($sqlDiasInicio);
   $dia = array();
   if ($resultDiasInicio->num_rows > 0) 
   {
       echo "<br> <p class='pa'>Dias de Encendido: </p><br>";
       // lleno un arreglo con los dias desde mysql
       
       while($row = $resultDiasInicio->fetch_assoc()) {
                $dia[] = $row["diaInicio"];
       }

       // relleno el arreglo con cadenas vacias, para que contenga 7 elementos
       //for ($x = count($dia); $x < 7; $x++) {
       //	$dia[] = "";
       //}
       //echo "<br>";
       //print_r($dia);
       //echo "<br>" . count($dia);

       // comparo los arreglos y marco los check que correspondan
       for ($x = 0; $x < count($semanaCompleta); $x++) {

	  if (in_array($semanaCompleta[$x], $dia)) {
              echo "<input type='checkbox' name='checkInicio[]' value='$semanaCompleta[$x]' checked/> $semanaCompleta[$x] ";
	  }
	  else
	  {
	      echo "<input type='checkbox' name='checkInicio[]' value='$semanaCompleta[$x]'/> $semanaCompleta[$x] ";
	  }
       }
   } 
   else 
   {
     echo "<br>No hay dias de encendido agendados.";
   }

   // consulta dias de apagado
   $sqlDiasTermino = "SELECT diaTermino FROM DiasTermino WHERE idNombreTermino = '" . $id . "'";
   $resultDiasTermino = $conn->query($sqlDiasTermino);
   $arregloDiasTermino = array();
   if ($resultDiasTermino->num_rows > 0) 
   {
       echo "<br><br><p class='pa'> Dias de Apagado: </p><br>";
       while($fila = $resultDiasTermino->fetch_assoc()) {
           $arregloDiasTermino[] = $fila["diaTermino"];
       }
       // si el dia existe en el arreglo, marca el check, si no, no marca el check
       for ($x = 0; $x < count($semanaCompleta); $x++) {

		if (in_array($semanaCompleta[$x], $arregloDiasTermino)) {
		   echo "<input type='checkbox' name='checkTermino[]' value='$semanaCompleta[$x]' checked/> $semanaCompleta[$x] ";
		}
		else
		{
		   echo "<input type='checkbox' name='checkTermino[]' value='$semanaCompleta[$x]'/> $semanaCompleta[$x] ";
		}
       }
   } 
   else 
   {
     echo "<br>No hay dias de apagado agendados.";
   }
   echo "<br><br>";
   echo "<hr>";
   echo "<br>";
   echo "<input type='submit' name='editar' value=' Editar '/> ";
   echo "<br><br><br><br><br>";

   function array_envia($array) { 

      $tmp = serialize($array); 
      $tmp = urlencode($tmp); 

      return $tmp; 
   } 

   $arrayInicio = array_envia($dia);
   $arrayTermino =  array_envia($arregloDiasTermino); 

?>  

   <input type="hidden" name="ArregloDiasInicio" value="<?php echo $arrayInicio; ?>">  
   <input type="hidden" name="ArregloDiasTermino" value="<?php echo $arrayTermino; ?>">
 
</form>
<!--<p class="pe"><a rel="shadowbox;width=700;height=500" title="Página web" href="inicio.php">Página web</a></p>-->
        <footer>
	        <h2><i>Sofogal&copy;</i> Todos los derechos reservados, 2015.</h2>
            <a class="tzine" href="http://www.sofogal.cl" target="_blank"><i>Desarrollado por: </i><b>Sofogal.cl</b></a>
        </footer> 
    </body>
</html>
