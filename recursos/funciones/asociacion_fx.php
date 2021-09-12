<?php 

if ($_POST['codigo'] != null) {
    
    include('../clases/asociacionCs.php');

$codigo = $_POST['codigo'];
if ($codigo!=""){
    $params = array(
       'codigo' => $codigo);
       $respuesta=json_decode($asociacion->consulta($params));
       
       $respuesta= json_encode($respuesta);
    echo $respuesta;
    }
} else {
    header('Location: ../../index.html');
}
