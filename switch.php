<? include("seguridad.php"); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require_once('conexion.php');

    // Funcion que devuelve un array del estado y lugar de un interruptor
    function estado_interruptor ($conn, $num_gpio) {
	$sqlSelect = "SELECT estado, lugar FROM switch WHERE num_gpio = ". $num_gpio;
	$result = $conn->query($sqlSelect);
   	if ($result->num_rows > 0) {
     	// output data of each row
     		while($row = $result->fetch_assoc()) {
         	    return array ( $row["estado"], $row["lugar"] );
    	 	}
   	}
   	else {
     		echo "No hay interruptores...";
   	}
     }

     // Deja las variables segun el interruptor
     list($output, $habitacion) = estado_interruptor($conn, 24);  // Interruptor en GPIO 24

     if(isset($_POST['encender'])) {
	if ($output == "Luz Encendida")
	{
		echo"<script>alert('Aviso: El Interruptor ubicado en ".$habitacion."  ya está en modo encendido...');
		window.location.href=\"switch.php\"</script>";
	}
	else
	{
		exec("sudo python /home/pi/encender_luz.py");
     		$output = 'Luz Encendida';
		$sqlUpdate = "UPDATE switch SET estado = '" . $output . "' WHERE num_gpio = 24";
		$conn->query($sqlUpdate);
	}

     }

     if (isset($_POST['apagar']))
     {
	if ($output == "Luz Apagada")
	{
		echo"<script>alert('Aviso: El Interruptor ubicado en ".$habitacion."  ya está en modo apagado...');
		window.location.href=\"switch.php\"</script>";
	}
	else
	{
		exec("sudo python /home/pi/apagar_luz.py");
     		$output = 'Luz Apagada';
		$sqlUpdate = "UPDATE switch SET estado = '" . $output . "' WHERE num_gpio = 24";
        	$conn->query($sqlUpdate);
	}
     }

     // Deja las variables segun el interruptor
     list($output7, $habitacion7) = estado_interruptor($conn, 7); // Interruptor en GPIO 7

     if(isset($_POST['encender7'])) {
        if ($output7 == "Luz Encendida")
        {
                echo"<script>alert('Aviso: El Interruptor ubicado en ".$habitacion7."  ya está en modo encendido...');
                window.location.href=\"switch.php\"</script>";
        }
        else
        {
                exec("sudo python /home/pi/encender_luz_gpio7.py");
                $output7 = 'Luz Encendida';
                $sqlUpdate = "UPDATE switch SET estado = '" . $output7 . "' WHERE num_gpio = 7";
                $conn->query($sqlUpdate);
        }

     }

     if (isset($_POST['apagar7']))
     {
        if ($output7 == "Luz Apagada")
        {
                echo"<script>alert('Aviso: El Interruptor ubicado en  ".$habitacion7." ya está en modo apagado...');
                window.location.href=\"switch.php\"</script>";
        }
        else
        {
                exec("sudo python /home/pi/apagar_luz_gpio7.py");
                $output7 = 'Luz Apagada';
                $sqlUpdate = "UPDATE switch SET estado = '" . $output7 . "' WHERE num_gpio = 7";
                $conn->query($sqlUpdate);
        }
     }

     // Deja las variables segun el interruptor
     list($output8, $habitacion8) = estado_interruptor($conn, 8); // Interruptor en GPIO 8

     if(isset($_POST['encender8'])) {
        if ($output8 == "Luz Encendida")
        {
                echo"<script>alert('Aviso: El Interruptor ubicado en ".$habitacion8."  ya está en modo encendido...');
                window.location.href=\"switch.php\"</script>";
        }
        else
        {
                exec("sudo python /home/pi/encender_luz_gpio8.py");
                $output8 = 'Luz Encendida';
                $sqlUpdate = "UPDATE switch SET estado = '" . $output8 . "' WHERE num_gpio = 8";
                $conn->query($sqlUpdate);
        }

     }

     if (isset($_POST['apagar8']))
     {
        if ($output8 == "Luz Apagada")
        {
                echo"<script>alert('Aviso: El Interruptor ubicado en  ".$habitacion8." ya está en modo apagado...');
                window.location.href=\"switch.php\"</script>";
        }
        else
        {
                exec("sudo python /home/pi/apagar_luz_gpio8.py");
                $output8 = 'Luz Apagada';
                $sqlUpdate = "UPDATE switch SET estado = '" . $output8 . "' WHERE num_gpio = 8";
                $conn->query($sqlUpdate);
        }
     }

   $conn->close();
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
 <p class="pe">Interruptores</p>
<br>
<hr>
<br>
<p class="pa">Ubicación: <?php echo $habitacion ?></p>
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
<br>
<p class="pa">Ubicación: <?php echo $habitacion7 ?></p>
<p class="pa">Estado: <?php echo $output7 ?></p>
<br>
<hr>
  <br>
  <br>
  <table class="center">
  <tr>
     <td><input type="submit" name="encender7" value=" Encender " /></td>
  </tr>
  <tr>
     <td><input type="submit" name="apagar7" value="   Apagar  " /></td>
  </tr>
  </table>
  <br><br>
<hr>
<br>
<p class="pa">Ubicación: <?php echo $habitacion8 ?></p>
<p class="pa">Estado: <?php echo $output8 ?></p>
<br>
<hr>
  <br>
  <br>
  <table class="center">
  <tr>
     <td><input type="submit" name="encender8" value=" Encender " /></td>
  </tr>
  <tr>
     <td><input type="submit" name="apagar8" value="   Apagar  " /></td>
  </tr>
  </table>
  <br><br>
<hr>
<br>
<br>
<br>
<br>
</form>
<script>
</script>
        <footer>
	        <h2><i>Sofogal&copy;</i> Todos los derechos reservados, 2015.</h2>
            <a class="tzine" href="http://www.sofogal.cl" target="_blank"><i>Desarrollado por: </i><b>Sofogal.cl</b></a>
        </footer>   
    </body>
</html>
