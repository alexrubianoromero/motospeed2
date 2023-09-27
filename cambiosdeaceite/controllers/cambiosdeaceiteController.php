<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/cambiosdeaceite/views/cambiosdeaceiteVista.php');
require_once($raiz.'/cambiosdeaceite/models/CambiosDeAceiteModel.php');
require_once($raiz.'/vehiculos/modelo/VehiculosModelo.php');

class cambiosdeaceiteController
{
    protected $vista;
    protected $model;
    protected $modelVehiculos;
    
    public function __construct()
    {
        $this->vista = new cambiosdeaceiteVista();
        $this->model = new CambiosDeAceiteModel();
        $this->modelVehiculos = new VehiculosModelo();

        if(!isset($_REQUEST['opcion']) || $_REQUEST['opcion']=='' )
        {
            $this->menuPrincipal();
        }
        if($_REQUEST['opcion']=='pregunteNuevoCambioAceite')
        {
            $this->pregunteNuevoCambioAceite($_REQUEST);
        }
        if($_REQUEST['opcion']=='grabarCambioAceite')
        {
            $this->grabarCambioAceite($_REQUEST);
        }
        if($_REQUEST['opcion']=='historialCambiosDeAceite')
        {
            $this->historialCambiosDeAceite($_REQUEST);
        }
        if($_REQUEST['opcion']=='historialCambiosDeAceiteFecha')
        {
            $this->historialCambiosDeAceiteFecha($_REQUEST);
        }



    }
    public function menuPrincipal()
    {
        $this->vista->menuPrincipal();
    }
    
    public function pregunteNuevoCambioAceite($request)
    {
        $this->vista->pregunteNuevoCambioAceite($request['placa']);
    }
    
    public function grabarCambioAceite($request)
    {
        $this->model->grabarCambioAceite($request);
        echo 'Cambio de aceite grabado '; 
    }
    
    public function historialCambiosDeAceite($request)
    {
        $datosVehiculo= $this->modelVehiculos->buscarPlacaSimple($request['placa']);
        // echo '<pre>'; 
        // print_r($datosVehiculo); 
        // echo '</pre>';
        if($datosVehiculo['filas']=='0')
        {
            echo 'No existe placa';
        }
        else{
            
            $historiales=$this->model->traerHistorialPlaca($request['placa']); 
            $this->vista->historialCambiosDeAceite($datosVehiculo,$historiales);
        }
        
    }
    
    public function historialCambiosDeAceiteFecha($request)
    {
        $infoCambio = $this->model->traerCambioAceiteId($request['id']);
        $this->vista->mostrarInfoCambioAceite($infoCambio);
    }

    
}

?>