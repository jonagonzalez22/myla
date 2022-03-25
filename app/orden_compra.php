<?php 
    session_start();
    if (!isset($_SESSION['rowUsers']['id_usuario'])) {
      header("location:./redireccionar_app.php");
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
    <title>Myla - Ordenes de compra</title>
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
        <div class="pageTitle">Ordenes de compra</div>
        <div class="right">
        </div>

    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section full mt-2">
            <div class="wide-block pt-2 pb-2">
                <form class="search-form">
                    <div class="form-group searchbox">
                        <input type="text" class="form-control buscador" value="" placeholder="Ingrese número de orden o estado">
                        <i class="input-icon">
                            <ion-icon name="search-outline"></ion-icon>
                        </i>
                    </div>
                </form>
            </div>
        </div>

        <div id="contenedorCards">
            
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


    <!-- DialogIconedInfo -->
        <div class="modal fade dialogbox" id="updateOrdenOk" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-icon">
                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Accion realizada</h5>
                    </div>
                    <div class="modal-body">
                        Se actualizó orden de compra
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn" data-dismiss="modal">CERRAR</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * DialogIconedInfo -->


     <!-- Modal orden de compra -->
        <div class="modal fade modalbox" id="ordenes_de_compra" data-backdrop="static" tabindex="-1" role="dialog">
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
                        <h5 class="modal-title">Orden número #<span id="id_orden_editar"></span></h5>
                        <a href="javascript:;" data-dismiss="modal">Cerrar</a>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover" id="tablaItems">
                        <thead class="text-center">
                          <tr>
                            <th class="text-center">#ID</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio unit.</th>
                          </tr>
                        </thead>
                        <tbody class="tbodyItems ">
                        </tbody>
                      </table>
                    </p>
                      <span class="mt5">
                          <label class="font-weight-bold h6">Total:</label>
                          <span class="totalFormateado h6">$ 0,00</span>
                          <span class="total d-none"></span>
                        </span>
                    </div>
                    <div class="text-center pb-2">
                        <button class="btn btn-primary" id="actualizarOrden">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Modal orden de compra -->


        <!-- Dialog Basic -->
        <div class="modal fade dialogbox" id="enDistribucion" data-backdrop="static" tabindex="-1"
            role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="d-none" id="ordenDistribucion"></span>
                        <h5 class="modal-title">Atención</h5>
                    </div>
                    <div class="modal-body">
                        Va a despachar la mercadería?
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-danger" data-dismiss="modal">
                                <ion-icon name="close-circle-outline"></ion-icon>
                                CANCELAR
                            </a>
                            <a href="#" class="btn btn-text-primary" id="cambiarEstadoOrden" data-dismiss="modal">
                                <ion-icon name="archive-outline"></ion-icon>
                                OK
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Dialog Basic -->

        <!-- Modal orden de compra -->
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
                                <div class="alert alert-outline-danger" role="alert" id="textoErrorAdjunto">
                                </div>
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
        <!-- * Modal orden de compra -->

<!-- Modal detalle orden de compra -->
        <div class="modal fade modalbox" id="detalle_orden_de_compra" data-backdrop="static" tabindex="-1" role="dialog">
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
                        <h5 class="modal-title">Orden número #<span id="id_orden_detalle"></span></h5>
                        <a href="javascript:;" data-dismiss="modal">Cerrar</a>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover" id="tablaDetalleODC">
                        <thead class="text-center">
                          <tr>
                            <th class="text-center">#ID</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio unit.</th>
                          </tr>
                        </thead>
                        <tbody class="tbodyItemsDOC ">
                        </tbody>
                      </table>
                    </p>
                      <span class="mt5">
                          <label class="font-weight-bold h6">Total:</label>
                          <span class="totalFormateadoDOC h6">$ 0,00</span>
                          <span class="totalDOC d-none"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Modal detalle orden de compra -->
        



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
        $(document).ready(function(){

            itemsOrden = new Map();
            itemsOrdenTmp = new Map();
            montoTotalOC = new Map();
            itemCambioPrecio = new Map();
            accion = "";

            traerOrdenesDeCrompra();

            const listaItems = document.getElementById('tablaItems');

            btnActualizarOrden = document.getElementById("actualizarOrden");

            cargarEventos(listaItems, btnActualizarOrden);

             $('#ordenes_de_compra').on('hidden.bs.modal', function (e) {
                let $tablaItems = document.querySelector(".tbodyItems");
                $tablaItems.innerHTML="";

                montoTotalOC.clear();
                itemsOrden.clear();
                itemsOrdenTmp.clear();
                itemCambioPrecio.clear();

            });

             $('#detalle_orden_de_compra').on('hidden.bs.modal', function (e) {
                let $tablaItemsDOC = document.querySelector(".tbodyItemsDOC");
                $tablaItemsDOC.innerHTML="";

            });

             $('#subirArchivos').on('hidden.bs.modal', function (e) {
                document.getElementById("msgErrAdjunto").style.display="none";
                document.getElementById("textoErrorAdjunto").innerText = ""; 
                document.getElementById("inputFile").style.display="none";

            });

        });

        function traerOrdenesDeCrompra(){
            let accion = "traerOrdenes";
            let id_proveedor = parseInt(document.getElementById("id_proveedor").textContent);
            $.ajax({
                url:"models/administrar_ordenes_app.php",
                type: "POST",
                dataType: "json",
                data: {accion: accion, id_proveedor:id_proveedor},
                success: function(response){
                    
                    if(response.length > 0){
                        jsonResultado=response;
                        arrayBuscador = [];
                        completarDOM(response);
                    }else{
                        console.log("no hay datos");
                    }

                }
            });
        }


        function completarDOM(response){
            $contenedor = document.getElementById("contenedorCards");
            $contenedor.innerHTML = "";

            $fragment = document.createDocumentFragment();

            response.forEach((ordenCompra)=>{

                $divContCard = document.createElement("div");
                $divContCard.className="section mt-2";

                $divCard = document.createElement("div");
                $divCard.className="card text-center";

                $divCardHeader = document.createElement("div");
                $divCardHeader.className="card-header";
                $textDivHeader=document.createTextNode(`Orden de compra número: ${ordenCompra.id_oc}`);
                $divCardHeader.appendChild($textDivHeader);

                /*BODY*/

                $divCardBody = document.createElement("div");
                $divCardBody.className="card-body";

                
                /*LIST VIEWS*/

                $contListView = document.createElement("ul");
                $contListView.className="listview image-listview";
                $contListView.style.border="0px";

                $contItemsListView = document.createElement("li");

                $divContItem = document.createElement("div");
                $divContItem.className="item";

                $divIconList = document.createElement("div");
                $divIconList.className="icon-box bg-secondary";


                $iconoUno=document.createElement("ion-icon");
                $iconoUno.setAttribute("name", "calendar-outline");

                $divContTexto = document.createElement("div");
                $divContTexto.className="in";

                $divTexto = document.createElement("div");
                $textoDivContTexto = document.createTextNode(`Fecha de carga:`);
                $divTexto.appendChild($textoDivContTexto);

                $spanValor = document.createElement("span");
                $spanValor.className="badge badge-primary";
                $valorSpan = document.createTextNode(`${ordenCompra.fecha}`);
                $spanValor.appendChild($valorSpan);

                //**********************************************************

                $divContItemDos = document.createElement("div");
                $divContItemDos.className="item";

                $divIconListDos = document.createElement("div");
                $divIconListDos.className="icon-box bg-secondary";

                $iconoDos=document.createElement("ion-icon");
                $iconoDos.setAttribute("name", "cash-outline");

                $divContTextoDos = document.createElement("div");
                $divContTextoDos.className="in";

                $divTextoDos = document.createElement("div");
                $textoDivContTextoDos = document.createTextNode(`Importe orden:`);
                $divTextoDos.appendChild($textoDivContTextoDos);

                $spanValorDos = document.createElement("span");
                $spanValorDos.className="badge badge-primary";
                $valorSpanDos = document.createTextNode(`${ordenCompra.total}`);
                $spanValorDos.appendChild($valorSpanDos);

                //**********************************************************

                $divContItemTres = document.createElement("div");
                $divContItemTres.className="item";

                $divIconListTres = document.createElement("div");
                $divIconListTres.className="icon-box bg-secondary";

                $iconoTres=document.createElement("ion-icon");
                $iconoTres.setAttribute("name", "checkmark-circle-outline");

                $divContTextoTres = document.createElement("div");
                $divContTextoTres.className="in";

                $divTextoTres = document.createElement("div");
                $textoDivContTextoTres = document.createTextNode(`Estado:`);
                $divTextoTres.appendChild($textoDivContTextoTres);

                $spanValorTres = document.createElement("span");
                $spanValorTres.className="badge badge-primary";
                $valorSpanTres = document.createTextNode(`${ordenCompra.estado}`);
                $spanValorTres.appendChild($valorSpanTres);


                /*Dibujamos los text views*/
                $contListView.appendChild($contItemsListView);
                $contItemsListView.appendChild($divContItem);
                $divContItem.appendChild($divIconList);
                $divIconList.appendChild($iconoUno);
                $divContItem.appendChild($divContTexto);
                $divContTexto.appendChild($divTexto);
                $divContTexto.appendChild($spanValor);

                $contItemsListView.appendChild($divContItemDos);
                $divContItemDos.appendChild($divIconListDos);
                $divIconListDos.appendChild($iconoDos);
                $divContItemDos.appendChild($divContTextoDos);
                $divContTextoDos.appendChild($divTextoDos);
                $divContTextoDos.appendChild($spanValorDos);

                $contItemsListView.appendChild($divContItemTres);
                $divContItemTres.appendChild($divIconListTres);
                $divIconListTres.appendChild($iconoTres);
                $divContItemTres.appendChild($divContTextoTres);
                $divContTextoTres.appendChild($divTextoTres);
                $divContTextoTres.appendChild($spanValorTres);


                /*FIN LIST VIEWS*/




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
                $buttonBodyEditar.setAttribute("onclick", `traerOrdenEditar(${ordenCompra.id_oc})`)
                $buttonBodyEditar.appendChild($iconoButtonEditar);

                /*BOTON SUBIR DOCUMENTACION*/
                $buttonBodySubir = document.createElement("button");
                $buttonBodySubir.className="btn btn-icon btn-warning mr-1 mb-1 btnSubir";
                $iconoButtonSubir = document.createElement("ion-icon");
                $iconoButtonSubir.setAttribute("name", "cloud-upload-outline");
                $iconoButtonSubir.setAttribute("onclick", `subirArchivosOrdenes(${ordenCompra.id_oc}, ${ordenCompra.id_proveedor})`)
                $buttonBodySubir.appendChild($iconoButtonSubir);


                /*BOTON EN DISTRIBUCIÓN*/
                $buttonBodyDistribucion = document.createElement("button");
                $buttonBodyDistribucion.className="btn btn-icon btn-primary mr-1 mb-1 btnEditar";
                $iconoDistribucion = document.createElement("ion-icon");
                $iconoDistribucion.setAttribute("name", "archive-outline");
                $buttonBodyDistribucion.setAttribute("onclick", `enviarMercaderia(${ordenCompra.id_oc})`)
                $buttonBodyDistribucion.appendChild($iconoDistribucion);

                /*BOTON VER DETALLE ORDEN*/
                $buttonBodyDetalleOrden = document.createElement("button");
                $buttonBodyDetalleOrden.className="btn btn-icon btn-secondary mr-1 mb-1 btnEditar";
                $iconoDetalleOrden = document.createElement("ion-icon");
                $iconoDetalleOrden.setAttribute("name", "eye-outline");
                $buttonBodyDetalleOrden.setAttribute("onclick", `verDetalleOrden(${ordenCompra.id_oc})`)
                $buttonBodyDetalleOrden.appendChild($iconoDetalleOrden);


                //$contFooter.appendChild($buttonBodyVer);
                if(ordenCompra.id_estado < 4){
                    $contFooter.appendChild($buttonBodyDistribucion);
                    $contFooter.appendChild($buttonBodyEditar);
                }
                $contFooter.appendChild($buttonBodySubir);
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


        function cargarEventos(listaItems, btnActualizarOrden){

            listaItems.addEventListener('click', (e)=>{seleccionarNodos(e)})
            btnActualizarOrden.addEventListener('click', actualizarOrden);
        }

        function seleccionarNodos(e){
            if(e.target.classList.contains('cantidad')){
                let item = e.target.parentElement.parentElement;

                let $inputCantidad = item.querySelectorAll("td")[2].children[0];

                /*EDITAR CANTIDADES*/

                $inputCantidad.addEventListener("keyup", ()=>{

                    $cantidad = item.querySelectorAll("td")[2].children[0].value;
                    $id_item = item.querySelectorAll("td")[0].textContent;
                    $importe = item.querySelectorAll("td")[3].children[0].value;
                    return editarCantidades($id_item, $importe)

                });

                 $inputCantidad.addEventListener("change", ()=>{

                    
                    let $id_item = item.querySelectorAll("td")[0].textContent;
                    let $importe = item.querySelectorAll("td")[3].children[0].value;
                    return cambiarVacio($id_item, $cantidad, item)

                });




                //let cantidad = item.querySelectorAll("td")[2].children[0].value;
               
            }else if(e.target.classList.contains('precio')){


                    let item = e.target.parentElement.parentElement;

                    let $inputCantidad = item.querySelectorAll("td")[2].children[0];
                    let $inputImporte = item.querySelectorAll("td")[3].children[0];

                    $inputImporte.addEventListener("keyup", ()=>{

                    $cantidad = item.querySelectorAll("td")[2].children[0].value;
                    $id_item = item.querySelectorAll("td")[0].textContent;
                    $importe = item.querySelectorAll("td")[3].children[0].value;
                    return editarPrecios($id_item, $importe)

                    });

                    /*$inputImporte.addEventListener("change", ()=>{

                    $cantidad = item.querySelectorAll("td")[2].children[0].value;
                    $id_item = item.querySelectorAll("td")[0].textContent;
                    $importe = item.querySelectorAll("td")[3].children[0].value;
                    return cambiarVacioPrecios($id_item, $importe)

                    });*/
            }
        }

        function editarCantidades(id_item, importe){
            $inputCantidad = event.target
            let cantidadSel = parseInt($inputCantidad.value);
            if(!isNaN(cantidadSel) || cantidadSel > 0){
                if(itemsOrden.has(`${id_item}`)){
                    let itemFind = itemsOrden.get(`${id_item}`);

                    itemsOrdenTmp.set(id_item, cantidadSel);

                    let itemTmpFind = itemsOrdenTmp.get(`${id_item}`);

                    if (itemFind["cantidad"] < itemTmpFind) {

                        $textToast = document.getElementById("textToastMayor")
                        $textToast.innerText= `cantidad debe ser menor o igual a ${itemFind["cantidad"]}`;
                        toastbox('toast-4', 2000);
                        $inputCantidad.value=itemFind["cantidad"];

                        itemsOrdenTmp.set(id_item, {cantidad: itemFind["cantidad"], precio: itemFind["precio"]})
                    }else{
                        itemsOrdenTmp.set(id_item, {cantidad: cantidadSel, precio: itemFind["precio"]});

                        calcularTotal(id_item, cantidadSel, importe);
                    }

                    
                }else{
                    //console.log("no se encontró item");

                }
            }
            
        }

        function cambiarVacio(id_item, importe, item){
            let importeValidar = parseInt(importe);
            if(isNaN(importeValidar) ){
                let objValorOriginal =  itemsOrden.get(`${id_item}`);

                item.querySelectorAll("td")[2].children[0].value = objValorOriginal["cantidad"]
            }
        }

        function editarPrecios(id_item, importe){
            let $inputPrecio = event.target;
            let precioSel = parseFloat($inputPrecio.value);

            if(!isNaN(precioSel)){

                if(itemsOrden.has(`${id_item}`)){
                    let itemFind = itemsOrden.get(`${id_item}`);

                    itemCambioPrecio.set(id_item, precioSel);

                    let itemTmpFind = itemCambioPrecio.get(`${id_item}`);

                    if (itemTmpFind == 0) {

                        $textToast = document.getElementById("textToastMayor")
                        $textToast.innerText= `Precio debe ser mayor a 0`;
                        toastbox('toast-4', 2000);
                        $inputPrecio.value=itemFind["precio"];

                        itemCambioPrecio.set(id_item, {cantidad: itemFind["cantidad"], precio: itemFind["precio"]});

                        let cantidadSel = itemFind["cantidad"];

                        calcularTotal(id_item, cantidadSel, precioSel)
                    }else{
                        
                        itemCambioPrecio.set(id_item, {cantidad: itemFind["cantidad"], precio: precioSel});

                        let cantidadSel = itemFind["cantidad"];
                        

                        calcularTotal(id_item, cantidadSel, precioSel);
                    }

                    
                }else{
                    //console.log("no se encontró item");

                }
            }
            
        }

        function traerOrdenEditar(id_orden, id_proveedor){
            document.getElementById("id_orden_editar").innerText=id_orden;
            let montoTotalInicial = 0;
            $("#ordenes_de_compra").modal("show");
            
            let accion = "traerItemUpdateOrden";
            let id_orden_update = id_orden;

            $.ajax({
                url: "models/administrar_ordenes_app.php",
                type: "POST",
                datatype: "json",
                data: {accion: accion, id_orden: id_orden},
                success: function(response){
                    respuestaJson = JSON.parse(response);

                    let $fragment = document.createDocumentFragment();
                    let $tablaItems = document.querySelector(".tbodyItems");

                    respuestaJson.forEach((item)=>{
                        $tr = document.createElement("tr");
                        $tr.innerHTML+=`<td>${item.id_item}</td>
                                        <td>${item.item}</td>
                                        <td>
                                            <input type="number" class="form-control cantidad" value="${item.cantidad}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control precio" value="${item.precio}">
                                        </td>
                                        `;
                        $fragment.appendChild($tr);

                        let id_item = item.id_item;
                        let cantidad = item.cantidad;
                        let precio = item.precio;

                        itemsOrden.set(id_item, {cantidad, precio});
                        itemsOrdenTmp.set(id_item, {cantidad, precio});
                        montoTotalOC.set(id_item, precio*cantidad);
                        
                        montoTotalInicial+=(precio*cantidad);

                    });

                    $tablaItems.appendChild($fragment);
                    let montoFormateado= new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(montoTotalInicial);
                    $('.totalFormateado').text(montoFormateado);
                    $('.total').text(montoTotalInicial);

                    


                }
            });

        }

        function calcularTotal(id_item, cantidadSel, importe){
        
            console.log(itemCambioPrecio);
            let nuevoImporte = 0;
            let precio = 0;
            itemsOrdenTmp.forEach((valor, index)=>{

                if (itemCambioPrecio.has(index)) {
                    importeFind = itemCambioPrecio.get(index);
                    precio = parseFloat(importeFind["precio"]);
                }else{
                    precio = parseFloat(valor.precio);
                }

                nuevoImporte += precio*valor.cantidad

            })

            let montoFormateado= new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(nuevoImporte);
                    $('.totalFormateado').text(montoFormateado);
                    $('.total').text(nuevoImporte);


        }

        function actualizarOrden(){

            let accion ="updateOrden";
            let id_orden = parseInt(document.getElementById("id_orden_editar").innerText);
            let totalOrden = parseFloat(document.querySelector(".total").innerText);

            let itemsCambioCantidadArray= [];

            itemsOrdenTmp.forEach((valor, index)=>{

                if (itemCambioPrecio.has(index)) {
                    importeFind = itemCambioPrecio.get(index);
                    precio = parseFloat(importeFind["precio"]);

                    cantidadFind = itemsOrdenTmp.get(index);
                    cantidad = parseFloat(cantidadFind["cantidad"]);

                    itemsOrdenTmp.set(index, {cantidad: cantidad, precio: precio});
                }
            })


            const itemsOrdenTmpArray = [];
            for(let[key, value] of itemsOrdenTmp){
                itemsOrdenTmpArray.push({
                    id: key,
                    valor: value.cantidad,
                    precio: value.precio  
                }) 
            }

            const itemsCambioPrecioArray = [];
            for([key, value] of itemCambioPrecio){
                itemsCambioPrecioArray.push({
                    id:key,
                    precio: value.precio
                })
            };

            itemsOrden.forEach((valor, index)=>{
                if(itemsOrdenTmp.has(index)){

                    let findCantidadOrig=itemsOrden.get(index);
                    let cantOriginal = parseInt(findCantidadOrig["cantidad"]);
                    
                    let findCantdidadTmp=itemsOrdenTmp.get(index);
                    let cantidadTmp = parseInt(findCantdidadTmp["cantidad"]);

                    if (cantOriginal != cantidadTmp) {
                       itemsCambioCantidadArray.push({
                        id: index,
                        cantidad: cantidadTmp
                       }) 
                    }
                }
            });

            let items = JSON.stringify(itemsOrdenTmpArray);
            let cambioPrecios = JSON.stringify(itemsCambioPrecioArray);
            let cambioCantidad = JSON.stringify(itemsCambioCantidadArray);

            /*console.log(itemsOrden);
            console.log(itemsOrdenTmp);
            console.log(itemCambioPrecio);*/



            $.ajax({
                url: "models/administrar_ordenes_app.php",
                type: "POST",
                datatype: "json",
                 data: {accion: accion, id_orden: id_orden, total_orden: totalOrden, items: items, cambioPrecios: cambioPrecios, cambioCantidad: cambioCantidad},
                success: function(){
                    $("#ordenes_de_compra").modal("hide");
                    $("#updateOrdenOk").modal("show");
                    traerOrdenesDeCrompra();
                }

            })
        }

        function subirArchivosOrdenes(id_orden, id_proveedor){
            
            document.getElementById("id_orden_archivo").innerText=id_orden;
            document.getElementById("id_proveedor_archivo").innerText=id_proveedor;
            let orden = id_orden;

            btnAgregarAdjunto = document.getElementById("btnAgregarAdjunto");

            btnEnviarAdj = document.getElementById("btnEnviarAdj");

            btnAgregarAdjunto.addEventListener("click", function(){
            $contenedorInputFile = document.getElementById("inputFile");
            $contenedorInputFile.style.display = "block";
            })

            btnEnviarAdj.addEventListener("click", enviarAdjunto);


            $("#subirArchivos").modal("show");

            $tabla = document.getElementById("tablaAdjuntos");
            $bodyTabla = $tabla.querySelector("tbody");

            let accion = "traerAdjuntos";
            $.ajax({
                url: "models/administrar_ordenes_app.php",
                type: "POST",
                datatype: "json",
                 data: {accion: accion, id_orden: id_orden},
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
            let id_orden = document.getElementById("id_orden_archivo").innerText;
            let file = document.getElementById("adjunto");

            let comentarios = document.getElementById("comentarios").value;
            let id_proveedor = document.getElementById("id_proveedor_archivo").innerText;
            let datosEnviar = new FormData();

            if (file.files.length > 0) {
              datosEnviar.append("file", file.files[0]);
              datosEnviar.append("accion", "adjuntarArchivo");
              datosEnviar.append("id_orden", id_orden);
              datosEnviar.append("comentarios", comentarios);
              datosEnviar.append("id_proveedor", id_proveedor);
              

            $.ajax({
                data: datosEnviar,
                url: "models/administrar_ordenes_app.php",
                method: "post",
                cache: false,
                contentType: false,
                processData: false, 
                success: function(){
                    $contenedorInputFile = document.getElementById("inputFile");
                    $contenedorInputFile.style.display="none";

                    subirArchivosOrdenes(id_orden, id_proveedor);

                    file.value="";
                }

            })


            }else{
              document.getElementById("msgErrAdjunto").style.display="block";
              document.getElementById("textoErrorAdjunto").innerText = "No se adjuntó ningún archivo";
            }

        }

        function enviarMercaderia(id_orden){
            $("#enDistribucion").modal("show");
            $("#ordenDistribucion").html(id_orden);
            btnCambiarEstadoOrden=document.getElementById("cambiarEstadoOrden");
            btnCambiarEstadoOrden.addEventListener("click", cambiarEstado);
        }

        function verDetalleOrden(id_orden){
            $("#detalle_orden_de_compra").modal("show");
            $("#id_orden_detalle").html(id_orden);

            
            let montoTotalInicial = 0;
           
            
            let accion = "traerItemUpdateOrden";
            let id_orden_update = id_orden;

            $.ajax({
                url: "models/administrar_ordenes_app.php",
                type: "POST",
                datatype: "json",
                data: {accion: accion, id_orden: id_orden},
                success: function(response){
                    respuestaJson = JSON.parse(response);

                    let $fragment = document.createDocumentFragment();
                    let $tablaDetalleOC = document.querySelector(".tbodyItemsDOC");

                    respuestaJson.forEach((item)=>{
                        $tr = document.createElement("tr");
                        $tr.innerHTML+=`<td>${item.id_item}</td>
                                        <td>${item.item}</td>
                                        <td>
                                            ${item.cantidad}
                                        </td>
                                        <td>
                                            ${item.precio}
                                        </td>
                                        `;
                        $fragment.appendChild($tr);

                        let id_item = item.id_item;
                        let cantidad = item.cantidad;
                        let precio = item.precio;
            
                        montoTotalInicial+=(precio*cantidad);

                    });

                    $tablaDetalleOC.appendChild($fragment);
                    let montoFormateadoDOC= new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(montoTotalInicial);
                    $('.totalFormateadoDOC').text(montoFormateadoDOC);
                    $('.totalDOC').text(montoTotalInicial);

                    


                }
            });
            
        }

        function cambiarEstado(){
            let id_orden = document.getElementById("ordenDistribucion").innerText;
            let accion ="cambiarEstadoOrden"
            $.ajax({
                url: "models/administrar_ordenes_app.php",
                type: "POST",
                datatype: "json",
                 data: {accion: accion, id_orden: id_orden},
                success: function(){
                    //$("#ordenes_de_compra").modal("hide");
                    //$("#updateOrdenOk").modal("show");
                    traerOrdenesDeCrompra();
                }

            })
        }

        $(document).on("keyup", ".buscador", (e)=>{
            this.arrayBuscador=[];
            let caracter= e.target.value.toLowerCase();
            if(caracter !==""){
                let arrayDatos = Array.from(this.jsonResultado);
                for(let datos of arrayDatos){
                    /*BUSCAR POR ID*/

                    if(datos.id_oc.indexOf(caracter) !== -1){
                        if(this.arrayBuscador.length == 0){
                            this.arrayBuscador.push({
                                    id_oc: datos.id_oc,
                                    fecha: datos.fecha,
                                    total: datos.total,
                                    estado: datos.estado
                                    }); 
                        }else{
                            for(let buscador of this.arrayBuscador){
                                if(buscador.id_oc.indexOf(datos.id_oc) == -1){
                                    this.arrayBuscador.push({
                                    id_oc: datos.id_oc,
                                    fecha: datos.fecha,
                                    total: datos.total,
                                    estado: datos.estado
                                    });
                                }
                        }
                        }
                        completarDOM(this.arrayBuscador);
                    }else if(datos.estado.toLowerCase().indexOf(caracter) !== -1){
                        this.arrayBuscador.push({
                                    id_oc: datos.id_oc,
                                    fecha: datos.fecha,
                                    total: datos.total,
                                    estado: datos.estado
                                    });
                        completarDOM(this.arrayBuscador);
                    }
                }
                if(this.arrayBuscador.length==0){
                    let $contenedor=document.getElementById("contenedorCards")
                    $contenedor.innerHTML=`<div class="wide-block pt-2 pb-2">
                                <div class="alert alert-outline-danger" role="alert">
                                    No se encontraron datos!
                                </div>

                            </div>`;
                }
            }else{
                completarDOM(this.jsonResultado);
                this.arrayBuscador=[];
            }
        });
    </script>

</body>

</html>