<?php
	include_once('conexion.php');

	class RegistrarseModel{

		private $conexion;
		private $email;
		private $id_cliente, $id_proveedor;
		private $id_perfil;

		public function __construct(){
			$this->conexion = new Conexion();
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosIniciales(){

			/*CLIENTES*/
			$queryCliente = "SELECT id as id_cliente, razon_social cliente 
							FROM clientes 			
							WHERE activo = 1";
			$getCliente = $this->conexion->consultaRetorno($queryCliente);

			/*PROVEEDORES*/
			$queryProveedores = "SELECT id as id_prov, razon_social proveedor 
								FROM proveedores
								WHERE activo = 1";
			$getProveedores = $this->conexion->consultaRetorno($queryProveedores);

			$datosIniciales = array();
			$clientes = array();
			$proveedores = array();



			while ($rowsClientes= $getCliente->fetch_array()) {
				$id_cliente = $rowsClientes['id_cliente'];
				$cliente = $rowsClientes['cliente'];
				$clientes[] = array('id_cliente' => $id_cliente, 'cliente' =>$cliente);
			}



			while ($rowsProv= $getProveedores->fetch_array()) {
				$id_prov = $rowsProv['id_prov'];
				$proveedor = $rowsProv['proveedor'];
				$proveedores[] = array('id_prov' => $id_prov, 'proveedor' =>$proveedor);
			}


			$datosIniciales["clientes"] = $clientes;
			$datosIniciales["proveedores"] = $proveedores;
			echo json_encode($datosIniciales);
		}

		public function verificarCentaExitente($mail){
			$this->mail = $mail;

			$queryConsultarCuenta = "SELECT email FROM usuarios WHERE email='$this->mail'";
			$getCuenta = $this->conexion->consultaRetorno($queryConsultarCuenta);

			if($getCuenta->num_rows > 0){
				$resultado = 1;
			}else{
				$resultado = 0;
			}

			echo $resultado;
		}

		Public function registrarUsuario($mail, $clave, $idProveedor, $idCliente, $idPerfil){
			$this->email = $mail;
			$this->clave = $clave;
			$this->id_proveedor = $idProveedor;
			$this->id_cliente = $idCliente;
			$this->id_perfil = $idPerfil;
			$fecha_alta = date("Y-m-d");

			$queryInsertUser = "INSERT INTO usuarios(email, clave, activo, fecha_alta,id_perfil, id_cliente, id_proveedor)VALUES('$this->email', '$this->clave', 0, '$fecha_alta', $this->id_perfil, $this->id_cliente, $this->id_proveedor)";
			$insertUser = $this->conexion->consultaSimple($queryInsertUser);
		}
	}

	if(isset($_POST['accion'])){
		$registrarseModel = new RegistrarseModel();

		switch ($_POST['accion']) {
			case 'traerDatosIniciales':
				$registrarseModel->traerDatosIniciales();
				break;
			case 'verificarCuenta':
				$mail = $_POST['cuentaMail'];
				$registrarseModel->verificarCentaExitente($mail);
				break;
			case 'registrarUsuario':
				$mail = $_POST['mail'];
				$clave = $_POST['clave'];
				$idCliente = $_POST['id_cliente'];
				$idProveedor = $_POST['id_proveedor'];
				$idPerfil = $_POST['id_perfil'];
				$registrarseModel->registrarUsuario($mail, $clave, $idProveedor, $idCliente, $idPerfil);
				break;
			default:
				// code...
				break;
		}
	}
?>