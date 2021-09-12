<?php
include_once("conexionCs.php");

class Regalo extends Connection {

  private $id;
  private $nombre;

  public function create($ruta, $repartidor){
  }

  public function find($queryId){
    $query = "SELECT 
                regalo.idbolsa, 
                regalo.nombre 
              FROM regalo 
              WHERE regalo.idbolsa = ?";

    $query = $this->prepare($query);
    $query->bind_param('i', $queryId);
    $this->execute($query);
    $query->bind_result($this->id, $this->nombre);
    $query->fetch();

    return $this->getProperties();
  }

  public function getProperties(){
    return [
      "id" => $this->id,
      "nombre" => $this->nombre
    ];
  }
}
