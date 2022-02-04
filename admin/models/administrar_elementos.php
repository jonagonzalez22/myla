<?php
require_once('conexion.php');
require_once('administrar_clientes.php');
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}
//var_dump($_SESSION);
extract($_REQUEST);
//$cliente = new Cliente();
class Elemento{

		private $id_elemento;

		public function __construct(){
			$this->conexion = new Conexion();
      $this->id_empresa = $_SESSION["rowUsers"]["id_empresa"];
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosInicialesElementos(){
      $datosIniciales = array();
      $tecnicos = array();
      $direcciones_cliente = array();
			//$totalizadores = array();

      $cliente = new Clientes();
      $listaClientes=$cliente->traerClientes($this->id_empresa);
      $listaClientes=json_decode($listaClientes,true);
      //var_dump($listaClientes);

      /*DIRECCIONES CLIENTES*/
			$query = "SELECT id as id_direccion_cliente, direccion FROM direcciones_clientes";
			$getDatos = $this->conexion->consultaRetorno($query);
      /*CARGO ARRAY TECNICOS*/
			while ($row= $getDatos->fetch_array()) {
				$id_direccion_cliente = $row['id_direccion_cliente'];
				$direccion = $row['direccion'];
				$direcciones_cliente[] = array('id_direccion_cliente' => $id_direccion_cliente, 'direccion' =>$direccion);
			}
      //var_dump($direcciones_cliente);

			//$datosIniciales["proveedores"] = $proveedores;
      //$datosIniciales["tecnicos"] = $tecnicos;
      $datosIniciales["direcciones_cliente"] = $direcciones_cliente;
      $datosIniciales["clientes"] = $listaClientes;
			//$datosIniciales["totalizadores"] = $totalizadores;

			echo json_encode($datosIniciales);
		}

		public function traerElementos($filtros=0){

      $filtro_elemento="";
      $filtro_cliente="";
      if($filtros!=0){
          //var_dump($filtros);
          if(isset($filtros["id_elemento"]) and $filtros["id_elemento"]!=""){
              $filtro_elemento=" AND ac.id = ".$filtros["id_elemento"];
          }
          if(isset($filtros["id_cliente"]) and $filtros["id_cliente"]!=""){
              $filtro_cliente=" AND c.id = ".$filtros["id_cliente"];
          }
      }
      
			$arrayElementos = array();

			$queryGet = "SELECT ac.id AS id_elemento,ac.id_direccion_cliente,ac.descripcion,ac.ubicacion,ac.fecha_alta,ac.id_tecnico_ultima_revision,ac.fecha_hora_ultima_revision,ac.activo,IF(ac.activo=1,'Activo','Inactivo') AS estado,c.id AS id_cliente,c.razon_social
      FROM activos_cliente ac 
      INNER JOIN direcciones_clientes dc ON ac.id_direccion_cliente=dc.id 
      INNER JOIN clientes c ON dc.id_cliente=c.id
      WHERE c.id_empresa = $this->id_empresa $filtro_elemento $filtro_cliente";
      //var_dump($queryGet);
			$getDatos = $this->conexion->consultaRetorno($queryGet);

			while ($row = $getDatos->fetch_array()) {
        /*$id_elemento = $row['id_elemento'];
				$id_direccion_cliente = $row['id_direccion_cliente'];
        $id_cliente= $row["id_cliente"];*/

        $fecha_alta = $row['fecha_alta'];
        $fecha_hora_ultima_revision = $row['fecha_hora_ultima_revision'];

				//$arrayElementos[] = array('id_elemento'=>$id_elemento, 'id_direccion_cliente'=>$id_direccion_cliente, 'descripcion' => $descripcion, 'ubicacion' => $ubicacion, 'id_tecnico_ultima_revision' => $id_tecnico_ultima_revision, 'activo' => $activo, 'estado'=>$estado, 'fecha_alta'=>$fecha_alta, 'fecha_alta_mostrar'=>$fecha_alta_mostrar, 'fecha_hora_ultima_revision'=>$fecha_hora_ultima_revision);

        $arrayElementos[] = array(
          'id_elemento'=>$row['id_elemento'],
          'id_direccion_cliente'=>$row['id_direccion_cliente'],
          'id_cliente'=>$row['id_cliente'],
          'cliente'=>$row['razon_social'],
          'descripcion' => $row['descripcion'],
          'ubicacion' => $row['ubicacion'],
          'id_tecnico_ultima_revision' => $row['id_tecnico_ultima_revision'],
          'activo' => $row['activo'],
          'estado'=>$row['estado'],
          'fecha_alta'=>$fecha_alta,
          'fecha_alta_mostrar'=>date("d/m/Y", strtotime($fecha_alta)),
          'fecha_hora_ultima_revision'=>$fecha_hora_ultima_revision,
          'fecha_hora_ultima_revision_mostrar'=>date("d/m/Y H:i", strtotime($fecha_hora_ultima_revision))."hs",
        );
			}
			//echo json_encode($arrayElementos);
      return json_encode($arrayElementos);
		}

		public function agregarElemento($id_direccion_cliente, $descripcion, $ubicacion){
			//$fecha_alta = date('Y-m-d H:i:s');
      $activo = 1;
      $hash="";

			/*GUARDO EN TABLA EMPRESA*/
			$queryInsert = "INSERT INTO activos_cliente (id_direccion_cliente, descripcion, ubicacion, hash, activo) VALUES('$id_direccion_cliente', '$descripcion', '$ubicacion', '$hash', '$activo')";
      //echo $queryInsert;
			$insertar= $this->conexion->consultaSimple($queryInsert);

      $mensajeError=$this->conexion->conectar->error;
      //var_dump($mensajeError);
      echo $mensajeError;
      if($mensajeError!=""){
        echo "<br><br>".$queryInsert;
      }

      /*BUSCO EL ID DEL VEHICULO CREADO PARA GUARDAR EL HISTORIAL DE TECNICOS*/
      /*$queryGetIdVehiculo = "SELECT id as id_elemento FROM vehiculos 
        WHERE patente = '$patente'
        AND fecha_alta = '$fecha_alta'";
      $getIdVehiculo = $this->conexion->consultaRetorno($queryGetIdVehiculo);
      if ($getIdVehiculo->num_rows > 0 ) {
          $idRow = $getIdVehiculo->fetch_assoc();
          $id_elemento = $idRow['id_elemento'];
      }*/

      /*GUARDO EL HISTORIAL DE TECNICOS*/
			/*$queryInsertVehiculo = "INSERT INTO asignacion_tecnico_vehiculo (id_elemento, id_tecnico, fecha, validado) VALUES('$id_elemento', '$tecnico', NOW(), 1)";
			$insertarVehiculo= $this->conexion->consultaSimple($queryInsertVehiculo);*/
			
		}

    /*public function traerVechiculoUpdate($id_elemento){
			$this->id_elemento = $id_elemento;

			$queryGetVehiculoUpdate = "SELECT id, patente, fecha_adquirido, fecha_baja, id_tecnico_asignado, comentarios, proximo_service_general, km_adquirido, proximo_vencimiento_vtv, km_actuales
								FROM vehiculos
								WHERE id = $this->id_elemento";
			$getVehiculoUpdate= $this->conexion->consultaRetorno($queryGetVehiculoUpdate);

			$arrayDatosVehiculos= array();
			$arrayVehiculos = array();

        $rowVehiculo = $getVehiculoUpdate->fetch_assoc();

				$patente = $rowVehiculo['patente'];
				//$fecha_alta = $rowVehiculo['fecha_alta'];
				$fecha_adquirido = $rowVehiculo['fecha_adquirido'];
				$fecha_baja = $rowVehiculo['fecha_baja'];
				$tecnico = $rowVehiculo['id_tecnico_asignado'];
				$comentarios = $rowVehiculo['comentarios'];
				$proximo_service_general = $rowVehiculo['proximo_service_general'];
				$km_adquirido = $rowVehiculo['km_adquirido'];
				$proximo_vencimiento_vtv = $rowVehiculo['proximo_vencimiento_vtv'];
				$km_actuales = $rowVehiculo['km_actuales'];
				
				$arrayVehiculos = array('patente'=>$patente, 'fecha_adquirido'=>$fecha_adquirido, 'fecha_baja'=>$fecha_baja, 'tecnico'=>$tecnico, 'comentarios'=>$comentarios, 'proximo_service_general'=>$proximo_service_general, 'km_adquirido'=>$km_adquirido, 'proximo_vencimiento_vtv'=>$proximo_vencimiento_vtv, 'km_actuales'=>$km_actuales);

			$arrayDatosVehiculos['datos_vehiculo'] = $arrayVehiculos;
      return json_encode($arrayDatosVehiculos);
		}*/

    public function updateElemento($id_elemento, $id_direccion_cliente, $descripcion, $ubicacion){

			$this->id_elemento=$id_elemento;

			//Actualizo datos del vehiculo
      $queryUpdate = "UPDATE activos_cliente set id_direccion_cliente = '$id_direccion_cliente', descripcion = '$descripcion', ubicacion = '$ubicacion'
      WHERE id = $this->id_elemento";
      //echo $queryUpdate;
			$update = $this->conexion->consultaSimple($queryUpdate);
      //var_dump("afectados: ".$this->conexion->conectar->affected_rows);
      $mensajeError=$this->conexion->conectar->error;
      //var_dump($mensajeError);
      echo $mensajeError;
      /*$error=0;
      if($mensajeError!=""){
        $error=1;
      }*/

      /*BUSCO EL ID DEL VEHICULO CREADO PARA GUARDAR EL HISTORIAL DE TECNICOS*/
      /*$queryGetIdTecnico = "SELECT id_tecnico FROM asignacion_tecnico_vehiculo 
        WHERE id_elemento = '$id_elemento'
        ORDER BY fecha DESC LIMIT 1";
      $getIdTecnico = $this->conexion->consultaRetorno($queryGetIdTecnico);
      $id_tecnico=0;
      if ($getIdTecnico->num_rows > 0 ) {
        $idRow = $getIdTecnico->fetch_assoc();
        $id_tecnico = $idRow['id_tecnico'];
      }*/

      /*SI LOS TECNICOS SON DIFERENTES, GUARDO EL HISTORIAL DE TECNICOS*/
      /*if($id_tecnico!=$tecnico){
        $queryInsertVehiculo = "INSERT INTO asignacion_tecnico_vehiculo (id_elemento, id_tecnico, fecha, validado) VALUES('$id_elemento', '$tecnico', NOW(), 1)";
        $insertarVehiculo= $this->conexion->consultaSimple($queryInsertVehiculo);
      }*/

		}

    public function deleteElemento($id_elemento){
			$this->id_elemento = $id_elemento;

			/*Eliminamos registros de la base de datos*/

			/*Tabla activos_cliente*/
			$queryDelete = "DELETE FROM activos_cliente WHERE id=$this->id_elemento";
			$delte = $this->conexion->consultaSimple($queryDelete);

		}

}

