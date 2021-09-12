<?php

require("../clases/ruta.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $idRuta = isset($_GET['ruta']) ? $_GET['ruta'] : '';
  $pedidos = isset($_GET['pedidos']) ? $_GET['pedidos'] : '';
  $retiros = isset($_GET['retiros']) ? $_GET['retiros'] : '';

  $ruta = new Ruta();
  $ruta->find($idRuta,$pedidos,$retiros);


  header('Content-Type: application/json');

  echo json_encode($ruta->getProperties());

  
}