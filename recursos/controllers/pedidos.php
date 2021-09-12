<?php

require("../clases/pedido.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $idPedido = isset($_GET['pedido']) ? $_GET['pedido'] : '';

  $pedido = new Pedido();
  $pedido->find($idPedido);


  header('Content-Type: application/json');
  echo json_encode($pedido->getProperties());
}