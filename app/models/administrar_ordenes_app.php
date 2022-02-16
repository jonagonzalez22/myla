<?php
session_start();
	require_once('../../conexion.php');
	class Ordenes{

		private $id_proveedor;
		private $id_orden;

		public function __construct(){
			$this->conexion = new Conexion();
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerOrdenes($id_proveedor){
			
			$this->id_proveedor = $id_proveedor;
			$ordenes_de_compra = array();

			$queryGetOC = "SELECT oc.id as id_oc, razon_social as proveedor, almacen, 				total, fecha, email as usuario, oc.id_estado, estado 
							FROM ordenes_compra oc JOIN proveedores prov
							ON(oc.id_proveedor = prov.id)
							JOIN estados_orden_compra eoc
							ON(oc.id_estado = eoc.id)
							JOIN usuarios usr
							ON(oc.id_usuario_alta = usr.id)
							JOIN almacenes alm
							ON(oc.id_almacen = alm.id)
							WHERE oc.id_proveedor = $this->id_proveedor
							order by oc.id";
			$getOc = $this->conexion->consultaRetorno($queryGetOC);

			while ($rowOC = $getOc->fetch_array()) {
				$id_oc= $rowOC['id_oc'];
				$proveedor= $rowOC['proveedor'];
				$almacen = $rowOC['almacen'];
				$total= "$".number_format($rowOC['total'],2,',','.');
				$fecha= date("d/m/Y", strtotime($rowOC['fecha']));
				$usuario= $rowOC['usuario'];
				$estado= $rowOC['estado'];
				$id_estado = $rowOC['id_estado'];
				$ordenes_de_compra[] = array("id_oc"=>$id_oc, "proveedor"=>$proveedor, "almacen"=>$almacen, "total"=>$total, "fecha"=>$fecha, "usuario"=>$usuario, "estado"=>$estado, "id_proveedor"=>$this->id_proveedor, "id_estado"=>$id_estado);
			}

			echo json_encode($ordenes_de_compra);
		}

		public function traerItemsUpdateOrden($id_orden){
			$this->id_orden = $id_orden;
			//$this->id_proveedor = $_SESSION['rowUsers']['id_usuario'];

			/*Traigo detalle orden de compra*/
			$queryGetDetalleOrden = "SELECT id_item, it.item, cantidad, precio_unitario
									FROM ordenes_compra_detalle dc
									JOIN item as it
									ON(dc.id_item = it.id)
									WHERE id_orden_compra = $this->id_orden";
			$getDetalleOrden = $this->conexion->consultaRetorno($queryGetDetalleOrden);

			$detalleOrden = array();
			$itemsDetalleOrden = array();

			/*Lleno array con detalle orden de compra*/
			while ($rowDetallOrden=$getDetalleOrden->fetch_array()) {
				$id_item = $rowDetallOrden['id_item'];
				$item = $rowDetallOrden['item'];
				$cantidad = $rowDetallOrden['cantidad'];
				$precio_unitario = $rowDetallOrden['precio_unitario'];
				$itemsDetalleOrden[] = array("id_item"=>$id_item, "item"=>$item, "cantidad"=>$cantidad, "precio"=>$precio_unitario);
			}

			/*Traigo items del proveedor menos los que tiene pedidos
			$queryGetItemProv ="SELECT it.id id_item, it.item, lp.precio, 0 cantidad
							FROM item as it JOIN lista_precios as lp
							ON(it.id = lp.id_item)
							WHERE lp.id_proveedor = $this->id_proveedor
							AND it.id not in(SELECT id_item FROM ordenes_compra_detalle WHERE id_orden_compra = $this->id_orden)";
			$getItemProv = $this->conexion->consultaRetorno($queryGetItemProv);*/


			/*Completo array con items de proveedor faltante
			while ($rowItemProv = $getItemProv->fetch_array()) {
				$id_item = $rowItemProv['id_item'];
				$item = $rowItemProv['item'];
				$cantidad = $rowItemProv['cantidad'];
				$precio_unitario = $rowItemProv['precio'];
				$itemsDetalleOrden[] = array("id_item"=>$id_item, "item"=>$item, "cantidad"=>$cantidad, "precio"=>$precio_unitario);
			}*/



			$detalleOrden = $itemsDetalleOrden;
			echo json_encode($detalleOrden);
		}

		public function updateOrden($id_orden, $total_orden, $items, $cambioPrecios, $cambioCantidad){

			$this->id_orden = $id_orden;
			$fecha_hora_desde= date("Y-m-d H:i:s");
			$fecha_hora_hasta= NULL;
			$cambioPrecios = json_decode($cambioPrecios);
			$cambioCantidad = json_decode($cambioCantidad);
			//$id_usuario = $_SESSION['rowUsers']['id_usuario'];
			$id_usuario = 1;

			/*Actualizo estado orden*/
			$queryUpdateEstado = "UPDATE ordenes_compra SET id_estado = 2, total = 						$total_orden WHERE id= $this->id_orden";
			$updateEstado = $this->conexion->consultaSimple($queryUpdateEstado);

			/*Guardo en tabla log_ordenes_compra*/
			$queryInsertLogsOC = "INSERT INTO log_ordenes_compra(id_orden_compra, id_estado, fecha_hora_desde, fecha_hora_hasta, id_usuario) values($this->id_orden, 2, '$fecha_hora_desde', '$fecha_hora_hasta', $id_usuario)";
			$insertLogsOC = $this->conexion->consultaSimple($queryInsertLogsOC);

			/*Ralizo verificaciones para detectar actualizaciones de precios de los items*/
			if(count($cambioPrecios)>0){
				for ($i=0; $i < count($cambioPrecios); $i++) { 

					$nuevoPrecio = $cambioPrecios[$i]->precio;
					$id_item = $cambioPrecios[$i]->id;

					/*Actualizo precio en ordenes_compra_detalle*/
					$queryUpdateDOC = "UPDATE ordenes_compra_detalle SET precio_unitario=			$nuevoPrecio
									WHERE id_item = $id_item";
					$updateDOC = $this->conexion->consultaSimple($queryUpdateDOC);

					/*Actualizo precio en lista_precios*/
					$queryUpdateLista = "UPDATE lista_precios SET precio = $nuevoPrecio,
								fecha_hora_ultima_actualizacion = '$fecha_hora_desde'
								WHERE id_item = $id_item";
					$updateItem = $this->conexion->consultaSimple($queryUpdateLista);
				}
			};

			/*Ralizo verificaciones para detectar actualizaciones de cantidades de los items*/
			if(count($cambioCantidad) > 0){

				for ($i=0; $i < count($cambioCantidad); $i++) {

					$nuevaCantidad =  $cambioCantidad[$i]->cantidad;
					$id_item = $cambioCantidad[$i]->id;

					/*Actualizo cantidades en ordenes_compra_detalle*/
					$queryUpdateDOC = "UPDATE ordenes_compra_detalle SET cantidad=			$nuevaCantidad
									WHERE id_item = $id_item";
					$updateDOC = $this->conexion->consultaSimple($queryUpdateDOC);
				}

			}


		}

		public function traerAdjuntos($id_orden){
			$this->id_orden = $id_orden;

			$queryGetAdjuntos = "SELECT adj.archivo, usr.email, adj.comentarios, 
								adj.fecha_hora as fecha
								FROM adjuntos_orden_compra as adj JOIN usuarios as usr
								ON(adj.id_usuario = usr.id)
								WHERE id_orden_compra = $this->id_orden";
			$getAdjuntos = $this->conexion->consultaRetorno($queryGetAdjuntos);

			$arrayAdjuntos = array();

			while($rowAdj = $getAdjuntos->fetch_array()){
				$archivo = $rowAdj['archivo'];
				$email = $rowAdj['email'];
				$comentarios = $rowAdj['comentarios'];
				$fechaFormat = $fecha= date("d/m/Y H:m:s", strtotime($rowAdj['fecha']));
				$fecha = $fechaFormat;

				$arrayAdjuntos[]=array("archivo"=>$archivo, "email"=>$email, "comentarios"=>$comentarios, "fecha"=>$fecha);
			}

			echo json_encode($arrayAdjuntos);

		}

		public function adjuntarArchivo($id_orden, $archivo, $comentarios, $id_proveedor){
			$this->id_orden = $id_orden;
			$nombreImagen = $archivo['name'];
			$directorio = "../../admin/views/adjuntosOC/";
			$nombreFinalArchivo = $nombreImagen;
			$id_usuario = $_SESSION['rowUsers']['id_usuario'];
			$fecha= date("Y-m-d H:i:s");

			$nombreEnv = $id_orden."_".$nombreFinalArchivo;

			move_uploaded_file($archivo['tmp_name'], $directorio.$id_orden."_".$nombreFinalArchivo);



			/*ACTUALIZO ADJUNTOS*/
			$queryUpdateAdjuntos = "INSERT INTO adjuntos_orden_compra(id_orden_compra, archivo, fecha_hora, id_usuario, id_proveedor, comentarios)VALUES($this->id_orden, '$nombreEnv', '$fecha', $id_usuario, $id_proveedor, '$comentarios')";
			$updateAdjuntos= $this->conexion->consultaSimple($queryUpdateAdjuntos);
		}

		public function cambiarEstadoOrden($id_orden){
			$this->id_orden = $id_orden;

			/*ACTUALIZO EL ESTADO EN ORDEN DE COMPRA*/
			$queryUpdateEstadoOrden = "UPDATE ordenes_compra SET id_estado = 4 
									WHERE id = $this->id_orden";
			$updateEstadoOrden = $this->conexion->consultaSimple($queryUpdateEstadoOrden);

			/*GUARDO EN TABLA LOG_ORDENES_COMPRA*/
			$fecha_hora_desde= date("Y-m-d H:i:s");
			$fecha_hora_hasta= NULL;
			$id_usuario = $_SESSION['rowUsers']['id_usuario'];

			$queryInsertLogsOC = "INSERT INTO log_ordenes_compra(id_orden_compra, id_estado, fecha_hora_desde, fecha_hora_hasta, id_usuario) values($this->id_orden, 4, '$fecha_hora_desde', '$fecha_hora_hasta', $id_usuario)";
			$InsertLogsOC = $this->conexion->consultaSimple($queryInsertLogsOC);
		}

	}

	if (isset($_POST['accion'])) {
		$ordenesApp = new Ordenes();
		switch ($_POST['accion']) {
			case 'traerOrdenes':
					$id_proveedor=$_POST['id_proveedor'];
					$ordenesApp->traerOrdenes($id_proveedor);
					break;
			case 'traerItemUpdateOrden':
					$id_orden = $_POST['id_orden'];
					$ordenesApp->traerItemsUpdateOrden($id_orden);
				break;
			case 'updateOrden':
					$id_orden = $_POST['id_orden'];
					$total_orden = $_POST['total_orden'];
					$items = $_POST['items'];
					$cambioPrecios = $_POST['cambioPrecios'];
					$cambioCantidad = $_POST['cambioCantidad'];
					$ordenesApp->updateOrden($id_orden, $total_orden, $items, $cambioPrecios, $cambioCantidad);
				break;
			case 'traerAdjuntos':
				$id_orden = $_POST['id_orden'];
				$ordenesApp->traerAdjuntos($id_orden);
				break;
			case 'adjuntarArchivo':
				$id_orden = $_POST['id_orden'];
				$archivo = $_FILES['file'];
				$comentarios = $_POST['comentarios'];
				$id_proveedor = $_POST['id_proveedor'];
				$ordenesApp->adjuntarArchivo($id_orden, $archivo, $comentarios, $id_proveedor);
				break;
			case 'cambiarEstadoOrden':
				$id_orden = $_POST['id_orden'];
				$ordenesApp->cambiarEstadoOrden($id_orden);
				break;
		}
	}else{
		if (isset($_GET['accion'])) {
			$ordenes = new Ordenes();

			switch ($_GET['accion']) {
				
			}
		}
	}
?>