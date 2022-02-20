<?php
	session_start();
	require_once('../../conexion.php');

	class ValidateUsers{

		private $mail;
		private $clave;

		public function __construct(){
			$this->conexion = new Conexion();
			date_default_timezone_set('UTC'); 
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function validateUsr($mail, $clave){
			$this->mail = $mail;
			$this->clave = $clave;

			/*Buscar usuario*/
			$queryGetUser = "SELECT id as id_usuario, email, clave, activo, id_perfil, id_cliente, id_proveedor, id_tecnico
						FROM usuarios 
						WHERE email = '$this->mail'
						AND clave = '$this->clave'";
			$getUser = $this->conexion->consultaRetorno($queryGetUser);
			

			if($getUser->num_rows == 0){

				echo 0;
				
			}else{
				$userRows = $getUser->fetch_assoc();

				/*Verificamos que la contraseña admin sea correcta*/

					if($this->clave == $userRows['clave']){

							/*Verificamos si está activo*/

							if ($userRows['activo'] > 0) {

								/*Entrará y derivaremos*/
								$_SESSION['rowUsers'] = $userRows;
								//$_SESSION['tipo'] = "admin";
								echo 1;

							}else{
								echo 3;
							}

					}else{
						
						echo 0;
					}
				
			}
		}

	}

	if ($_POST['accion']) {

			$validateUser = new validateUsers();
			switch ($_POST['accion']) {
			case 'validarUsuario':
				$mail = $_POST['mail'];
				$clave = $_POST['clave'];
				$validateUser->validateUsr($mail, $clave);
				break;
		}

		}
?>