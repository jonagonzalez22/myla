<?php 
session_start();
if (!isset($_SESSION['rowUsers']['id_usuario'])) {
  header("location:./models/redireccionar_app.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Myla - Home Técnicos</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
</head>

<body>
  <span id="id_tecnico" class=""><?=$_SESSION['rowUsers']['id_tecnico'];?></span>
  <span id="hoy" class=""><?=date("Y-m-d")?></span>
  <!-- loader -->
  <div id="loader">
      <div class="spinner-border text-primary" role="status"></div>
  </div>
  <!-- * loader -->

  <!-- App Header -->
  <div class="appHeader bg-primary text-light">
    <div class="left">
      <a href="javascript:;" class="headerButton goBack">
        <ion-icon name="chevron-back-outline"></ion-icon>
      </a>
    </div>
    <div class="pageTitle">Ordenes de trabajo</div>
    <div class="right">
    
    </div>

  </div>
  <!-- * App Header -->

  <!-- App Capsule -->
  <div id="appCapsule">
    <!--<div class="section">
      <button type="button" class="btn btn-icon btn-primary mr-1 mb-1" id="verFiltros">
        <ion-icon name="funnel-outline" role="img" class="md hydrated" aria-label="document text outline"></ion-icon>
      </button>
      <div class="chip chip-primary chip-media ml-05 mb-05 d-none" id="quitFiltro">
        <span class="chip-label" id="leyendaFiltro"></span>
        <a href="javascript:;" class="chip-delete" id="limpiarFiltro">
          <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
        </a>
      </div>
    </div>

    <div class="section full mt-2 d-none" id="contFiltros">
      <div class="wide-block pt-2 pb-2">
        <form class="search-form">
          <div class="form-group boxed">
            <input type="date" id="fdesde" class="form-control" required>
            <input type="date" id="fhasta" class="form-control mt-1" required>
            <button class="btn btn-primary form-control mt-1" id="btnEnviar">Buscar</button>
            <button class="btn btn-secondary form-control mt-1" id="btnCancelar">Cancelar</button>
          </div>
        </form>
      </div>
    </div> -->

    <div id="contenedorCards">
            
    </div>

    <div class="section mt-2">
    
      <!-- <table class="table table-hover d-none" id="tablaDetalleOT">
        <thead class="text-center">
          <tr>
            <th>Elemento</th>
            <th>Desde</th>
            <th>Hasta</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody class="tbodyDOC text-center">
        </tbody>
      </table> -->
      
      <!-- <div class="card text-center">
        <div class="card-header bg-success text-white">
          <ion-icon name="receipt-outline"></ion-icon>
          <span>Ordenes de trabajo</span>
        </div>
        <div class="card-body">    
          <table class="table table-hover" id="tablaDetalleOT">
            <thead class="text-center">
              <tr>
                <th>Elemento</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody class="tbodyDOC text-center">
            </tbody>
          </table>
        </div>
        <div class="card-footer text-muted">
          <button class="btn btn-success mr-1 mb-1 btnDetalle" data-toggle="modal" data-target="#detalle_ordenes_trabajo">Ver detalle</button>
        </div>
      </div> -->

    </div>

  </div>
  <!-- * App Capsule -->

  <!-- App Bottom Menu -->
  <div class="appBottomMenu">
    <a href="home_tecnicos.php" class="item">
      <div class="col">
        <ion-icon name="home-outline"></ion-icon>
      </div>
    </a>
    <!--<a href="app-components.html" class="item">
      <div class="col">
        <ion-icon name="cube-outline"></ion-icon>
      </div>
    </a>
    <a href="page-chat.html" class="item">
      <div class="col">
        <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
        <span class="badge badge-danger">5</span>
      </div>
    </a>
    <a href="app-pages.html" class="item">
      <div class="col">
        <ion-icon name="layers-outline"></ion-icon>
      </div>
    </a>-->
    <a href="https://wa.me/549115908450?text=" target="_blank" class="item">
      <div class="col">
        <ion-icon name="logo-whatsapp"></ion-icon>
      </div>
    </a>
    <a href="javascript:;" class="item" data-toggle="modal" data-target="#sidebarPanel">
      <div class="col">
        <ion-icon name="menu-outline"></ion-icon>
      </div>
    </a>
  </div>
  <!-- * App Bottom Menu -->

  <!-- App Sidebar -->
  <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body p-0" id="menuLateral"><?php
          include_once("models/menu_lateral.php");?>
        </div>
        <!-- sidebar buttons -->
        <div class="sidebar-buttons">
          <a href="mi_cuenta.php" class="button">
            <ion-icon name="person-outline"></ion-icon>
          </a>
          <!--<a href="javascript:;" class="button">
            <ion-icon name="archive-outline"></ion-icon>
          </a>
          <a href="javascript:;" class="button">
            <ion-icon name="settings-outline"></ion-icon>
          </a>-->
          <a href="logOut.php" class="button">
            <ion-icon name="log-out-outline"></ion-icon>
          </a>
        </div>
        <!-- * sidebar buttons -->
      </div>
    </div>
  </div>
  <!-- * App Sidebar -->

  <!-- Modal detalle orden de trabajo -->
  <div class="modal fade modalbox" id="detalle_orden_de_trabajo" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- toast top auto close in 2 seconds -->
        <div id="toast-4" class="toast-box toast-buttom">
          <div class="in">
            <div class="text" id="textToastMayor">
                
            </div>
          </div>
        </div>
        <!-- * toast top auto close in 2 seconds -->
        <div class="modal-header">
          <h5 class="modal-title">Orden de trabajo número #<span id="id_orden_trabajo_detalle"></span></h5>
          <a href="javascript:;" data-dismiss="modal">Cerrar</a>
        </div>
        <div class="modal-body" id="detalleOT">
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal detalle orden de trabajo -->

  <!-- Modal materiales orden de trabajo -->
  <div class="modal fade modalbox" id="materiales_orden_de_trabajo" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- toast top auto close in 2 seconds -->
        <div id="toast-4" class="toast-box toast-buttom">
          <div class="in">
            <div class="text" id="textToastMayor">
                
            </div>
          </div>
        </div>
        <!-- * toast top auto close in 2 seconds -->
        <div class="modal-header">
          <h5 class="modal-title">Orden de trabajo número #<span id="id_orden_trabajo_materiales"></span></h5>
          <a href="javascript:;" data-dismiss="modal">Cerrar</a>
        </div>
        <div class="modal-body">
          <button class="btn btn-icon btn-primary mr-1 mb-1" id="btnAgregarMateriales">
            <ion-icon name="add-outline"></ion-icon>
          </button>
          <div id="almacenMateriales">Almacen: <span id="nombreAlmacenMateriales"></span></div>
          <table class="table table-hover" id="tablaMaterialesOT">
            <thead class="text-center">
              <tr>
                <th>Material</th>
                <th>Proveedor</th>
                <th>Cantidad</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody class="tbodyDOC text-center">
            </tbody>
          </table>
        </div>
        <div class="text-center pb-2">
          <button class="btn btn-primary" id="actualizarOrden">Actualizar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal materiales orden de trabajo -->

  <!-- Modal seleccionar tarea para agregar materiales orden de trabajo -->
  <!-- <div class="modal fade modalbox" id="modal_select_tarea" data-backdrop="static" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Seleccione la tarea</h5>
                  <a href="javascript:;" data-dismiss="modal">Cerrar</a>
                  <span class="d-none" id="id_tarea_agregar_materiales"></span>
              </div>
              <div class="modal-body p-0">
                  <ul class="listview image-listview flush mb-2" id="lista_tareas"> </ul>
              </div>
          </div>
      </div>
  </div> -->
  <!-- * Modal seleccionar tarea para agregar materiales orden de trabajo -->
  
  <!-- Modal seleccionar almacen para agregar materiales orden de trabajo -->
  <div class="modal fade modalbox" id="modal_select_almacen" data-backdrop="static" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Seleccione un almacen</h5>
                  <a href="javascript:;" data-dismiss="modal">Cerrar</a>
                  <span class="d-none" id="id_almacen_agregar_materiales"></span>
              </div>
              <div class="modal-body p-0">
                  <ul class="listview image-listview flush mb-2" id="lista_almacenes">
                      <!-- <li>
                          <div class="item">
                              <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                              <div class="in">
                                  <div>Frank Boehm</div>
                              </div>
                          </div>
                      </li>
                      <li>
                          <div class="item">
                              <img src="assets/img/sample/avatar/avatar2.jpg" alt="image" class="image">
                              <div class="in">
                                  <div>Sophie Asveld</div>
                              </div>
                          </div>
                      </li> -->
                  </ul>
              </div>
          </div>
      </div>
  </div>
  <!-- * Modal seleccionar almacen para agregar materiales orden de trabajo -->

  <!-- Modal seleccionar materiales para agregar a la orden de trabajo -->
  <div class="modal fade modalbox" id="modal_select_materiales" data-backdrop="static" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Materiales</h5>
                  <a href="javascript:;" data-dismiss="modal">Cerrar</a>
              </div>
              <div class="modal-body p-0">
                <table class="table table-hover" id="tablaAgregarMaterialesOT">
                  <thead class="text-center">
                    <tr>
                      <th>Material</th>
                      <th>Proveedor</th>
                      <th>Cantidad</th>
                    </tr>
                  </thead>
                  <tbody class="tbodyDOC text-center">
                  </tbody>
                </table>
              </div>
              <div class="text-center pb-2">
                <button class="btn btn-primary" id="agregarMateriales">Agregar</button>
              </div>
          </div>
      </div>
  </div>
  <!-- * Modal seleccionar materiales para agregar a la orden de trabajo -->

  <!-- Modal adjuntar archivos a orden de trabajo -->
  <div class="modal fade modalbox" id="subirArchivos" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Subir archivos orden número #<span id="id_orden_archivo"></span></h5>
          <a href="javascript:;" data-dismiss="modal">Cerrar</a>
        </div>
        <div class="modal-body">
          <button class="btn btn-icon btn-primary mr-1 mb-1" id="btnAgregarAdjunto">
            <ion-icon name="add-outline"></ion-icon>
          </button>
          <div id="inputFile" style="display: none;" class="border p-1 rounded">
            <input type="file" class="form-control" id="adjunto">
            <textarea class="form-control mt-2" id="comentarios" maxlength="100" placeholder="comentarios"></textarea>
            <div class="pt-2" id="msgErrAdjunto" style="display: none">
              <div class="alert alert-outline-danger" role="alert" id="textoErrorAdjunto"></div>
            </div>
            <button class="btn btn-success mt-2" id="btnEnviarAdj">Enviar</button>
          </div>
          <span id="id_proveedor_archivo" class="d-none"></span>
          <table class="table table-responsive" id="tablaAdjuntos">
            <thead>
              <th>Archivo</th>
              <th>Usuario</th>
              <th>Comentarios</th>
              <th>Fecha</th>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal adjuntar archivos a orden de trabajo -->

  <!-- Modal detalle movimiento -->
  <div class="modal fade modalbox" id="detalle_ordenes_trabajo" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- toast top auto close in 2 seconds -->
        <div id="toast-4" class="toast-box toast-buttom">
          <div class="in">
            <div class="text" id="textToastMayor">
                
            </div>
          </div>
        </div>
        <!-- * toast top auto close in 2 seconds -->
        <div class="modal-header">
          <h5 class="modal-title">Detalle orden de trabajo</h5>
          <a href="javascript:;" data-dismiss="modal">Cerrar</a>
        </div>
        
      </div>
    </div>
  </div>
  <!-- * Modal detalle movimiento -->

  <!-- ///////////// Js Files ////////////////////  -->
  <!-- Jquery -->
  <script src="assets/js/lib/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap-->
  <script src="assets/js/lib/popper.min.js"></script>
  <script src="assets/js/lib/bootstrap.min.js"></script>
  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
  <!-- Owl Carousel -->
  <script src="assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
  <!-- jQuery Circle Progress -->
  <script src="assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
  <!-- Base Js File -->
  <script src="assets/js/base.js"></script>
  <script type="text/javascript">

    function iniciarDashboard(){
      traerDatosIniciales();
    }

    function traerDatosIniciales(){
      let accion = "traerDatosOrdenesTrabajoTecnico";
      let id_tecnico = parseInt(document.getElementById("id_tecnico").textContent);
      $.ajax({
        url: "models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        data: {accion: accion, id_tecnico: id_tecnico},
        success: function(response){
          //console.log(response);
          let respuestaJson = JSON.parse(response);

          completarDOM(respuestaJson.ordenes_trabajo_tecnico);

          /*let $fragmentCOD = document.createDocumentFragment();
          let $tablaDetalleOT = document.querySelector("#tablaDetalleOT tbody");
          //console.log($tablaDetalleOT);
          $tablaDetalleOT.innerHTML="";
          respuestaJson.ordenes_trabajo_tecnico.forEach((orden_trabajo)=>{
            //console.log(orden_trabajo);
            let $tr = document.createElement("tr");
    
            $tr.innerHTML+=`<td>${orden_trabajo.descripcion_activo}</td>
                            <td>${orden_trabajo.hora_desde_mostrar}</td>
                            <td>${orden_trabajo.hora_hasta_mostrar}</td>
                            <td><a class="btn btn-success mr-1 mb-1" href="ver_orden_trabajo.php?id=${orden_trabajo.id_orden_trabajo}">Ver detalle</a></td>
                            `;
                            //<td><button class="btn btn-success mr-1 mb-1 btnDetalle" data-id-orden-trabajo="${orden_trabajo.id_orden_trabajo}" data-toggle="modal" data-target="#detalle_ordenes_trabajo">Ver detalle</button></td>
            $fragmentCOD.appendChild($tr);
          });

          $tablaDetalleOT.appendChild($fragmentCOD);*/
        }
      })
    }

    function completarDOM(response){
      console.log(response);
      $contenedor = document.getElementById("contenedorCards");
      $contenedor.innerHTML = "";

      $fragment = document.createDocumentFragment();

      response.forEach((ordenTrabajo)=>{

        $divContCard = document.createElement("div");
        $divContCard.className="section mt-2";

        $divCard = document.createElement("div");
        $divCard.className="card text-center";

        $divCardHeader = document.createElement("div");
        $divCardHeader.className="card-header";
        $textDivHeader=document.createTextNode(`Orden de trabajo número: ${ordenTrabajo.id_orden_trabajo}`);
        $divCardHeader.appendChild($textDivHeader);

        /*BODY*/
        $divCardBody = document.createElement("div");
        $divCardBody.className="card-body";

        /*LIST ITEMS VIEWS*/
        $contListView = document.createElement("ul");
        $contListView.className="listview image-listview";
        $contListView.style.border="0px";

        $contItemsListView = document.createElement("li");

        //***************************ITEM UNO***************************************************
        $divContItem = document.createElement("div");
        $divContItem.className="item";

        $divIconList = document.createElement("div");
        $divIconList.className="icon-box bg-secondary";

        $iconoUno=document.createElement("ion-icon");
        $iconoUno.setAttribute("name", "people-circle-outline");//ICONO

        $divContTexto = document.createElement("div");
        $divContTexto.className="in";

        $divTexto = document.createElement("div");
        $textoDivContTexto = document.createTextNode(`Cliente:`);//LABEL
        $divTexto.appendChild($textoDivContTexto);

        $spanValor = document.createElement("span");
        $spanValor.className="badge badge-primary";
        $valorSpan = document.createTextNode(`${ordenTrabajo.cliente}`);//VALOR
        $spanValor.appendChild($valorSpan);

        //Dibujamos los text views
        $contListView.appendChild($contItemsListView);
        $contItemsListView.appendChild($divContItem);
        $divContItem.appendChild($divIconList);
        $divIconList.appendChild($iconoUno);
        $divContItem.appendChild($divContTexto);
        $divContTexto.appendChild($divTexto);
        $divContTexto.appendChild($spanValor);

        //***************************ITEM DOS***************************************************
        $divContItemDos = document.createElement("div");
        $divContItemDos.className="item";

        $divIconListDos = document.createElement("div");
        $divIconListDos.className="icon-box bg-secondary";

        $iconoDos=document.createElement("ion-icon");
        $iconoDos.setAttribute("name", "business-outline");//ICONO

        $divContTextoDos = document.createElement("div");
        $divContTextoDos.className="in";

        $divTextoDos = document.createElement("div");
        $textoDivContTextoDos = document.createTextNode(`Elemento:`);//LABEL
        $divTextoDos.appendChild($textoDivContTextoDos);

        $spanValorDos = document.createElement("span");
        $spanValorDos.className="badge badge-primary";
        $valorSpanDos = document.createTextNode(`${ordenTrabajo.descripcion_activo}`);//VALOR
        $spanValorDos.appendChild($valorSpanDos);

        //Dibujamos los text views
        $contItemsListView.appendChild($divContItemDos);
        $divContItemDos.appendChild($divIconListDos);
        $divIconListDos.appendChild($iconoDos);
        $divContItemDos.appendChild($divContTextoDos);
        $divContTextoDos.appendChild($divTextoDos);
        $divContTextoDos.appendChild($spanValorDos);

        //***************************ITEM TRES***************************************************
        $divContItemTres = document.createElement("div");
        $divContItemTres.className="item";

        $divIconListTres = document.createElement("div");
        $divIconListTres.className="icon-box bg-secondary";

        $iconoTres=document.createElement("ion-icon");
        $iconoTres.setAttribute("name", "location-outline");//ICONO

        $divContTextoTres = document.createElement("div");
        $divContTextoTres.className="in";

        $divTextoTres = document.createElement("div");
        $textoDivContTextoTres = document.createTextNode(`Direccion:`);//LABEL
        $divTextoTres.appendChild($textoDivContTextoTres);

        $spanValorTres = document.createElement("span");
        $spanValorTres.className="badge badge-primary";
        $valorSpanTres = document.createTextNode(`${ordenTrabajo.direccion}`);//VALOR
        $spanValorTres.appendChild($valorSpanTres);

        //Dibujamos los text views
        $contItemsListView.appendChild($divContItemTres);
        $divContItemTres.appendChild($divIconListTres);
        $divIconListTres.appendChild($iconoTres);
        $divContItemTres.appendChild($divContTextoTres);
        $divContTextoTres.appendChild($divTextoTres);
        $divContTextoTres.appendChild($spanValorTres);

        //***************************ITEM CUATRO***************************************************
        $divContItemCuatro = document.createElement("div");
        $divContItemCuatro.className="item";

        $divIconListCuatro = document.createElement("div");
        $divIconListCuatro.className="icon-box bg-secondary";

        $iconoCuatro=document.createElement("ion-icon");
        $iconoCuatro.setAttribute("name", "checkmark-circle-outline");//ICONO

        $divContTextoCuatro = document.createElement("div");
        $divContTextoCuatro.className="in";

        $divTextoCuatro = document.createElement("div");
        $textoDivContTextoTres = document.createTextNode(`Estado:`);//LABEL
        $divTextoCuatro.appendChild($textoDivContTextoTres);

        $spanValorCuatro = document.createElement("span");
        $spanValorCuatro.className="badge badge-primary";
        $valorSpanTres = document.createTextNode(`${ordenTrabajo.estado}`);//VALOR
        $spanValorCuatro.appendChild($valorSpanTres);

        //Dibujamos los text views
        $contItemsListView.appendChild($divContItemCuatro);
        $divContItemCuatro.appendChild($divIconListCuatro);
        $divIconListCuatro.appendChild($iconoCuatro);
        $divContItemCuatro.appendChild($divContTextoCuatro);
        $divContTextoCuatro.appendChild($divTextoCuatro);
        $divContTextoCuatro.appendChild($spanValorCuatro);


        /*$divCardBody.appendChild($cardTitle);
        $divCardBody.appendChild($cardText);*/
        $divCardBody.appendChild($contListView);
        /*FIN BODY*/

        /*FOOTER*/
        $contFooter = document.createElement("div");
        $contFooter.className="card-footer text-muted";

        /*BOTON VER*/
        $buttonBodyVer = document.createElement("a");
        $buttonBodyVer.className="btn btn-icon btn-primary mr-1 mb-1";
        $iconoButtonVer = document.createElement("ion-icon");
        $iconoButtonVer.setAttribute("name", "eye-outline");
        $buttonBodyVer.setAttribute("href", "#");
        $buttonBodyVer.appendChild($iconoButtonVer);

        /*BOTON EDITAR*/
        $buttonBodyEditar = document.createElement("button");
        $buttonBodyEditar.className="btn btn-icon btn-success mr-1 mb-1 btnEditar";
        $iconoButtonEditar = document.createElement("ion-icon");
        $iconoButtonEditar.setAttribute("name", "create-outline");
        $buttonBodyEditar.setAttribute("onclick", `traerOrdenEditar(${ordenTrabajo.id_orden_trabajo})`)
        $buttonBodyEditar.appendChild($iconoButtonEditar);

        /*BOTON CHECK MATERIALES*/
        $buttonBodyCheckMateriales = document.createElement("button");
        $buttonBodyCheckMateriales.className="btn btn-icon btn-primary mr-1 mb-1";
        $iconoButtonChckateriales = document.createElement("ion-icon");
        $iconoButtonChckateriales.setAttribute("name", "clipboard-outline");
        $buttonBodyCheckMateriales.setAttribute("onclick", `traerMaterialesOrden(${ordenTrabajo.id_orden_trabajo})`)
        $buttonBodyCheckMateriales.appendChild($iconoButtonChckateriales);

        /*BOTON SUBIR DOCUMENTACION*/
        $buttonBodySubir = document.createElement("button");
        $buttonBodySubir.className="btn btn-icon btn-warning mr-1 mb-1 btnSubir";
        $iconoButtonSubir = document.createElement("ion-icon");
        $iconoButtonSubir.setAttribute("name", "cloud-upload-outline");
        $iconoButtonSubir.setAttribute("onclick", `subirArchivosOrdenes(${ordenTrabajo.id_orden_trabajo})`)
        $buttonBodySubir.appendChild($iconoButtonSubir);

        /*BOTON EN DISTRIBUCIÓN*/
        $buttonBodyDistribucion = document.createElement("button");
        $buttonBodyDistribucion.className="btn btn-icon btn-primary mr-1 mb-1";
        $iconoDistribucion = document.createElement("ion-icon");
        $iconoDistribucion.setAttribute("name", "archive-outline");
        $buttonBodyDistribucion.setAttribute("onclick", `enviarMercaderia(${ordenTrabajo.id_orden_trabajo})`)
        $buttonBodyDistribucion.appendChild($iconoDistribucion);

        /*BOTON VER DETALLE ORDEN*/
        $buttonBodyDetalleOrden = document.createElement("button");
        $buttonBodyDetalleOrden.className="btn btn-icon btn-secondary mr-1 mb-1";
        $iconoDetalleOrden = document.createElement("ion-icon");
        $iconoDetalleOrden.setAttribute("name", "eye-outline");
        $buttonBodyDetalleOrden.setAttribute("onclick", `verDetalleOrden(${ordenTrabajo.id_orden_trabajo})`)
        $buttonBodyDetalleOrden.appendChild($iconoDetalleOrden);

        /*BOTON INICIAR ORDEN*/
        $buttonBodyIniciarOrden = document.createElement("button");
        $buttonBodyIniciarOrden.className="btn btn-icon btn-success mr-1 mb-1";
        $iconoIniciarOrden = document.createElement("ion-icon");
        $iconoIniciarOrden.setAttribute("name", "play-circle-outline");
        $buttonBodyIniciarOrden.setAttribute("onclick", `iniciarOrden(${ordenTrabajo.id_orden_trabajo})`)
        $buttonBodyIniciarOrden.appendChild($iconoIniciarOrden);

        /*BOTON FINALIZAR ORDEN*/
        $buttonBodyFinalizarOrden = document.createElement("button");
        $buttonBodyFinalizarOrden.className="btn btn-icon btn-success mr-1 mb-1";
        $iconoFinalizarOrden = document.createElement("ion-icon");
        $iconoFinalizarOrden.setAttribute("name", "stop-circle-outline");
        $buttonBodyFinalizarOrden.setAttribute("onclick", `finalizarOrden(${ordenTrabajo.id_orden_trabajo})`)
        $buttonBodyFinalizarOrden.appendChild($iconoFinalizarOrden);

        //$contFooter.appendChild($buttonBodyVer);
        if(ordenTrabajo.id_estado < 3){
            //$contFooter.appendChild($buttonBodyDistribucion);
            //$contFooter.appendChild($buttonBodyEditar);
            if(ordenTrabajo.fecha_hora_inicio_trabajo_tecnico==""){
              $contFooter.appendChild($buttonBodyIniciarOrden);
              $contFooter.appendChild($buttonBodyCheckMateriales);
            }else{
              $contFooter.appendChild($buttonBodyFinalizarOrden);
            }
            $contFooter.appendChild($buttonBodySubir);
        }

        $contFooter.appendChild($buttonBodyDetalleOrden);
        /*FIN FOOTER*/

        $fragment.appendChild($divContCard);
        $divContCard.appendChild($divCard);
        $divCard.appendChild($divCardHeader);
        $divCard.appendChild($divCardBody);
        $divCard.appendChild($contFooter);
      });

      $contenedor.appendChild($fragment);
    }

    function iniciarOrden(id_orden_trabajo){
      /*$("#detalle_orden_de_trabajo").modal("show");
      $("#id_orden_trabajo_detalle").html(id_orden_trabajo);*/
      let id_tecnico = parseInt(document.getElementById("id_tecnico").textContent);
      let accion = "darInicioOrdenTrabajoTecnico";

      $.ajax({
        url: "models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        data: {accion: accion, id_orden_trabajo: id_orden_trabajo, id_tecnico: id_tecnico},
        success: function(response){
          console.log(response);
          traerDatosIniciales();
          //respuestaJson = JSON.parse(response);
        }
      });
    }

    function verDetalleOrden(id_orden_trabajo){
      $("#detalle_orden_de_trabajo").modal("show");
      $("#id_orden_trabajo_detalle").html(id_orden_trabajo);

      let montoTotalInicial = 0;

      let accion = "traerDetalleOrdenTrabajoApp";
      let id_orden_update = id_orden_trabajo;

      $.ajax({
        url: "models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        data: {accion: accion, id_orden_trabajo: id_orden_trabajo},
        success: function(response){
          //console.log(response)
          respuestaJson = JSON.parse(response);
          //console.log(respuestaJson);
          let dot=respuestaJson.detalle_orden_trabajo;
          //console.log(dot);
          let $detalleOT = document.getElementById("detalleOT");
          //console.log($detalleOT);
          let tablaDetalle=`<table class="table">
            <tbody>
              <tr>
                <td class='text-left font-weight-bold'>Cliente:</td>
                <td class='text-left'>${dot.cliente}</td>
              </tr>
              <tr>
                <td class='text-left font-weight-bold'>Contacto:</td>
                <td class='text-left'>${dot.contacto_cliente}</td>
              </tr>
              <tr>
                <td class='text-left font-weight-bold'>Elemento:</td>
                <td class='text-left'>${dot.descripcion_activo}</td>
              </tr>
              <tr>
                <td class='text-left font-weight-bold'>Direccion:</td>
                <td class='text-left'>${dot.direccion}</td>
              </tr>
              <tr>
                <td class='text-left font-weight-bold'>Estado:</td>
                <td class='text-left'>${dot.estado}</td>
              </tr>
              <tr>
                <td class='text-left font-weight-bold'>Fecha:</td>
                <td class='text-left'>${dot.fecha_mostrar}</td>
              </tr>
              <tr>
                <td class='text-left font-weight-bold'>Desde:</td>
                <td class='text-left'>${dot.hora_desde_mostrar}</td>
              </tr>
              <tr>
                <td class='text-left font-weight-bold'>Hasta:</td>
                <td class='text-left'>${dot.hora_hasta_mostrar}</td>
              </tr>
            </tbody>
          </table>
          <table class="table">
            <tbody>
              <tr>
                <td class='text-center font-weight-bold' colspan='2'>Tareas</td>
              </tr>
              <tr>
                <td class='text-left font-weight-bold'>Asunto</td>
                <td class='text-left font-weight-bold'>Detalle</td>
              </tr>`;
          respuestaJson.tareas_orden_trabajo.forEach((tareas)=>{
            tablaDetalle+=`
                <tr>
                  <td class='text-left'>${tareas.asunto}</td>
                  <td class='text-left'>${tareas.detalle}</td>
                </tr>`;
            });
            tablaDetalle+=`
            </tbody>
          </table>
          <table class="table">
            <tbody>
              <tr>
                <td class='text-center font-weight-bold' colspan='2'>Tecnicos</td>
              </tr>
              <tr>
                <td class='text-left font-weight-bold'>Nombre completo</td>
                <td class='text-left font-weight-bold'>Vehiculo</td>
              </tr>`;
          respuestaJson.tecnicos_orden_trabajo.forEach((tecnico)=>{
            tablaDetalle+=`
                <tr>
                  <td class='text-left'>${tecnico.tecnico}</td>
                  <td class='text-left'>${tecnico.vehiculo}</td>
                </tr>`;
            });
          tablaDetalle+=`
            </tbody>
          </table>`;

          $detalleOT.innerHTML=tablaDetalle;
        }
      });
    }

    function traerMaterialesOrden(id_orden_trabajo){
      $("#materiales_orden_de_trabajo").modal("show");
      $("#id_orden_trabajo_materiales").html(id_orden_trabajo);

      document.getElementById("almacenMateriales").classList.add("d-block");
      document.getElementById("actualizarOrden").classList.add("d-none");
      document.getElementById("btnAgregarMateriales").classList.add("d-none");

      let accion = "traerDetalleOrdenTrabajo";
      let id_orden_update = id_orden_trabajo;

      $.ajax({
        url: "models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        data: {accion: accion, id_orden_trabajo: id_orden_trabajo},
        success: function(response){
          respuestaJson = JSON.parse(response);

          let $fragmentCOD = document.createDocumentFragment();
          let $tablaMaterialesOT = document.querySelector("#tablaMaterialesOT tbody");
          //console.log($tablaMaterialesOT);
          $tablaMaterialesOT.innerHTML="";

          let tieneMateriales=0;
          respuestaJson.materiales_orden_trabajo.forEach((material)=>{
            tieneMateriales=1;
            //console.log(material);
            document.getElementById("nombreAlmacenMateriales").textContent=material.almacen;
            //agregar id_proveedor e id_almacen a los items
            let $tr = document.createElement("tr");

            let estadoBoton="";
            if(material.cargado_vehiculo==1){
              estadoBoton="disabled";
            }
    
            $tr.innerHTML+=`<td>${material.item}</td>
                            <td>${material.proveedor}</td>
                            <td>${material.cantidad_reservada}</td>
                            <td>
                              <button class="btn btn-sm btn-warning checkCargado" title="Cargado" ${estadoBoton}
                                data-id-item="${material.id_item}"
                                data-id-proveedor="${material.id_proveedor}"
                                data-id-almacen="${material.id_almacen}">
                                  <ion-icon name="checkmark-circle-outline"></ion-icon>
                              </button>
                            </td>`;
            $fragmentCOD.appendChild($tr);
          });
          if(tieneMateriales==0){
            let $tr = document.createElement("tr");
            $tr.innerHTML+=`<td colspan="4">No se han encontrado materiales</td>`;
            $fragmentCOD.appendChild($tr);
          }
          $tablaMaterialesOT.appendChild($fragmentCOD);
        }
      });
    }

    function finalizarOrden(id_orden_trabajo,materiales_agregar){
      let materiales_orden_de_trabajo=$("#materiales_orden_de_trabajo");
      materiales_orden_de_trabajo.modal("show");
      $("#id_orden_trabajo_materiales").html(id_orden_trabajo);

      document.getElementById("almacenMateriales").classList.add("d-none");
      document.getElementById("actualizarOrden").classList.remove("d-none");
      document.getElementById("btnAgregarMateriales").classList.remove("d-none");

      let accion = "traerDetalleOrdenTrabajo";
      let id_orden_update = id_orden_trabajo;

      $.ajax({
        url: "models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        data: {accion: accion, id_orden_trabajo: id_orden_trabajo},
        success: function(response){
          respuestaJson = JSON.parse(response);

          let $fragmentCOD = document.createDocumentFragment();
          let $tablaMaterialesOT = document.querySelector("#tablaMaterialesOT tbody");
          //console.log($tablaMaterialesOT);
          $tablaMaterialesOT.innerHTML="";

          let tieneMateriales=0;
          respuestaJson.materiales_orden_trabajo.forEach((material)=>{
            tieneMateriales=1;

            let cantidad="";
            let readonly="";
            if(materiales_agregar!=undefined){
              materiales_agregar.forEach((material_agregado)=>{
                
                if(material_agregado.item==material.id_item && 
                  material_agregado.proveedor==material.id_proveedor && 
                  material_agregado.almacen==material.id_almacen
                ){
                  cantidad=material_agregado.cantidad;
                  readonly="readonly";
                }
              });
            }
            //console.log(material);
            document.getElementById("nombreAlmacenMateriales").textContent=material.almacen;
            //agregar id_proveedor e id_almacen a los items
            let $tr = document.createElement("tr");

            $tr.innerHTML+=`<td>${material.item}</td>
                            <td>${material.proveedor}</td>
                            <td>${material.cantidad_reservada}</td>
                            <td>
                              <input type="number" class="form-control cantidadUtilizada"
                                data-id-item="${material.id_item}"
                                data-id-proveedor="${material.id_proveedor}"
                                data-id-almacen="${material.id_almacen}"
                                value="${cantidad}"
                                ${readonly}>
                            </td>`;
            $fragmentCOD.appendChild($tr);
          });
          if(tieneMateriales==0){
            let $tr = document.createElement("tr");
            $tr.innerHTML+=`<td colspan="4">No se han encontrado materiales</td>`;
            $fragmentCOD.appendChild($tr);
          }
          $tablaMaterialesOT.appendChild($fragmentCOD);
        }
      });
    }

    //añadimos funcionlidad al boton para agregar nuevos items
    /*$(document).on("click", "#btnAgregarMateriales", function(){
      //$("#modal_select_tarea").modal("show");
      $("#modal_select_tarea").modal("show");
      //$("#id_orden_trabajo_agregar_materiales").html(id_orden_trabajo);
      let id_orden_trabajo=$("#id_orden_trabajo_materiales").html();
      let accion = "traerDetalleOrdenTrabajoApp";

      $.ajax({
        url: "./models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        data: {accion: accion, id_orden_trabajo:id_orden_trabajo},
        success: function(response){
          respuestaJson = JSON.parse(response);
          let tot=respuestaJson.tareas_orden_trabajo;
          console.log(tot);
          let tareas="";
          tot.forEach((tarea)=>{
            tareas+=`
              <li>
                <div class="item tarea_elegible" data-id-tarea="${tarea.id_mantenimiento_preventivo}">
                  <div class="in d-block">
                    <div><b>Asunto:</b> ${tarea.asunto}</div>
                    <div><b>Elemento:</b> ${tarea.descripcion_activo}</div>
                  </div>
                  <ion-icon size="large" name="arrow-forward-circle-outline"></ion-icon>
                </div>
              </li>`;
              //<img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
          });

          document.getElementById("lista_tareas").innerHTML=tareas;
        }
      });
    });*/

    //añadimos funcionlidad al boton para agregar nuevos items
    //$(document).on("click", ".tarea_elegible", function(){
    $(document).on("click", "#btnAgregarMateriales", function(){
      //$("#id_tarea_agregar_materiales").html(this.dataset.idTarea)
      $("#modal_select_almacen").modal("show");
      let accion = "traerAlmacenes";

      $.ajax({
        url: "../admin/models/administrar_almacenes.php",
        type: "POST",
        datatype: "json",
        data: {accion: accion},
        success: function(response){
          //console.log(response)
          respuestaJson = JSON.parse(response);
          //console.log(respuestaJson);
          let almacenes="";
          respuestaJson.forEach((almacen)=>{
            almacenes+=`
              <li>
                <div class="item almacen_elegible" data-id_almacen="${almacen.id_almacen}">
                  <div class="in">
                    <div>${almacen.almacen}</div>
                  </div>
                  <ion-icon size="large" name="arrow-forward-circle-outline"></ion-icon>
                </div>
              </li>`;
              //<img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
          });

          document.getElementById("lista_almacenes").innerHTML=almacenes;
        }
      });
    });

    $(document).on("click", ".almacen_elegible", function(){
      $("#modal_select_materiales").modal("show");
      let id_almacen = this.dataset.id_almacen;
      $("#id_almacen_agregar_materiales").html(id_almacen);

      $.ajax({
        url: "../admin/models/administrar_stock.php?accion=traerItems&id_almacen="+id_almacen,
        type: "GET",
        datatype: "json",
        success: function(response){
          //console.log(response)
          respuestaJson = JSON.parse(response);
          //console.log(respuestaJson);
          let materiales="";
          respuestaJson.forEach((material)=>{
            //console.log(material);
            encontrado=0;
            $(".cantidadUtilizada").each(function(){
              if(this.dataset.idItem==material.id_item && this.dataset.idProveedor==material.id_proveedor && this.dataset.idAlmacen==material.id_almacen){
                encontrado=1;
              }
            })
            if(encontrado==0){
              materiales+=`
                <tr>
                  <td>${material.item}</td>
                  <td>${material.proveedor}</td>
                  <td>
                    <input type="number" class="form-control" name="cantidad_agregar" 
                      data-id-item="${material.id_item}" 
                      data-id-proveedor="${material.id_proveedor}" 
                      data-id-almacen="${material.id_almacen}">
                  </td>
                </tr>`;
            }
          });

          $("#tablaAgregarMaterialesOT tbody").html(materiales);
        }
      });

    });

    $(document).on("click", "#agregarMateriales", function(){
      let id_orden_trabajo=$("#id_orden_trabajo_materiales").html();
      //let id_tarea_agregar_materiales=$("#id_tarea_agregar_materiales").html();
      let id_almacen_agregar_materiales=$("#id_almacen_agregar_materiales").html();
      //$("#agregar_materiales_orden_de_trabajo").modal("show");

      var materiales_agregar=[];
      $("input[name='cantidad_agregar']").each(function(){
        cantidad=this.value;
        if(cantidad!="" || cantidad>0){

          material={
            item: this.dataset.idItem,
            almacen: id_almacen_agregar_materiales,
            cantidad: cantidad,
            proveedor: this.dataset.idProveedor,
          }
          materiales_agregar.push(material);

        }
      })
      //materiales_agregar=JSON.stringify(materiales_agregar);

      $.ajax({
        url: "./models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        //data: {accion:"agregarMateriales", id_orden_trabajo: id_orden_trabajo, id_tarea_agregar_materiales: id_tarea_agregar_materiales, id_almacen_agregar_materiales: id_almacen_agregar_materiales, materiales_agregar: materiales_agregar},
        data: {accion:"agregarMateriales", id_orden_trabajo: id_orden_trabajo, materiales_agregar: materiales_agregar},
        success: function(response){
          //console.log(response)
          if(response==""){
            $("#modal_select_tarea").modal("hide");
            $("#modal_select_almacen").modal("hide");
            $("#modal_select_materiales").modal("hide");
            finalizarOrden(id_orden_trabajo,materiales_agregar);
          }
          //respuestaJson = JSON.parse(response);
          //console.log(respuestaJson);

        }
      });
    });

    $(document).on("click", "#actualizarOrden", function(){
      let id_tecnico = parseInt(document.getElementById("id_tecnico").textContent);
      accion = "finalizarOrden";

      let aItem=[];
      let aProveedor=[];
      let aAlmacen=[];
      let aCantidadUtilizada=[];

      let id_orden_trabajo = parseInt(document.getElementById("id_orden_trabajo_materiales").textContent);
      $(".cantidadUtilizada").each(function(){
        aItem.push(this.dataset.idItem);
        aProveedor.push(this.dataset.idProveedor);
        aAlmacen.push(this.dataset.idAlmacen);
        aCantidadUtilizada.push(this.value);
      })

      datosFinalizarOrden={
        "items":aItem,
        "proveedores":aProveedor,
        "almacenes":aAlmacen,
        "cantidadesUtilizadas":aCantidadUtilizada,
      }

      console.log(datosFinalizarOrden);
      
      $.ajax({
        url: "models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        data: {accion:accion, id_orden_trabajo: id_orden_trabajo, id_tecnico:id_tecnico, datosFinalizarOrden:datosFinalizarOrden},
        success: function(response){
          console.log(response);
          //let respuestaJson = JSON.parse(response);
          //boton.disabled=true;
          $("#materiales_orden_de_trabajo").modal("hide");
          traerDatosIniciales();
        }
      })
    });

    $(document).on("click", ".checkCargado", function(){
      accion = "marcarCargadoMaterial";
      let boton=this;
      let id_orden_trabajo = parseInt(document.getElementById("id_orden_trabajo_materiales").textContent);
      let id_item=boton.dataset.idItem;
      let id_proveedor=boton.dataset.idProveedor;
      let id_almacen=boton.dataset.idAlmacen;
      $.ajax({
        url: "models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        data: {accion:accion, id_orden_trabajo:id_orden_trabajo, id_item:id_item, id_proveedor:id_proveedor, id_almacen:id_almacen},
        success: function(response){
          console.log(response);
          //let respuestaJson = JSON.parse(response);
          boton.disabled=true;
        }
      })
    });

    function subirArchivosOrdenes(id_orden_trabajo){
      document.getElementById("id_orden_archivo").innerText=id_orden_trabajo;
      //document.getElementById("id_proveedor_archivo").innerText=id_proveedor;
      let orden = id_orden_trabajo;

      btnAgregarAdjunto = document.getElementById("btnAgregarAdjunto");
      btnAgregarAdjunto.addEventListener("click", function(){
        $contenedorInputFile = document.getElementById("inputFile");
        $contenedorInputFile.style.display = "block";
      })
      document.getElementById("btnEnviarAdj").addEventListener("click", enviarAdjunto);

      $("#subirArchivos").modal("show");

      $tabla = document.getElementById("tablaAdjuntos");
      $bodyTabla = $tabla.querySelector("tbody");

      let accion = "traerAdjuntos";
      $.ajax({
        url: "models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        data: {accion: accion, id_orden_trabajo: id_orden_trabajo},
        success: function(response){
          $bodyTabla.innerHTML="";
          respuestaJson = JSON.parse(response);
          respuestaJson.forEach((adjuntos)=>{
            $tr = `<tr>
                    <td><a href="./views/adjuntosOC/${adjuntos.archivo}" target="_blank" download>${adjuntos.archivo}</a></td>
                    <td>${adjuntos.email}</td>
                    <td>${adjuntos.comentarios}</td>
                    <td>${adjuntos.fecha}</td>
                </tr>`;
            $bodyTabla.innerHTML +=$tr;
          })
        }
      })
    }

    function enviarAdjunto(){
      let id_orden_trabajo = document.getElementById("id_orden_archivo").innerText;
      let file = document.getElementById("adjunto");

      let comentarios = document.getElementById("comentarios").value;
      //let id_proveedor = document.getElementById("id_proveedor_archivo").innerText;
      let datosEnviar = new FormData();

      if (file.files.length > 0) {
        datosEnviar.append("file", file.files[0]);
        datosEnviar.append("accion", "adjuntarArchivo");
        datosEnviar.append("id_orden_trabajo", id_orden_trabajo);
        datosEnviar.append("comentarios", comentarios);

        $.ajax({
          data: datosEnviar,
          url: "models/administrar_home_tecnicos_app.php",
          method: "post",
          cache: false,
          contentType: false,
          processData: false, 
          success: function(){
            $contenedorInputFile = document.getElementById("inputFile");
            $contenedorInputFile.style.display="none";

            subirArchivosOrdenes(id_orden_trabajo);

            file.value="";
          }
        })
      }else{
        document.getElementById("msgErrAdjunto").style.display="block";
        document.getElementById("textoErrorAdjunto").innerText = "No se adjuntó ningún archivo";
      }
    }

    function verFiltros(){
      $contFiltros = document.getElementById("contFiltros");
      $contFiltros.classList.toggle("d-none");
    }

    function hideFiltros(){
      event.preventDefault();
      $contFiltros = document.getElementById("contFiltros");
      $contFiltros.classList.toggle("d-none");
    }

    function filtrar(){
      let fDesde = document.getElementById("fdesde").value;
      let fHasta = document.getElementById("fhasta").value;

      if(fDesde == '' || fHasta ==''){
      }else{
        event.preventDefault();
        traerDatosPorFiltro(fDesde, fHasta)
      }
    }

    function traerDatosPorFiltro(fDesde, fHasta){
      let accion = "traerPorFiltro";
      let id_proveedor = parseInt(document.getElementById("id_proveedor").textContent);

      let $contFiltros = document.getElementById("contFiltros");
      $contFiltros.classList.toggle("d-none");

      let $leyendaFiltro = document.getElementById("leyendaFiltro");

      let fechaDesde = fDesde.split("-").reverse().join('/');
      let fechaHasta = fHasta.split("-").reverse().join('/')

      $leyendaFiltro.textContent=`${fechaDesde} - ${fechaHasta}`

      let $quitFiltro = document.getElementById("quitFiltro");
      $quitFiltro.classList.toggle("d-none");

      let $limpiarFiltro = document.getElementById("limpiarFiltro");
      $limpiarFiltro.addEventListener("click", limpiarFiltro)


      $.ajax({
        url: "models/administrar_home_proveedores_app.php",
        type: "POST",
        datatype: "json",
        data: {accion: accion, id_proveedor: id_proveedor, fdesde: fDesde, fhasta: fHasta},
        success: function(response){
          let respuestaJson = JSON.parse(response);
          
          /*CANTIDADES ORDENES DE COMPRA*/
          $cantOC=document.getElementById("cantOC");
          $cantOC.textContent=respuestaJson.cdad_oc;

          let $fragmentCOD = document.createDocumentFragment();
          let $tablaDetalleCOC = document.querySelector(".tbodyDCOC");
          $tablaDetalleCOC.innerHTML="";

          respuestaJson.cantidad_oc_detalle.forEach((detalle_ordenes_trabajo)=>{
            let $tr = document.createElement("tr");

            $tr.innerHTML+=`<td>${detalle_ordenes_trabajo.estado}</td>
                            <td>${detalle_ordenes_trabajo.cantidad}</td>
                            `;
            $fragmentCOD.appendChild($tr);

          });

          $tablaDetalleCOC.appendChild($fragmentCOD);
        }
      })
    }

    function limpiarFiltro(){
      document.getElementById("leyendaFiltro").textContent="";
      document.getElementById("quitFiltro").classList.toggle("d-none");
      traerDatosIniciales();
    }

    window.addEventListener("DOMContentLoaded", iniciarDashboard);
  </script>
</body>
</html>