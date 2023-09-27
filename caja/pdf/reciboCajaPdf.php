<?php
$raiz= $_SERVER['DOCUMENT_ROOT'];
date_default_timezone_set('America/Bogota');
require_once($raiz.'/fpdf/fpdf.php');
$ruta = dirname(dirname(dirname(__FILE__)));
require_once($ruta .'/orden/modelo/OrdenesModelo.class.php');
require_once($ruta .'/inventario_codigos/modelo/CodigosInventarioModelo.php');
require_once($ruta .'/caja/model/ReciboCajaModelo.php');
// die($ruta);
// require_once($ruta .'/vehiculos/modelo/VehiculosModelo.php');
$reciboModel = new ReciboCajaModelo(); 
$orden = new OrdenesModelo();
$infoCode = new CodigosInventarioModelo();
// $vehiculo = new VehiculosModelo(); 
$datosRecibo = $reciboModel->traerReciboPorId($_REQUEST['id_recibo']); 
$datoOrden = $orden->traerOrdenId($_REQUEST['idOrden']);
$datosCarro = $orden->traerDatosCarroConPlaca($datoOrden['placa']);
$datosCliente = $orden->traerDatosPropietarioConPlaca($datosCarro['propietario']); 
$datosItems = $orden->traerItemsAsociadosOrdenPorIdOrden($_REQUEST['idOrden']); 

if($datosRecibo['tipo_recibo']==1)
{
    $nombreRecibo = 'INGRESO';
}

if($datosRecibo['tipo_recibo']==2)
{
    $nombreRecibo = 'EGRESO';
}



$pdf=new FPDF();

$pdf->AddPage();
$pdf->Ln(5);
$pdf->Ln(5);
$pdf->Ln(5);
$pdf->Image('../../logos/logokaymo.png',15,20,50);
$pdf->SetFont('Arial','B',15);
    // Movernos a la derecha
$pdf->Cell(80);
    // T�tulo
$pdf->Cell(70,10,'RECIBO DE '.$nombreRecibo ,1,0,'');
$pdf->Cell(19,10,$datosRecibo['id_recibo'],1,1,'');

    
$pdf->SetFont('Arial','',10);
$pdf->Ln(5);

$pdf->Cell(80);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,6,'Fecha',1,0,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(49,6,$datosRecibo['fecha_recibo'],1,1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(80);
$pdf->Cell(40,6,'Cliente',1,0,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(49,6,$datosRecibo['dequienoaquin'],1,1,'C');
$pdf->Cell(80);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,6,'Total ',1,0,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(49,6,number_format($datosRecibo['lasumade'],0,",","."),1,1,'C');


$pdf->Cell(17);
$pdf->Cell(22,6,'KAYMO SOFTWARE',0,0,'C');
$pdf->Cell(41);
$pdf->Cell(89,6,'Observaciones',1,1,'C');
$pdf->Cell(17);
$pdf->Cell(22,6,'Nit:',0,0,'C');
$pdf->Cell(41);
$pdf->Cell(89,6,$datosRecibo['observaciones'],1,1,'C');

$anchoCol = 32; 
$pdf->Ln(5);
$pdf->Cell(10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell($anchoCol,6,'EFECTIVO',1,0,'C');
$pdf->Cell($anchoCol,6,'DEBITO',1,0,'C');
$pdf->Cell($anchoCol,6,'CREDITO',1,0,'C');
$pdf->Cell($anchoCol,6,'BANCOLOMBIA',1,0,'C');
$pdf->Cell($anchoCol,6,'BOLD',1,1,'C');

$pdf->Cell(10);
$pdf->SetFont('Arial','',10);
$pdf->Cell($anchoCol,6,number_format($datosRecibo['efectivo'],0,",","."),1,0,'C');
$pdf->Cell($anchoCol,6,number_format($datosRecibo['t_debito'],0,",","."),1,0,'C');
$pdf->Cell($anchoCol,6,number_format($datosRecibo['t_credito'],0,",","."),1,0,'C');
$pdf->Cell($anchoCol,6,number_format($datosRecibo['bancolombia'],0,",","."),1,0,'C');
$pdf->Cell($anchoCol,6,number_format($datosRecibo['bold'],0,",","."),1,1,'C');


$pdf->Output();

?>