	if (isset($_POST['accion'])) {
		$elemento = new Elemento();
		switch ($_POST['accion']) {
			case 'traerDatosInicialesElementos':
			  	$elemento->traerDatosInicialesElementos();
			break;
			case 'addElemento':
					$elemento->agregarElemento($id_direccion_cliente, $descripcion, $ubicacion);
			break;
      case 'traerElementoUpdate':
      case 'trerDetalleElemento':
					//$id_elemento = $_POST['id_elemento'];
					//echo $elemento->traerVechiculoUpdate($id_elemento);
          $filtros=[];
          if(isset($id_elemento)) $filtros["id_elemento"]=$id_elemento;
          if(isset($id_cliente)) $filtros["id_cliente"]=$id_cliente;
          echo $elemento->traerElementos($filtros);
			break;
      case 'updateElemento':
        $elemento->updateElemento($id_elemento, $id_direccion_cliente, $descripcion, $ubicacion);
      break;
      case 'eliminarElemento':
        //$id_elemento = $_POST['id_elemento'];
        $elemento->deleteElemento($id_elemento);
      break;
      case 'trerElementosCliente':
        //$id_elemento = $_POST['id_elemento'];
        //echo $elemento->traerVechiculoUpdate($id_elemento);
        $filtros=[];
        if(isset($id_elemento)) $filtros["id_elemento"]=$id_elemento;
        if(isset($id_cliente)) $filtros["id_cliente"]=$id_cliente;
        echo $elemento->traerElementos($filtros);
    break;
		}
	}else{
		if (isset($_GET['accion'])) {
			$elemento = new Elemento();

			switch ($_GET['accion']) {
				case 'traerElementos':
					$elementos=$elemento->traerElementos();
          $elementos=json_decode($elementos,true);

          $listarElementos=[];
          foreach ($elementos as $elemento) {
            $listarElementos[]=[
              "id_elemento"               =>$elemento["id_elemento"],
              "direccion"                 =>$elemento["descripcion"],
              "descripcion"               =>$elemento["descripcion"],
              "ubicacion"                 =>$elemento["ubicacion"],
              "id_tecnico_ultima_revision"=>$elemento["id_tecnico_ultima_revision"],
              "tecnico_ultima_revision"   =>$elemento["id_tecnico_ultima_revision"],
              "fecha_hora_ultima_revision"=>$elemento["fecha_hora_ultima_revision"],
              "estado"                    =>$elemento["estado"],
            ];
          }
          echo json_encode($listarElementos);
				break;
			}
		}
	}
?>