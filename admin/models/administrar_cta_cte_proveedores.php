<?php
	session_start();
	require_once('conexion.php');
	class CtaCteProv{
		private $id_empresa;
		private $id_tipo_caja;
		private $id_usuario;
		private $id_proveedor;
		
		public function __construct(){
				$this->conexion = new Conexion();
				date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosIniciales($id_empresa){

			$this->id_empresa = $id_empresa;

			/*PROVEEDORES*/
			$queryProveedores = "SELECT id as id_proveedor, razon_social 
								FROM proveedores 
								WHERE id_empresa = $this->id_empresa
								AND activo = 1";
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


		public function traerCtaCteProv($id_empresa, $id_proveedor){

			$this->id_empresa = $id_empresa;
			$this->id_proveedor = $id_proveedor;

			$query = "SELECT prv.id as id_proveedor, prv.razon_social as proveedor, sum(mp.monto_cancelado-mp.monto) AS saldo
					FROM movimientos_proveedores as mp join proveedores as prv
					ON(mp.id_proveedor = prv.id)
					WHERE prv.id_empresa = $this->id_empresa
					AND prv.id = $this->id_proveedor
					group by prv.razon_social";
			$getCtaCteProv = $this->conexion->consultaRetorno($query);

			$arrayCtaCteProv = array(); //creamos un array

			while ($row = $getCtaCteProv->fetch_array()) {
            $id_proveedor = $row['id_proveedor'];
            $proveedor = $row['proveedor'];
            $saldo = $row['saldo'];

            $arrayCtaCteProv[] = array('id_proveedor'=> $id_proveedor, 'proveedor'=>$proveedor, 'saldo'=>$saldo);
        }

        echo json_encode($arrayCtaCteProv);

		}


		public function emitirPago($id_proveedor, $importe){

			$this->id_proveedor = $id_proveedor;

			/*BUSCO MOVIMIENTOS CON SALDOS PENDIENTES*/		
			$query = "SELECT id, id_proveedor, monto, monto_cancelado, 
					(monto_cancelado - monto) as saldo
					FROM movimientos_proveedores
					WHERE id_proveedor = $this->id_proveedor
					AND (monto_cancelado - monto) < 0";
			$getNegativos = $this->conexion->consultaRetorno($query);

			if($getNegativos->num_rows > 0 ){

				while ($rowNegativos = $getNegativos->fetch_assoc()) {
					if($rowNegativos['saldo'] < $importe){
						
						$id_movimiento = $rowNegativos['id'];
						$montoCancelado = 0;

						if($rowNegativos['monto_cancelado']+$importe > $rowNegativos['monto']){
							
							$montoCancelado = $rowNegativos['monto'];

						}else{
							$montoCancelado = $rowNegativos['monto_cancelado']+$importe;
						}



						$queryUpdateSaldos = "UPDATE movimientos_proveedores SET monto_cancelado = $montoCancelado
							WHERE id = $id_movimiento";
						$updateSaldo = $this->conexion->consultaSimple($queryUpdateSaldos);

						$importe = $importe-($rowNegativos['monto']-$rowNegativos['monto_cancelado']);
						
					}else{

						$id_movimiento = $rowNegativos['id'];
						$queryUpdateSaldos = "UPDATE movimientos_proveedores SET monto_cancelado = monto_cancelado+$importe
							WHERE id = $id_movimiento";
						$updateSaldo = $this->conexion->consultaSimple($queryUpdateSaldos);

						$importe-= $importe;
					}
				}
			}

			if($importe > 0 ){

					$fecha_hora = date("Y-m-d H:i:s");

					$queryInsertCtaCte = "INSERT INTO movimientos_proveedores(id_proveedor, id_tipo_movimiento, monto, fecha_hora, id_origen, monto_cancelado)VALUES($this->id_proveedor, 3, 0, '$fecha_hora', 0, $importe)";

					$insertCtaCte = $this->conexion->consultaSimple($queryInsertCtaCte);

					$importe-=$importe;
				}
		}

		public function traerDetalleCtaCte($id_proveedor){
			$this->id_proveedor = $id_proveedor;

			
			$arrayDetalleCtaCte = array();

			$queryDetalleCtaCte = "SELECT mp.id, mcta.tipo, mp.monto, 
								mp.id_origen, (monto_cancelado - monto) as saldo 
								FROM movimientos_proveedores as mp JOIN tipos_movimientos_ctacte as mcta
								ON(mp.id_tipo_movimiento = mcta.id)
								WHERE  id_proveedor = $this->id_proveedor";
			$getDetalleCtaCte = $this->conexion->consultaRetorno($queryDetalleCtaCte);

			while ($rowDetalle = $getDetalleCtaCte->fetch_assoc()) {
				
				$id_movimiento = $rowDetalle['id'];
				$tipo = $rowDetalle['tipo'];
				$monto = "$".number_format($rowDetalle['monto'],2,',','.');
				$id_origen = $rowDetalle['id_origen'];
				$saldo = $rowDetalle['saldo'];

				$arrayDetalleCtaCte[] = array('id_movimiento'=>$id_movimiento, 'tipo'=>$tipo, 'monto'=>$monto, 'id_origen'=>$id_origen, 'saldo'=>$saldo);
			}

			echo json_encode($arrayDetalleCtaCte);

		}
}	

	if (isset($_POST['accion'])) {
		$ctaCteProv = new CtaCteProv();
		switch ($_POST['accion']) {
			case 'emitirPago':
					$id_proveedor = $_POST['id_proveedor'];
					$importe = $_POST['importe'];
					$ctaCteProv->emitirPago($id_proveedor, $importe);
				break;
			case 'traerDatosIniciales':
				$id_empresa = $_POST['id_empresa'];
				$ctaCteProv->traerDatosIniciales($id_empresa);
				break;
		}
	}else{
		if (isset($_GET['accion'])) {
			$ctaCteProv = new CtaCteProv();

			switch ($_GET['accion']) {
				case 'traerCtacCteProv':
					$id_empresa = $_GET['id_empresa'];
					$id_proveedor = $_GET['id_proveedor'];
					$ctaCteProv->traerCtaCteProv($id_empresa, $id_proveedor);
					break;
				case 'traerDetalleCtaCte':
					$id_proveedor = $_GET['id_proveedor'];
					$ctaCteProv->traerDetalleCtaCte($id_proveedor);
					break;
				default:
					// code...
					break;
			}
		}
	}
?>