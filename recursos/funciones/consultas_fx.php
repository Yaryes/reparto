<?php
if ($_POST['controlador'] != null) {




    //include('../clases/consultasCs.php');
    if (is_string($_POST['controlador'])) {
        $respuesta = explode(",", $_POST['controlador']);
        $controlador = array(
            0 => $respuesta[0],
            1 => $respuesta[1]
        );
        $array = $controlador;
        switches($array);
    } else {
        $array = $_POST['controlador'];
        switches($array);
    }


} else {
    header('Location: ../../index.html');
}
function switches($array)
{
    include('../clases/consultasCs.php');

    switch ($array[1]) {
        case 'cons':

            $codigo = $array[0];
            $params = array(
                'codigo' => $codigo
            );
            $respuesta = json_decode($consultas->consultaC($params));

            $respuesta = json_encode($respuesta);
            echo $respuesta;
            break;

        case 'enco':

            $codigo = $array[0];
            $params = array(
                'codigo' => $codigo
            );
            $respuesta = json_decode($consultas->consultaE($params));

            $respuesta = json_encode($respuesta);
            echo $respuesta;
            break;

        case 'pedid':

            $codigo = $array[0];
            $params = array(
                'codigo' => $codigo
            );
            $respuesta = json_decode($consultas->consultaP($params));

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
}