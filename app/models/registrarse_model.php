<?php
	require_once('../../conexion.php');

	class RegistrarseModel{

		private $conexion;
		private $email;
		private $id_cliente, $id_proveedor;
		private $id_perfil;
		private $id_empresa;
		private $id_tecnico;

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

		Public function registrarUsuario($mail, $clave, $idProveedor, $idCliente, $idPerfil, $empresa, $tecnico){
			$this->email = $mail;
			$this->clave = $clave;
			$this->id_proveedor = $idProveedor;
			$this->id_cliente = $idCliente;
			$this->id_perfil = $idPerfil;
			$this->id_tecnico = $tecnico;
			$this->id_empresa = $empresa;
			$fecha_alta = date("Y-m-d");

			$queryInsertUser = "INSERT INTO usuarios(email, clave, activo, fecha_alta,id_perfil, id_cliente, id_proveedor, id_empresa, id_tecnico)VALUES('$this->email', '$this->clave', 0, '$fecha_alta', $this->id_perfil, $this->id_cliente, $this->id_proveedor, $this->id_empresa, $this->id_tecnico)";
			$insertUser = $this->conexion->consultaSimple($queryInsertUser);
		}

		public function traerEmpresas(){

			/*PROVEEDORES*/
			$queryEmpresas = "SELECT id as id_empresa, nombre as empresa 
								FROM empresas
								WHERE activo = 1";
			$getEmpresas= $this->conexion->consultaRetorno($queryEmpresas);

			$arrayEmpresas = array();

			while ($rowsEmpresas= $getEmpresas->fetch_array()) {
				$id_empresa = $rowsEmpresas['id_empresa'];
				$empresa = $rowsEmpresas['empresa'];
				$arrayEmpresas[] = array('id_empresa' => $id_empresa, 'empresa' =>$empresa);
			}

			echo json_encode($arrayEmpresas);

		}

		public function traerTecnicos($id_empresa){

			
			$this->id_empresa = $id_empresa;
			
			/*TECNICOS*/
			$queryTecnicos = "SELECT id as id_tecnico, nombre_completo as tecnico 
								FROM tecnicos
								WHERE id_empresa = $this->id_empresa
								AND activo = 1";
			$getTecnicos= $this->conexion->consultaRetorno($queryTecnicos);

			$arrayTecnicos = array();

			while ($rowsEmpresas= $getTecnicos->fetch_array()) {
				$id_tecnico = $rowsEmpresas['id_tecnico'];
				$tecnico = $rowsEmpresas['tecnico'];
				$arrayTecnicos[] = array('id_tecnico' => $id_tecnico, 'tecnico' =>$tecnico);
			}

			echo json_encode($arrayTecnicos);

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
				$empresa = $_POST['empresa'];
				$tecnico = $_POST['tecnico'];
				$registrarseModel->registrarUsuario($mail, $clave, $idProveedor, $idCliente, $idPerfil, $empresa, $tecnico);
				break;
			case 'traerEmpresas':
				$registrarseModel->traerEmpresas();
				break;
			case 'traerTecnicos':
				$id_empresa = $_POST['id_empresa'];
				$registrarseModel->traerTecnicos($id_empresa);
				break;
			default:
				// code...
				break;
		}
	}
?>