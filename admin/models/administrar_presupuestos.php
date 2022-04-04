<?php
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
  // session isn't started
  session_start();
}
require_once('../../conexion.php');
require_once('administrar_vehiculos.php');
require_once('administrar_clientes.php');
require_once('administrar_almacenes.php');

extract($_REQUEST);
class Presupuestos{

  private $id_presupuesto;
  private $id_empresa;

  public function __construct(){
    $this->conexion = new Conexion();
    //var_dump($_SESSION["rowUsers"]);
    $this->id_empresa = $_SESSION["rowUsers"]["id_empresa"];
    date_default_timezone_set("America/Buenos_Aires");
  }

  public function traerDatosIniciales(){
    $datosIniciales = array();

    $cliente = new Clientes();
    $listaClientes=$cliente->traerClientes($this->id_empresa);
    $listaClientes=json_decode($listaClientes,true);

    /*PRIORIDADES*/
    $prioridades=[];
    $query = "SELECT id as id_prioridad, prioridad FROM prioridades_tareas";
    $get = $this->conexion->consultaRetorno($query);
    while ($row= $get->fetch_array()) {
      $prioridades[] = array(
        'id_prioridad' => $row['id_prioridad'],
        'prioridad' =>$row['prioridad']
      );
    }

    $datosIniciales["clientes"] = $listaClientes;
    $datosIniciales["prioridades"] = $prioridades;

    echo json_encode($datosIniciales);
  }

