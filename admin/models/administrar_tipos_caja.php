<?php
	session_start();
	require_once('conexion.php');
	class TiposCaja{
		private $id_rubro;
		private $id_empresa;
		private $id_tipo_caja;
		
		public function __construct(){
				$this->conexion = new Conexion();
				date_default_timezone_set("America/Buenos_Aires");
		}


		Public function agregarTiposCaja($tipo_caja, $id_empresa){

			$this->id_empresa = $id_empresa;

			$sql = "INSERT INTO tipos_caja(tipo, id_empresa) VALUES('$tipo_caja', $this->id_empresa)";
			$insertTipoCaja = $this->conexion->consultaSimple($sql);

		}
		public function traerTiposCajas($id_empresa){

			$this->id_empresa = $id_empresa;

			$query = "SELECT id as id_tipo_caja, tipo 
					FROM tipos_caja
					WHERE id_empresa = $this->id_empresa";
			$getQuery = $this->conexion->consultaRetorno($query);

			$tipos_cajas = array(); //creamos un array

			while ($row = $getQuery->fetch_array()) {
            $id_tipo_caja = $row['id_tipo_caja'];
            $tipo = $row['tipo'];
            $tipos_cajas[] = array('id_tipo_caja'=> $id_tipo_caja, 'tipo'=>$tipo);
        }

        echo json_encode($tipos_cajas);

		}
		public function updateTipoCaja($id_tipo_caja, $tipo_caja){

			$this->id_tipo_caja = $id_tipo_caja;

			$query = "UPDATE tipos_caja SET tipo ='$tipo_caja'
								WHERE id=$this->id_tipo_caja";
			$updateTipoCaja = $this->conexion->consultaSimple($query);
		}


		public function deleteTipoCaja($id_tipo_caja){
			$this->id_tipo_caja = $id_tipo_caja;

			/*ELIMINO RUBRO*/
			$query = "DELETE FROM tipos_caja WHERE id = $this->id_tipo_caja";
			$delTipoCaja = $this->conexion->consultaSimple($query);
		}
		
}	

	if (isset($_POST['accion'])) {
		$tiposCaja = new TiposCaja();
		switch ($_POST['accion']) {
			case 'addTipoCaja':
					$tipo_caja = $_POST['tipo_caja'];
					$id_empresa = $_POST['id_empresa'];
					$tiposCaja->agregarTiposCaja($tipo_caja, $id_empresa);
				break;
			case 'updateTipoCaja':
					$id_tipo_caja = $_POST['id_tipo_caja'];
					$tipo_caja = $_POST['tipo_caja'];
					$tiposCaja->updateTipoCaja($id_tipo_caja, $tipo_caja);
				break;
			case 'eliminarTipoCaja':
					$id_tipo_caja = $_POST['id_tipo_caja'];
					$tiposCaja->deleteTipoCaja($id_tipo_caja);
				break;
			case 'traerDatosIniciales':
				$tiposCaja->traerDatosIniciales();
				break;
		}
	}else{
		if (isset($_GET['accion'])) {
			$tiposCaja = new TiposCaja();
			$id_empresa = $_GET['id_empresa'];
			$tiposCaja->traerTiposCajas($id_empresa);
		}
	}
?>