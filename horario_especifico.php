<? include("seguridad.php"); ?>
<?php
//header('Content-Type: text/html; charset=UTF-8'); 
?>
<?php
// require_once('conexion.php');

// $output = ""; 
// $habitacion = "";

// $sqlSelect = "SELECT estado, lugar FROM switch";
// $result = $conn->query($sqlSelect);
//    if ($result->num_rows > 0) {
//      // output data of each row
//      while($row = $result->fetch_assoc()) {
//          $output = $row["estado"];
// 	 $habitacion = $row["lugar"];
//      }
//    } 
//    else {
//      echo "0 results";
//    }

//      if(isset($_POST['encender'])) {
// 	if ($output == "Luz Encendida")
// 	{
// 		echo"<script>alert('Aviso: El Interruptor ya está en modo encendido...');
// 		window.location.href=\"switch.php\"</script>";  
// 	}
// 	else
// 	{
// 		//exec("gpio -g write 24 0");
//      		$output = 'Luz Encendida';
// 		$sqlUpdate = "UPDATE switch SET estado = '" . $output . "' ";
// 		$conn->query($sqlUpdate);
// 	}

//      }

//      if (isset($_POST['apagar']))
//      {
// 	if ($output == "Luz Apagada")
// 	{
// 		echo"<script>alert('Aviso: El Interruptor ya está en modo apagado...');
// 		window.location.href=\"switch.php\"</script>";  
// 	}
// 	else
// 	{
// 		//exec("gpio -g write 24 1");
//      		$output = 'Luz Apagada';
// 		$sqlUpdate = "UPDATE switch SET estado = '" . $output . "' ";
//         	$conn->query($sqlUpdate);
// 	}
//      }
//    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title>Switch</title>

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
<br><br><br>
 <form ACTION="switch.php" METHOD="post" NAME="switch">
 <p class="pe">Muy Pronto...</p>
<hr>
<br>
<!-- <p class="pa">Ubicación: <?php echo $habitacion ?></p>
<p class="pa">Estado: <?php echo $output ?></p>
<br>
<hr>
  <br>
  <br>
  <table class="center">
  <tr>
     <td><input type="submit" name="encender" value=" Encender " /></td>
  </tr>
  <tr>
     <td><input type="submit" name="apagar" value="   Apagar  " /></td>
  </tr>
  </table>
  <br><br>
<hr>
<br> -->
</form>
        <footer>
	        <h2><i>Sofogal&copy;</i> Todos los derechos reservados, 2015.</h2>
            <a class="tzine" href="http://www.sofogal.cl" target="_blank"><i>Desarrollado por: </i><b>Sofogal.cl</b></a>
        </footer>   
    </body>
</html>