  public function traerPresupuestos($filtros=0){

    /*$filtro_presupuesto="";
    if($id_presupuesto!=0){
      $filtro_presupuesto=" AND cm.id = $id_presupuesto";
    }*/
    $filtro_presupuesto="";
    $filtro_cliente="";
    $filtro_ubicacion="";
    $filtro_estado="";
    $filtro_fecha="";
    if($filtros!=0){
        //var_dump($filtros);
        if(isset($filtros["id_presupuesto"]) and $filtros["id_presupuesto"]!=""){
            $filtro_presupuesto=" AND cm.id IN (".$filtros["id_presupuesto"].")";
        }
        if(isset($filtros["id_cliente"]) and $filtros["id_cliente"]!=""){
            $filtro_cliente=" AND c.id = ".$filtros["id_cliente"];
        }
        if(isset($filtros["id_ubicacion"]) and $filtros["id_ubicacion"]!=""){
            $filtro_ubicacion=" AND dc.id = ".$filtros["id_ubicacion"];
        }
        if(isset($filtros["id_estado"]) and $filtros["id_estado"]!=""){
            $filtro_estado=" AND cm.id_estado = ".$filtros["id_estado"];
        }
        if(isset($filtros["fecha"]) and $filtros["fecha"]!=""){
            $filtro_fecha=" AND '".$filtros["fecha"]."' BETWEEN DATE(cm.fecha) AND DATE(cm.fecha)";
        }
    }
    
    $arrayPresupuestos = [];

    $queryGet = "SELECT cm.id AS id_presupuesto,cm.id_usuario_alta,cm.fecha_alta,cm.id_activo_cliente,ac.descripcion AS descripcion_activo,dc.id AS id_direccion_cliente,dc.direccion,cm.asunto,cm.detalle,cm.fecha,cm.hora_desde,cm.hora_hasta,cm.id_estado,etm.estado,cm.id_contacto_cliente,cc.nombre_completo AS contacto_cliente,c.id AS id_cliente,c.razon_social AS cliente, cm.id_prioridad, pt.prioridad
    FROM calendario_mantenimiento cm 
    INNER JOIN activos_cliente ac ON cm.id_activo_cliente=ac.id 
    INNER JOIN direcciones_clientes dc ON ac.id_direccion_cliente=dc.id
    INNER JOIN estados_tareas_mantenimiento etm ON cm.id_estado=etm.id 
    INNER JOIN contactos_clientes cc ON cm.id_contacto_cliente=cc.id 
    INNER JOIN clientes c ON cc.id_cliente=c.id
    INNER JOIN prioridades_tareas pt ON cm.id_prioridad=pt.id
    WHERE c.id_empresa = $this->id_empresa $filtro_presupuesto $filtro_cliente $filtro_ubicacion $filtro_estado $filtro_fecha";
    //var_dump($queryGet);
    $getDatos = $this->conexion->consultaRetorno($queryGet);

    while ($row = $getDatos->fetch_array()) {
      $fecha_alta=$row["fecha_alta"];
      $fecha=$row["fecha"];
      $hora_desde=date("H:i", strtotime($row["hora_desde"]));
      $hora_hasta=date("H:i", strtotime($row["hora_hasta"]));
      $arrayPresupuestos[] =[
        "id_presupuesto"       =>$row["id_presupuesto"],
        "id_usuario_alta"                   =>$row["id_usuario_alta"],
        "fecha_alta"                        =>($fecha_alta == 0) ? "" : $fecha_alta,
        "fecha_alta_mostrar"                =>($fecha_alta == 0) ? "" : date("d/m/Y", strtotime($fecha_alta)),
        "id_activo_cliente"                 =>$row["id_activo_cliente"],
        "descripcion_activo"                =>$row["descripcion_activo"],
        "id_direccion_cliente"              =>$row["id_direccion_cliente"],
        "direccion"                         =>$row["direccion"],
        "asunto"                            =>$row["asunto"],
        "detalle"                           =>$row["detalle"],
        "fecha"                             =>($fecha == 0) ? "" : date("Y-m-d", strtotime($fecha)),
        "fecha_mostrar"                     =>($fecha == 0) ? "" : date("d/m/Y", strtotime($fecha)),
        "hora_desde"                        =>($hora_desde == 0) ? "" : $hora_desde,
        "hora_desde_mostrar"                =>($hora_desde == 0) ? "" : $hora_desde."hs",
        "hora_hasta"                        =>($hora_hasta == 0) ? "" : $hora_hasta,
        "hora_hasta_mostrar"                =>($hora_hasta == 0) ? "" : $hora_hasta."hs",
        "id_estado"                         =>$row["id_estado"],
        "estado"                            =>$row["estado"],
        "id_contacto_cliente"               =>$row["id_contacto_cliente"],
        "id_cliente"                        =>$row["id_cliente"],
        "cliente"                           =>$row["cliente"],
        "contacto_cliente"                  =>$row["contacto_cliente"],
        "id_prioridad"                      =>$row["id_prioridad"],
        "prioridad"                         =>$row["prioridad"],
      ];
    }
    //echo json_encode($arrayPresupuestos);
    return json_encode($arrayPresupuestos);
  }

  public function traerMaterialesPresupuestos($id_presupuesto){

    $arrayMaterialesPresupuestos = [];

    $queryGet = "SELECT mm.id_item,i.item,mm.id_proveedor,p.razon_social AS proveedor,mm.id_almacen,a.almacen,mm.cantidad_estimada,um.unidad_medida,ti.tipo,ci.categoria
    FROM materiales_mantenimiento mm 
      INNER JOIN item i ON mm.id_item=i.id 
      INNER JOIN proveedores p ON mm.id_proveedor=p.id
      INNER JOIN almacenes a ON mm.id_almacen=a.id
      INNER JOIN unidades_medida um ON i.id_unidad_medida=um.id
      INNER JOIN tipos_items ti ON i.id_tipo=ti.id
      INNER JOIN categorias_item ci ON i.id_categoria=ci.id
    WHERE mm.id_calendario_mantenimiento = $id_presupuesto";
    //var_dump($queryGet);
    $getDatos = $this->conexion->consultaRetorno($queryGet);

    while ($row = $getDatos->fetch_array()) {
      $arrayMaterialesPresupuestos[] =[
        "id_item"           =>$row["id_item"],
        "item"              =>$row["item"],
        "id_proveedor"      =>$row["id_proveedor"],
        "proveedor"         =>$row["proveedor"],
        "id_almacen"        =>$row["id_almacen"],
        "almacen"           =>$row["almacen"],
        "unidad_medida"     =>$row["unidad_medida"],
        "tipo"              =>$row["tipo"],
        "categoria"         =>$row["categoria"],
        "cantidad_estimada" =>$row["cantidad_estimada"],
      ];
    }
    //echo json_encode($arrayMaterialesPresupuestos);
    return json_encode($arrayMaterialesPresupuestos);
  }

