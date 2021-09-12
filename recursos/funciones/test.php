<?php

        //$respuesta = $_POST['controlador'];
        $respuesta = explode(",", $_POST['controlador']);
        $controlador = array(
            0 => $respuesta[0],
            1 => $respuesta[1]
        );
        $respuesta = json_encode($respuesta[1]);
        echo $controlador[0];


