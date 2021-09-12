<?php
if ($_POST['rut'] != null) {
include('../clases/loginCs.php');
  //  var_dump($_POST);
//contenido

$rut = $_POST['rut'];
$pass = $_POST['pass'];

if ($rut!=""){
    $params = array(
        'rut'=>$rut,
        'pass'=>$pass);
       $respuesta=json_decode($login->iniciarSesion($params));
       $respuesta= json_encode($respuesta);
    echo $respuesta;
    }

  } else {
    header('Location: ../../index.html');
}

