<?php
	session_start();
	require_once('../../conexion.php');
	class Listas{

		private $id_proveedor;
		private $id_item;

		public function __construct(){
			$this->conexion = new Conexion();
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosIniciales(){

			/*PROVEEDORES*/
			$queryProveedores = "SELECT id as id_proveedor, razon_social FROM proveedores WHERE activo = 1";
			$getProveedores = $this->conexion->consultaRetorno($queryProveedores);

			$datosIniciales = array();
			$arrayProveedores = array();

			/*CARGO ARRAY PROVEEDORES*/
			while ($rowProveedores= $getProveedores->fetch_array()) {
				$id_proveedor = $rowProveedores['id_proveedor'];
				$razon_social = $rowProveedores['razon_social'];
				$arrayProveedores[] = array('id_proveedor' => $id_proveedor, 'razon_social' =>$razon_social);
			}

			$datosIniciales["proveedores"] = $arrayProveedores;
			echo json_encode($datosIniciales);

		}

		public function traerArticulos($id_proveedor){
			$this->id_proveedor = $id_proveedor;

			$queryTraerLista="SELECT it.id id_item, it.item, provee.razon_social as 				proveedor, lp.precio, unidad_medida,
							lp.fecha_hora_ultima_actualizacion as ultima_actualizacion,
							lp.codigo_proveedor as codigo_proveedor
							FROM item as it JOIN lista_precios as lp
							ON(it.id = lp.id_item)
							JOIN proveedores as provee
							ON(lp.id_proveedor = provee.id)
							JOIN unidades_medida um
							ON(it.id_unidad_medida=um.id)
							WHERE lp.id_proveedor = $this->id_proveedor";
			$traerLista = $this->conexion->consultaRetorno($queryTraerLista);

			$arrayItems = array();

			if ($traerLista->num_rows > 0) {
				while ($rowListas= $traerLista->fetch_array()) {
						$id_item = $rowListas['id_item'];
						$item = $rowListas['item'];
						$proveedor = $rowListas['proveedor'];
						$precio = $rowListas['precio'];
						$fechaUA = date("d/m/Y H:i:s", strtotime($rowListas['ultima_actualizacion']));
						$ultima_actualizacion = $fechaUA;
						$unidad_medida = $rowListas['unidad_medida'];
						$codigoProveedor = $rowListas['codigo_proveedor'];
						$arrayItems[] = array("id_item"=>$id_item, "item"=>$item, "proveedor"=>$proveedor, "precio"=>$precio, "ultima_actualizacion"=>$ultima_actualizacion, 'unidad_medida'=>$unidad_medida, 'codigo_proveedor' => $codigoProveedor);
					}	
			}

			echo json_encode($arrayItems);
		}

		public function importarListas($id_proveedor){
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
					$precio = $sheet->getCell("B".$row)->getFormattedValue();
					$resultado = $this->agregarLista($id_item, $id_proveedor, $precio);

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

			$arrayResultados[] = array("ingresados"=>$procesados, "actualizados"=>$actualizados, "no_procesados"=>$no_procesados);
			echo json_encode($arrayResultados);
			}
		}

		public function agregarLista($id_item, $id_proveedor, $precio){
			
			/*VERIFICO SI EXISTE ITEM EN MASTRO DE ITEMS*/
			$queryGetItem = "SELECT id FROM item WHERE id = $id_item";
			$getItems = $this->conexion->consultaRetorno($queryGetItem);

			if ($getItems->num_rows > 0) {
				
				$fecha_actualizacion = date("Y-m-d H:i:s");

				/*VERIFICO SI EXISTE ITEM EN STOCK*/
				$queryGetItemLP = "SELECT id_item FROM lista_precios WHERE id_item = $id_item";
				$getItemLP = $this->conexion->consultaRetorno($queryGetItemLP);

				if($getItemLP->num_rows > 0){
					$queryUpdateItemLP = "UPDATE lista_precios SET id_proveedor = $id_proveedor, precio=$precio, fecha_hora_ultima_actualizacion = '$fecha_actualizacion' WHERE id_item = $id_item";
					$UpdateItemLP = $this->conexion->consultaSimple($queryUpdateItemLP);
					return 2;
				}else{
					$queryInsertLP = "INSERT INTO lista_precios(id_item, id_proveedor,  precio, fecha_hora_ultima_actualizacion) VALUES($id_item, $id_proveedor, $precio, '$fecha_actualizacion')";
					$insertLP = $this->conexion->consultaSimple($queryInsertLP);
					return 1;
				}

			}else{
				return 3;
			}
		}

		public function eliminarItemLista($id_item){
			$this->id_item = $id_item;

			$queryDelItemLista = "DELETE FROM lista_precios WHERE id_item = $this->id_item";
			$delItemLista = $this->conexion->consultaSimple($queryDelItemLista);
		}

		public function editarCantidadStock($id_item, $precio){
			$this->id_item = $id_item;
			$queryUpdateCantidad = "UPDATE lista_precios SET precio = $precio WHERE id_item = $this->id_item";
			$updateCantidad = $this->conexion->consultaSimple($queryUpdateCantidad);
		}
	}

	if (isset($_POST['accion'])) {
		$listas = new Listas();
		switch ($_POST['accion']) {
			case 'traerDatosIniciales':
				$listas->traerDatosIniciales();
				break;
			case 'importarItems':
				$id_proveedor = $_POST['id_proveedor'];
				$listas->importarListas($id_proveedor);
				break;
			case 'eliminarItemLista':
				$id_item = $_POST['id_item'];
				$listas->eliminarItemLista($id_item);
				break;
			case 'editarCantidadStock':
				$id_item = $_POST['id_item'];
				$precio = $_POST['precio'];
				$listas->editarCantidadStock($id_item, $precio);
				break;
			case 'traerListaExportar':
				$id_proveedor = $_POST['id_proveedor'];
				$listas->traerArticulos($id_proveedor);
				break;
		}
	}else{
		if (isset($_GET['accion'])) {
			$listas = new Listas();

			$listas->traerArticulos($_GET['id_proveedor']);
		}
	}

?>