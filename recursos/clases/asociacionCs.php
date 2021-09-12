<?php
require("conexionCs.php");


class asociacion extends Connection
{

    function __construct()
    {
        parent::__construct();
        return $this;
    }
    public function consulta()
    {

        $args = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();
        $sql = "SELECT C.direcion, P.idpedido FROM pedido P 
        LEFT JOIN consultora C ON C.idconsultora = P.consultora_idconsultora
        WHERE idpedido = ?";

        $consulta = $this->prepare($sql);
        $consulta->bind_param('i', $codigo);
        $codigo = $args['codigo'];

        $this->execute($consulta);
        $consulta->bind_result($direccion,$id);
        $consulta->fetch();

        $consulta->close();

        if ($direccion != "") {
            $r = array(
                'existe' => true,
                'direccion' => $direccion,
                'id' => $id

            );
        } else {
            $r = array(
                'existe' => false
            );
        }


        return json_encode($r);
    }
}
$asociacion = new asociacion;
