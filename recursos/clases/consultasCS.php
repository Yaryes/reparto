<?php
require("conexionCs.php");

class consultas extends Connection
{

    function __construct()
    {
        parent::__construct();
        return $this;
    }
    public function consultaC()
    {

        $args = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();
        //SELECT C.nombre, C.direcion, C.sector, C.telefono,P.idpedido
        // FROM consultora C 
        //INNER JOIN pedido P ON P.consultora_idconsultora = c.idconsultora 
        //WHERE idconsultora ='585465'

        $sql = "SELECT C.nombre, C.direcion, C.sector, C.telefono,P.idpedido
        FROM consultora C 
        LEFT JOIN pedido P ON P.consultora_idconsultora = c.idconsultora 
        WHERE idconsultora =?";


        $consulta = $this->prepare($sql);
        $consulta->bind_param('i', $codigo);
        $codigo = $args['codigo'];

        $this->execute($consulta);
        $consulta->bind_result($nombre_consultora, $direccion_consultora, $sector_consultora, $telefono_consultora, $idpedido);
        //$consulta->fetch();

        $c = 0;
        $pedidos = array();
        while ($consulta->fetch()) {
            if (!empty($idpedido)) {
                $c++;
                $pedidos['cantidad'] = $c;
                array_push($pedidos, $idpedido);
            }
        }
        $consulta->close();

        if ($nombre_consultora != "") {
            $r = array(
                'existe' => true,
                'nombre_consultora' => $nombre_consultora,
                'direccion_consultora' => $direccion_consultora,
                'sector_consultora' => $sector_consultora,
                'telefono_consultora' => $telefono_consultora,
                'pedidos' => $pedidos
            );
        } else {
            $r = array(
                'existe' => false
            );
        }


        return json_encode($r);
    }

    public function consultaE()
    {

        $args = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();
        //SELECT usuario_rut,ruta_idruta,DATE_FORMAT(`fecha`, "%d-%m-%Y %k:%i"),estado_de_movimiento
        //FROM historial_pedido
        //WHERE pedido_idpedido ='2004131734'
        //ORDER BY fecha DESC

        $sql = "SELECT usuario_rut,ruta_idruta,DATE_FORMAT(fecha, '%d-%m-%Y %k:%i'),estado_de_movimiento
        FROM historial_pedido
        WHERE pedido_idpedido =?
        ORDER BY fecha DESC";


        $consulta = $this->prepare($sql);
        $consulta->bind_param('i', $codigo);
        $codigo = $args['codigo'];

        $this->execute($consulta);
        $consulta->bind_result($usuario_rut, $ruta_idruta, $fecha, $estado_de_movimiento);
        //$consulta->fetch();

        $c = 0;
        $r = array();
        while ($consulta->fetch()) {
            $c++;
            $r['cantidad'] = $c;
            array_push($r, ['usuario_rut' => $usuario_rut, 'ruta_idruta' => $ruta_idruta, 'fecha' => $fecha, 'estado_de_movimiento' => $estado_de_movimiento]);
        }




        $consulta->close();
        if (count($r) > 0) {
            $r['existe'] = true;
        } else {
            $r = array(
                'existe' => false
            );
        }
        return json_encode($r);
    }
    public function consultaP()
    {

        $args = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();
        //SELECT `usuario_rut`,`ruta_idruta`,`fecha`,`estado_de_movimiento` 
        //FROM `historial_pedido` 
        //WHERE `pedido_idpedido` ='2004108696' 
        //ORDER BY fecha DESC ;

        $sql = "SELECT pedido_idpedido, usuario_rut,ruta_idruta,DATE_FORMAT(fecha,'%d-%m-%Y %k:%i'),estado_de_movimiento
        FROM historial_pedido
        WHERE pedido_idpedido =? 
        ORDER BY fecha DESC LIMIT 1";


        $consulta = $this->prepare($sql);
        $consulta->bind_param('i', $codigo);
        $codigo = $args['codigo'];

        $this->execute($consulta);
        $consulta->bind_result($pedido_idpedido, $usuario_rut, $ruta_idruta, $fecha, $estado_de_movimiento);
        $consulta->fetch();
        $consulta->close();
        if ($estado_de_movimiento != "") {
            $r = array(
                'existe' => true,
                'pedido_idpedido' => $pedido_idpedido,
                'usuario_rut' => $usuario_rut,
                'ruta_idruta' => $ruta_idruta,
                'fecha' => $fecha,
                'estado_de_movimiento' => $estado_de_movimiento
            );
        } else {
            $r = array(
                'existe' => false
            );
        }
        return json_encode($r);
    }
}
$consultas = new consultas;
