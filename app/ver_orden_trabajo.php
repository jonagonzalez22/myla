<?php 
    session_start();
    if (!isset($_SESSION['rowUsers']['id_usuario'])) {
      header("location:./redireccionar.php");
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
  <span id="id_proveedor" class=""><?php 
    echo $_SESSION['rowUsers']['id_proveedor'];?>
  </span>
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
    <div class="pageTitle">Orden de trabajo N° <span id='id_orden_trabajo'><?=$_GET["id"]?></span></div>
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

    <div class="section mt-2">
      
    <div class="card text-center">
        <div class="card-header bg-secondary text-white">
          <ion-icon name="receipt-outline"></ion-icon>
          <span>Detalle</span>
        </div>
        <div class="card-body" id="detalleOT">
          agregar aca el detalle de la OT
        </div>
        <!-- <div class="card-footer text-muted">
          <button class="btn btn-success mr-1 mb-1 btnDetalle" data-toggle="modal" data-target="#detalle_ordenes_trabajo">Ver detalle</button>
        </div> -->
      </div>
      
      <div class="card text-center">
        <div class="card-header bg-secondary text-white">
          <ion-icon name="receipt-outline"></ion-icon>
          <span>Materiales</span>
        </div>
        <div class="card-body">
          <span id="almacenMaterales"></span>
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
        <!-- <div class="card-footer text-muted">
          <button class="btn btn-success mr-1 mb-1 btnDetalle" data-toggle="modal" data-target="#detalle_ordenes_trabajo">Ver detalle</button>
        </div> -->
      </div>

      <div class="card text-center">
        <div class="card-header bg-secondary text-white">
          <ion-icon name="receipt-outline"></ion-icon>
          <span>Tecnicos</span>
        </div>
        <div class="card-body">
          <table class="table table-hover" id="tablaTecnicosOT">
            <thead class="text-center">
              <tr>
                <th>Nombre completo</th>
                <th>Vehiculo</th>
              </tr>
            </thead>
            <tbody class="tbodyDOC text-left">
            </tbody>
          </table>
        </div>
        <!-- <div class="card-footer text-muted">
          <button class="btn btn-success mr-1 mb-1 btnDetalle" data-toggle="modal" data-target="#detalle_ordenes_trabajo">Ver detalle</button>
        </div> -->
      </div>

      <div class="card text-center">
        <div class="card-header bg-secondary text-white">
          <ion-icon name="receipt-outline"></ion-icon>
          <span>Comentarios</span>
        </div>
        <div class="card-body">
          <textarea class="form-control" id="comentarios"></textarea>
        </div>
      </div>

      <div class="card text-center">
        <div class="card-header bg-secondary text-white">
          <ion-icon name="receipt-outline"></ion-icon>
          <span>Adjuntos</span>
        </div>
        <div class="card-body">
          <textarea class="form-control" id="comentarios"></textarea>
        </div>
      </div>

      <div class="text-center mt-1">
        <button class="btn btn-success mr-1 mb-1">Iniciar</button>
      </div>
    </div>

  </div>
  <!-- * App Capsule -->

  <!-- App Bottom Menu -->
  <div class="appBottomMenu">
    <a href="home_proveedores.php" class="item">
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
      let accion = "traerDetalleOrdenTrabajo";
      let id_orden_trabajo = parseInt(document.getElementById("id_orden_trabajo").textContent);
      $.ajax({
        url: "models/administrar_home_tecnicos_app.php",
        type: "POST",
        datatype: "json",
        data: {accion: accion, id_orden_trabajo: id_orden_trabajo},
        success: function(response){
          //console.log(response);
          let respuestaJson = JSON.parse(response);
          //console.log(respuestaJson);

          let dot=respuestaJson.detalle_orden_trabajo;
          //console.log(dot);
          //let $fragmentCOD = document.createDocumentFragment();
          let $detalleOT = document.getElementById("detalleOT");
          //console.log($detalleOT);
          $detalleOT.innerHTML=`<table class="table">
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
                <td class='text-left font-weight-bold'>Asunto:</td>
                <td class='text-left'>${dot.asunto}</td>
              </tr>
              <tr>
                <td class='text-left font-weight-bold'>Detalle:</td>
                <td class='text-left'>${dot.detalle}</td>
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
          </table>`;

          let $fragmentCOD = document.createDocumentFragment();
          let $tablaMaterialesOT = document.querySelector("#tablaMaterialesOT tbody");
          //console.log($tablaMaterialesOT);
          $tablaMaterialesOT.innerHTML="";

          respuestaJson.materiales_orden_trabajo.forEach((material)=>{
            console.log(material);
            document.getElementById("almacenMaterales").textContent=material.almacen;
            //agregar id_proveedor e id_almacen a los items
            let $tr = document.createElement("tr");
    
            $tr.innerHTML+=`<td>${material.item}</td>
                            <td>${material.proveedor}</td>
                            <td>${material.cantidad_reservada}</td>
                            <td>
                              <button class="btn btn-sm btn-warning checkCargado" title="Cargado"
                                data-id-item="${material.id_item}"
                                data-id-proveedor="${material.id_proveedor}"
                                data-id-almacen="${material.id_almacen}">
                                  <ion-icon name="checkmark-circle-outline"></ion-icon>
                              </button>
                            </td>`;
            $fragmentCOD.appendChild($tr);
          });
          $tablaMaterialesOT.appendChild($fragmentCOD);

          let $fragmentCodigo = document.createDocumentFragment();
          let $tablaTecnicosOT = document.querySelector("#tablaTecnicosOT tbody");
          //console.log($tablaTecnicosOT);
          $tablaTecnicosOT.innerHTML="";

          respuestaJson.tecnicos_orden_trabajo.forEach((tecnico)=>{
            //console.log(tecnico);
            //agregar id_proveedor e id_almacen a los items
            let $tr = document.createElement("tr");
    
            $tr.innerHTML+=`<td>${tecnico.tecnico}</td>
                            <td>${tecnico.vehiculo}</td>`;
            $fragmentCodigo.appendChild($tr);
          });
          $tablaTecnicosOT.appendChild($fragmentCodigo);
        }
      })
    }
    
    $(document).on("click", ".checkCargado", function(){
      accion = "marcarCargadoMaterial";
      let boton=this;
      let id_orden_trabajo = parseInt(document.getElementById("id_orden_trabajo").textContent);
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