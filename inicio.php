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
                                <li class="orange">
                                        <a href="#" class="icon-time"></a>
                                        <ul>
                                                <li><a href="timer.php">Timer</a></li>
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
<br><br><br><br><br><p class="pe">Hola <? echo $_SESSION["usuarioactual"]; ?>, elija una opción del menú...</p>
        <footer>
	        <h2><i>Sofogal&copy;</i> Todos los derechos reservados, 2015.</h2>
            <a class="tzine" href="http://www.sofogal.cl" target="_blank"><i>Desarrollado por: </i><b>Sofogal.cl</b></a>
        </footer>   
    </body>
</html>
