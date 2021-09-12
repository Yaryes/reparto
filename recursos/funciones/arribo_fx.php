<?php

session_start();
if ($_POST['controlador'] != null) {
    include('../clases/arriboCs.php');

switch ($_POST['controlador'][0]) {
    case 'find':
        $codigo = $_POST['controlador'][1];
        $params = array(
            'codigo' => $codigo
        );
        $respuesta = json_decode($arribo->consulta($params));

        $respuesta = json_encode($respuesta);
        echo $respuesta;
        break;

    case 'save':
        $err = 0;
        for ($i = 0; $i < $_POST['controlador'][1]; $i++) {

            $codigo = $_POST['controlador'][$i + 2];
            $user= $_SESSION['user']['rut'];
            $params = array(
                'codigo' => $codigo,
                'user' => $user
            );
            $respuesta = json_decode($arribo->save($params), true);
            if (!$respuesta['resp']) {
                $err = $err + 1;
            }
        }
        $respuesta = array(
            'errores' => $err
        );
        $respuesta = json_encode($respuesta);

        echo $respuesta;
        break;

    default:
        $respuesta = array(
            'existe' => false
        );
        $respuesta = json_encode($respuesta);
        echo $respuesta;
}
}else{
    header('Location: ../../index.html');
 }