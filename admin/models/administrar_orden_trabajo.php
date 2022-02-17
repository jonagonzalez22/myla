<?php
	//session_start();
  require_once('../../conexion.php');
  if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
  }
  require_once('administrar_clientes.php');
  require_once('administrar_vehiculos.php');
  
  extract($_REQUEST);
	class OrdenTrabajo{

		private $id_orden_trabajo;
    private $id_empresa;

		public function __construct(){
			$this->conexion = new Conexion();
      $this->id_empresa = isset($_SESSION["rowUsers"]["id_empresa"]) ? $_SESSION["rowUsers"]["id_empresa"] : "";
			date_default_timezone_set("America/Buenos_Aires");
		}

		public function traerDatosIniciales(){
      $datosIniciales = array();

      $cliente = new Clientes();
      $listaClientes=$cliente->traerClientes($this->id_empresa);
      $listaClientes=json_decode($listaClientes,true);

      $datosIniciales["clientes"] = $listaClientes;

			echo json_encode($datosIniciales);
		}

		public function traerOrdenTrabajo($filtros=0){

      /*$filtro_orden_trabajo="";
      if($id_orden_trabajo!=0){
        $filtro_orden_trabajo=" AND cm.id = $id_orden_trabajo";
      }*/
      $filtro_orden_trabajo="";
      $selectTecnicos="";
      $joinTecnicos="";
      $filtro_tecnico="";
      $filtro_desde="";
      $filtro_hasta="";
      if($filtros!=0){
          //var_dump($filtros);
          if(isset($filtros["id_orden_trabajo"]) and $filtros["id_orden_trabajo"]!=""){
              $filtro_orden_trabajo=" AND ot.id = ".$filtros["id_orden_trabajo"];
          }
          if(isset($filtros["id_tecnico"]) and $filtros["id_tecnico"]!=""){
              $selectTecnicos=",ttm.fecha_hora_inicio_trabajo,ttm.fecha_hora_fin_trabajo";
              $joinTecnicos="INNER JOIN tecnicos_tareas_mantenimiento ttm ON ttm.id_orden_trabajo=ot.id";
              $filtro_tecnico=" AND ttm.id_tecnico = ".$filtros["id_tecnico"];
          }
          if(isset($filtros["fecha_desde"]) and $filtros["fecha_desde"]!=""){
              $filtro_desde=" AND ot.id = ".$filtros["fecha_desde"];
          }
          if(isset($filtros["fecha_hasta"]) and $filtros["fecha_hasta"]!=""){
              $filtro_hasta=" AND ot.id = ".$filtros["fecha_hasta"];
          }
      }

      $filtro_empresa="";
      if($this->id_empresa!=""){
          $filtro_empresa=" AND c.id_empresa = ".$this->id_empresa;
      }
			
			$arrayOrdenTrabajo = [];

			/*$queryGet = "SELECT ot.id AS id_orden_trabajo,cm.id AS id_calendario_mantenimiento,ac.id AS id_activo_cliente,ac.descripcion AS descripcion_activo,ac.ubicacion,dc.id AS id_direccion_cliente,dc.direccion,cm.asunto,cm.detalle,c.id AS id_cliente,c.razon_social AS cliente,ot.fecha,ot.hora_desde,ot.hora_hasta,ot.fecha_hora_alta,cc.id AS id_contacto_cliente,cc.nombre_completo AS contacto_cliente,eot.id AS id_estado,eot.estado
      FROM ordenes_trabajo ot 
        INNER JOIN tareas_ordenes_trabajo tot ON tot.id_orden_trabajo=ot.id
        INNER JOIN calendario_mantenimiento cm ON tot.id_calendario_mantenimiento=cm.id 
        INNER JOIN activos_cliente ac ON cm.id_activo_cliente=ac.id 
        INNER JOIN direcciones_clientes dc ON ac.id_direccion_cliente=dc.id 
        INNER JOIN clientes c ON dc.id_cliente=c.id 
        INNER JOIN contactos_clientes cc ON cm.id_contacto_cliente=cc.id 
        INNER JOIN estados_ordenes_trabajo eot ON ot.id_estado_orden=eot.id
        $joinTecnicos
      WHERE 1 $filtro_empresa $filtro_orden_trabajo $filtro_tecnico";*/
      $queryGet = "SELECT ot.id AS id_orden_trabajo,ac.id AS id_activo_cliente,ac.descripcion AS descripcion_activo,ac.ubicacion,dc.id AS id_direccion_cliente,dc.direccion,c.id AS id_cliente,c.razon_social AS cliente,ot.fecha,ot.hora_desde,ot.hora_hasta,ot.fecha_hora_alta,cc.id AS id_contacto_cliente,cc.nombre_completo AS contacto_cliente,eot.id AS id_estado,eot.estado $selectTecnicos
      FROM ordenes_trabajo ot 
        INNER JOIN tareas_ordenes_trabajo tot ON tot.id_orden_trabajo=ot.id
        INNER JOIN calendario_mantenimiento cm ON tot.id_calendario_mantenimiento=cm.id 
        INNER JOIN activos_cliente ac ON cm.id_activo_cliente=ac.id 
        INNER JOIN direcciones_clientes dc ON ac.id_direccion_cliente=dc.id 
        INNER JOIN clientes c ON dc.id_cliente=c.id 
        INNER JOIN contactos_clientes cc ON cm.id_contacto_cliente=cc.id 
        INNER JOIN estados_ordenes_trabajo eot ON ot.id_estado_orden=eot.id
        $joinTecnicos
      WHERE 1 $filtro_empresa $filtro_orden_trabajo $filtro_tecnico
      GROUP BY ot.id";
      //var_dump($queryGet);
      //echo $queryGet;
			$getDatos = $this->conexion->consultaRetorno($queryGet);

			while ($row = $getDatos->fetch_array()) {
        $fecha_hora_alta=$row["fecha_hora_alta"];
        $fecha=$row["fecha"];
        $hora_desde=$row["hora_desde"];
        $hora_hasta=$row["hora_hasta"];
        $fecha_hora_inicio_trabajo_tecnico="";
        $fecha_hora_inicio_trabajo_tecnico_mostrar="";
        if(isset($row["fecha_hora_inicio_trabajo"])){
          $fecha_hora_inicio_trabajo_tecnico=$row["fecha_hora_inicio_trabajo"];
          $fecha_hora_inicio_trabajo_tecnico_mostrar=date("d/m/Y H:i",strtotime($fecha_hora_inicio_trabajo_tecnico))."hs";
        }
        $fecha_hora_fin_trabajo_tecnico="";
        $fecha_hora_fin_trabajo_tecnico_mostrar="";
        if(isset($row["fecha_hora_fin_trabajo"])){
          $fecha_hora_fin_trabajo_tecnico=$row["fecha_hora_fin_trabajo"];
          $fecha_hora_fin_trabajo_tecnico_mostrar=date("d/m/Y H:i",strtotime($fecha_hora_fin_trabajo_tecnico))."hs";
        }
        $arrayOrdenTrabajo[] =[
          "id_orden_trabajo"            =>$row["id_orden_trabajo"],
          //"id_calendario_mantenimiento" =>$row["id_calendario_mantenimiento"],
          "fecha_hora_alta"             =>($fecha_hora_alta == 0) ? "" : $fecha_hora_alta,
          "fecha_hora_alta_mostrar"     =>($fecha_hora_alta == 0) ? "" : date("d/m/Y", strtotime($fecha_hora_alta)),
          "id_activo_cliente"           =>$row["id_activo_cliente"],
          "descripcion_activo"          =>$row["descripcion_activo"],
          "id_direccion_cliente"        =>$row["id_direccion_cliente"],
          "direccion"                   =>$row["direccion"],
          //"asunto"                      =>$row["asunto"],
          //"detalle"                     =>$row["detalle"],
          "fecha"                       =>($fecha == 0) ? "" : $fecha,
          "fecha_mostrar"               =>($fecha == 0) ? "" : date("d/m/Y",strtotime($fecha)),
          "hora_desde"                  =>($hora_desde == 0) ? "" : $hora_desde,
          "hora_desde_mostrar"          =>($hora_desde == 0) ? "" : date("H:i",strtotime($hora_desde))."hs",
          "hora_hasta"                  =>($hora_hasta == 0) ? "" : $hora_hasta,
          "hora_hasta_mostrar"          =>($hora_hasta == 0) ? "" : date("H:i",strtotime($hora_hasta))."hs",
          "id_estado"                   =>$row["id_estado"],
          "estado"                      =>$row["estado"],
          "id_contacto_cliente"         =>$row["id_contacto_cliente"],
          "id_cliente"                  =>$row["id_cliente"],
          "cliente"                     =>$row["cliente"],
          "contacto_cliente"            =>$row["contacto_cliente"],
          "fecha_hora_inicio_trabajo_tecnico"         =>$fecha_hora_inicio_trabajo_tecnico,
          "fecha_hora_inicio_trabajo_tecnico_mostrar" =>$fecha_hora_inicio_trabajo_tecnico_mostrar,
          "fecha_hora_fin_trabajo_tecnico"            =>$fecha_hora_fin_trabajo_tecnico,
          "fecha_hora_fin_trabajo_tecnico_mostrar"    =>$fecha_hora_fin_trabajo_tecnico_mostrar,
        ];
			}
			//echo json_encode($arrayOrdenTrabajo);
      return json_encode($arrayOrdenTrabajo);
		}

		public function agregarOrdenTrabajo($fecha, $hora_desde, $hora_hasta, $aTareas, $aTecnicos){
      $id_calendario_mantenimiento=$aTareas[0]["id_mantenimiento_preventivo"];
      $nro_orden_trabajo="";
      $id_estado_orden=1;

      /*$fecha_hora_desde=date("Y-m-d H:i",strtotime($fecha_hora_desde));
      $fecha_hora_hasta=date("Y-m-d H:i",strtotime($fecha_hora_hasta));*/

      //$queryInsert = "INSERT INTO ordenes_trabajo (id_calendario_mantenimiento, nro_orden_trabajo, fecha_hora_alta, fecha, hora_desde, hora_hasta, id_estado_orden) VALUES ('$id_calendario_mantenimiento', '$nro_orden_trabajo', NOW(), '$fecha', '$hora_desde', '$hora_hasta', '$id_estado_orden')";
      $queryInsert = "INSERT INTO ordenes_trabajo (nro_orden_trabajo, fecha_hora_alta, fecha, hora_desde, hora_hasta, id_estado_orden) VALUES ('$nro_orden_trabajo', NOW(), '$fecha', '$hora_desde', '$hora_hasta', '$id_estado_orden')";
      //echo $queryInsert;
      $insertar= $this->conexion->consultaSimple($queryInsert);
      $mensajeError=$this->conexion->conectar->error;
      $id_orden_trabajo=$this->conexion->conectar->insert_id;

      echo $mensajeError;
      if($mensajeError!=""){
        echo "<br><br>".$queryInsert;
      }

      $aIdCalendarioMantenimiento=[];
      foreach ($aTareas as $key => $tarea) {
        $aIdCalendarioMantenimiento[]=$id_mantenimiento_preventivo=$tarea["id_mantenimiento_preventivo"];
        $queryInsert = "INSERT INTO tareas_ordenes_trabajo (id_orden_trabajo, id_calendario_mantenimiento) VALUES ('$id_orden_trabajo', '$id_mantenimiento_preventivo')";
        //echo $queryInsert;
        $insertar= $this->conexion->consultaSimple($queryInsert);
        $mensajeError=$this->conexion->conectar->error;

        echo $mensajeError;
        if($mensajeError!=""){
          echo "<br><br>".$queryInsert;
        }
      }

      $idCalendarioMantenimiento=implode(",",$aIdCalendarioMantenimiento);

      $queryItems = "SELECT id_item,id_proveedor,id_almacen,SUM(cantidad_estimada) AS cantidad_estimada_total FROM materiales_mantenimiento WHERE id_calendario_mantenimiento IN ($idCalendarioMantenimiento) GROUP BY id_item,id_proveedor,id_almacen";
      //var_dump($queryItems);
      $getItems = $this->conexion->consultaRetorno($queryItems);
      while ($row = $getItems->fetch_array()) {
        $cargado_vehiculo=0;
        $cantidad_utilizada=0;
        $aprobado_cliente=0;

        //RESERVAR ITEMS DEL STOCK!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        //INSERTO DATOS EN LA TABLA ADJUNTOS ORDEN_COMPRA
        $queryInsertMateriales = "INSERT INTO materiales_orden_trabajo (id_orden_trabajo, id_item, id_proveedor, id_almacen, cantidad_reservada, cargado_vehiculo, cantidad_utilizada, aprobado_cliente) VALUES ($id_orden_trabajo, ".$row["id_item"].", ".$row["id_proveedor"].", ".$row["id_almacen"].", ".$row["cantidad_estimada_total"].", $cargado_vehiculo, $cantidad_utilizada, $aprobado_cliente)";
        $insertAdjuntos = $this->conexion->consultaSimple($queryInsertMateriales);
        $mensajeError=$this->conexion->conectar->error;
    
        echo $mensajeError;
        if($mensajeError!=""){
          echo "<br><br>".$queryInsertMateriales;
        }
      }

      foreach($aTecnicos as $infoTecnicos){
        /*GUARDO EN TABLA EMPRESA*/
        $id_tecnico=$infoTecnicos["id_tecnico"];
        $id_vehiculo=$infoTecnicos["id_vehiculo"];
        $fecha_hora_desde="NOW()";
        $fecha_hora_hasta="NOW()";
        $id_tipo_turno_laboral=0;
        $cantidad_horas_estimadas=0;

        //$queryInsert = "INSERT INTO tecnicos_tareas_mantenimiento (id_orden_trabajo, id_tecnico, id_vehiculo, fecha_hora_desde, fecha_hora_hasta, id_tipo_turno_laboral, cantidad_horas_estimadas) VALUES ($id_orden_trabajo, $id_tecnico, $id_vehiculo, '$fecha_hora_desde', '$fecha_hora_hasta', '$id_tipo_turno_laboral', $cantidad_horas_estimadas)";
        $queryInsert = "INSERT INTO tecnicos_tareas_mantenimiento (id_orden_trabajo, id_tecnico, id_vehiculo, fecha_hora_desde, fecha_hora_hasta, cantidad_horas_estimadas) VALUES ($id_orden_trabajo, $id_tecnico, $id_vehiculo, '$fecha_hora_desde', '$fecha_hora_hasta', $cantidad_horas_estimadas)";
        //echo $queryInsert;
        $insertar= $this->conexion->consultaSimple($queryInsert);
        //var_dump($insertar);
        
        $mensajeError=$this->conexion->conectar->error;
        echo $mensajeError;
        if($mensajeError!=""){
          echo "<br><br>".$queryInsert;
        }

      }
      //echo 1;

		}

    public function traerDetalleOrdenTrabajo($id_orden_trabajo){

      $filtrosOT["id_orden_trabajo"]=$id_orden_trabajo;

			$orden_trabajo = new OrdenTrabajo();
      $detalle_orden_trabajo=$orden_trabajo->traerOrdenTrabajo($filtrosOT);
      $detalle_orden_trabajo=json_decode($detalle_orden_trabajo,true);
      $detalle_orden_trabajo=$detalle_orden_trabajo[0];

      $tareas_orden_trabajo=$orden_trabajo->traerTareasOrdenTrabajo($id_orden_trabajo);
      $tareas_orden_trabajo=json_decode($tareas_orden_trabajo,true);
      
      $materiales_orden_trabajo=$orden_trabajo->traerMaterialesOrdenTrabajo($id_orden_trabajo);
      $materiales_orden_trabajo=json_decode($materiales_orden_trabajo,true);

      $tecnicos_orden_trabajo=$orden_trabajo->traerTecnicosOrdenTrabajo($id_orden_trabajo);
      $tecnicos_orden_trabajo=json_decode($tecnicos_orden_trabajo,true);

      //var_dump($detalle_orden_trabajo);
      $filtrosCliente["id_cliente"]=$detalle_orden_trabajo["id_cliente"];
      $filtrosCliente["id_ubicacion"]=$detalle_orden_trabajo["id_direccion_cliente"];

      $clientes = new Clientes();
      $contactos=$clientes->traerContactos($filtrosCliente);
      $contactos_orden_trabajo=json_decode($contactos,true);
      $contactos_orden_trabajo=$contactos_orden_trabajo["contactos"];

      //var_dump($aOrdenesTrabajoTecnico);
			$arrayDatosIniciales['detalle_orden_trabajo'] = $detalle_orden_trabajo;
			$arrayDatosIniciales['tareas_orden_trabajo'] = $tareas_orden_trabajo;
      $arrayDatosIniciales['materiales_orden_trabajo'] = $materiales_orden_trabajo;
      $arrayDatosIniciales['tecnicos_orden_trabajo'] = $tecnicos_orden_trabajo;
      $arrayDatosIniciales['contactos_orden_trabajo'] = $contactos_orden_trabajo;

			return json_encode($arrayDatosIniciales);
		}

    public function updateOrdenTrabajo($id_orden_trabajo, $id_elemento_cliente, $asunto, $detalle, $id_contacto_cliente, $fecha_hora_ejecucion_desde, $fecha_hora_ejecucion_hasta, $adjuntos, $cantAdjuntos){

			$this->id_orden_trabajo=$id_orden_trabajo;
      $id_estado=1;

			//Actualizo datos del vehiculo
      $query = "UPDATE calendario_mantenimiento set id_activo_cliente = '$id_elemento_cliente', asunto = '$asunto', detalle = '$detalle', id_contacto_cliente = '$id_contacto_cliente', fecha_hora_ejecucion_desde = '$fecha_hora_ejecucion_desde', fecha_hora_ejecucion_hasta = '$fecha_hora_ejecucion_hasta', id_estado = '$id_estado'
      WHERE id = $this->id_orden_trabajo";
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
        WHERE id_orden_trabajo = '$id_orden_trabajo'
        ORDER BY fecha DESC LIMIT 1";
      $getIdTecnico = $this->conexion->consultaRetorno($queryGetIdTecnico);
      $id_tecnico=0;
      if ($getIdTecnico->num_rows > 0 ) {
        $idRow = $getIdTecnico->fetch_assoc();
        $id_tecnico = $idRow['id_tecnico'];
      }*/

      /*SI LOS TECNICOS SON DIFERENTES, GUARDO EL HISTORIAL DE TECNICOS*/
      /*if($id_tecnico!=$tecnico){
        $queryInsertVehiculo = "INSERT INTO asignacion_tecnico_vehiculo (id_orden_trabajo, id_tecnico, fecha, validado) VALUES('$id_orden_trabajo', '$tecnico', NOW(), 1)";
        $insertarVehiculo= $this->conexion->consultaSimple($queryInsertVehiculo);
      }*/

		}

    public function eliminarOrdenTrabajo($id_orden_trabajo){
			$this->id_orden_trabajo = $id_orden_trabajo;

			/*Eliminamos registros de la base de datos*/

			/*Tabla adjuntos_orden_trabajo*/
			$queryDelelte = "DELETE FROM adjuntos_orden_trabajo WHERE id_orden_trabajo=$this->id_orden_trabajo";
			$delete = $this->conexion->consultaSimple($queryDelelte);

			/*Tabla tecnicos_tareas_mantenimiento*/
			$queryDelelte = "DELETE FROM tecnicos_tareas_mantenimiento WHERE id_orden_trabajo=$this->id_orden_trabajo";
			$delete = $this->conexion->consultaSimple($queryDelelte);
			
      /*Tabla materiales_orden_trabajo*/
			$queryDelelte = "DELETE FROM materiales_orden_trabajo WHERE id_orden_trabajo=$this->id_orden_trabajo";
			$delete = $this->conexion->consultaSimple($queryDelelte);
			
      /*Tabla tareas_ordenes_trabajo*/
			$queryDelelte = "DELETE FROM tareas_ordenes_trabajo WHERE id_orden_trabajo=$this->id_orden_trabajo";
			$delete = $this->conexion->consultaSimple($queryDelelte);
			
      /*Tabla ordenes_trabajo*/
			$queryDelelte = "DELETE FROM ordenes_trabajo WHERE id=$this->id_orden_trabajo";
			$delete = $this->conexion->consultaSimple($queryDelelte);

		}

    public function marcarOrdenTrabajoRealizada($id_mantenimiento){
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

    public function traerTareasOrdenTrabajo($id_orden_trabajo){

			$tareasOrdenTrabajo = [];

			$queryGet = "SELECT cm.asunto,cm.detalle,ac.descripcion,ac.ubicacion,cm.fecha_hora_ejecucion_desde,cm.fecha_hora_ejecucion_hasta
      FROM tareas_ordenes_trabajo tot 
        INNER JOIN calendario_mantenimiento cm ON tot.id_calendario_mantenimiento=cm.id 
        INNER JOIN activos_cliente ac ON cm.id_activo_cliente=ac.id
      WHERE tot.id_orden_trabajo = $id_orden_trabajo";
      //var_dump($queryGet);
			$getDatos = $this->conexion->consultaRetorno($queryGet);

			while ($row = $getDatos->fetch_array()) {
        $tareasOrdenTrabajo[] =[
          "asunto"                              =>$row["asunto"],
          "detalle"                             =>$row["detalle"],
          "descripcion_activo"                  =>$row["descripcion"],
          "ubicacion_activo"                    =>$row["ubicacion"],
          "fecha_hora_ejecucion_desde_mostrar"  =>date("d/m/Y H:i",strtotime($row["fecha_hora_ejecucion_desde"]))."hs",
          "fecha_hora_ejecucion_hasta_mostrar"  =>date("d/m/Y H:i",strtotime($row["fecha_hora_ejecucion_hasta"]))."hs",
        ];
			}
			//echo json_encode($tareasOrdenTrabajo);
      return json_encode($tareasOrdenTrabajo);
		}

    public function traerMaterialesOrdenTrabajo($id_orden_trabajo){

			$materialesOrdenTrabajo = [];

			$queryGet = "SELECT mot.id_item,i.item,mot.id_proveedor,p.razon_social AS proveedor,mot.id_almacen,a.almacen,cantidad_reservada,cargado_vehiculo 
      FROM materiales_orden_trabajo mot 
        INNER JOIN item i ON mot.id_item=i.id 
        INNER JOIN proveedores p ON mot.id_proveedor=p.id
        INNER JOIN almacenes a ON mot.id_almacen=a.id
      WHERE id_orden_trabajo = $id_orden_trabajo";
      //var_dump($queryGet);
			$getDatos = $this->conexion->consultaRetorno($queryGet);

			while ($row = $getDatos->fetch_array()) {
        $materialesOrdenTrabajo[] =[
          "id_item"           =>$row["id_item"],
          "item"              =>$row["item"],
          "id_proveedor"      =>$row["id_proveedor"],
          "proveedor"         =>$row["proveedor"],
          "id_almacen"        =>$row["id_almacen"],
          "almacen"           =>$row["almacen"],
          "cantidad_reservada"=>$row["cantidad_reservada"],
          "cargado_vehiculo"  =>$row["cargado_vehiculo"],
        ];
			}
			//echo json_encode($materialesOrdenTrabajo);
      return json_encode($materialesOrdenTrabajo);
		}

    public function traerTecnicosOrdenTrabajo($id_orden_trabajo){

			$tecnicosOrdenTrabajo = [];

			$queryGet = "SELECT ttm.id_tecnico,t.nombre_completo AS tecnico,ttm.id_vehiculo 
      FROM tecnicos_tareas_mantenimiento ttm 
        INNER JOIN tecnicos t ON ttm.id_tecnico=t.id
      WHERE id_orden_trabajo = $id_orden_trabajo";
      //var_dump($queryGet);
			$getDatos = $this->conexion->consultaRetorno($queryGet);

      $vehiculo = new Vehiculo();

			while ($row = $getDatos->fetch_array()) {
        $id_vehiculo=$row["id_vehiculo"];
        $vehiculo_tecnico="";
        if($id_vehiculo!=0){
          $listaVehiculos=$vehiculo->traerVehiculos($id_vehiculo);
          $listaVehiculos=json_decode($listaVehiculos,true);
          $vehiculo_tecnico=$listaVehiculos[0]["vehiculo"];
        }
        $tecnicosOrdenTrabajo[] =[
          "id_tecnico"=>$row["id_tecnico"],
          "tecnico"   =>$row["tecnico"],
          "vehiculo"  =>$vehiculo_tecnico,
        ];
			}
			//echo json_encode($tecnicosOrdenTrabajo);
      return json_encode($tecnicosOrdenTrabajo);
		}

    public function marcarCargadoMaterial($id_orden_trabajo,$id_item,$id_proveedor,$id_almacen){
      $query = "UPDATE materiales_orden_trabajo SET cargado_vehiculo = 1
      WHERE id_orden_trabajo = $id_orden_trabajo AND id_item = $id_item AND id_proveedor = $id_proveedor AND id_almacen = $id_almacen";
      //var_dump($query);
			$update = $this->conexion->consultaSimple($query);
      
      $filasAfectadas=$this->conexion->conectar->affected_rows;
      $mensajeError=$this->conexion->conectar->error;
      //var_dump($mensajeError);
      echo $mensajeError;
      if($mensajeError!=""){
        echo "<br><br>".$query;
      }
			//echo json_encode($tecnicosOrdenTrabajo);
      //return json_encode($tecnicosOrdenTrabajo);
    }

    public function darInicioOrdenTrabajoTecnico($id_orden_trabajo,$id_tecnico){
      //cambiamos de estado la orden. Ponemos "En proceso"
      $query = "UPDATE ordenes_trabajo SET id_estado_orden = 2 WHERE id = $id_orden_trabajo";
      //var_dump($query);
			$update = $this->conexion->consultaSimple($query);
      
      $filasAfectadas=$this->conexion->conectar->affected_rows;
      $mensajeError=$this->conexion->conectar->error;
      //var_dump($mensajeError);
      echo $mensajeError;
      if($mensajeError!=""){
        echo "<br><br>".$query;
      }

      //cargamos la fecha y hora y geoposicion del inicio de trabajo
      $query = "UPDATE tecnicos_tareas_mantenimiento SET fecha_hora_inicio_trabajo = NOW(), geoposicion_inicio_trabajo='obtener geo'
      WHERE id_orden_trabajo = $id_orden_trabajo AND id_tecnico = $id_tecnico";
      //var_dump($query);
			$update = $this->conexion->consultaSimple($query);
      
      $filasAfectadas=$this->conexion->conectar->affected_rows;
      $mensajeError=$this->conexion->conectar->error;
      //var_dump($mensajeError);
      echo $mensajeError;
      if($mensajeError!=""){
        echo "<br><br>".$query;
      }
			//echo json_encode($tecnicosOrdenTrabajo);
      //return json_encode($tecnicosOrdenTrabajo);
    }

    public function finalizarOrden($id_orden_trabajo,$id_tecnico,$datosFinalizarOrden){
      //cambiamos de estado la orden. Ponemos "Finalizado"
      $query = "UPDATE ordenes_trabajo SET id_estado_orden = 3 WHERE id = $id_orden_trabajo";
      //var_dump($query);
			$update = $this->conexion->consultaSimple($query);
      
      $filasAfectadas=$this->conexion->conectar->affected_rows;
      $mensajeError=$this->conexion->conectar->error;
      //var_dump($mensajeError);
      echo $mensajeError;
      if($mensajeError!=""){
        echo "<br><br>".$query;
      }

      $query = "UPDATE tecnicos_tareas_mantenimiento SET fecha_hora_fin_trabajo = NOW() WHERE id_orden_trabajo = $id_orden_trabajo AND id_tecnico = $id_tecnico";
      //var_dump($query);
			$update = $this->conexion->consultaSimple($query);
      
      $filasAfectadas=$this->conexion->conectar->affected_rows;
      $mensajeError=$this->conexion->conectar->error;
      //var_dump($mensajeError);
      echo $mensajeError;
      if($mensajeError!=""){
        echo "<br><br>".$query;
      }

      $cantidadesUtilizadas=$datosFinalizarOrden["cantidadesUtilizadas"];
      $items=$datosFinalizarOrden["items"];
      $proveedores=$datosFinalizarOrden["proveedores"];
      $almacenes=$datosFinalizarOrden["almacenes"];
      foreach ($items as $key => $id_item) {
        $query = "UPDATE materiales_orden_trabajo SET cantidad_utilizada = '".$cantidadesUtilizadas[$key]."' WHERE id_orden_trabajo = $id_orden_trabajo AND id_item = '".$items[$key]."' AND id_proveedor = '".$proveedores[$key]."' AND id_almacen = '".$almacenes[$key]."'";
        //var_dump($query);
        $update = $this->conexion->consultaSimple($query);
        
        $filasAfectadas=$this->conexion->conectar->affected_rows;
        $mensajeError=$this->conexion->conectar->error;
        //var_dump($mensajeError);
        echo $mensajeError;
        if($mensajeError!=""){
          echo "<br><br>".$query;
        }
      }
			//echo json_encode($tecnicosOrdenTrabajo);
      //return json_encode($tecnicosOrdenTrabajo);
    }

    public function traerAdjuntos($id_orden_trabajo){
			$this->id_orden_trabajo = $id_orden_trabajo;

			$queryGetAdjuntos = "SELECT aot.archivo, u.email, aot.comentarios, aot.fecha_hora as fecha
			FROM adjuntos_orden_trabajo aot 
        JOIN usuarios as u ON aot.id_usuario = u.id
			WHERE id_orden_trabajo = $this->id_orden_trabajo";
			$getAdjuntos = $this->conexion->consultaRetorno($queryGetAdjuntos);

			$arrayAdjuntos = array();

			while($rowAdj = $getAdjuntos->fetch_array()){
				$arrayAdjuntos[]=array(
          "archivo"=>$rowAdj['archivo'],
          "email"=>$rowAdj['email'],
          "comentarios"=>$rowAdj['comentarios'],
          "fecha"=>$fecha= date("d/m/Y H:m:s", strtotime($rowAdj['fecha']))
        );
			}

			return json_encode($arrayAdjuntos);

		}

    public function adjuntarArchivo($id_orden_trabajo, $file, $comentarios){
			$this->id_orden_trabajo = $id_orden_trabajo;
			$nombreImagen = $file['name'];
			$directorio = "../../admin/views/adjuntosOT/";
			$nombreFinalArchivo = $nombreImagen;
			$id_usuario = $_SESSION['rowUsers']['id_usuario'];
			$fecha= date("Y-m-d H:i:s");

			$nombreEnv = $id_orden_trabajo."_".$nombreFinalArchivo;

			move_uploaded_file($file['tmp_name'], $directorio.$id_orden_trabajo."_".$nombreFinalArchivo);

			/*ACTUALIZO ADJUNTOS*/
			$queryUpdateAdjuntos = "INSERT INTO adjuntos_orden_trabajo (id_orden_trabajo, archivo, fecha_hora, id_usuario, comentarios) VALUES($this->id_orden_trabajo, '$nombreEnv', '$fecha', $id_usuario, '$comentarios')";
			$updateAdjuntos= $this->conexion->consultaSimple($queryUpdateAdjuntos);
		}

}

	if (isset($_POST['accion'])) {
		$orden_trabajo = new OrdenTrabajo();
		switch ($_POST['accion']) {
			case 'traerDatosInicialesOrdenesTrabajo':
			  	$orden_trabajo->traerDatosIniciales();
			break;
      /*case 'traerOrdenTrabajoUpdate':
          echo $orden_trabajo->traerOrdenTrabajo($id_orden_trabajo);
			break;*/
			case 'addOrdenTrabajo':
        //var_dump($_POST);
        $tareas=json_decode($tareas,true);
        $aTareas=[];
        foreach ($tareas as $key => $value) {
          $aTareas[]=$value["data"];
        }
        //var_dump($aTareas);
        $tecnicos=json_decode($tecnicos,true);
        $aTecnicos=[];
        foreach ($tecnicos as $key => $value) {
          $aTecnicos[]=$value["data"];
        }
        //var_dump($aTecnicos);

        $orden_trabajo->agregarOrdenTrabajo($fecha, $hora_desde, $hora_hasta, $aTareas, $aTecnicos);
			break;
      case 'updateOrdenTrabajo':
        $orden_trabajo->updateOrdenTrabajo($id_orden_trabajo, $fecha, $hora_desde, $hora_hasta, $aTareas, $aTecnicos);
      break;
      case 'traerDetalleOrdenTrabajo':
        //$id_orden_trabajo = $_POST['id_orden_trabajo'];
        echo $orden_trabajo->traerDetalleOrdenTrabajo($id_orden_trabajo);
      break;
      case 'eliminarOrdenTrabajo':
        //$id_orden_trabajo = $_POST['id_orden_trabajo'];
        $orden_trabajo->eliminarOrdenTrabajo($id_orden_trabajo);
      break;
      case 'marcarOrdenTrabajoRealizada':
        //$id_orden_trabajo = $_POST['id_orden_trabajo'];
        $orden_trabajo->marcarOrdenTrabajoRealizada($id_mantenimiento);
      break;
		}
	}else{
		if (isset($_GET['accion'])) {
			$orden_trabajo = new OrdenTrabajo();

			switch ($_GET['accion']) {
				case 'traerOrdenTrabajo':
          $filtros=[];
          if(isset($id_orden_trabajo)) $filtros["id_orden_trabajo"]=$id_orden_trabajo;
					echo $orden_trabajo->traerOrdenTrabajo($filtros);
				break;
        case 'traerOrdenTrabajoCalendario':
          $mantenimientosPreventivo=$orden_trabajo->traerOrdenTrabajo();
          $mantenimientosPreventivo=json_decode($mantenimientosPreventivo,true);

          $mantenimientoCalendario=[];
          foreach ($mantenimientosPreventivo as $mantenimiento) {
            $id_orden_trabajo= $mantenimiento['id_orden_trabajo'];
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
              "id"          =>$id_orden_trabajo,
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