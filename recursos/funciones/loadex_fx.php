<?php
if ($_FILES['file']['tmp_name']!= null) {
require '../clases/PHPExcel.php';
session_start();
include('../clases/loadexCs.php');

$filePath = $_FILES['file']['tmp_name'];


$inputFileType = 'Excel2007';

class SampleReadFilter implements PHPExcel_Reader_IReadFilter {
    public function readCell($column, $row, $worksheetName = '') {
		if ($row >= 1 && $row <= 1000) {
		   if ($column=='A'||$column=='B'||$column=='C'||$column=='D'||$column=='E'||$column=='F'||$column=='G'
		   ||$column=='I'||$column=='J'||$column=='K'||$column=='L'||$column=='M'||$column=='U'
		   ||$column=='V'||$column=='W'||$column=='AC') {
             return true;
           }
		}
        return false;
    }
}

$fill= new SampleReadFilter();
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setReadDataOnly(true);
$objReader->setReadFilter($fill);
$objPHPExcel = $objReader->load($filePath);
$count=0;
$countConsu=0;
$countPedido=0;
$countRetiro=0;
$countTipoBolsa=0;
$countBolsa=0;



if ($objPHPExcel->getActiveSheet()->getCell('D1')->getValue() == "CONSULTORA") {
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	for ($i = 1; $i <= $numRows; $i++) {
		$zona = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getValue();
		if ($zona == "1115") {
			$count ++ ;
			$codigo = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getValue();
			$seccion = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getValue();
			$nombre = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getValue();
			$direccion = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getValue();
			$sector = $objPHPExcel->getActiveSheet()->getCell('AC' . $i)->getValue();
			$telefono = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getValue();
			$pedido = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getValue();
			$cajas = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getValue();
			$codbolsa = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getValue();
			$bolsa = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getValue();
			$cantbolsa = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getValue();
			$campana=$objPHPExcel->getActiveSheet()->getCell('U' . $i)->getValue();
			$codretiro=$objPHPExcel->getActiveSheet()->getCell('V' . $i)->getValue();
			$cantretiro=$objPHPExcel->getActiveSheet()->getCell('W' . $i)->getValue();
			$params = array(
				//CONSULTORA
				'codigo' => $codigo,
				'nombre' => $nombre,
				'direccion' => $direccion,
				'zona' => $zona,
				'seccion' => $seccion,
				'telefono' => $telefono,
				'sector' => $sector,
				//PEDIDO
		
				'pedido' => $pedido,
				'cajas' => $cajas,
				'campana' => $campana,
				
				//BOLSAS
				'codbolsa' => $codbolsa,
				'nombrebolsa' => $bolsa,
				'cantidadbolsa' => $cantbolsa,
				//RETIROS
				'codretiro' => $codretiro,
				'cantretiro' => $cantretiro,
				'user'=> $_SESSION ['user']['rut']
			);
			$respuesta = json_decode($load->loadex($params));
		$countConsu = $countConsu + $respuesta->countConsu; 
		$countTipoBolsa = $countTipoBolsa + $respuesta->countTipoBolsa; 
		$countPedido = $countPedido + $respuesta->countPedido; 
		$countBolsa = $countBolsa + $respuesta->countBolsa; 
		$countRetiro = $countRetiro + $respuesta->countRetiro; 
		}

	}
	$totales = $countConsu + $countPedido + $countTipoBolsa + $countRetiro;

	
        $respuesta = array(
            'existe' => true,
			'conteo'=> $count,
			'countConsu' => $countConsu,
            'countPedido' => $countPedido,
            'countTipoBolsa' => $countTipoBolsa,
            'countBolsa' => $countBolsa,
            'countRetiro' => $countRetiro,
			'totales' => $totales
        );
        $respuesta = json_encode($respuesta);
        echo $respuesta;

} else {
	$respuesta = array(
		'existe' => false
	);
	$respuesta = json_encode($respuesta);
	echo $respuesta;
}
} else {
    header('Location: ../../index.html');
}

?>
