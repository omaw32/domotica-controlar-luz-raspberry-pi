<?
     /* A continuación, realizamos la conexión con nuestra base de datos en MySQL */
     $link = mysql_connect("localhost","root","anto01++");
     mysql_select_db("sofogal", $link);

     /* El query valida si el usuario ingresado existe en la base de datos. Se utiliza la función 
     htmlentities para evitar inyecciones SQL. */
     $myusuario = mysql_query("select idusuario from usuarios 
                                 where idusuario =  '".htmlentities($_POST["usuario"])."'",$link);
     $nmyusuario = mysql_num_rows($myusuario);

     //Si existe el usuario, validamos también la contraseña ingresada y el estado del usuario...
     if($nmyusuario != 0){
          $sql = "select idusuario
               from usuarios
               where estado = 1
               and idusuario = '".htmlentities($_POST["usuario"])."' 
               and clave = '".md5(htmlentities($_POST["clave"]))."'";
          $myclave = mysql_query($sql,$link);
          $nmyclave = mysql_num_rows($myclave);

          //Si el usuario y clave ingresado son correctos (y el usuario está activo en la BD), creamos la sesión del mismo.
          if($nmyclave != 0){
               session_start();
               //Guardamos dos variables de sesión que nos auxiliará para saber si se está o no "logueado" un usuario
               $_SESSION["autentica"] = "SIP";
               $_SESSION["usuarioactual"] = mysql_result($myclave,0,0); //nombre del usuario logueado.
               //Direccionamos a nuestra página principal del sistema.
               header ("Location: inicio.php");
          }
          else{
               echo"<script>alert('La contrase\u00f1a del usuario no es correcta.');
               window.location.href=\"index.php\"</script>"; 
          }
     }else{
          echo"<script>alert('El usuario no existe.');window.location.href=\"index.php\"</script>";
     }
     mysql_close($link);
?>
<html>
        <meta charset="utf-8" />
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

</body>
</html>
