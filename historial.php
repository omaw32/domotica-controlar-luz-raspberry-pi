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
		<script text="javascript">
			function confirmDel()
			{
			  if (confirm("¿Está seguro de eliminar este horario?")) 
				return true ;
			  else 
				return false;
			}
		</script>
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
<br><br><br><p class="pe">Historial de Horarios</p>
<?php
   require_once('conexion.php');

	function DiasInicio($conn, $id) {

	   $diasSemanaInicio = "";
	   // consulta dias de inicio
	   $resultDiasInicio = $conn->query( "SELECT diaInicio FROM DiasInicio WHERE idNombre = '" . $id . "'");
	   $arregloDiasInicio = array();
	   if ($resultDiasInicio->num_rows > 0) 
	   {
		   // lleno un arreglo con los dias desde mysql
		   while($row = $resultDiasInicio->fetch_assoc()) {
		            $arregloDiasInicio[] = $row["diaInicio"];
		   }
		   // lleno la variable con los dias concatenado una coma
		   for($i=0; $i < count($arregloDiasInicio); $i++) {
				$diasSemanaInicio = implode($arregloDiasInicio, ", ");
		   }
	   } 
	   else 
	   {
		   $diasSemanaInicio = "No hay dias de encendido agendados.";
	   }
		
	   return $diasSemanaInicio; // Devolver el resultado
	}

	function DiasTermino($conn, $id) {
       // inicializo variables que contendran dias concatenados 
       $diasSemanaTermino = ""; 

       // consulta dias de apagado
   	   $resultDiasTermino = $conn->query( "SELECT diaTermino FROM DiasTermino WHERE idNombreTermino = '" . $id . "'");
       $arregloDiasTermino = array();
       if ($resultDiasTermino->num_rows > 0) 
       {
          while($fila = $resultDiasTermino->fetch_assoc()) {
              $arregloDiasTermino[] = $fila["diaTermino"];
          }
          // lleno la variable con los dias concatenado una coma
	      for($i=0; $i < count($arregloDiasTermino); $i++) {
			  $diasSemanaTermino = implode($arregloDiasTermino, ", ");
          }
       } 
       else 
       {
          $diasSemanaTermino = "No hay dias de apagado agendados.";
       }

	   return $diasSemanaTermino;
    }

   // Enviar consulta 
   $sqlSelect = "SELECT IdHorario, NombreHorario, HoraInicio, HoraTermino FROM horarios ORDER BY IdHorario desc";
   $result = $conn->query($sqlSelect);
   if ($result->num_rows > 0) {
?> 
	<table class="semana">
<?php
     // output data of each row
     while($row = $result->fetch_assoc()) {
		echo "<tr><td class='a2' colspan='3'></td></tr>";
		echo"<tr>";
?>
			<td class ="a1"><p class = "po">Nombre Horario: </p></td>
			<td class ="a1"><?php echo " ".$row["NombreHorario"];?></td>
			<td></td>
		</tr>
		<tr>
			<td class ="a1"><p class = "po">Hora Encendido: </p></td>
			<td class ="a1"><?php echo " ".$row["HoraInicio"];?></td>
			<td></td>
		</tr>
		<tr>
			<td class ="a1"><p class = "po">HoraApagado: </p></td>
			<td class ="a1"><?php echo " ".$row["HoraTermino"];?></td>
			<td>
				<a href="editar.php?id=<?php echo $row['IdHorario']; ?>">
				    <img src="img/modificar.png" title="Modificar" alt="Modificar" width="18" height="18" />
        			</a>
        			/ 
        			<a onclick="return confirmDel();" href="eliminar.php?id=<?php echo $row['IdHorario']; ?>">
				    <img src="img/eliminar.png" title="Eliminar" alt="Eliminar" width="18" height="18" />
				</a>
			</td>
		</tr>
		<tr>
			<td class ="a1"><p class = "po">Dias de Encendido: </p></td>
			<td class ="a1"><?php echo DiasInicio($conn, $row["IdHorario"]); ?></td>
			<td></td>
		</tr>
		<tr>
			<td class ="a1"><p class = "po">Dias de Apagado: </p></td>
			<td class ="a1"><?php echo DiasTermino($conn, $row['IdHorario']); ?></td>
			<td></td>
		</tr>
		<!--<tr>
			<td class="a2" colspan="3"></td>
		</tr>-->
	<?php
     	   }
	?>
	</table>
<br>
<br>
<br>
<br>
<br>
	<?php
   	} 
   	else {
     		echo "<p class='pa'>No hay horarios agendados.</p>";
        }  
	?>
        <footer>
	        <h2><i>Sofogal&copy;</i> Todos los derechos reservados, 2015.</h2>
            <a class="tzine" href="http://www.sofogal.cl" target="_blank"><i>Desarrollado por: </i><b>Sofogal.cl</b></a>
        </footer>   
    </body>
</html>
