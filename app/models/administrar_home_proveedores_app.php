<?php 
	
	session_start();
	require_once('../../conexion.php');

	class DashboardCtaCte{
		
		private $id_proveedor;
		private $id_cc;
		private $id_orden;

		public function __construct(){

			$this->conexion = new Conexion();
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosIniciales($id_proveedor){

			$this->id_proveedor = $id_proveedor;
			$arrayDatosIniciales = array();

			/*CANTIDAD ORDENES DE COMPRA*/
			$queryGetCdadOC = "SELECT COUNT(1) as cant_oc 
								FROM ordenes_compra
								WHERE id_proveedor = $this->id_proveedor";
			$getCdadOC = $this->conexion->consultaRetorno($queryGetCdadOC);

			$rowCdadOC = $getCdadOC->fetch_assoc();

			/*CANTIDAD ORDENES DE COMPRA DETALLE*/
			$queryGetCdadOCD = "SELECT COUNT(1) as cantidad, est.estado
								FROM ordenes_compra as oc 
								JOIN estados_orden_compra as est
								ON(oc.id_estado = est.id)
								WHERE id_proveedor = $this->id_proveedor
								GROUP BY estado";
			$getCdadOCD = $this->conexion->consultaRetorno($queryGetCdadOCD);

			$arrayCdadOCD = array();

			while ($row=$getCdadOCD->fetch_assoc()) {
				$estado = $row['estado'];
				$cantidad = $row['cantidad'];

				$arrayCdadOCD[]=array('estado' =>$estado, 'cantidad'=>$cantidad);
			}

			/*MONTO TOTAL ORDENES DE COMPRA*/
			$queryGetMontoOC = "SELECT SUM(total) as total_oc
								FROM ordenes_compra
								WHERE id_proveedor = $this->id_proveedor";
			$getMontoOC = $this->conexion->consultaRetorno($queryGetMontoOC);

			$rowMontoOC = $getMontoOC->fetch_assoc();

			/*MONTO TOTAL ORDENES DE COMPRA DETALLE*/
			$queryGetMontoOCD = "SELECT SUM(oc.total) as total, est.estado
								FROM ordenes_compra as oc 
								JOIN estados_orden_compra as est
								ON(oc.id_estado = est.id)
								WHERE id_proveedor = $this->id_proveedor
								GROUP BY estado";
			$getMontoOCD = $this->conexion->consultaRetorno($queryGetMontoOCD);

			$arrayMontoOCD = array();

			while ($row=$getMontoOCD->fetch_assoc()) {
				$estado = $row['estado'];
				$total = $row['total'];

				$arrayMontoOCD[]=array('estado' =>$estado, 'total'=>$total);
			}

			/*ITEMS POR ENTREGA*/
			$queryGetProdXEntregar = "SELECT sum(cantidad-cantidad_recibida) as 				cdad_por_entregar
								FROM ordenes_compra as oc 
								JOIN ordenes_compra_detalle as ocd
								ON(oc.id = ocd.id_orden_compra)
								WHERE oc.id_proveedor = $this->id_proveedor
								AND oc.id_estado < 5
								AND (cantidad-cantidad_recibida) > 0";
			$getProdXEntregar = $this->conexion->consultaRetorno($queryGetProdXEntregar);

			$rowPXE = $getProdXEntregar->fetch_assoc();

			/*ITEM POR ENTREGAR DETALLE*/

			$queryGetProdXEntregarDetalle= "SELECT oc.id orden, it.id as id_item, 					it.item, (cantidad-cantidad_recibida) as 						por_entregar
								FROM ordenes_compra as oc 
								JOIN ordenes_compra_detalle as ocd
								ON(oc.id = ocd.id_orden_compra)
								JOIN item as it
								ON(ocd.id_item=it.id)
								WHERE oc.id_proveedor = $this->id_proveedor
								AND oc.id_estado < 5
								AND (cantidad-cantidad_recibida) > 0
								order by oc.id";
			$getProdXEntregarDetalle = $this->conexion->consultaRetorno($queryGetProdXEntregarDetalle);

			$arrayProdXEntregar = array();

			while ($rowPE = $getProdXEntregarDetalle->fetch_assoc()) {
				$orden = $rowPE['orden'];
				$id_item = $rowPE['id_item'];
				$item = $rowPE['item'];
				$por_entregar = number_format($rowPE['por_entregar'],0,',','.');
				$arrayProdXEntregar[]=array("orden"=>$orden, "id_item"=>$id_item, "item"=>$item, "por_entregar"=>$por_entregar);
			}


			$arrayDatosIniciales['cdad_oc'] = $rowCdadOC['cant_oc'];
			$arrayDatosIniciales['cantidad_oc_detalle'] = $arrayCdadOCD;
			$arrayDatosIniciales['monto_oc'] = $rowMontoOC['total_oc'];
			$arrayDatosIniciales['monto_oc_detalle'] = $arrayMontoOCD;
			$arrayDatosIniciales['prod_por_entregar'] = $total= number_format($rowPXE['cdad_por_entregar'],0,',','.');
			$arrayDatosIniciales['detalle_por_entregar'] = $arrayProdXEntregar;


			echo json_encode($arrayDatosIniciales);
		}

		public function traerPorFiltro($id_proveedor, $fdesde, $fhasta){

			$this->id_proveedor = $id_proveedor;
			$arrayDatosIniciales = array();

			/*CANTIDAD ORDENES DE COMPRA*/
			$queryGetCdadOC = "SELECT COUNT(1) as cant_oc 
								FROM ordenes_compra
								WHERE id_proveedor = $this->id_proveedor
								AND date_format(fecha, '%Y-%m-%d') between '$fdesde' and '$fhasta'";
			$getCdadOC = $this->conexion->consultaRetorno($queryGetCdadOC);

			$rowCdadOC = $getCdadOC->fetch_assoc();

			/*CANTIDAD ORDENES DE COMPRA DETALLE*/
			$queryGetCdadOCD = "SELECT COUNT(1) as cantidad, est.estado
								FROM ordenes_compra as oc 
								JOIN estados_orden_compra as est
								ON(oc.id_estado = est.id)
								WHERE id_proveedor = $this->id_proveedor
								AND date_format(fecha, '%Y-%m-%d') between '$fdesde' and '$fhasta'
								GROUP BY estado";
			$getCdadOCD = $this->conexion->consultaRetorno($queryGetCdadOCD);

			$arrayCdadOCD = array();

			while ($row=$getCdadOCD->fetch_assoc()) {
				$estado = $row['estado'];
				$cantidad = $row['cantidad'];

				$arrayCdadOCD[]=array('estado' =>$estado, 'cantidad'=>$cantidad);
			}

			/*MONTO TOTAL ORDENES DE COMPRA*/
			$queryGetMontoOC = "SELECT SUM(total) as total_oc
								FROM ordenes_compra
								WHERE id_proveedor = $this->id_proveedor
								AND date_format(fecha, '%Y-%m-%d') between '$fdesde' and '$fhasta'";
			$getMontoOC = $this->conexion->consultaRetorno($queryGetMontoOC);

			$rowMontoOC = $getMontoOC->fetch_assoc();

			/*MONTO TOTAL ORDENES DE COMPRA DETALLE*/
			$queryGetMontoOCD = "SELECT SUM(oc.total) as total, est.estado
								FROM ordenes_compra as oc 
								JOIN estados_orden_compra as est
								ON(oc.id_estado = est.id)
								WHERE id_proveedor = $this->id_proveedor
								AND date_format(fecha, '%Y-%m-%d') between '$fdesde' and '$fhasta'
								GROUP BY estado";
			$getMontoOCD = $this->conexion->consultaRetorno($queryGetMontoOCD);

			$arrayMontoOCD = array();

			while ($row=$getMontoOCD->fetch_assoc()) {
				$estado = $row['estado'];
				$total = $row['total'];

				$arrayMontoOCD[]=array('estado' =>$estado, 'total'=>$total);
			}

			/*ITEMS POR ENTREGA*/
			$queryGetProdXEntregar = "SELECT sum(cantidad-cantidad_recibida) as 				cdad_por_entregar
								FROM ordenes_compra as oc 
								JOIN ordenes_compra_detalle as ocd
								ON(oc.id = ocd.id_orden_compra)
								WHERE oc.id_proveedor = $this->id_proveedor
								AND date_format(fecha, '%Y-%m-%d') between '$fdesde' and '$fhasta'
								AND oc.id_estado < 5
								AND (cantidad-cantidad_recibida) > 0";
			$getProdXEntregar = $this->conexion->consultaRetorno($queryGetProdXEntregar);

			$rowPXE = $getProdXEntregar->fetch_assoc();

			/*ITEM POR ENTREGAR DETALLE*/

			$queryGetProdXEntregarDetalle= "SELECT oc.id orden, it.id as id_item, 					it.item, (cantidad-cantidad_recibida) as 						por_entregar
								FROM ordenes_compra as oc 
								JOIN ordenes_compra_detalle as ocd
								ON(oc.id = ocd.id_orden_compra)
								JOIN item as it
								ON(ocd.id_item=it.id)
								WHERE oc.id_proveedor = $this->id_proveedor
								AND date_format(fecha, '%Y-%m-%d') between '$fdesde' and '$fhasta'
								AND oc.id_estado < 5
								AND (cantidad-cantidad_recibida) > 0
								order by oc.id";
			$getProdXEntregarDetalle = $this->conexion->consultaRetorno($queryGetProdXEntregarDetalle);

			$arrayProdXEntregar = array();

			while ($rowPE = $getProdXEntregarDetalle->fetch_assoc()) {
				$orden = $rowPE['orden'];
				$id_item = $rowPE['id_item'];
				$item = $rowPE['item'];
				$por_entregar = number_format($rowPE['por_entregar'],0,',','.');
				$arrayProdXEntregar[]=array("orden"=>$orden, "id_item"=>$id_item, "item"=>$item, "por_entregar"=>$por_entregar);
			}


			$arrayDatosIniciales['cdad_oc'] = $rowCdadOC['cant_oc'];
			$arrayDatosIniciales['cantidad_oc_detalle'] = $arrayCdadOCD;
			$arrayDatosIniciales['monto_oc'] = $rowMontoOC['total_oc'];
			$arrayDatosIniciales['monto_oc_detalle'] = $arrayMontoOCD;
			$arrayDatosIniciales['prod_por_entregar'] = $total= number_format($rowPXE['cdad_por_entregar'],0,',','.');
			$arrayDatosIniciales['detalle_por_entregar'] = $arrayProdXEntregar;


			echo json_encode($arrayDatosIniciales);
		}
		
	}

	if (isset($_POST['accion'])) {
		
		$dashboardCtaCte = new DashboardCtaCte();

		switch ($_POST['accion']) {
			case 'traerDatosIniciales':
				$id_proveedor = $_POST['id_proveedor'];
				$dashboardCtaCte->traerDatosIniciales($id_proveedor);
				break;
			case 'traerPorFiltro':
				$id_proveedor = $_POST['id_proveedor'];
				$fdesde = $_POST['fdesde'];
				$fhasta = $_POST['fhasta'];
				$dashboardCtaCte->traerPorFiltro($id_proveedor, $fdesde, $fhasta);
				break;
		}
	}


?>