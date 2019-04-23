<? include("seguridad.php"); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');
require_once('conexion.php');
?>
<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$sql="SELECT lugar, num_gpio FROM switch";
//$result = $conn->query($sql); //usamos la conexion para dar un resultado a la variable
$result = $conn->query($sql); //usamos la conexion para dar un resultado a la variable
if ($result->num_rows > 0) //si la variable tiene al menos 1 fila entonces seguimos con el codigo
{
    $combobit="<option value='0'>- Seleccionar -</option>";
    while ($row = $result->fetch_assoc())
    {
        $combobit .=" <option value='".$row['num_gpio']."'>".$row['lugar']."</option>"; //concatenamos el los options para luego ser insertado en el HTML
    }
}
else
{
   	 echo "No hay interruptores...";
}

if(isset($_POST['enviar']))
{
  function hora_a_segundos($hora) {
        list($h, $m, $s) = explode(':', $hora);
        return ($h * 3600) + ($m * 60) + $s;
  }

  if (isset($_POST['interruptores'])){
	 $interruptor = $_POST['interruptores'];
  }
  else {
	 $interruptor = "";
  }

  if (isset($_POST['hora'])){
	 $hora = $_POST['hora'];
  }
  else {
	 $hora = "";
  }

  //echo "<script>alert('Hora en segundos: ".hora_a_segundos($hora).", interruptor: ".$interruptor."  ')</script>";

  if(isset($_POST['radio']))
  {
    	$sw = $_POST['radio'];
	if ($sw == "encender") {
		//$comando = "python /home/pi/timer_encender_interruptor.py ". hora_a_segundos($hora) ." ". $interruptor ." &";
		shell_exec("sudo python /home/pi/timer_encender_interruptor.py ". hora_a_segundos($hora) ." ". $interruptor ." > /dev/null &");
		//echo "<script>alert('Hora en segundos: ".hora_a_segundos($hora).", interruptor: ".$interruptor."  ')</script>";
                echo"<script>alert('Aviso: El Interruptor se encenderá ".$hora."  minutos...');
                window.location.href=\"timer.php\"</script>";
	}
	if ($sw == "apagar"){
		//$comando = "python /home/pi/timer_apagar_interruptor.py ". hora_a_segundos($hora) ." ". $interruptor ." > /dev/null &";
                shell_exec("sudo python /home/pi/timer_apagar_interruptor.py ". hora_a_segundos($hora) ." ". $interruptor ." > /dev/null &");
		//echo "<script>alert('Hora en segundos: ".hora_a_segundos($hora).", interruptor: ".$interruptor."  ')</script>";
                echo"<script>alert('Aviso: El Interruptor se apagará en ".$hora."  minutos...');
                window.location.href=\"timer.php\"</script>";
	}
  }
  else {
	$sw = "";
  }

  $conn->close();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Timer</title>

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
                                                <li><a href="switch.php">Timer</a></li>
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
<br><br><br><p class="pe">Timer</p>
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

 Seleccione nombre del interruptor: <select name="interruptores">
       					<?php echo $combobit; ?>
   				    </select> 
<br>
<br>
<hr>
<br>
 Hora de encendido: <input type="time" name="hora" placeholder="00:00:00" required/> <br>
<br>
<p>Seleccione dias de encendido:</p>
<br>
<input type="radio" name="radio" value="encender">Encender
<input type="radio" name="radio" value="apagar">Apagar
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
	        <h2><i>Sofogal&copy;</i> Todos los derechos reservados, 2017.</h2>
            <a class="tzine" href="http://www.sofogal.cl" target="_blank"><i>Desarrollado por: </i><b>Sofogal.cl</b></a>
        </footer> 
</body>
</html>
