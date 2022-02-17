<?php
	session_start();
	require_once('conexion.php');
	class LejagosTecnicos{
		private $id_empresa;
		private $id_tecnico;

		public function __construct(){
			$this->conexion = new Conexion();
				date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosIniciales(){

					
			/*PROVINCIAS*/
			$queryProvincias = "SELECT id as id_provincia, provincia 
									FROM provincias";
			$getProvincias = $this->conexion->consultaRetorno($queryProvincias);

			/*TIPOS DE IVA*/
			$queryTipoIva = "SELECT id as idIva, tipo FROM tipos_iva_responsable";
			$getTipoIva = $this->conexion->consultaRetorno($queryTipoIva);

			/*CARGOS*/
			$queryCargos = "SELECT id as idCargo, cargo FROM cargos";
			$getCargos = $this->conexion->consultaRetorno($queryCargos);

			$datosIniciales = array();
			$arrayProvincias = array();
			$arrayCargos = array();
			$arrayTiposIva = array();


			/*CARGO PROVINCIAS*/
			while ($rowsProv= $getProvincias->fetch_array()) {
				$id_provincia = $rowsProv['id_provincia'];
				$provincia = $rowsProv['provincia'];
				$arrayProvincias[] = array('id_provincia' => $id_provincia, 'provincia' =>$provincia);
			}

			/*CARGO ARRAY TIPO IVA*/
			while ($rowsIva= $getTipoIva->fetch_array()) {
				$id_iva = $rowsIva['idIva'];
				$tipoIva = $rowsIva['tipo'];
				$arrayTiposIva[] = array('id_iva' => $id_iva, 'tipoIva' =>$tipoIva);
			}

			/*CARGO ARRAY CARGOS*/
			while ($rowCargos = $getCargos->fetch_array()) {
				$id_cargo = $rowCargos['idCargo'];
				$cargo = $rowCargos['cargo'];
				$arrayCargos[]= array('id_cargo' => $id_cargo, 'cargo' =>$cargo);
			}

			$datosIniciales["provincias"] = $arrayProvincias;
			$datosIniciales["condicion_iva"] = $arrayTiposIva;
			$datosIniciales["cargos"] = $arrayCargos;

			echo json_encode($datosIniciales);
		}

		public function traerTecnicos($id_empresa){

			$this->id_empresa = $id_empresa;

			$queryTraerTecnicos = "SELECT tc.id, tc.nombre_completo, tc.nro_legajo
							, tc.cuil, tc.telefono, tc.email, cg.cargo, 
							tc.fecha_alta, tc.activo, iva.tipo as tipo_iva, 
							tc.valor_hora, tc.direccion, pcias.provincia, tc.saldo
							FROM tecnicos as tc JOIN cargos as cg
							ON (id_cargo = cg.id)
							JOIN tipos_iva_responsable as iva
							ON(tc.id_tipo_iva_responsable = iva.id)
							JOIN provincias as pcias
							ON(tc.id_provincia = pcias.id)
							WHERE tc.id_empresa = $this->id_empresa";
			$getTecnicos = $this->conexion->consultaRetorno($queryTraerTecnicos);

			$arrayTecnicos = array();

			while ($rowTecnicos = $getTecnicos->fetch_array()) {
				$id_tecnico = $rowTecnicos['id']	;
				$legajo = $rowTecnicos['nro_legajo'];
				$nombre = $rowTecnicos['nombre_completo'];
				$cuil = $rowTecnicos['cuil'];
				$telefono = $rowTecnicos['telefono'];
				$email = $rowTecnicos['email'];
				$cargo = $rowTecnicos['cargo'];
				$activo = $rowTecnicos['activo'];
				$fecha_alta = date("d/m/Y", strtotime($rowTecnicos['fecha_alta']));
				$tipo_iva = $rowTecnicos['tipo_iva'];
				$valor_hora = "$".number_format($rowTecnicos['valor_hora'],2,',','.');
				$direccion = $rowTecnicos['direccion'];
				$provincia = $rowTecnicos['provincia'];
				$saldo = $rowTecnicos['saldo'];
				$arrayTecnicos[] = array('id_tecnico'=>$id_tecnico, 'legajo'=>$legajo, 'nombre'=>$nombre, 'cuil'=>$cuil, 'telefono'=>$telefono, 'email'=>$email, 'cargo'=>$cargo, 'activo'=>$activo, 'fecha_alta'=>$fecha_alta, 'tipo_iva'=>$tipo_iva, 'valor_hora'=>$valor_hora, 'direccion'=>$direccion, 'provincia'=>$provincia, 'saldo'=>$saldo);
			}

			echo json_encode($arrayTecnicos);

		}

		public function agregarTecnico($nombre, $legajo, $cuit, $telefono, $email, $cargo, $iva, $direccion, $provincia, $valHora, $id_empresa){
			$fecha_alta = date('Y-m-d');


			/*GUARDO EN TABLA TECNICOS*/
			$queryInsertTecnico = "INSERT INTO tecnicos(nombre_completo, nro_legajo, cuil, telefono, email, id_cargo, fecha_alta, activo, id_tipo_iva_responsable, valor_hora, direccion, id_provincia, saldo, id_empresa)VALUES('$nombre', '$legajo', '$cuit', '$telefono', '$email', $cargo, '$fecha_alta', 0, $iva, $valHora, '$direccion', $provincia, 0, $id_empresa)";
			$insertTecnico= $this->conexion->consultaSimple($queryInsertTecnico);

			
		}

		public function deleteTecnico($id_tecnico){
			$this->id_tecnico = $id_tecnico;
			
			/*Tabla tecnicos*/
			$queryDelTecnico = "DELETE FROM tecnicos WHERE id=$this->id_tecnico";
			$delTecnico = $this->conexion->consultaSimple($queryDelTecnico);

		}

		public function traerTecnicoUpdate($id_tecnico){

			$this->id_tecnico = $id_tecnico;

			$queryTraerTecnicos = "SELECT id, nombre_completo, nro_legajo, cuil,
								telefono, email, id_cargo, activo, 
								id_tipo_iva_responsable as tipo_iva, valor_hora,
								direccion, id_provincia as provincia, saldo
							FROM tecnicos
							WHERE id = $this->id_tecnico";
			$getTecnicos = $this->conexion->consultaRetorno($queryTraerTecnicos);

			$arrayDatosTecnico= array();
			$arrayTecnicos = array();

			while ($rowTecnicos = $getTecnicos->fetch_array()) {
				$id_tecnico = $rowTecnicos['id']	;
				$legajo = $rowTecnicos['nro_legajo'];
				$nombre = $rowTecnicos['nombre_completo'];
				$cuil = $rowTecnicos['cuil'];
				$telefono = $rowTecnicos['telefono'];
				$email = $rowTecnicos['email'];
				$cargo = $rowTecnicos['id_cargo'];
				$activo = $rowTecnicos['activo'];
				$tipo_iva = $rowTecnicos['tipo_iva'];
				$valor_hora = $rowTecnicos['valor_hora'];
				$direccion = $rowTecnicos['direccion'];
				$provincia = $rowTecnicos['provincia'];
				$saldo = $rowTecnicos['saldo'];
				$arrayTecnicos[] = array('id_tecnico'=>$id_tecnico, 'legajo'=>$legajo, 'nombre'=>$nombre, 'cuil'=>$cuil, 'telefono'=>$telefono, 'email'=>$email, 'cargo'=>$cargo, 'activo'=>$activo, 'tipo_iva'=>$tipo_iva, 'valor_hora'=>$valor_hora, 'direccion'=>$direccion, 'provincia'=>$provincia, 'saldo'=>$saldo);
			}
			

			$arrayDatosTecnicos['datos_tecnico'] = $arrayTecnicos;
			echo json_encode($arrayDatosTecnicos);
		}

		public function updateTecnico($nombre, $legajo, $cuit, $telefono, $email, $cargo, $iva, $direccion, $provincia, $valHora, $id_tecnico){

			$this->id_tecnico=$id_tecnico;

			//Actualizo datos de empresa
			$queryUpdateTecnico = "UPDATE tecnicos SET nombre_completo = '$nombre', nro_legajo='$legajo', cuil='$cuit', telefono = '$telefono', email='$email', id_cargo=$cargo, id_tipo_iva_responsable=$iva, valor_hora= $valHora, direccion= '$direccion', id_provincia = $provincia
				WHERE id = $this->id_tecnico";

			$updateTecnico = $this->conexion->consultaSimple($queryUpdateTecnico);
		
		}

		public function cambiarEstado($id_tecnico, $estado){

			$this->id_tecnico = $id_tecnico;

			$queryUpdateEstado = "UPDATE tecnicos SET activo = $estado 
								WHERE id = $this->id_tecnico";
			$updateEstado = $this->conexion->consultaSimple($queryUpdateEstado);
		}

	}

if (isset($_POST['accion'])) {
		$lejagosTecnicos = new LejagosTecnicos();
		switch ($_POST['accion']) {
			case 'traerTecnicoUpdate':
					$id_tecnico = $_POST['id_tecnico'];
					$lejagosTecnicos->traerTecnicoUpdate($id_tecnico);
				break;
			case 'updateTecnico':
					$nombre = $_POST['nombre'];
					$legajo = $_POST['legajo'];
					$cuit = $_POST['cuit'];
					$telefono = $_POST['telefono'];
					$email = $_POST['email'];
					$cargo = $_POST['cargo'];
					$iva = $_POST['iva'];
					$direccion = $_POST['direccion'];
					$provincia = $_POST['provincia'];
					$valHora = $_POST['valHora'];
					$id_tecnico = $_POST['id_tecnico'];

					$lejagosTecnicos->updateTecnico($nombre, $legajo, $cuit, $telefono, $email, $cargo, $iva, $direccion, $provincia, $valHora, $id_tecnico);
				break;
			case 'addTecnico':
					$nombre = $_POST['nombre'];
					$legajo = $_POST['legajo'];
					$cuit = $_POST['cuit'];
					$telefono = $_POST['telefono'];
					$email = $_POST['email'];
					$cargo = $_POST['cargo'];
					$iva = $_POST['iva'];
					$direccion = $_POST['direccion'];
					$provincia = $_POST['provincia'];
					$valHora = $_POST['valHora'];
					$id_empresa = $_POST['id_empresa'];

					$lejagosTecnicos->agregarTecnico($nombre, $legajo, $cuit, $telefono, $email, $cargo, $iva, $direccion, $provincia, $valHora, $id_empresa);
				break;
			case 'eliminarTecnico':
					$id_tecnico = $_POST['id_tecnico'];
					$lejagosTecnicos->deleteTecnico($id_tecnico);
				break;
			case 'traerDatosIniciales':
				$lejagosTecnicos->traerDatosIniciales();
				break;
			case 'cambiarEstado':
					$id_tecnico = $_POST['id_tecnico'];
					$estado = $_POST['estado'];
					$lejagosTecnicos->cambiarEstado($id_tecnico, $estado);
			break;
		}
	}else{
		if (isset($_GET['accion'])) {

			$lejagosTecnicos = new LejagosTecnicos();

			switch ($_GET['accion']) {
				case 'traerTecnicos':
					$id_empresa = $_GET['id_empresa'];
					$lejagosTecnicos->traerTecnicos($id_empresa);
					break;
				
				default:
					// code...
					break;
			}

		}
	}

?>