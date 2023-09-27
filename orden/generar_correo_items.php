<?php



// echo '<pre>';

// print_r($_REQUEST);

// echo '</pre>';



include('../valotablapc.php');



$sql_correo = "select cli.email as email from $tabla14 o

inner join $tabla4 c on (c.placa = o.placa)

inner join $tabla3 cli on (cli.idcliente=c.propietario)

where o.id = '".$_REQUEST['idorden']."'

";

$consulta_email= mysql_query($sql_correo,$conexion);

$arreglo_email = mysql_fetch_assoc($consulta_email);

$email = $arreglo_email['email'];



$sql_items= "select * from $tabla15 where no_factura =   '".$_REQUEST['idorden']."'  ";



//echo '<br>'.$sql_items;

$consulta_items = mysql_query($sql_items);

$texto_items ='';

$suma_items = '0';

while($items = mysql_fetch_assoc($consulta_items))

{	

 $texto_items = $texto_items.'*'.$items['descripcion'];

 $suma_items += $items['total_item'];

 //echo '<br>'.$items['descripcion'];

}

//echo '<br>'.$texto_items;

//echo '<br>'.$suma_items;



$body = 'KAYMO SOFTWARE 



Te informa el avance de tu orden de reparacion



Placa: '.$_REQUEST['placa'].'  Orden No: '.$_REQUEST['idorden'].'



TRABAJO A REALIZAR : '.$_REQUEST['descripcion'].'


https://www.alexrubiano.com/demo2/ordendetrabajo/'.$_REQUEST['idorden'].'

<br>

KAYMO SOFTWARE. 

Software Para Talleres

3124551226 



O envianos un E-mail a alexrubianoromero@gmail.com 

Recuerda, estamos ubicados en Bogota';



//echo '<br>'.$texto_items;



//echo '<br>body<br>'.$body.'<br>fin de body</br>';

//$body="prueba envio correo";

/*

$cuerpo_correo="crecion de orden";

*/

//////////////////////////////////////////////////////////////////	

/////////////////enviar el correo 

//mail($_REQUEST['email'],'MOTORCYCLE ROOM',$body,$headers); 

// include('enviar_correo_items.php');
$_REQUEST['email'] = $email ;
include('enviar_correo_phpmailer_avance.php');



?>