  public function traerAdjuntosPresupuestos($id_presupuesto){

    $arrayAdjuntosPresupuestos = [];

    $queryGet = "SELECT atm.id AS id_adjunto,atm.archivo,atm.fecha_hora,u.email AS usuario
    FROM adjuntos_tareas_mantenimiento atm 
      INNER JOIN usuarios u ON atm.id_usuario_alta=u.id 
    WHERE atm.id_calendario_mantenimiento = $id_presupuesto";
    //var_dump($queryGet);
    $getDatos = $this->conexion->consultaRetorno($queryGet);

    while ($row = $getDatos->fetch_array()) {
      $arrayAdjuntosPresupuestos[] =[
        "id_adjunto"  =>$row["id_adjunto"],
        "archivo"     =>$row["archivo"],
        "fecha_hora"  =>date("d-M-Y H:i",strtotime($row["fecha_hora"]))."hs",
        "usuario"     =>$row["usuario"],
      ];
    }
    //echo json_encode($arrayAdjuntosPresupuestos);
    return json_encode($arrayAdjuntosPresupuestos);
  }

  public function agregarPresupuestos($id_elemento_cliente, $asunto, $detalle, $prioridad, $id_contacto_cliente, $fecha, $hora_desde, $hora_hasta, $frecuencia_cantidad, $frecuencia_repeticion, $frecuencia_stop, $id_almacen, $aItems, $adjuntos, $cantAdjuntos){
    $activo = 1;
    $id_usuario_alta=$_SESSION["rowUsers"]["id_usuario"];
    $id_estado=1;

    $eventos=[];
    //$eventos[]=date("Y-m-d",strtotime($fecha));

    while($fecha<=$frecuencia_stop){
      //echo "$fecha<=$frecuencia_stop<br>";
      $eventos[]=$fecha;
      $fecha=date("Y-m-d",strtotime($fecha."+$frecuencia_cantidad $frecuencia_repeticion"));
    }
    //var_dump($eventos);

    $b=1;
    $id_referencia_original=0;
    foreach($eventos as $repeticion){
      /*GUARDO EN TABLA EMPRESA*/
      $queryInsert = "INSERT INTO calendario_mantenimiento (id_usuario_alta, fecha_alta, id_activo_cliente, asunto, detalle, id_prioridad, id_contacto_cliente, fecha, hora_desde, hora_hasta, id_estado, id_referencia_original) VALUES ('$id_usuario_alta', NOW(), '$id_elemento_cliente', '$asunto', '$detalle', '$prioridad', '$id_contacto_cliente', '$repeticion', '$hora_desde', '$hora_hasta', '$id_estado',$id_referencia_original)";
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

      $this->agregarMaterialesPresupuestos($id_calendario_mantenimiento, $id_almacen, $aItems);
      $this->agregarAdjuntosPresupuestos($id_calendario_mantenimiento, $adjuntos, $cantAdjuntos);

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

  public function agregarMaterialesPresupuestos($id_calendario_mantenimiento, $id_almacen, $aItems){
    foreach($aItems as $id_item => $datos){
      $id_item=explode("-",$id_item);
      $id_item=$id_item[1];
      $cantidad_estimada=$datos["cantidad"];
      $id_proveedor=$datos["proveedor"];
      /*var_dump($id_item);
      var_dump($datos);*/

      //INSERTO DATOS EN LA TABLA MATERIALES ORDEN_COMPRA
      $queryInsertMateriales = "INSERT INTO materiales_mantenimiento (id_item, id_calendario_mantenimiento, cantidad_estimada, id_proveedor, id_almacen) VALUES ($id_item, $id_calendario_mantenimiento, $cantidad_estimada, $id_proveedor, $id_almacen)";
      $insertAdjuntos = $this->conexion->consultaSimple($queryInsertMateriales);
      $mensajeError=$this->conexion->conectar->error;
  
      echo $mensajeError;
      if($mensajeError!=""){
        echo "<br><br>".$queryInsertMateriales;
      }
    }
  }

  public function agregarAdjuntosPresupuestos($id_calendario_mantenimiento, $adjuntos, $cantAdjuntos){
    $id_usuario_alta=$_SESSION["rowUsers"]["id_usuario"];
    //SI VIENEN ADJUNTOS LOS GUARDO.
    if ($adjuntos > 0) {
      $comentarios="";
      $etiquetas="";
      for ($i=0; $i < $cantAdjuntos; $i++) { 
        $indice = "file".$i;
        $nombreADJ = $_FILES[$indice]['name'];

        //INSERTO DATOS EN LA TABLA ADJUNTOS ORDEN_COMPRA
        $queryInsertAdjuntos = "INSERT INTO adjuntos_tareas_mantenimiento (id_calendario_mantenimiento, archivo, fecha_hora, id_usuario_alta, comentarios, etiquetas)VALUES($id_calendario_mantenimiento, '$nombreADJ',NOW(),'$id_usuario_alta','$comentarios', '$etiquetas')";
        //var_dump($queryInsertAdjuntos);
        $insertAdjuntos = $this->conexion->consultaSimple($queryInsertAdjuntos);

        $mensajeError=$this->conexion->conectar->error;
    
        echo $mensajeError;
        if($mensajeError!=""){
          echo "<br><br>".$queryInsert;
        }
        
        //INGRESO ARCHIVOS EN EL DIRECTORIO
        $directorio = "../views/presupuesto/";
        $nombre_archivo_guardado=$directorio."adj_".$id_calendario_mantenimiento."_".$nombreADJ;

        $imagenGuardada=move_uploaded_file($_FILES[$indice]['tmp_name'], $nombre_archivo_guardado);

        //var_dump($imagenGuardada);
        if(!$imagenGuardada){

          $queryGet = "SELECT DISTINCT(cm.id_referencia_original) AS id_referencia_original FROM adjuntos_tareas_mantenimiento atm INNER JOIN calendario_mantenimiento cm ON atm.id_calendario_mantenimiento=cm.id WHERE atm.id_calendario_mantenimiento = $id_calendario_mantenimiento";
          $getDatos = $this->conexion->consultaRetorno($queryGet);
          $row = $getDatos->fetch_array();
          //var_dump($row);
          $id_referencia_original=$row["id_referencia_original"];

          $nuevo_nombre_archivo_guardado=str_replace($id_calendario_mantenimiento,$id_referencia_original,$nombre_archivo_guardado);

          if (!copy($nuevo_nombre_archivo_guardado, $nombre_archivo_guardado)) {
              //echo "Error al copiar $fichero...\n";
          }
        }
        //$ruta_completa_imagen = $directorio.$nombreFinalArchivo;
      }
    }
  }

  public function traerDetallePresupuestos($id_presupuesto){

    $filtros["id_presupuesto"]=$id_presupuesto;
    $datos_presupuesto=$this->traerPresupuestos($filtros);
    $datos_presupuesto=json_decode($datos_presupuesto,true);
    $datos_presupuesto=$datos_presupuesto[0];

    $materiales_presupuesto=$this->traerMaterialesPresupuestos($id_presupuesto);
    $materiales_presupuesto=json_decode($materiales_presupuesto,true);

    $adjuntos_presupuesto=$this->traerAdjuntosPresupuestos($id_presupuesto);
    $adjuntos_presupuesto=json_decode($adjuntos_presupuesto,true);

    $aDetallePresupuestos=[
      "datos_presupuesto"      =>$datos_presupuesto,
      "materiales_presupuesto" =>$materiales_presupuesto,
      "adjuntos_presupuesto"   =>$adjuntos_presupuesto,
    ];
    return json_encode($aDetallePresupuestos);

  }

  public function eliminarAdjuntos($id_adjunto, $nombre_adjunto){

    $this->id_adj = $id_adjunto;

    $queryGet = "SELECT id_calendario_mantenimiento FROM adjuntos_tareas_mantenimiento WHERE id = $this->id_adj";
    $getDatos = $this->conexion->consultaRetorno($queryGet);
    $row = $getDatos->fetch_array();
    $id_calendario_mantenimiento=$row["id_calendario_mantenimiento"];

    $queryDelAdjunto= "DELETE FROM adjuntos_tareas_mantenimiento WHERE id = $this->id_adj";
    $delAdjunto = $this->conexion->consultaSimple($queryDelAdjunto);

    $directorio = "../views/presupuesto/";

    $rutaCompleta = $directorio."adj_".$id_calendario_mantenimiento."_".$nombre_adjunto;
    
    unlink($rutaCompleta);

  }

  public function updatePresupuestos($id_presupuesto, $id_elemento_cliente, $asunto, $detalle, $prioridad, $id_contacto_cliente, $id_almacen, $aItems, $adjuntos, $cantAdjuntos){

    //Actualizo datos de la tarea de mantenimiento preventivo
    $query = "UPDATE calendario_mantenimiento set id_activo_cliente = '$id_elemento_cliente', asunto = '$asunto', detalle = '$detalle', id_prioridad = '$prioridad', id_contacto_cliente = '$id_contacto_cliente' WHERE id_estado = 1 AND id_referencia_original = (SELECT id_referencia_original FROM calendario_mantenimiento b WHERE id = $id_presupuesto)";
    //echo $query;
    $update = $this->conexion->consultaSimple($query);
    
    $filasAfectadas=$this->conexion->conectar->affected_rows;
    $mensajeError=$this->conexion->conectar->error;
    //var_dump($mensajeError);
    echo $mensajeError;
    if($mensajeError!=""){
      echo "<br><br>".$query;
    }

    $queryGet = "SELECT id AS id_presupuesto FROM calendario_mantenimiento WHERE id_estado = 1 AND id_referencia_original = (SELECT id_referencia_original FROM calendario_mantenimiento b WHERE id = $id_presupuesto)";
    //var_dump($queryGet);
    $getDatos = $this->conexion->consultaRetorno($queryGet);

    while ($row = $getDatos->fetch_array()) {
      $id=$row["id_presupuesto"];
      $this->eliminarAdjuntosOrdenTrabajo($id);
      $this->eliminarMaterialesOrdenTrabajo($id);

      $this->agregarMaterialesPresupuestos($id, $id_almacen, $aItems);
      $this->agregarAdjuntosPresupuestos($id, $adjuntos, $cantAdjuntos);
    }

  }

  public function eliminarPresupuestos($id_presupuesto){
    $this->id_presupuesto = $id_presupuesto;

    /*Eliminamos registros de la base de datos*/
    $this->eliminarAdjuntosOrdenTrabajo($id_presupuesto);
    $this->eliminarMaterialesOrdenTrabajo($id_presupuesto);

    /*Tabla calendario_mantenimiento*/
    $queryDelelte = "DELETE FROM calendario_mantenimiento WHERE id=$this->id_presupuesto";
    //echo $queryDelelte."<br><br>";
    $delete = $this->conexion->consultaSimple($queryDelelte);

  }

  public function eliminarPresupuestosPendientes($id_presupuesto){

    //$this->eliminarPresupuestos($id_presupuesto);

    $queryGet = "SELECT cm.id AS id_presupuesto FROM calendario_mantenimiento cm WHERE id_estado = 1 AND cm.id_referencia_original = (SELECT id_referencia_original FROM calendario_mantenimiento b WHERE id = $id_presupuesto)";
    //var_dump($queryGet);
    $getDatos = $this->conexion->consultaRetorno($queryGet);

    while ($row = $getDatos->fetch_array()) {
      $this->eliminarPresupuestos($row["id_presupuesto"]);
    }

  }

  public function eliminarAdjuntosOrdenTrabajo($id_calendario_mantenimiento){
    /*Tabla adjuntos_tareas_mantenimiento*/
    $queryDelelte = "DELETE FROM adjuntos_tareas_mantenimiento WHERE id_calendario_mantenimiento=$id_calendario_mantenimiento";
    $delete = $this->conexion->consultaSimple($queryDelelte);
  }

  public function eliminarMaterialesOrdenTrabajo($id_calendario_mantenimiento){
    /*Tabla materiales_mantenimiento*/
    $queryDelelte = "DELETE FROM materiales_mantenimiento WHERE id_calendario_mantenimiento=$id_calendario_mantenimiento";
    $delete = $this->conexion->consultaSimple($queryDelelte);
    /*var_dump($queryDelelte);
    var_dump($delete);*/
  }

  public function marcarPresupuestosRealizada($id_mantenimiento){
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

$aPresupuestos=[
  [
    "id_presupuesto"=>1,
    "id_cliente"=> "1",
    "cliente"=> "Edificio Gámez",
    "id_direccion_cliente"=> "1",
    "direccion"=> "Sarmiento 1919",
    "id_contacto_cliente"=> "1",
    "contacto_cliente"=> "Alberto González",
    "fecha"=> "2022-02-03",
    "fecha_mostrar"=> "03/02/2022",
    "total"=> "200000",
    "total_mostrar"=> "$ 200.000",
    "id_estado"=> "1",
    "estado"=> "Pendiente",
    "fecha_alta"=> "2022-02-01",
    "fecha_alta_mostrar"=> "01/02/2022",
    "id_usuario_alta"=> "12",
  ],
  [
    "id_presupuesto"=>2,
    "id_cliente"=> "1",
    "cliente"=> "Edificio Gámez",
    "id_direccion_cliente"=> "1",
    "direccion"=> "Sarmiento 1919",
    "id_contacto_cliente"=> "1",
    "contacto_cliente"=> "Alberto González",
    "fecha"=> "2022-02-03",
    "fecha_mostrar"=> "03/02/2022",
    "total"=> "200000",
    "total_mostrar"=> "$ 200.000",
    "id_estado"=> "1",
    "estado"=> "Pendiente",
    "fecha_alta"=> "2022-02-01",
    "fecha_alta_mostrar"=> "01/02/2022",
    "id_usuario_alta"=> "12",
  ],
  [
    "id_presupuesto"=>3,
    "id_cliente"=> "1",
    "cliente"=> "Edificio Gámez",
    "id_direccion_cliente"=> "1",
    "direccion"=> "Sarmiento 1919",
    "id_contacto_cliente"=> "1",
    "contacto_cliente"=> "Alberto González",
    "fecha"=> "2022-02-03",
    "fecha_mostrar"=> "03/02/2022",
    "total"=> "200000",
    "total_mostrar"=> "$ 200.000",
    "id_estado"=> "1",
    "estado"=> "Pendiente",
    "fecha_alta"=> "2022-02-01",
    "fecha_alta_mostrar"=> "01/02/2022",
    "id_usuario_alta"=> "12",
  ],
];

if(isset($id_presupuesto)){
  $aPresupuestos=$aPresupuestos[$id_presupuesto-1];
}

$presupuesto = new Presupuestos();
if (isset($_POST['accion'])) {
  switch ($_POST['accion']) {
    case 'traerDatosInicialesPresupuestos':
        $presupuesto->traerDatosIniciales();
    break;
    case 'traerPresupuestos':
      echo json_encode($aPresupuestos);
      /*$filtros=[];
      if(isset($id_presupuesto)) $filtros["id_presupuesto"]=$id_presupuesto;
      if(isset($id_cliente)) $filtros["id_cliente"]=$id_cliente;
      if(isset($id_ubicacion)) $filtros["id_ubicacion"]=$id_ubicacion;
      if(isset($id_estado)) $filtros["id_estado"]=$id_estado;
      if(isset($fecha)) $filtros["fecha"]=$fecha;
      echo $presupuesto->traerPresupuestos($filtros);*/
    break;
    case 'addPresupuestos':
      //var_dump($_FILES);
      /*if(isset($_FILES['file0'])) {
        $adjuntos = 1;
      }else{
        $adjuntos = 0;
      }
      $aItems=json_decode($itemsJSON,true);

      $presupuesto->agregarPresupuestos($id_elemento_cliente, $asunto, $detalle, $prioridad, $id_contacto_cliente, $fecha, $hora_desde, $hora_hasta, $frecuencia_cantidad, $frecuencia_repeticion, $frecuencia_stop, $id_almacen, $aItems, $adjuntos, $cantAdjuntos);*/
    break;
    case 'updatePresupuestos':
      /*if(isset($_FILES['file0'])) {
        $adjuntos = 1;
      }else{
        $adjuntos = 0;
      }
      $aItems=json_decode($itemsJSON,true);

      $presupuesto->updatePresupuestos($id_presupuesto, $id_elemento_cliente, $asunto, $detalle, $prioridad, $id_contacto_cliente, $id_almacen, $aItems, $adjuntos, $cantAdjuntos);*/
    break;
    case 'traerDetallePresupuestos':
      //echo $presupuesto->traerDetallePresupuestos($id_presupuesto);
    break;
    case 'borrarAdjunto':
      //$presupuesto->eliminarAdjuntos($id_adjunto, $nombre_adjunto);
    break;
    case 'eliminarPresupuestosIndividual':
      //$presupuesto->eliminarPresupuestos($id_presupuesto);
    break;
    case 'eliminarPresupuestosPendientes':
      //$presupuesto->eliminarPresupuestosPendientes($id_presupuesto);
    break;
    case 'marcarPresupuestosRealizada':
      //$presupuesto->marcarPresupuestosRealizada($id_mantenimiento);
    break;
  }
}else{
  if (isset($_GET['accion'])) {
    switch ($_GET['accion']) {
      case 'traerPresupuestos':
        echo json_encode($aPresupuestos);
        /*$filtros=[];
        if(isset($id_presupuesto)) $filtros["id_presupuesto"]=$id_presupuesto;
        if(isset($id_cliente)) $filtros["id_cliente"]=$id_cliente;
        if(isset($id_ubicacion)) $filtros["id_ubicacion"]=$id_ubicacion;
        if(isset($id_estado)) $filtros["id_estado"]=$id_estado;
        if(isset($fecha)) $filtros["fecha"]=$fecha;
        echo $presupuesto->traerPresupuestos($filtros);*/
      break;
      case 'traerPresupuestosCalendario':
        /*$mantenimientosPreventivo=$presupuesto->traerPresupuestos();
        $mantenimientosPreventivo=json_decode($mantenimientosPreventivo,true);

        $mantenimientoCalendario=[];
        foreach ($mantenimientosPreventivo as $mantenimiento) {
          $id_presupuesto= $mantenimiento['id_presupuesto'];
          $descripcion_activo= $mantenimiento['descripcion_activo'];
          $fecha= $mantenimiento['fecha'];
          $fecha_hora_inicio= $fecha." ".$mantenimiento['hora_desde'];
          $fecha_hora_fin= $fecha." ".$mantenimiento['hora_hasta'];
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
            "id"          =>$id_presupuesto,
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
        echo json_encode($mantenimientoCalendario);*/
      break;
    }
  }
}?>