<?php 
session_start();
require_once('../../conexion.php');
require_once('../../admin/models/administrar_orden_trabajo.php');
require_once('../../admin/models/administrar_mantenimieno_preventivo.php');
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
    case 'traerDetalleOrdenTrabajoApp':
      echo $orden_trabajo->traerDetalleOrdenTrabajo($id_orden_trabajo);
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
    case 'traerAdjuntos':
      echo $orden_trabajo->traerAdjuntos($id_orden_trabajo);
    break;
    case 'adjuntarArchivo':
      $file = $_FILES['file'];
      $orden_trabajo->adjuntarArchivo($id_orden_trabajo, $file, $comentarios);
    break;
    case "agregarMateriales":

      //var_dump($materiales_agregar);
      /*$materiales_agregar=json_decode($materiales_agregar,true);
      var_dump($materiales_agregar);*/
      foreach ($materiales_agregar as $material) {

        $id_item=$material["item"];
        $id_proveedor=$material["proveedor"];
        $id_almacen=$material["almacen"];
        $cantidad_reservada=$material["cantidad"];

        $orden_trabajo->agregarMaterialesOrdenTrabajo($id_orden_trabajo, $id_item, $id_proveedor, $id_almacen, $cantidad_reservada);
      }

      /*$id_calendario_mantenimiento=$id_tarea_agregar_materiales;
      $id_almacen=$id_almacen_agregar_materiales;
      $aItems=json_decode($materiales_agregar,true);

      $mantenimiento_preventivo = new MantenimientoPreventivo();
      $mantenimiento_preventivo->agregarMaterialesMantenimientoPreventivo($id_calendario_mantenimiento, $id_almacen, $aItems);*/
      
    break;
  }
}
?>