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
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Myla - Home Proveedores</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
</head>

<body>
    <span id="id_proveedor" class="">
        <?php 
            echo $_SESSION['rowUsers']['id_proveedor'];
        ?>    
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
        <div class="pageTitle">Home</div>
        <div class="right">
        </div>

    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section">
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
        </div>

        <div class="section mt-2">
            <div class="card text-center">
                <div class="card-header bg-success text-white">
                   
                    <ion-icon name="receipt-outline"></ion-icon>
                   <span>Cantidad ordenes de compra</span>
                           
                </div>
                <div class="card-body">    
                    <span class="display-4" id="cantOC"></span>
                </div>
                <div class="card-footer text-muted">
                    <button class="btn btn-success mr-1 mb-1 btnDetalle" data-toggle="modal" data-target="#detalle_cantidad">
                        Ver detalle
                    </button>
                </div>
            </div>

            <div class="card text-center mt-2">
                <div class="card-header bg-info text-white">
                    <ion-icon name="cash-outline"></ion-icon>
                   <span>Monto total ordenes de compra</span>
                </div>
                <div class="card-body">    
                    <span class="display-4" id="montoOC"></span>
                </div>
                <div class="card-footer text-muted">
                     <button class="btn btn-info mr-1 mb-1" data-toggle="modal" data-target="#detalle_montos">
                        Ver detalle
                    </button>
                </div>
            </div>
            <div class="card text-center mt-2">
                <div class="card-header bg-warning">
                     <ion-icon name="storefront-outline"></ion-icon>
                   <span>Productos sin entregar</span>
                </div>
                <div class="card-body">    
                    <span class="display-4" id="prodXEntregar"></span>
                </div>
                <div class="card-footer text-muted">
                    <button class="btn btn-warning mr-1 mb-1 btnDetalle" data-toggle="modal" data-target="#productos_sin_entregar">
                        Ver detalle
                    </button>
                </div>
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
                <div class="modal-body p-0" id="menuLateral">
                    <?php include_once("models/menu_lateral.php"); ?>
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
        </div>-->
    </div>
    <!-- * App Sidebar -->

     <!-- Modal detalle movimiento -->
        <div class="modal fade modalbox" id="detalle_montos" data-backdrop="static" tabindex="-1" role="dialog">
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
                        <h5 class="modal-title">Detalle monto total ordenes</h5>
                        <a href="javascript:;" data-dismiss="modal">Cerrar</a>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover" id="tablaDetalleOCd">
                        <thead class="text-center">
                          <tr>
                            <th>Estado</th>
                            <th>Monto</th>
                          </tr>
                        </thead>
                        <tbody class="tbodyDOC text-center">
                        </tbody>
                      </table>
                    </p>
                      <!--<span class="mt5">
                          <label class="font-weight-bold h6">Total:</label>
                          <span class="totalFormateadoDOC h6">$ 0,00</span>
                        </span>-->
                    </div>
                </div>
            </div>
        </div>
    <!-- * Modal detalle movimiento -->

    <!-- Modal detalle cantidad orden de compra -->
        <div class="modal fade modalbox" id="detalle_cantidad" data-backdrop="static" tabindex="-1" role="dialog">
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
                        <h5 class="modal-title">Detalle cantidad ordenes compra</h5>
                        <a href="javascript:;" data-dismiss="modal">Cerrar</a>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover" id="tablaDetalleCantidad">
                        <thead class="text-center">
                          <tr>
                            <th>Estado</th>
                            <th>Cantidad</th>
                          </tr>
                        </thead>
                        <tbody class="tbodyDCOC text-center">
                        </tbody>
                      </table>
                    </p>
                      <!--<span class="mt5">
                          <label class="font-weight-bold h6">Total:</label>
                          <span class="totalFormateadoDOC h6">$ 0,00</span>
                        </span>-->
                    </div>
                </div>
            </div>
        </div>
    <!-- * Modal detalle cantida orden de compra -->

     <!-- Modal detalle productos sin entregar -->
        <div class="modal fade modalbox" id="productos_sin_entregar" data-backdrop="static" tabindex="-1" role="dialog">
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
                        <h5 class="modal-title">Detalle productos sin entregar</h5>
                        <a href="javascript:;" data-dismiss="modal">Cerrar</a>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover" id="tablaProdSinEntregar">
                        <thead class="text-center">
                          <tr>
                            <th>Codigo</th>
                            <th>Item</th>
                            <th>Cdad por entregar</th>
                            <th>Orden</th>
                          </tr>
                        </thead>
                        <tbody class="tbodyPSE text-center">
                        </tbody>
                      </table>
                    </p>
                      <!--<span class="mt5">
                          <label class="font-weight-bold h6">Total:</label>
                          <span class="totalFormateadoDOC h6">$ 0,00</span>
                        </span>-->
                    </div>
                </div>
            </div>
        </div>
    <!-- * Modal detalle productos sin entregar -->

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
            
            let $btnVerFiltros = document.getElementById("verFiltros");
            $btnVerFiltros.addEventListener("click", verFiltros)

            let $btnCancelar = document.getElementById("btnCancelar");
            $btnCancelar.addEventListener("click", hideFiltros);

            let $btnEnviar = document.getElementById("btnEnviar");
            $btnEnviar.addEventListener("click", filtrar);

            traerDatosIniciales();
        }

        function traerDatosIniciales(){
            let accion = "traerDatosIniciales";
            let id_proveedor = parseInt(document.getElementById("id_proveedor").textContent);
            $.ajax({
                url: "models/administrar_home_proveedores_app.php",
                type: "POST",
                datatype: "json",
                data: {accion: accion, id_proveedor: id_proveedor},
                success: function(response){
                        let respuestaJson = JSON.parse(response);
                        
                        /*CANTIDADES ORDENES DE COMPRA*/
                        $cantOC=document.getElementById("cantOC");
                        $cantOC.textContent=respuestaJson.cdad_oc;

                        let $fragmentCOD = document.createDocumentFragment();
                        let $tablaDetalleCOC = document.querySelector(".tbodyDCOC");
                        $tablaDetalleCOC.innerHTML="";

                        respuestaJson.cantidad_oc_detalle.forEach((detalle_cantidad)=>{
                            let $tr = document.createElement("tr");
                    
                            $tr.innerHTML+=`<td>${detalle_cantidad.estado}</td>
                                            <td>${detalle_cantidad.cantidad}</td>
                                            `;
                            $fragmentCOD.appendChild($tr);

                        });

                        $tablaDetalleCOC.appendChild($fragmentCOD);


                        /*MONTOS ORDENES DE COMPRA*/
                        $montoOC = document.getElementById("montoOC");
                        montoOCFormat = new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(respuestaJson.monto_oc);
                        $montoOC.textContent=montoOCFormat;
                        
                        let $fragmentOCD = document.createDocumentFragment();
                        let $tablaDetalleOCd = document.querySelector(".tbodyDOC");
                        $tablaDetalleOCd.innerHTML="";

                        respuestaJson.monto_oc_detalle.forEach((detalle_monto)=>{
                            let $tr = document.createElement("tr");
                             let montoFormateado= new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(detalle_monto.total);


                            $tr.innerHTML+=`<td>${detalle_monto.estado}</td>
                                            <td>${montoFormateado}</td>
                                            `;
                            $fragmentOCD.appendChild($tr);

                        });

                        $tablaDetalleOCd.appendChild($fragmentOCD);

                        /*PRODUCTOS POR ENTREGAR*/
                        $prodXEntregar = document.getElementById("prodXEntregar");
                        $prodXEntregar.textContent=respuestaJson.prod_por_entregar;

                        let $fragmentSE = document.createDocumentFragment();
                        let $tablaDetalleSE = document.querySelector(".tbodyPSE");
                        $tablaDetalleSE.innerHTML="";

                        respuestaJson.detalle_por_entregar.forEach((detalle_entregar)=>{
                            let $tr = document.createElement("tr");

                            $tr.innerHTML+=`<td>${detalle_entregar.id_item}</td>
                                            <td>${detalle_entregar.item}</td>
                                            <td>${detalle_entregar.por_entregar}</td>
                                             <td>${detalle_entregar.orden}</td>
                                            `;
                            $fragmentSE.appendChild($tr);

                        });

                        $tablaDetalleSE.appendChild($fragmentSE);

                }
            })
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

                        respuestaJson.cantidad_oc_detalle.forEach((detalle_cantidad)=>{
                            let $tr = document.createElement("tr");
                    
                            $tr.innerHTML+=`<td>${detalle_cantidad.estado}</td>
                                            <td>${detalle_cantidad.cantidad}</td>
                                            `;
                            $fragmentCOD.appendChild($tr);

                        });

                        $tablaDetalleCOC.appendChild($fragmentCOD);


                        /*MONTOS ORDENES DE COMPRA*/
                        $montoOC = document.getElementById("montoOC");
                        montoOCFormat = new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(respuestaJson.monto_oc);
                        $montoOC.textContent=montoOCFormat;
                        
                        let $fragmentOCD = document.createDocumentFragment();
                        let $tablaDetalleOCd = document.querySelector(".tbodyDOC");
                        $tablaDetalleOCd.innerHTML="";

                        respuestaJson.monto_oc_detalle.forEach((detalle_monto)=>{
                            let $tr = document.createElement("tr");
                             let montoFormateado= new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(detalle_monto.total);


                            $tr.innerHTML+=`<td>${detalle_monto.estado}</td>
                                            <td>${montoFormateado}</td>
                                            `;
                            $fragmentOCD.appendChild($tr);

                        });

                        $tablaDetalleOCd.appendChild($fragmentOCD);

                        /*PRODUCTOS POR ENTREGAR*/
                        $prodXEntregar = document.getElementById("prodXEntregar");
                        $prodXEntregar.textContent=respuestaJson.prod_por_entregar;

                        let $fragmentSE = document.createDocumentFragment();
                        let $tablaDetalleSE = document.querySelector(".tbodyPSE");
                        $tablaDetalleSE.innerHTML="";

                        respuestaJson.detalle_por_entregar.forEach((detalle_entregar)=>{
                            let $tr = document.createElement("tr");

                            $tr.innerHTML+=`<td>${detalle_entregar.id_item}</td>
                                            <td>${detalle_entregar.item}</td>
                                            <td>${detalle_entregar.por_entregar}</td>
                                             <td>${detalle_entregar.orden}</td>
                                            `;
                            $fragmentSE.appendChild($tr);

                        });

                        $tablaDetalleSE.appendChild($fragmentSE);

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