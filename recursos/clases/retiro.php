<?php
include_once("conexionCs.php");

class Retiro extends Connection {

  public function createHistory($id, $ruta, $estado){
    $query = "REPLACE INTO historial_retiro (
                retiro_idretiro,
                ruta_idruta,
                movimiento,
                fecha
              ) VALUES (?,?,?,NOW())";
    $query = $this->prepare($query);
    $query->bind_param('iis', $id, $ruta, $estado);
    $this->execute($query);
    return 'ok';
  }

  public function entregarRetiro($id){
    $query = "UPDATE retiro 
              SET retiro.entrega = 1
              WHERE retiro.idretiro = ?";
    $query = $this->prepare($query);
    $query->bind_param('i', $id);
    $this->execute($query);
    return 'ok';
  }
}
