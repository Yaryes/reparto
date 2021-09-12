<?php

require("../clases/pedido.php");
require("../clases/retiro.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $json = file_get_contents('php://input');
  $body = json_decode($json);
  $ruta = $body->ruta;

  foreach ($body->pedidos as $key => $pedido) {
    $newPedido = new Pedido();
    $newPedido->createHistory($pedido->id, $ruta, 'SALIDA A RUTA');
 //
    foreach ($pedido->retiros as $key => $retiro) {
      $newRetiro = new Retiro();
      $newRetiro->createHistory($retiro->id, $ruta, 'SALIDA A RUTA');
    }
  }

  header('Content-Type: application/json');
  echo json_encode('OK');
}