<?php
require("conexionCs.php");

class login extends Connection{

function __construct()
{
    parent::__construct();
    return $this;
}
 public function iniciarSesion() {
     
     $args = (count(func_get_args())>0) ? func_get_args()[0]:func_get_args();
     $sql = "SELECT rut,nombre,apellido,contrasena,correo,perfil FROM usuario WHERE rut = ?";
     $consulta = $this->prepare($sql);
     $consulta->bind_param('s',$rut);
     $rut = $args ['rut'];
     $pass = $args ['pass'];
     $this->execute($consulta);
     $consulta->bind_result($rut_bd,$nombre,$apellido,$contrasena,$correo,$perfil);
     $consulta->fetch();
     if ($pass==$contrasena) {
         $r = array(
             'state'=>true,
             'rut'=>$rut_bd,
             'nombre'=>$nombre,
             'apellido'=>$apellido,
             'contrasena'=>$contrasena,
             'correo'=>$correo,
             'perfil'=>$perfil

         );
     }else{
         $r = array (
             'state'=>false,
             'msg'=>'Las contraseñas no coinciden'
         );

     }
return json_encode($r);
 }
}
$login = new login;












?>