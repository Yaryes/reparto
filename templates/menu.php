
<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <div class="container-fluid">
    <a class="navbar-brand" href="inicio.php">
      <img src="img/bluexlogo.png" width="50" height="50" alt="" loading="lazy">
    </a>
    <a class="navbar-brand font-weight-bold" href="inicio.php"><?php echo 'HOLA DE NUEVO ' . $_SESSION['user']['fullname']; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ">
        <a class="nav-link active  ml-5 " aria-current="page" href="excel.php">CARGAR DATOS</a>
        <a class="nav-link active ml-3" aria-current="page" href="arribo.php">ARRIBO</a>
        <a class="nav-link active ml-3" aria-current="page" href="asociacion.php">ASOCIACIÓN</a>
        <a class="nav-link active ml-3" aria-current="page" href="SalidaRuta.php">SALIDA A RUTA</a>
        <a class="nav-link active ml-3" aria-current="page" href="recepcion-ruta.php">RECEPCIÓN DE RUTA</a>
        <a class="nav-link active ml-3" aria-current="page" href="consultas.php">CONSULTAS</a>
      </div>

    </div>
    <span class="nav-item rounded p-2">
        <a class="nav-link  text-white logout transition" href="salir.php">CERRAR SESIÓN</a>
      </span>
  </div>
</nav>