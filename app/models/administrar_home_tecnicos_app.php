<?php 
session_start();
require_once('../../conexion.php');
require_once('../../admin/models/administrar_orden_trabajo.php');
extract($_REQUEST);

class DashboardTecnicos{
		
		private $id_proveedor;
		private $id_cc;
		private $id_orden;

		public function __construct(){

			$this->conexion = new Conexion();
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosIniciales($id_tecnico,$filtros){

			$this->id_tecnico = $id_tecnico;

      $filtro_desde="";
      $filtro_hasta="";
      if($filtros!=0){
          if(isset($filtros["fecha_desde"]) and $filtros["fecha_desde"]!=""){
            $filtro_desde=" AND ot.id = ".$filtros["fecha_desde"];
          }
          if(isset($filtros["fecha_hasta"]) and $filtros["fecha_hasta"]!=""){
            $filtro_hasta=" AND ot.id = ".$filtros["fecha_hasta"];
        }
      }

      $filtros["id_tecnico"]=$id_tecnico;

      $orden_trabajo = new OrdenTrabajo();
      $aOrdenesTrabajoTecnico=$orden_trabajo->traerOrdenTrabajo($filtros);
      $aOrdenesTrabajoTecnico=json_decode($aOrdenesTrabajoTecnico,true);
      //var_dump($aOrdenesTrabajoTecnico);

      $cantOrdenesTrabajo=count($aOrdenesTrabajoTecnico);

			$arrayDatosIniciales['cant_ordenes_trabajo'] = $cantOrdenesTrabajo;
			$arrayDatosIniciales['ordenes_trabajo_tecnico'] = $aOrdenesTrabajoTecnico;

			return json_encode($arrayDatosIniciales);
		}

		public function traerDetalleOrdenTrabajo($id_orden_trabajo){

      $filtros["id_orden_trabajo"]=$id_orden_trabajo;

			$orden_trabajo = new OrdenTrabajo();
      $detalle_orden_trabajo=$orden_trabajo->traerOrdenTrabajo($filtros);
      $detalle_orden_trabajo=json_decode($detalle_orden_trabajo,true);

      $materiales_orden_trabajo=$orden_trabajo->traerMaterialesOrdenTrabajo($id_orden_trabajo);
      $materiales_orden_trabajo=json_decode($materiales_orden_trabajo,true);

      $tecnicos_orden_trabajo=$orden_trabajo->traerTecnicosOrdenTrabajo($id_orden_trabajo);
      $tecnicos_orden_trabajo=json_decode($tecnicos_orden_trabajo,true);

      //var_dump($aOrdenesTrabajoTecnico);
			$arrayDatosIniciales['detalle_orden_trabajo'] = $detalle_orden_trabajo[0];
			$arrayDatosIniciales['materiales_orden_trabajo'] = $materiales_orden_trabajo;
      $arrayDatosIniciales['tecnicos_orden_trabajo'] = $tecnicos_orden_trabajo;

			return json_encode($arrayDatosIniciales);
		}

	}

	if (isset($_POST['accion'])) {
		
		$dashboardTecnicos = new DashboardTecnicos();
    $orden_trabajo = new OrdenTrabajo();

		switch ($_POST['accion']) {
			case 'traerDatosOrdenesTrabajoTecnico':
				//$id_tecnico = $_POST['id_tecnico'];
        $filtros=[];
        if(isset($fdesde)) $filtros["fecha_desde"]=$fdesde;
        if(isset($fhasta)) $filtros["fecha_hasta"]=$fhasta;
				
        echo $dashboardTecnicos->traerDatosIniciales($id_tecnico,$filtros);
			break;
      case 'traerDetalleOrdenTrabajo':
        echo $dashboardTecnicos->traerDetalleOrdenTrabajo($id_orden_trabajo);
      break;
      case 'marcarCargadoMaterial':
        $orden_trabajo->marcarCargadoMaterial($id_orden_trabajo,$id_item,$id_proveedor,$id_almacen);
      break;
      case 'darInicioOrdenTrabajoTecnico':
        $orden_trabajo->darInicioOrdenTrabajoTecnico($id_orden_trabajo,$id_tecnico);
      break;
      case 'finalizarOrden':
        //var_dump($datosFinalizarOrden);
        $orden_trabajo->finalizarOrden($id_orden_trabajo,$id_tecnico,$datosFinalizarOrden);
      break;
      
		}
	}


?>