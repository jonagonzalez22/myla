<?php
	session_start();
	include_once('conexion.php');

	class RedirUsuariosApp{

		private $conexion;
		private $id_usuario;
		private $id_proveedor;

		public function __construct(){
			$this->conexion = new Conexion();
			date_default_timezone_set('UTC'); 
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function redirProveedor(){
			//$this->id_usuario = $_SESSION['rowUsers']['id_usuario'];
			$this->id_proveedor = $_SESSION['rowUsers']['id_proveedor'];
			header('Location: ../home_proveedores.php');
		}
    public function redirTecnico(){
			//$this->id_proveedor = $_SESSION['rowUsers']['id_proveedor'];//ESTABLECER DE ALGUNA MANERA EL ID DEL TECNICO
			header('Location: ../home_tecnicos.php');
		}
		public function redirCliente(){
			header('Location: ../home.php');
		}
	}

	if (isset($_SESSION['rowUsers'])) {

		$redirUsuariosApp = new RedirUsuariosApp();

    var_dump($_SESSION);
    if(isset($_SESSION['rowUsers']['id_perfil']) and $_SESSION['rowUsers']['id_perfil']==4){//4 -> Técnico
      $_SESSION['rowUsers']['id_tecnico']=8;
      $redirUsuariosApp->redirTecnico();
    }else{
      if($_SESSION['rowUsers']['id_cliente']!=""){
        $redirUsuariosApp->redirCliente();
      }else{
        $redirUsuariosApp->redirProveedor();
      }
    }


	}else{
		header('Location: ../login.html');
	}
?>