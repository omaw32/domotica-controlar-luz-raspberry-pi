<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <form action="control.php" method="post" id="form" class="login">
    <p class="pe">Sistema Control de Luz</p>
<br>
<br>
    <p>
      <label for="login">Usuario:</label>
      <input type="text" name="usuario" id="usuario" placeholder="Nombre de Usuario" required/>
    </p>

    <p>
      <label for="password">Contraseña:</label>
      <input type="password" name="clave" id="clave" placeholder="********" required/>
    </p>

    <p class="login-submit">
      <button type="submit" class="login-button">Login</button>
    </p>

    <p class="forgot-password"><a href="index.php">Olvido su contraseña?</a></p>
  </form>

  <section class="about">
   <!-- <p class="about-links">
      <a href="http://www.cssflow.com/snippets/dark-login-form" target="_parent">View Article</a>
      <a href="http://www.cssflow.com/snippets/dark-login-form.zip" target="_parent">Download</a>
    </p> -->
    <p class="about-author">
      &copy; 2015, Todos los derechos reservados <br>
      Desarrollado por: <a href="http://www.sofogal.cl" target="_blank">Sofogal.cl</a>
  </section>
</body>
</html>
