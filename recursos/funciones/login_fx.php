<?php
session_start();

include('../clases/loginCs.php');
if (isset($_POST['login'])) {
  //  var_dump($_POST);
//contenido

$rut = $_POST['rut'];
$pass = $_POST['pass'];

$datos = array(
    'rut'=>$rut,
    'pass'=>$pass
);

$iniciarSesion = json_decode($login->iniciarSesion($datos)) ;
var_dump($iniciarSesion);
if ($iniciarSesion->state==true) {
    $_SESSION['user']['fullname']= $iniciarSesion->nombre." ". $iniciarSesion->apellido; 
    $_SESSION['user']['perfil']= $iniciarSesion->perfil; 
    $_SESSION['user']['correo']= $iniciarSesion->correo; 
    $_SESSION['user']['pass']= $iniciarSesion->contrasena; 
    $_SESSION['user']['rut']= $iniciarSesion->rut; 

    header('location:../../inicio.php');
 
}else{
    header('location:../../index.html');
}

}else{
    //no se selecciono el boton iniciar sesion del index
    header('Location: ../../index.html');
}






?>