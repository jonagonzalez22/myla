<?php
	session_start();
	require_once('conexion.php');
	class Momivientos{

		private $id_proveedor;
		private $id_orden;
		private $id_almacen;
		private $id_item;

		public function __construct(){
			$this->conexion = new Conexion();
			date_default_timezone_set("America/Buenos_Aires");
		}


		public function traerMovimientos(){
			
			$arrayMovimientos = array();

			$queryGetMomiviento = "SELECT mst.id as id_movimiento, mst.id_stock, it.item, 	mst.cantidad, usr.email as usuario, fecha_hora as fecha,  tipo_movimiento
								FROM movimientos_stock mst JOIN stock stk
								ON(mst.id_stock = stk.id)
								JOIN item as it
								ON(stk.id_item=it.id)
								JOIN usuarios usr
								ON(mst.id_usuario = usr.id)";
			$getMomiviento = $this->conexion->consultaRetorno($queryGetMomiviento);

			while ($row = $getMomiviento->fetch_array()) {
				$id_movimiento= $row['id_movimiento'];
				$id_stock= $row['id_stock'];
				$item= $row['item'];
				$cantidad = $row['cantidad'];
				$usuario = $row['usuario'];
				$tipo_movimiento = $row['tipo_movimiento'];
				$fecha= date("d/m/Y H:m:s", strtotime($row['fecha']));
				$arrayMovimientos[] = array('id_movimiento'=>$id_movimiento, 'id_stock'=>$id_stock, 'item'=>$item, 'cantidad'=>$cantidad, 'usuario'=>$usuario, 'tipo_movimiento'=>$tipo_movimiento, 'fecha'=>$fecha);
			}

			echo json_encode($arrayMovimientos);
		}

		public function traerMovimientosFiltro($fDesde, $fHasta){
			$arrayMovimientos = array();

			$queryGetMomiviento = "SELECT mst.id as id_movimiento, mst.id_stock, it.item, 	mst.cantidad, usr.email as usuario, fecha_hora as fecha, tipo_movimiento 
								FROM movimientos_stock mst JOIN stock stk
								ON(mst.id_stock = stk.id)
								JOIN item as it
								ON(stk.id_item=it.id)
								JOIN usuarios usr
								ON(mst.id_usuario = usr.id)
								WHERE date_format(fecha_hora, '%Y-%m-%d') between '$fDesde' and '$fHasta'";
			$getMomiviento = $this->conexion->consultaRetorno($queryGetMomiviento);

			while ($row = $getMomiviento->fetch_array()) {
				$id_movimiento= $row['id_movimiento'];
				$id_stock= $row['id_stock'];
				$item= $row['item'];
				$cantidad = $row['cantidad'];
				$usuario = $row['usuario'];
				$tipo_movimiento = $row['tipo_movimiento'];
				$fecha= date("d/m/Y H:m:s", strtotime($row['fecha']));
				$arrayMovimientos[] = array('id_movimiento'=>$id_movimiento, 'id_stock'=>$id_stock, 'item'=>$item, 'cantidad'=>$cantidad, 'usuario'=>$usuario, 'tipo_movimiento'=>$tipo_movimiento, 'fecha'=>$fecha);
			}

			echo json_encode($arrayMovimientos);
		}

	}

	if (isset($_POST['accion'])) {
		$momivientos = new Momivientos();
		
	}else{
		if (isset($_GET['accion'])) {
			$momivientos = new Momivientos();

			switch ($_GET['accion']) {
				case 'traerMovimientos':
					$momivientos->traerMovimientos();
					break;
				case 'traerMovimientosFiltro':
					$fdesde = $_GET['fdesde'];
					$fhasta = $_GET['fhasta'];
					$momivientos->traerMovimientosFiltro($fdesde, $fhasta);
					break;

			}
		}
	}
?>