<?php
require("conexionCs.php");
/*
include('../clases/arriboCs.php');

$codigo = $_POST['codigo'];
if ($codigo!=""){
    $params = array(
       'codigo' => $codigo);
       $respuesta=json_decode($arribo->consulta($params));
    echo $respuesta;}

    */


class arribo extends Connection
{

    function __construct()
    {
        parent::__construct();
        return $this;
    }
    public function consulta()
    {

        $args = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();
        //SELECT P.idpedido, P.consultora_idconsultora, P.piezas, R.cantidad, G.nombre FROM pedido P 
        //INNER JOIN pedido_has_regalo R On P.idpedido = R.pedido_idpedido 
        //INNER JOIN regalo G ON g.idbolsa = R.regalo_idbolsa WHERE idpedido = '2004109175'
        $sql = "SELECT P.consultora_idconsultora, P.piezas, R.cantidad, G.nombre, C.direcion FROM pedido P 
        LEFT JOIN pedido_has_regalo R On P.idpedido = R.pedido_idpedido 
        LEFT JOIN regalo G ON g.idbolsa = R.regalo_idbolsa 
        lEFT JOIN consultora C ON C.idconsultora = P.consultora_idconsultora WHERE idpedido = ?";
        $consulta = $this->prepare($sql);
        $consulta->bind_param('i', $codigo);
        $codigo = $args['codigo'];

        $this->execute($consulta);
        $consulta->bind_result($consultora_idconsultora, $piezas, $cantidad_regalo, $nombre_regalo, $direccion);
        //$consulta->fetch();

        $c = 0;
        $regalo = array(
            'nombre_regalo' =>  array(),
            'cantidad_regalo' =>  array()
        );
        while ($consulta->fetch()) {
            if (!empty($nombre_regalo)) {
                $c++;
                $regalo['cantidad'] = $c;
                $regalo['nombre_regalo'][$c] = $nombre_regalo;
                $regalo['cantidad_regalo'][$c] = $cantidad_regalo;
            }
        }
        $consulta->close();

        if ($consultora_idconsultora != "") {
            $r = array(
                'existe' => true,
                'piezas' => $piezas,
                'direccion' => $direccion,
                'regalo' => $regalo,
            );
        } else {
            $r = array(
                'existe' => false
            );
        }


        return json_encode($r);
    }
    public function save()
    {

        $args = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();


        //INSERT INTO historial_pedido (historial_pedidocol, pedido_idpedido, usuario_rut, ruta_idruta, fecha, estado_de_movimiento) 
        //VALUES (NULL, ?, '11.111.111-1', NULL,  NOW(), 'ARRIBADO')
        $sql = "INSERT INTO historial_pedido (historial_pedidocol, pedido_idpedido, usuario_rut, ruta_idruta, fecha, estado_de_movimiento) 
        VALUES (NULL, ?, ?, NULL,  NOW(), 'ARRIBADO')";
        $consulta = $this->prepare($sql);
        $codigo = $args['codigo'];
        $user = $args['user'];


        $consulta->bind_param('is', $codigo,$user);

        $this->execute($consulta);

        $resp = $consulta->close();

    
        $r = array(
            'resp' => $resp
        );

        return json_encode($r);
    }
}
$arribo = new arribo;












/*
require("conexionCs.php");



//recepción de code
$codigo = $_POST['codigo'];
$respuesta = json_encode($codigo);
echo $respuesta ;









/*
$sql = "SELECT consultora_idconsultora, piezas, campana FROM pedido WHERE idpedido=?";


$consulta = $this->prepare($sql);
$consulta->bind_param('i',$codigo);
$codigo = $codigo;
$this->execute($consulta);

$consulta->bind_result($consultora_idconsultora,$piezas,$campana);
$consulta->fetch();
*/
