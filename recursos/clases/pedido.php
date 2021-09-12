<?php
include_once("conexionCs.php");
include_once("regalo.php");

class Pedido extends Connection
{

  private $id;
  private $idconsultora;
  private $direccion;
  private $piezas;
  private $campana;
  private $entrega;
  private $ruta;
  private $estadoPedido;
  private $regalos = [];
  private $retiros = [];

  public function create()
  {
  }

  private function getPedido($queryId)
  {
    $query = "SELECT 
                pedido.idpedido,
                pedido.consultora_idconsultora as idconsultora,
                consultora.direcion, 
                pedido.piezas,
                pedido.campana,
                pedido.entrega
              FROM pedido 
              INNER JOIN consultora
              ON pedido.consultora_idconsultora = consultora.idconsultora
              WHERE pedido.idpedido = ?";

    $query = $this->prepare($query);
    $query->bind_param('i', $queryId);
    $this->execute($query);
    $query->bind_result($this->id, $this->idconsultora, $this->direccion, $this->piezas, $this->campana, $this->entrega);
    $query->fetch();
  }

  private function getRegalos($queryId)
  {
    $query = "SELECT 
                pedido_has_regalo.regalo_idbolsa, 
                pedido_has_regalo.cantidad
              FROM pedido 
              INNER JOIN pedido_has_regalo
              ON pedido.idpedido = pedido_has_regalo.pedido_idpedido
              WHERE pedido.idpedido = ?";

    $query = $this->prepare($query);
    $query->bind_param('i', $queryId);
    $this->execute($query);
    $idRegalo = null;
    $cantidad = null;
    $query->bind_result($idRegalo, $cantidad);
    while ($query->fetch()) {
      $regalo = new Regalo();
      $regalo = $regalo->find($idRegalo);

      array_push($this->regalos, [
        "id" => $regalo['id'],
        "regalo" => $regalo['nombre'],
        "cantidad" => $cantidad
      ]);
    }
  }

  private function getRetiros($queryId)
  {
    $query = "SELECT 
                 retiro.idretiro, 
                 retiro.piezas 
               FROM retiro 
               WHERE retiro.consultora_idconsultora = ?";

    $query = $this->prepare($query);
    $query->bind_param('i', $queryId);
    $this->execute($query);
    $idRetiro = null;
    $piezas = null;
    $query->bind_result($idRetiro, $piezas);
    while ($query->fetch()) {
      array_push($this->retiros, [
        "id" => $idRetiro,
        "piezas" => $piezas,
      ]);
    }
  }

  private function getEstadoPedido($queryId)
  {
    $query = "SELECT 
                historial_pedido.estado_de_movimiento
              FROM historial_pedido 
              WHERE historial_pedido.pedido_idpedido = ? 
              ORDER BY fecha DESC LIMIT 1";
    $query = $this->prepare($query);
    $query->bind_param('i', $queryId);
    $this->execute($query);
    $query->bind_result($this->estadoPedido);
    $query->fetch();
  }

  public function find($queryId)
  {
    self::getPedido($queryId);
    self::getRegalos($queryId);
    self::getRetiros($this->idconsultora);
    self::getEstadoPedido($queryId);

    return $this->getProperties();
  }

  public function createHistory($id, $ruta, $estado)
  {
    $query = "REPLACE INTO historial_pedido (
                pedido_idpedido,
                ruta_idruta,
                fecha,
                estado_de_movimiento
              ) VALUES (?,?, NOW(),?)";
    $query = $this->prepare($query);
    $query->bind_param('iis', $id, $ruta, $estado);
    $this->execute($query);
  }

  public function entregarPedido($id){
    $query = "UPDATE pedido 
              SET pedido.entrega = 1
              WHERE pedido.idpedido = ?";
    $query = $this->prepare($query);
    $query->bind_param('i', $id);
    $this->execute($query);
    return 'ok';
  }

  public function getProperties()
  {
    return [
      "id" => $this->id,
      "idconsultora" => $this->idconsultora,
      "direccion" => $this->direccion,
      "piezas" => $this->piezas,
      "campana" => $this->campana,
      "regalos" => $this->regalos,
      "retiros" => $this->retiros,
      "estadoPedido" => $this->estadoPedido,
      "entrega"=> $this->entrega
    ];
  }
}
