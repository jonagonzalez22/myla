<?php
	session_start();
	require_once('conexion.php');
	class Stock{

		private $id_proveedor;
		private $id_orden;
		private $id_almacen;
		private $id_item;

		public function __construct(){
			$this->conexion = new Conexion();
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosIniciales(){

			/*ALMACEN*/
			$queryAlmacenes = "SELECT id, almacen FROM almacenes WHERE activo = 1";
			$getAlmacenes = $this->conexion->consultaRetorno($queryAlmacenes);

			/*PROVEEDORES*/
			$queryProveedores = "SELECT id as id_proveedor, razon_social FROM proveedores WHERE activo = 1";
			$getProveedores = $this->conexion->consultaRetorno($queryProveedores);

			/*TOTALIZADORES*/
			$queryGetTotalizadores = "SELECT sum(cantidad_disponible) as totItem, 
									sum(cantidad_disponible) as cantDisp, 
									sum(cantidad_reservada) as cantReserv,
									sum(cantidad_disponible*precio_unitario) as valoracion
									FROM stock";
			$getTotalizadores = $this->conexion->consultaRetorno($queryGetTotalizadores);

			$datosIniciales = array();
			$almacenes = array();
			$proveedores = array();
			$totalizadores = array();

			/*CARGO ARRAY ALMACENES*/
			while ($rowsAlmacenes= $getAlmacenes->fetch_array()) {
				$id_almacen = $rowsAlmacenes['id'];
				$almacen = $rowsAlmacenes['almacen'];
				$almacenes[] = array('id_almacen' => $id_almacen, 'almacen' =>$almacen);
			}

			/*CARGO ARRAY PROVEEDORES*/
			while ($rowProveedores= $getProveedores->fetch_array()) {
				$id_proveedor = $rowProveedores['id_proveedor'];
				$razon_social = $rowProveedores['razon_social'];
				$proveedores[] = array('id_proveedor' => $id_proveedor, 'razon_social' =>$razon_social);
			}

			/*CARGO ARRAY TOTALIZADORES*/
			while ($rowTotalizador = $getTotalizadores->fetch_array()) {
				$totItem = $rowTotalizador['totItem'];
				$cantDisp = $rowTotalizador['cantDisp'];
				$cantReserv = $rowTotalizador['cantReserv'];
				$valoracion = "$".number_format($rowTotalizador['valoracion'],2,',','.');
				$totalizadores[]=array("totItem"=>$totItem, "cantDisp"=>$cantDisp, "cantReserv"=>$cantReserv, "valoracion"=>$valoracion);
			}

			$datosIniciales["almacenes"] = $almacenes;
			$datosIniciales["proveedores"] = $proveedores;
			$datosIniciales["totalizadores"] = $totalizadores;

			echo json_encode($datosIniciales);
		}

		public function traerItems(){
			
			$arrayStock = array();

			$queryGetStock = "SELECT st.id_item, item, razon_social as proveedor, 
						almacen, st.cantidad_disponible, st.cantidad_reservada, 
						st.precio_unitario, it.punto_reposicion, it.hash, st.fecha_hora_ultima_actualizacion as fecha
						FROM stock st JOIN item as it
						ON(st.id_item = it.id)
						JOIN proveedores prov
						ON(st.id_proveedor = prov.id)
						JOIN almacenes alm
						ON(st.id_almacen = alm.id)";
			$getStock = $this->conexion->consultaRetorno($queryGetStock);

			while ($rowStock = $getStock->fetch_array()) {
				$id_item= $rowStock['id_item'];
				$item= $rowStock['item'];
				$proveedor= $rowStock['proveedor'];
				$almacen = $rowStock['almacen'];
				$cantDisp = $rowStock['cantidad_disponible'];
				$cantReserv = $rowStock['cantidad_reservada'];
				$precio_unitario= "$".number_format($rowStock['precio_unitario'],2,',','.');
				$fecha= date("d/m/Y H:m:s", strtotime($rowStock['fecha']));
				$punto_reposicion = $rowStock['punto_reposicion'];
				$hash = $rowStock['hash'];
				$arrayStock[] = array('id_item'=>$id_item, 'item'=>$item, 'proveedor'=>$proveedor, 'almacen'=>$almacen, 'cantDisp'=>$cantDisp, 'cantReserv'=>$cantReserv, "precio_unitario" =>$precio_unitario,'punto_reposicion'=>$punto_reposicion, 'hash'=>$hash, 'fecha'=>$fecha);
			}

			echo json_encode($arrayStock);
		}

		public function traerStockFiltro($almacen, $proveedor){
			$arrayStock = array();
			$condicion = "";

			if($proveedor != "" || $almacen !=""){

				if($proveedor != "" && $almacen !=""){
					$condicion = " WHERE id_proveedor = ".$proveedor." AND id_almacen =".$almacen;
				}else if($proveedor !=""){
					$condicion = " WHERE id_proveedor = ".$proveedor;
				}else{
					$condicion = " WHERE id_almacen = ".$almacen;
				}
			}
			$queryGetStock = "SELECT st.id_item, item, razon_social as proveedor, 
						almacen, st.cantidad_disponible, st.cantidad_reservada, 
						st.precio_unitario, it.punto_reposicion, it.hash, st.fecha_hora_ultima_actualizacion as fecha
						FROM stock as st JOIN item as it
						ON(st.id_item = it.id)
						JOIN proveedores as prov
						ON(st.id_proveedor = prov.id)
						JOIN almacenes as alm
						ON(st.id_almacen = alm.id) ".$condicion;
			$getStock = $this->conexion->consultaRetorno($queryGetStock);

			if($getStock){

				while ($rowStock = $getStock->fetch_array()) {
				$id_item= $rowStock['id_item'];
				$item= $rowStock['item'];
				$proveedor= $rowStock['proveedor'];
				$almacen = $rowStock['almacen'];
				$cantDisp = $rowStock['cantidad_disponible'];
				$cantReserv = $rowStock['cantidad_reservada'];
				$precio_unitario= "$".number_format($rowStock['precio_unitario'],2,',','.');
				$fecha= date("d/m/Y H:m:s", strtotime($rowStock['fecha']));
				$punto_reposicion = $rowStock['punto_reposicion'];
				$hash = $rowStock['hash'];
				$arrayStock[] = array('id_item'=>$id_item, 'item'=>$item, 'proveedor'=>$proveedor, 'almacen'=>$almacen, 'cantDisp'=>$cantDisp, 'cantReserv'=>$cantReserv, "precio_unitario" =>$precio_unitario,'punto_reposicion'=>$punto_reposicion, 'hash'=>$hash, 'fecha'=>$fecha);
			}
			}

			echo json_encode($arrayStock);
		}

		public function traerTotalizadoresFiltro($almacen, $proveedor){
			
			$condicion="";

			if($proveedor != "" || $almacen !=""){

				if($proveedor != "" && $almacen !=""){
					$condicion = "WHERE id_proveedor = ".$proveedor." AND id_almacen =".$almacen;
				}else if($proveedor !=""){
					$condicion = "WHERE id_proveedor = ".$proveedor;
				}else{
					$condicion = "WHERE id_almacen = ".$almacen;
				}
			}

			/*TOTALIZADORES*/
			$queryGetTotalizadores = "SELECT sum(cantidad_disponible) as totItem, 
									sum(cantidad_disponible) as cantDisp, 
									sum(cantidad_reservada) as cantReserv,
									sum(cantidad_disponible*precio_unitario) as valoracion
									FROM stock ".$condicion;
			$getTotalizadores = $this->conexion->consultaRetorno($queryGetTotalizadores);


			$totalizadores=array();

			/*CARGO ARRAY TOTALIZADORES*/
			while ($rowTotalizador = $getTotalizadores->fetch_array()) {
				$totItem = $rowTotalizador['totItem'];
				$cantDisp = $rowTotalizador['cantDisp'];
				$cantReserv = $rowTotalizador['cantReserv'];
				$valoracion = "$".number_format($rowTotalizador['valoracion'],2,',','.');
				$totalizadores[]=array("totItem"=>$totItem, "cantDisp"=>$cantDisp, "cantReserv"=>$cantReserv, "valoracion"=>$valoracion);
			}

			echo json_encode($totalizadores);

		}

		public function conciliar(){

			if (isset($_FILES['file0'])) {
				include_once('./PHPExcel/Classes/PHPExcel.php');
				$archivo = $_FILES['file0']['tmp_name'];
				$nombreArchivo = $_FILES['file0']['name'];
				$tipoArchivo = PHPExcel_IOFactory::identify($archivo);
				$objectReader = PHPExcel_IOFactory::createReader($tipoArchivo);
				$objPHPExcel = $objectReader->load($archivo);
				$sheet = $objPHPExcel->getSheet(0);
				$filaMasAlta = $sheet->getHighestRow();
				$colMasAlta = $sheet->getHighestColumn();
				$arrayResultados = array();
				$procesados = 0;
				$actualizados = 0;
				$no_procesados = 0;
				for ($row=2; $row <= $filaMasAlta ; $row++) {

					if($sheet->getCell("A".$row)->getFormattedValue()!=''){
						$id_item = $sheet->getCell("A".$row)->getFormattedValue();
						$cantDisponible = $sheet->getCell("B".$row)->getFormattedValue();
						$cantReservada = $sheet->getCell("C".$row)->getFormattedValue();
						$resultado = $this->conciliarItem($id_item, $cantDisponible, $cantReservada);

						switch ($resultado) {
							case 1:
								$procesados += 1;
								break;
							case 2:
								$actualizados +=1;
								break;
							case 3:
								$no_procesados += 1;
								break;
						}
					}
			}
		}
	}

	public function conciliarItem($id_item, $cantDisponible, $cantReservada){
		
		$fecha = date('Y-m-d H:i:s');
		$usuario = $_SESSION['rowUsers']['id_usuario'];

		/*SI EXISTE ACTUALIZO*/

					$queryUpdateStock = "UPDATE stock SET cantidad_disponible = $cantDisponible, cantidad_reservada = $cantReservada, fecha_hora_ultima_actualizacion = '$fecha'
										WHERE id_item = $id_item";
					$updateStock = $this->conexion->consultaSimple($queryUpdateStock);

					/*OBTENGO ID DE STOCK*/
					$queryGetIdStock = "SELECT id as id_stock FROM stock 
										WHERE id_item = $id_item";
					$getIdStock = $this->conexion->consultaRetorno($queryGetIdStock);

					$rowIdStock = $getIdStock->fetch_assoc();

					$id_stock = $rowIdStock['id_stock'];

					/*INSERTO MOVIMIENTOS STOCK*/
					$queryInsertMS = "INSERT INTO movimientos_stock(id_stock, cantidad, id_usuario, fecha_hora, tipo_movimiento)VALUES($id_stock, $cantDisponible, $usuario, '$fecha', 'Conciliación')";
					$insertMS = $this->conexion->consultaSimple($queryInsertMS);
	}
}

	if (isset($_POST['accion'])) {
		$stock = new stock();
		switch ($_POST['accion']) {
			case 'traerDatosIniciales':
				$stock->traerDatosIniciales();
				break;
			case 'actualizarTotalizadores':
				$almacen = $_POST['almacen'];
				$proveedor = $_POST['proveedor'];
				$stock->traerTotalizadoresFiltro($almacen, $proveedor);
				break;
			case 'conciliar':
				$stock->conciliar();
				break;
		}
	}else{
		if (isset($_GET['accion'])) {
			$stock = new Stock();

			switch ($_GET['accion']) {
				case 'traerItems':
					$stock->traerItems();
					break;
				case 'traerStockFiltro':
					$almacen = $_GET['almacen'];
					$proveedor = $_GET['proveedor'];
					$stock->traerStockFiltro($almacen, $proveedor);
					break;
			}
		}
	}
?>