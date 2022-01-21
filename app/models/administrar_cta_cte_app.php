<?php 
	
	session_start();
	require_once('conexion.php');

	class CtaCte{
		
		private $id_proveedor;
		private $id_cc;
		private $id_orden;

		public function __construct(){

			$this->conexion = new Conexion();
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerCtaCte($id_proveedor){

			$this->id_proveedor = $id_proveedor;

			$queryGetCtaCte = "SELECT mp.id as id_ctaCte, tipo as tipo_movimiento,
								monto, fecha_hora as fecha 
								FROM movimientos_proveedores as mp JOIN tipos_movimientos_ctacte tmp
								ON(mp.id_tipo_movimiento = tmp.id)
								WHERE id_proveedor = $this->id_proveedor";
			$getCtaCte = $this->conexion->consultaRetorno($queryGetCtaCte);

			$arrayCtaCte = array();

			while ($row = $getCtaCte->fetch_array()) {
				$id_ctaCte = $row['id_ctaCte'];
				$tipo_movimiento = $row['tipo_movimiento'];
				$monto = $row['monto'];
				$fecha = date("d/m/Y H:i:s", strtotime($row['fecha']));

				$arrayCtaCte[] = array('id_ctaCte'=>$id_ctaCte, 'tipo_movimiento'=>$tipo_movimiento, 'monto'=>$monto, 'fecha'=>$fecha);
			}
			echo json_encode($arrayCtaCte);
		}

		public function traerOrigen($id_cc){
			$this->id_cc = $id_cc;
			$arrayOrigen = array();

			$queryGetOrigen = "SELECT id_tipo_movimiento, id_origen FROM movimientos_proveedores WHERE id='$this->id_cc'";
			$getOrigen = $this->conexion->consultaRetorno($queryGetOrigen);

			if($getOrigen->num_rows > 0){
				
				$rowOrigen = $getOrigen->fetch_assoc();

				if($rowOrigen['id_tipo_movimiento']== 1){
					
					$this->id_orden = $rowOrigen['id_origen'];

						/*Traigo detalle orden de compra*/
						$queryGetDetalleOrden = "SELECT id_item, it.item, cantidad, precio_unitario
												FROM ordenes_compra_detalle dc
												JOIN item as it
												ON(dc.id_item = it.id)
												WHERE id_orden_compra = $this->id_orden";
						$getDetalleOrden = $this->conexion->consultaRetorno($queryGetDetalleOrden);

						$itemsDetalleOrden = array();

						/*Lleno array con detalle orden de compra*/
						while ($rowDetallOrden=$getDetalleOrden->fetch_array()) {
							$id_item = $rowDetallOrden['id_item'];
							$item = $rowDetallOrden['item'];
							$cantidad = $rowDetallOrden['cantidad'];
							$precio_unitario = $rowDetallOrden['precio_unitario'];
							$itemsDetalleOrden[] = array("id_item"=>$id_item, "item"=>$item, "cantidad"=>$cantidad, "precio"=>$precio_unitario);
						}

						$arrayOrigen['detalle_origen'] = $itemsDetalleOrden;
						$arrayOrigen['tipo_movimiento'] = array("tipo_movimiento"=>$rowOrigen['id_tipo_movimiento']);
						$arrayOrigen['origen'] = array("id_origen"=>$this->id_orden);

						echo json_encode($arrayOrigen);
				}else{

					$arrayOrigen['tipo_movimiento'] = array("tipo_movimiento"=>2);
					echo json_encode($arrayOrigen);
				}
			}

			
		}

		public function actualizarUsuario($id_user, $email, $clave){

			$this->id_user = $id_user;

			$queryUpdateUsuario="UPDATE usuarios SET email = '$email', clave = '$clave'
								WHERE id=$this->id_user";
			$updateUsuario = $this->conexion->consultaSimple($queryUpdateUsuario);


		}

	}

	if (isset($_POST['accion'])) {
		
		$ctaCte = new CtaCte();

		switch ($_POST['accion']) {
			case 'traerCtaCte':
				$id_proveedor = $_POST['id_proveedor'];
				$ctaCte->traerCtaCte($id_proveedor);
				break;
			case 'traerOrigen':
				$id_cc = $_POST['id_cc'];
				$ctaCte->traerOrigen($id_cc);
				break;
			case 'actualizarUsuario':
				$email = $_POST['email'];
				$clave = $_POST['clave'];
				$id_user = $_POST['id_user'];
				$ctaCte->actualizarUsuario($id_user, $email, $clave);
				break;
		}
	}


?>