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
    <title>Myla - Cuenta Corriente</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
</head>

<body>
    <span id="id_proveedor" class="d-none">
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
        <div class="pageTitle">Cuenta corriente</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section full mt-2">
            <div class="wide-block pt-2 pb-2">
                <form class="search-form">
                    <div class="form-group searchbox">
                        <input type="text" class="form-control buscador" value="" placeholder="Fecha o tipo de movimiento">
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

         <!-- Modal detalle movimiento -->
        <div class="modal fade modalbox" id="detalle_movimientos_oc" data-backdrop="static" tabindex="-1" role="dialog">
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
                        <h5 class="modal-title">Orden número #<span id="id_orden"></span></h5>
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
                </div>
            </div>
        </div>
        <!-- * Modal detalle movimiento -->

    <!-- android style -->
                <div id="notification-4" class="notification-box">
                    <div class="notification-dialog android-style">
                        <div class="notification-header">
                            <div class="in">
                                <img src="assets/img/sample/avatar/avatar6.jpg" alt="image" class="imaged w24 rounded">
                                <strong>Notificación</strong>
                                <span>just now</span>
                            </div>
                            <a href="#" class="close-button">
                                <ion-icon name="close"></ion-icon>
                            </a>
                        </div>
                        <div class="notification-content">
                            <div class="in">
                                <h3 class="subtitle">File Uploaded!</h3>
                                <div class="text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </div>
                            </div>
                            <div class="icon-box text-success">
                                <ion-icon name="checkmark-circle-outline"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- * android style -->

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
    <script src="assets/js/datatable/dataTables/jquery.dataTables.min.js"></script>
    <!-- Base Js File -->
    <script src="assets/js/base.js"></script>
    <script type="text/javascript">
        
        let id_proveedor = parseInt(document.getElementById("id_proveedor").textContent);
        
        function iniciarCtaCte(){
            traerCtaCte();

            /*Delego eventos*/
            document.addEventListener("click", (e)=>{

                if (e.target.matches(".btnDetalle")) {
                    verDetalleCC(e)
                }
            })
        }

        function verDetalleCC(e){

            let accion = "traerOrigen";
            let id_cc = e.target.getAttribute("data-idCC");
            let montoTotalInicial =0;

            $.ajax({
                url: "models/administrar_cta_cte_app.php",
                type: "POST",
                datatype: "json",
                data: {accion: accion, id_cc: id_cc},
                success: function(respuesta){

                    let respuestaJson = JSON.parse(respuesta);
                 
                    if(respuestaJson.tipo_movimiento.tipo_movimiento==1){

                        let $fragment = document.createDocumentFragment();
                        let $tablaItems = document.querySelector(".tbodyItems");
                        $tablaItems.innerHTML="";


                        respuestaJson.detalle_origen.forEach((item)=>{
                            $tr = document.createElement("tr");
                            $tr.innerHTML+=`<td>${item.id_item}</td>
                                            <td>${item.item}</td>
                                            <td>${item.cantidad}</td>
                                            <td>${item.precio}</td>
                                            `;
                            $fragment.appendChild($tr);

                            let cantidad = item.cantidad;
                            let precio = item.precio;
                            
                            montoTotalInicial+=(precio*cantidad);

                        });

                        $tablaItems.appendChild($fragment);
                        let montoFormateado= new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(montoTotalInicial);
                        $('.totalFormateado').text(montoFormateado);
                        $('.total').text(montoTotalInicial);

                        $("#id_orden").html(respuestaJson.origen.id_origen);

                        $("#detalle_movimientos_oc").modal("show");

                    }else{
                        alert("Aún no está el modulo pagos")
                    }

                }
            })

            

        }

        function traerCtaCte(){
            let accion = "traerCtaCte";
            let $contenedorCards = document.getElementById("contenedorCards");
            $.ajax({
                url: "models/administrar_cta_cte_app.php",
                type: "POST",
                datatype: "json",
                data: {accion: accion, id_proveedor: id_proveedor},
                success: function(response){

                    let respuestaJson = JSON.parse(response);

                    if(respuestaJson.length > 0){

                        let respuestaJson = JSON.parse(response); 
                        $fragment = document.createDocumentFragment();
                        $fragment.innerHTML="";
                        respuestaJson.forEach((ctaCte)=>{
                            let montoFormateado = new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(ctaCte.monto)
                            $fragment.innerHTML+=`
                                <div class="section mt-2">
                                    <div class="card text-center">
                                        <div class="card-header">
                                            ${ctaCte.tipo_movimiento}
                                        </div>
                                        <div class="card-body">
                                            <ul class="listview image-listview" style="border: 0px;">
                                                <li>
                                                    <div class="item">
                                                        <div class="icon-box bg-secondary">
                                                            <ion-icon name="calendar-outline" role="img" class="md hydrated" aria-label="calendar outline"></ion-icon>
                                                        </div>
                                                        <div class="in">
                                                            <div>Fecha:</div>
                                                            <span class="badge badge-primary"> ${ctaCte.fecha}</span>
                                                        </div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="icon-box bg-secondary">
                                                            <ion-icon name="cash-outline" role="img" class="md hydrated" aria-label="cash outline"></ion-icon>
                                                        </div>
                                                        <div class="in">
                                                            <div>Importe:</div>
                                                            <span class="badge badge-primary">${montoFormateado}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer text-muted">
                                           <button class="btn btn-warning mr-1 mb-1 btnDetalle" data-idCC="${ctaCte.id_ctaCte}">Ver origen
                                           </button>
                                        </div>
                                    </div>
                                </div>
                            `
                        })
                        $contenedorCards.innerHTML=$fragment.innerHTML;
                    }else{
                        //notification('notification-4')

                        $contenedorCards.innerHTML=`<div class ="alert alert-danger mt-2 ml-2 mr-2 text-center" role="alert">
                                <span class="">No se encontraron datos para mostrar</span>
                            </div>`;
                    }

                }
            });
        }


        window.addEventListener("DOMContentLoaded", iniciarCtaCte)
    </script>

</body>

</html>