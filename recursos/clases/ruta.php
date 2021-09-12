<?php
require("conexionCs.php");
include_once("pedido.php");

class Ruta extends Connection {

  private $id;
  private $repartidor;
  private $hasMovements;
  private $pedidos = [];
  private $retiros = [];

  public function create($ruta, $repartidor){
    $query = "INSERT INTO ruta
              VALUES(?, ?)";

    $query = $this->prepare($query);
    $query->bind_param('is', $ruta, $repartidor);
    $this->execute($query);

    return $this->find($ruta);
  }

  private function getRuta($queryId){
    $query = "SELECT 
                ruta.idruta, 
                ruta.nombre_repartidor 
              FROM ruta 
              WHERE ruta.idruta = ?";

    $query = $this->prepare($query);
    $query->bind_param('i', $queryId);
    $this->execute($query);
    $query->bind_result($this->id, $this->repartidor);
    $query->fetch();
  }

  private function hasMovement($queryId){
    $query = "SELECT 
                COUNT(*)
              FROM historial_pedido 
              WHERE historial_pedido.ruta_idruta = ? AND historial_pedido.estado_de_movimiento='SALIDA A RUTA'";

    $query = $this->prepare($query);
    $query->bind_param('i', $queryId);
    $this->execute($query);
    $query->bind_result($this->hasMovements);
    $query->fetch();
  }

  private function getPedidos($queryId){
    $query = "SELECT 
                pedido.idpedido,
                consultora.direcion,
                historial_pedido.estado_de_movimiento,
                pedido.piezas
              FROM historial_pedido
              INNER JOIN pedido
              ON pedido.idpedido = historial_pedido.pedido_idpedido
              INNER JOIN consultora
              ON consultora.idconsultora = pedido.consultora_idconsultora
              WHERE historial_pedido.ruta_idruta = ?";
    $query = $this->prepare($query);
    $query->bind_param('i', $queryId);
    $this->execute($query);
    $idPedido = null;
    $adress = null;
    $state = null;
    $pieces = null;
    $query->bind_result($idPedido,$adress,$state,$pieces);
    while ($query->fetch()){

      $pedido = new Pedido();
      $pedido = $pedido->find($idPedido);

      array_push($this->pedidos, [
        'idPedido'=>$idPedido,
        'adress'=>$adress,
        'state'=>$state,
        'pieces'=>$pieces,
        'regalos'=>$pedido['regalos'],
        'entrega'=>$pedido['entrega']
      ]);
    }
    $query->fetch();

  }

  private function getRetiros($queryId){
    $query = "SELECT 
                historial_retiro.retiro_idretiro,
                historial_retiro.movimiento,
                historial_retiro.fecha,
                consultora.direcion,
                retiro.entrega
              FROM historial_retiro
              INNER JOIN retiro
              ON historial_retiro.retiro_idretiro = retiro.idretiro
              INNER JOIN consultora
              ON consultora.idconsultora = retiro.consultora_idconsultora
              INNER JOIN ruta
              ON ruta.idruta = historial_retiro.ruta_idruta
              WHERE historial_retiro.ruta_idruta = ?";
    $query = $this->prepare($query);
    $query->bind_param('i', $queryId);
    $this->execute($query);
    $idRetiro = null;
    $movimiento = null;
    $fecha = null;
    $direccion = null;
    $entrega=null;
    $query->bind_result($idRetiro,$movimiento,$fecha,$direccion,$entrega);
    while ($query->fetch()){

      array_push($this->retiros, [
        'idRetiro'=>$idRetiro,
        'movimiento'=>$movimiento,
        'fecha'=>$fecha,
        'direccion'=>$direccion,
        'entrega'=>$entrega
      ]);
    }
    $query->fetch();

  }

  public function find($queryId, $pedidos = null, $retiros=null){
    self::getRuta($queryId);
    self::hasMovement($queryId);

    if($pedidos){
      self::getPedidos($queryId);
    }

    if($retiros){
      self::getRetiros($queryId);
    }

    return $this->getProperties();
  }

  public function getProperties(){
    return [
      "id" => $this->id,
      "repartidor" => $this->repartidor,
      'hasMovements'=>$this->hasMovements,
      'pedidos'=>$this->pedidos,
      'retiros'=>$this->retiros
    ];
  }
}
