<?php
require("conexionCs.php");

class load extends Connection
{

    function __construct()
    {
        parent::__construct();
        return $this;
    }


    public function loadex()
    {

        $data = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();

        $consuConsultora = "SELECT idconsultora FROM consultora WHERE idconsultora = ?";
        $consultaConsultora = $this->prepare($consuConsultora);
        $consultaConsultora->bind_param('i', $id);
        $id = $data['codigo'];
        $this->execute($consultaConsultora);
        $consultaConsultora->bind_result($id_bd);
        $consultaConsultora->fetch();
        $consultaConsultora->close();

        if ($id_bd == "") {
            //CONSULTORA
            $sqlInsertarCon = "INSERT INTO consultora (idconsultora, nombre, direcion, zona,seccion, telefono, sector) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $queryInsertarCon = $this->prepare($sqlInsertarCon);
            $id = $data['codigo'];
            $nombre = $data['nombre'];
            $direccion = $data['direccion'];
            $zona = $data['zona'];
            $seccion = $data['seccion'];
            $telefono = $data['telefono'];
            $sector = $data['sector'];

            $queryInsertarCon->bind_param('issssss', $id, $nombre, $direccion, $zona, $seccion, $telefono, $sector);
            if (!$queryInsertarCon->execute()) {
                trigger_error("there was an error...." . $queryInsertarCon->error, E_USER_WARNING);
            }
            $queryInsertarCon->execute();
            $queryInsertarCon->close();

            $countConsu = 1;
        } else {
            $countConsu = 0;
        }

        //PEDIDO
        $consuPedido = "SELECT idpedido FROM pedido WHERE idpedido = ?";
        $consultaPedido = $this->prepare($consuPedido);
        $consultaPedido->bind_param('i', $pedido);
        $pedido = $data['pedido'];
        $this->execute($consultaPedido);
        $consultaPedido->bind_result($pedido_bd);
        $consultaPedido->fetch();
        $consultaPedido->close();


        if ($pedido_bd == "") {

            $sqlInsertarPed = "INSERT INTO pedido (idpedido, consultora_idconsultora , piezas, campana) 
     VALUES (?, ?, ?, ?);";

            $queryInsertarPed = $this->prepare($sqlInsertarPed);

            $id = $data['pedido'];
            $pedido = $data['codigo'];
            $cantidad = $data['cajas'];
            $campana = $data['campana'];
            $queryInsertarPed->bind_param('iiii', $id, $pedido, $cantidad, $campana);
            if (!$queryInsertarPed->execute()) {
                trigger_error("there was an error...." . $queryInsertarPed->error, E_USER_WARNING);
            }
            $queryInsertarPed->close();

            //INSERT INTO historial_pedido ( pedido_idpedido , usuario_rut, fecha,estado_de_movimiento) 
            //VALUES ( '2004128423', '11.111.111-1', NOW(),'ARRIBADO')
            $sqlInsertarHPed = "INSERT INTO historial_pedido ( pedido_idpedido , usuario_rut, estado_de_movimiento,fecha) 
            VALUES (?, ?, ?,now());";

            $queryInsertarHPed = $this->prepare($sqlInsertarHPed);
            $usuario = $data['user'];
            $movimientoPed = "EN FACTURA";

            $queryInsertarHPed->bind_param('iss', $id, $usuario, $movimientoPed);
            $queryInsertarHPed->execute();
            $queryInsertarHPed->close();




            $countPedido = 1;
        } else {
            $countPedido = 0;
        }


        if ($data['codbolsa'] != 0) {
            //BOLSA
            $consuBolsa = "SELECT idbolsa FROM regalo WHERE idbolsa = ?";
            $consultaBolsa = $this->prepare($consuBolsa);
            $consultaBolsa->bind_param('i', $codbolsa);
            $codbolsa = $data['codbolsa'];
            $this->execute($consultaBolsa);
            $consultaBolsa->bind_result($codbolsa_bd);
            $consultaBolsa->fetch();
            $consultaBolsa->close();


            if ($codbolsa_bd == "") {


                $sqlInsertarBol = "INSERT INTO regalo (idbolsa, nombre) 
                    VALUES (?, ?);";

                $queryInsertarBol = $this->prepare($sqlInsertarBol);
                $nombrebolsa = $data['nombrebolsa'];
                $queryInsertarBol->bind_param('is', $codbolsa, $nombrebolsa);
                if (!$queryInsertarBol->execute()) {
                    trigger_error("there was an error...." . $queryInsertarBol->error, E_USER_WARNING);
                }
                $queryInsertarBol->close();





                $countTipoBolsa = 1;
            } else {
                $countTipoBolsa = 0;
            }

            //REGALO HAS PEDIDO


            $consuRegalo = "SELECT pedido_idpedido FROM pedido_has_regalo WHERE (regalo_idbolsa = ?) AND (pedido_idpedido =?)";
            $consultaRegalo = $this->prepare($consuRegalo);
            $consultaRegalo->bind_param('ii', $codbolsa, $pedido);
            $pedido = $data['pedido'];
            $this->execute($consultaRegalo);
            $consultaRegalo->bind_result($regalo_bd);
            $consultaRegalo->fetch();
            $consultaRegalo->close();

            if ($regalo_bd == "") {



                $sqlInsertarBolPed = "INSERT INTO pedido_has_regalo(pedido_idpedido, regalo_idbolsa, cantidad) 
            VALUES (?, ?, ?);";

                $queryInsertarBolPed = $this->prepare($sqlInsertarBolPed);
                $cantidadbolsa = $data['cantidadbolsa'];


                $queryInsertarBolPed->bind_param('iii', $pedido, $codbolsa, $cantidadbolsa);
                if (!$queryInsertarBolPed->execute()) {
                    trigger_error("there was an error...." . $queryInsertarBolPed->error, E_USER_WARNING);
                }
                $queryInsertarBolPed->close();


                $countBolsa = 1;
            } else {
                $countBolsa = 0;
            }
        } else {
            $countTipoBolsa = 0;
            $countBolsa = 0;
        }


        //RETIRO

        $codretiro = $data['codretiro'];

        if ($codretiro != "") {

            $consuRetiro = "SELECT idretiro FROM retiro WHERE idretiro = ?";
            $consultaRetiro = $this->prepare($consuRetiro);
            $consultaRetiro->bind_param('i', $codretiro);
            $this->execute($consultaRetiro);
            $consultaRetiro->bind_result($codretiro_bd);
            $consultaRetiro->fetch();
            $consultaRetiro->close();

            if ($codretiro_bd == "") {
                $sqlInsertarRet = "INSERT INTO retiro (idretiro, consultora_idconsultora, piezas) 
            VALUES (?, ?, ?);";

                $queryInsertarRet = $this->prepare($sqlInsertarRet);
                $cantretiro = $data['cantretiro'];
                $id = $data['codigo'];


                $queryInsertarRet->bind_param('iii', $codretiro, $id, $cantretiro);
                if (!$queryInsertarRet->execute()) {
                    trigger_error("there was an error...." . $queryInsertarRet->error, E_USER_WARNING);
                }
                $queryInsertarRet->close();


                $sqlInsertarHRet = "INSERT INTO historial_retiro (retiro_idretiro, movimiento, fecha) 
                VALUES (?, ?, now());";

                $sqlInsertarHRet = $this->prepare($sqlInsertarHRet);
                $movimientoRet = "EN FACTURA";

                $sqlInsertarHRet->bind_param('ii', $codretiro, $movimientoRet);
                if (!$sqlInsertarHRet->execute()) {
                    trigger_error("there was an error...." . $sqlInsertarHRet->error, E_USER_WARNING);
                }
                $sqlInsertarHRet->close();





                $countRetiro = 1;
            } else {
                $countRetiro = 0;
            }
        } else {
            $countRetiro = 0;
        }

 


        $info = array(
            'countConsu' => $countConsu,
            'countPedido' => $countPedido,
            'countTipoBolsa' => $countTipoBolsa,
            'countBolsa' => $countBolsa,
            'countRetiro' => $countRetiro,
        

        );
        return json_encode($info);
    }
}
$load = new load;
