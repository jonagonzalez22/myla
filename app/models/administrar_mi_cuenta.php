<?php 
	
	session_start();
	require_once('conexion.php');

	class MiCuenta{
		
		private $id_user;

		public function __construct(){

			$this->conexion = new Conexion();
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosUser($id_user){

			$this->id_user = $id_user;

			$queryGetDatosUser = "SELECT id as id_usuario, email, clave 
								FROM usuarios
								WHERE id = $this->id_user";
			$getDatosUser = $this->conexion->consultaRetorno($queryGetDatosUser);

			$arrayDatosUser = array();

			while ($row = $getDatosUser->fetch_array()) {
				$id_usuario = $row['id_usuario'];
				$email = $row['email'];
				$clave = $row['clave'];

				$arrayDatosUser[] = array('id_usuario'=>$id_usuario, 'email'=>$email, 'clave'=>$clave);

				echo json_encode($arrayDatosUser);
			}
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

		public function actualizarUsuario($id_user, $email, $clave){

			$this->id_user = $id_user;

			$queryUpdateUsuario="UPDATE usuarios SET email = '$email', clave = '$clave'
								WHERE id=$this->id_user";
			$updateUsuario = $this->conexion->consultaSimple($queryUpdateUsuario);


		}

	}

	if (isset($_POST['accion'])) {
		
		$miCuenta = new MiCuenta();

		switch ($_POST['accion']) {
			case 'traerDatosUser':
				$id_user = $_POST['id_user'];
				$miCuenta->traerDatosUser($id_user);
				break;
			case 'verificarCuenta':
				$email = $_POST['mail'];
				$miCuenta->verificarCentaExitente($email);
				break;
			case 'actualizarUsuario':
				$email = $_POST['email'];
				$clave = $_POST['clave'];
				$id_user = $_POST['id_user'];
				$miCuenta->actualizarUsuario($id_user, $email, $clave);
				break;
		}
	}


?>