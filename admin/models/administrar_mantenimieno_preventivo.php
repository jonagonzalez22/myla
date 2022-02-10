<?php
	session_start();
	require_once('conexion.php');
  require_once('administrar_vehiculos.php');
  require_once('administrar_clientes.php');
  require_once('administrar_almacenes.php');
  
  extract($_REQUEST);
	class MantenimientoPreventivo{

		private $id_mantenimiento_preventivo;
    private $id_empresa;

		public function __construct(){
			$this->conexion = new Conexion();
      $this->id_empresa = $_SESSION["rowUsers"]["id_empresa"];
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosIniciales(){
      $datosIniciales = array();

      $vehiculo = new Vehiculo();
      $listaVehiculos=$vehiculo->traerVehiculos();
      $listaVehiculos=json_decode($listaVehiculos,true);

      $cliente = new Clientes();
      $listaClientes=$cliente->traerClientes($this->id_empresa);
      $listaClientes=json_decode($listaClientes,true);

      $almacen = new Almacenes();
      //$listaAlmacenes=$almacen->traerAlmacenes($this->id_empresa);
      $listaAlmacenes=$almacen->traerAlmacenes();
      $listaAlmacenes=json_decode($listaAlmacenes,true);
      //var_dump($listaAlmacenes);

      $datosIniciales["vehiculos"] = $listaVehiculos;
      $datosIniciales["clientes"] = $listaClientes;
      $datosIniciales["almacenes"] = $listaAlmacenes;

			echo json_encode($datosIniciales);
		}

		public function traerMantenimientoPreventivo($filtros=0){

      /*$filtro_mantenimiento_preventivo="";
      if($id_mantenimiento_preventivo!=0){
        $filtro_mantenimiento_preventivo=" AND cm.id = $id_mantenimiento_preventivo";
      }*/
      $filtro_mantenimiento_preventivo="";
      if($filtros!=0){
          //var_dump($filtros);
          if(isset($filtros["id_mantenimiento_preventivo"]) and $filtros["id_mantenimiento_preventivo"]!=""){
              $filtro_mantenimiento_preventivo=" AND cm.id = ".$filtros["id_mantenimiento_preventivo"];
          }
      }
			
			$arrayMantenimientoPreventivo = [];

			$queryGet = "SELECT cm.id AS id_mantenimiento_preventivo,cm.id_usuario_alta,cm.fecha_alta,cm.id_activo_cliente,ac.descripcion AS descripcion_activo,dc.id AS id_direccion_cliente,dc.direccion,cm.asunto,cm.detalle,cm.fecha_hora_ejecucion_desde,cm.fecha_hora_ejecucion_hasta,cm.id_estado,etm.estado,cm.id_contacto_cliente,cc.nombre_completo AS contacto_cliente,c.id AS id_cliente,c.razon_social AS cliente
      FROM calendario_mantenimiento cm 
      INNER JOIN activos_cliente ac ON cm.id_activo_cliente=ac.id 
      INNER JOIN direcciones_clientes dc ON ac.id_direccion_cliente=dc.id
      INNER JOIN estados_tareas_mantenimiento etm ON cm.id_estado=etm.id 
      INNER JOIN contactos_clientes cc ON cm.id_contacto_cliente=cc.id 
      INNER JOIN clientes c ON cc.id_cliente=c.id
      WHERE c.id_empresa = $this->id_empresa $filtro_mantenimiento_preventivo";
			$getDatos = $this->conexion->consultaRetorno($queryGet);

			while ($row = $getDatos->fetch_array()) {
        $fecha_alta=$row["fecha_alta"];
        $fecha_hora_ejecucion_desde=$row["fecha_hora_ejecucion_desde"];
        $fecha_hora_ejecucion_hasta=$row["fecha_hora_ejecucion_hasta"];
        $arrayMantenimientoPreventivo[] =[
          "id_mantenimiento_preventivo"       =>$row["id_mantenimiento_preventivo"],
          "id_usuario_alta"                   =>$row["id_usuario_alta"],
          "fecha_alta"                        =>($fecha_alta == 0) ? "" : $fecha_alta,
          "fecha_alta_mostrar"                =>($fecha_alta == 0) ? "" : date("d/m/Y", strtotime($fecha_alta)),
          "id_activo_cliente"                 =>$row["id_activo_cliente"],
          "descripcion_activo"                =>$row["descripcion_activo"],
          "id_direccion_cliente"              =>$row["id_direccion_cliente"],
          "direccion"                         =>$row["direccion"],
          "asunto"                            =>$row["asunto"],
          "detalle"                           =>$row["detalle"],
          "fecha_hora_ejecucion_desde"        =>($fecha_hora_ejecucion_desde == 0) ? "" : date("Y-m-d\TH:i", strtotime($fecha_hora_ejecucion_desde)),
          "fecha_hora_ejecucion_desde_mostrar"=>($fecha_hora_ejecucion_desde == 0) ? "" : date("d/m/Y H:i", strtotime($fecha_hora_ejecucion_desde))."hs",
          "fecha_hora_ejecucion_hasta"        =>($fecha_hora_ejecucion_hasta == 0) ? "" : date("Y-m-d\TH:i", strtotime($fecha_hora_ejecucion_hasta)),
          "fecha_hora_ejecucion_hasta_mostrar"=>($fecha_hora_ejecucion_hasta == 0) ? "" : date("d/m/Y H:i", strtotime($fecha_hora_ejecucion_hasta))."hs",
          "id_estado"                         =>$row["id_estado"],
          "estado"                            =>$row["estado"],
          "id_contacto_cliente"               =>$row["id_contacto_cliente"],
          "id_cliente"                        =>$row["id_cliente"],
          "cliente"                           =>$row["cliente"],
          "contacto_cliente"                  =>$row["contacto_cliente"]
        ];
			}
			//echo json_encode($arrayMantenimientoPreventivo);
      return json_encode($arrayMantenimientoPreventivo);
		}

		public function agregarMantenimientoPreventivo($id_elemento_cliente, $asunto, $detalle, $id_contacto_cliente, $fecha_hora_ejecucion_desde, $fecha_hora_ejecucion_hasta, $frecuencia_cantidad, $frecuencia_repeticion, $frecuencia_stop, $aItems, $adjuntos, $cantAdjuntos){
      $activo = 1;
      $id_usuario_alta=$_SESSION["rowUsers"]["id_usuario"];
      $id_estado=1;

      $eventos[]=[
        "desde"=>date("Y-m-d H:i",strtotime($fecha_hora_ejecucion_desde)),
        "hasta"=>date("Y-m-d H:i",strtotime($fecha_hora_ejecucion_hasta))
      ];
      while($fecha_hora_ejecucion_desde<=$frecuencia_stop){
        $fecha_hora_ejecucion_desde=date("Y-m-d H:i",strtotime($fecha_hora_ejecucion_desde."+$frecuencia_cantidad $frecuencia_repeticion"));
        $fecha_hora_ejecucion_hasta=date("Y-m-d H:i",strtotime($fecha_hora_ejecucion_hasta."+$frecuencia_cantidad $frecuencia_repeticion"));
        $eventos[]=[
          "desde"=>date("Y-m-d H:i",strtotime($fecha_hora_ejecucion_desde)),
          "hasta"=>date("Y-m-d H:i",strtotime($fecha_hora_ejecucion_hasta))
        ];
      }
      //var_dump($eventos);

      $b=1;
      $id_referencia_original=0;
      foreach($eventos as $repeticion){
        /*GUARDO EN TABLA EMPRESA*/
        $queryInsert = "INSERT INTO calendario_mantenimiento (id_usuario_alta, fecha_alta, id_activo_cliente, asunto, detalle, id_contacto_cliente, fecha_hora_ejecucion_desde, fecha_hora_ejecucion_hasta, id_estado, id_referencia_original) VALUES ('$id_usuario_alta', NOW(), '$id_elemento_cliente', '$asunto', '$detalle', '$id_contacto_cliente', '".$repeticion["desde"]."', '".$repeticion["hasta"]."', '$id_estado',$id_referencia_original)";
        //echo $queryInsert;
        $insertar= $this->conexion->consultaSimple($queryInsert);
        //var_dump($insertar);
        
        $id_calendario_mantenimiento=$this->conexion->conectar->insert_id;
        if($b==1){
          $id_referencia_original=$id_calendario_mantenimiento;
          $b=0;
        }
        $mensajeError=$this->conexion->conectar->error;
        echo $mensajeError;
        if($mensajeError!=""){
          echo "<br><br>".$queryInsert;
        }

        foreach($aItems as $id_item => $datos){
          $id_item=explode("-",$id_item);
          $id_item=$id_item[1];
          $cantidad_estimada=$datos["cantidad"];
          $id_proveedor=$datos["proveedor"];
          /*var_dump($id_item);
          var_dump($datos);*/

          //INSERTO DATOS EN LA TABLA ADJUNTOS ORDEN_COMPRA
          $queryInsertMateriales = "INSERT INTO materiales_mantenimiento (id_item, id_calendario_mantenimiento, cantidad_estimada, id_proveedor) VALUES ($id_item, $id_calendario_mantenimiento, $cantidad_estimada, $id_proveedor)";
          $insertAdjuntos = $this->conexion->consultaSimple($queryInsertMateriales);
          $mensajeError=$this->conexion->conectar->error;
      
          echo $mensajeError;
          if($mensajeError!=""){
            echo "<br><br>".$queryInsertMateriales;
          }
        }

        //SI VIENEN ADJUNTOS LOS GUARDO.
        if ($adjuntos > 0) {
          $comentarios="";
          $etiquetas="";
          for ($i=0; $i < $cantAdjuntos; $i++) { 
            $indice = "file".$i;
            $nombreADJ = $_FILES[$indice]['name'];

            //INSERTO DATOS EN LA TABLA ADJUNTOS ORDEN_COMPRA
            $queryInsertAdjuntos = "INSERT INTO adjuntos_tareas_mantenimiento(id_calendario_mantenimiento, archivo, fecha_hora, id_usuario_alta, comentarios, etiquetas)VALUES($id_calendario_mantenimiento, '$nombreADJ',NOW(),'$id_usuario_alta','$comentarios', '$etiquetas')";
            $insertAdjuntos = $this->conexion->consultaSimple($queryInsertAdjuntos);

            $mensajeError=$this->conexion->conectar->error;
        
            echo $mensajeError;
            if($mensajeError!=""){
              echo "<br><br>".$queryInsert;
            }
            
            //INGRESO ARCHIVOS EN EL DIRECTORIO
            $directorio = "../views/mantenimiento_preventivo/";
            move_uploaded_file($_FILES[$indice]['tmp_name'], $directorio."adj_".$id_calendario_mantenimiento."_".$nombreADJ);
            //$ruta_completa_imagen = $directorio.$nombreFinalArchivo;
          }
        }
      }
      $queryUpdate = "UPDATE calendario_mantenimiento SET id_referencia_original = $id_referencia_original WHERE id = $id_referencia_original";
      //echo $queryUpdate;
      $update= $this->conexion->consultaSimple($queryUpdate);
      $mensajeError=$this->conexion->conectar->error;
    
      echo $mensajeError;
      if($mensajeError!=""){
        echo "<br><br>".$queryUpdate;
      }
      //echo 1;

		}

    public function updateMantenimientoPreventivo($id_mantenimiento_preventivo, $id_elemento_cliente, $asunto, $detalle, $id_contacto_cliente, $fecha_hora_ejecucion_desde, $fecha_hora_ejecucion_hasta, $adjuntos, $cantAdjuntos){

			$this->id_mantenimiento_preventivo=$id_mantenimiento_preventivo;
      $id_estado=1;

			//Actualizo datos del vehiculo
      $query = "UPDATE calendario_mantenimiento set id_activo_cliente = '$id_elemento_cliente', asunto = '$asunto', detalle = '$detalle', id_contacto_cliente = '$id_contacto_cliente', fecha_hora_ejecucion_desde = '$fecha_hora_ejecucion_desde', fecha_hora_ejecucion_hasta = '$fecha_hora_ejecucion_hasta', id_estado = '$id_estado'
      WHERE id = $this->id_mantenimiento_preventivo";
      //echo $query;
			$update = $this->conexion->consultaSimple($query);
      
      $filasAfectadas=$this->conexion->conectar->affected_rows;
      $mensajeError=$this->conexion->conectar->error;
      //var_dump($mensajeError);
      echo $mensajeError;
      if($mensajeError!=""){
        echo "<br><br>".$query;
      }

      /*BUSCO EL ID DEL VEHICULO CREADO PARA GUARDAR EL HISTORIAL DE TECNICOS*/
      /*$queryGetIdTecnico = "SELECT id_tecnico FROM asignacion_tecnico_vehiculo 
        WHERE id_mantenimiento_preventivo = '$id_mantenimiento_preventivo'
        ORDER BY fecha DESC LIMIT 1";
      $getIdTecnico = $this->conexion->consultaRetorno($queryGetIdTecnico);
      $id_tecnico=0;
      if ($getIdTecnico->num_rows > 0 ) {
        $idRow = $getIdTecnico->fetch_assoc();
        $id_tecnico = $idRow['id_tecnico'];
      }*/

      /*SI LOS TECNICOS SON DIFERENTES, GUARDO EL HISTORIAL DE TECNICOS*/
      /*if($id_tecnico!=$tecnico){
        $queryInsertVehiculo = "INSERT INTO asignacion_tecnico_vehiculo (id_mantenimiento_preventivo, id_tecnico, fecha, validado) VALUES('$id_mantenimiento_preventivo', '$tecnico', NOW(), 1)";
        $insertarVehiculo= $this->conexion->consultaSimple($queryInsertVehiculo);
      }*/

		}

    public function eliminarMantenimientoPreventivo($id_mantenimiento_preventivo){
			$this->id_mantenimiento_preventivo = $id_mantenimiento_preventivo;

			/*Eliminamos registros de la base de datos*/

			/*Tabla vehiculos*/
			$queryDelelte = "DELETE FROM calendario_mantenimiento WHERE id=$this->id_mantenimiento_preventivo";
			$delete = $this->conexion->consultaSimple($queryDelelte);

		}

    public function marcarMantenimientoPreventivoRealizada($id_mantenimiento){
      $id_usuario_ultima_actualizacion=$_SESSION["rowUsers"]["id_usuario"];

      $queryMarcarCompleta = "UPDATE mantenimientos_vehiculares set realizado = 1
      WHERE id = $id_mantenimiento";
      //echo $queryMarcarCompleta;
			$marcarCompleta = $this->conexion->consultaSimple($queryMarcarCompleta);

      /*BUSCO EL ID DEL VEHICULO CREADO PARA GUARDAR EL HISTORIAL DE TECNICOS*/
      $queryGetRealizadoMantenimiento = "SELECT realizado FROM mantenimientos_vehiculares 
        WHERE id_mantenimiento = '$id_mantenimiento'";
      $getRealizadoMantenimiento = $this->conexion->consultaRetorno($queryGetRealizadoMantenimiento);
      $realizado=0;
      if ($getRealizadoMantenimiento->num_rows > 0 ) {
        $idRow = $getRealizadoMantenimiento->fetch_assoc();
        $realizado = $idRow['realizado'];
      }

      echo $realizado;
		}

}

	if (isset($_POST['accion'])) {
		$mantenimiento_preventivo = new MantenimientoPreventivo();
		switch ($_POST['accion']) {
			case 'traerDatosInicialesMantenimientoPreventivo':
			  	$mantenimiento_preventivo->traerDatosIniciales();
			break;
      /*case 'traerMantenimientoPreventivoUpdate':
          echo $mantenimiento_preventivo->traerMantenimientoPreventivo($id_mantenimiento_preventivo);
			break;*/
			case 'addMantenimientoPreventivo':
        //var_dump($_FILES);
        if(isset($_FILES['file0'])) {
          $adjuntos = 1;
        }else{
          $adjuntos = 0;
        }
        $aItems=json_decode($itemsJSON,true);

				$mantenimiento_preventivo->agregarMantenimientoPreventivo($id_elemento_cliente, $asunto, $detalle, $id_contacto_cliente, $fecha_hora_ejecucion_desde, $fecha_hora_ejecucion_hasta, $frecuencia_cantidad, $frecuencia_repeticion, $frecuencia_stop, $aItems, $adjuntos, $cantAdjuntos);
			break;
      case 'updateMantenimientoPreventivo':
        $mantenimiento_preventivo->updateMantenimientoPreventivo($id_mantenimiento_preventivo, $id_elemento_cliente, $asunto, $detalle, $id_contacto_cliente, $fecha_hora_ejecucion_desde, $fecha_hora_ejecucion_hasta, $adjuntos, $cantAdjuntos);
      break;
      /*case 'trerDetalleVehiculo':
        //$id_mantenimiento_preventivo = $_POST['id_mantenimiento_preventivo'];
        $mantenimiento_preventivo->trerDetalleVehiculo($id_mantenimiento_preventivo);
      break;*/
      case 'eliminarMantenimientoPreventivo':
        //$id_mantenimiento_preventivo = $_POST['id_mantenimiento_preventivo'];
        $mantenimiento_preventivo->eliminarMantenimientoPreventivo($id_mantenimiento_preventivo);
      break;
      case 'marcarMantenimientoPreventivoRealizada':
        //$id_mantenimiento_preventivo = $_POST['id_mantenimiento_preventivo'];
        $mantenimiento_preventivo->marcarMantenimientoPreventivoRealizada($id_mantenimiento);
      break;
		}
	}else{
		if (isset($_GET['accion'])) {
			$mantenimiento_preventivo = new MantenimientoPreventivo();

			switch ($_GET['accion']) {
				case 'traerMantenimientoPreventivo':
          $filtros=[];
          if(isset($id_mantenimiento_preventivo)) $filtros["id_mantenimiento_preventivo"]=$id_mantenimiento_preventivo;
					echo $mantenimiento_preventivo->traerMantenimientoPreventivo($filtros);
				break;
        case 'traerMantenimientoPreventivoCalendario':
          $mantenimientosPreventivo=$mantenimiento_preventivo->traerMantenimientoPreventivo();
          $mantenimientosPreventivo=json_decode($mantenimientosPreventivo,true);

          $mantenimientoCalendario=[];
          foreach ($mantenimientosPreventivo as $mantenimiento) {
            $id_mantenimiento_preventivo= $mantenimiento['id_mantenimiento_preventivo'];
            $descripcion_activo= $mantenimiento['descripcion_activo'];
            $fecha_hora_inicio= $mantenimiento['fecha_hora_ejecucion_desde'];
            $fecha_hora_fin= $mantenimiento['fecha_hora_ejecucion_hasta'];
            $id_estado= $mantenimiento['id_estado'];
            $estado= $mantenimiento['estado'];
            $color="";
            switch($id_estado){
              case 1:
                $color="orange";//1 = Pendiente
              break;
              case 2:
                $color="red";//1 = Cancelado
              break;
              case 3:
                $color="green";//1 = Realizado
              break;
            }
            
            $contacto_cliente= $mantenimiento["contacto_cliente"];
            $detalle= $mantenimiento['detalle'];
            $asunto = $mantenimiento['asunto'];
            
            $descripcion="<u>Contacto cliente:</u> ".$contacto_cliente."<br><u>Asunto:</u> ".$asunto."<br><u>Detalle:</u> ".$detalle;//."<br><u>Comentarios:</u> ".$comentarios;
    
            $mantenimientoCalendario[]=[
              "id"          =>$id_mantenimiento_preventivo,
              "title"       =>$descripcion_activo ?? "(Vacío)",
              //"url"       =>"verEnvioLogistica.php?id=".$row["id"],
              "start"       =>$fecha_hora_inicio,
              "end"         =>$fecha_hora_fin,
              "description" =>$descripcion,
              "estado"      =>$estado,
              "color"       =>$color,
              //"classNames"=>"bg-success border-success"
            ];
    
          }
          echo json_encode($mantenimientoCalendario);
				break;
			}
		}
	}
?>