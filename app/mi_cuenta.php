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
    <title>Myla - Mi cuenta</title>
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
        <div class="pageTitle">Mi cuenta</div>
        <div class="right">
        </div>

    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="login-form">
            <div class="section mt-2 mb-5">
                    <form class="needs-validation" novalidate>
                        <div id="containerRegister">
                            <input type="number" class="d-none" id="tipoSeleccionado">
                            <!--<div class="form-group boxed">
                                <div class="input-wrapper">
                                    <label class="label" for="city5" id="titleSelect"></label>
                                    <select class="form-control custom-select" id="datosTipos" required>
                                        <option selected disabled value="">Seleccione...</option>
                                    </select>
                                    <div class="valid-feedback">Correcto!</div>
                                    <div class="invalid-feedback">Por favor elija una opción.</div>
                                </div>
                            </div>-->

                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <label class="label" for="email">E-mail</label>
                                    <input type="email" class="form-control" id="emailUpdate" placeholder="E-mail" required>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                    <div class="valid-feedback">Correcto!</div>
                                    <div class="invalid-feedback">Por favor ingrese e-mail.</div>
                                </div>
                            </div>

                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <label class="label" for="pass">Password</label>
                                    <input type="password" class="form-control" id="passwordUpdate" placeholder="Password" required>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                    <div class="valid-feedback">Correcto!</div>
                                    <div class="invalid-feedback">Por favor ingrese contraseña.</div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button class="btn btn-success btn-block" type="submit" id="btnActualizar">Actualizar</button>
                            </div>
                        </div>
                    </form>
                    <span id="id_user" class="d-none"><?php echo $_SESSION['rowUsers']['id_usuario']; ?></span>
                </div>
            </div>
    </div>
    <!-- * App Capsule -->

    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="models/redireccionar_app.php" class="item">
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

        <!-- toast center iconed -->
        <div id="userExist" class="toast-box toast-center">
            <div class="in">
                <ion-icon name="close-circle-outline" class="text-danger"></ion-icon>
                <div class="text">
                    El usuario ya existe
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-text-light close-button">Aceptar</button>
        </div>
        <!-- toast center iconed -->

        <!-- toast center iconed -->
        <div id="sinCambios" class="toast-box toast-center">
            <div class="in">
                <ion-icon name="close-circle-outline" class="text-danger"></ion-icon>
                <div class="text">
                    No se registraron cambios
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-text-light close-button">Aceptar</button>
        </div>
        <!-- toast center iconed -->

        <!-- toast top iconed -->
        <div id="cambioOK" class="toast-box toast-center">
            <div class="in">
                <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
                <div class="text">
                    Actualización exitosa!
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-text-light close-button">Cerrar</button>
        </div>
    <!-- * toast top iconed -->


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

        function iniciarMiCuenta(){
            datosUser = new Map();
            let id_user = parseInt(document.getElementById("id_user").textContent);
            let accion = "traerDatosUser";

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });

            $.ajax({
                url: "models/administrar_mi_cuenta.php",
                type: "POST",
                datatype: "json",
                data: {accion: accion, id_user: id_user},
                success: function(response){
                    let respuestaJson = JSON.parse(response);

                    document.getElementById("emailUpdate").value = respuestaJson[0].email;
                    document.getElementById("passwordUpdate").value = respuestaJson[0].clave;
                    datosUser.set(respuestaJson[0].id_usuario, {mail: respuestaJson[0].email, clave: respuestaJson[0].clave});


                }
            });
            form = document.querySelector("form");
            form.addEventListener("submit", (form)=>{verificarUsuario(form)});
        }

        function verificarUsuario(form){

            form.preventDefault();

            if (form.target.checkValidity() !== false) {

                        let id_user = parseInt(document.getElementById("id_user").textContent);
                        let user_act = document.getElementById("emailUpdate").value;
                        let clave_act = document.getElementById("passwordUpdate").value
                        
                        let user_ant = datosUser.get(""+id_user+"").mail;
                        let clave_ant = datosUser.get(""+id_user+"").clave;

                        if(user_ant === user_act && clave_ant === clave_act){
                            toastbox('sinCambios');
                        }else{

                            let mail = document.getElementById("emailUpdate").value;
                            let accion= "verificarCuenta";
                            $.ajax({
                                url: "./models/administrar_mi_cuenta.php",
                                type: "POST",
                                datatype: "json",
                                data: {accion: accion, mail: mail},
                                success: function(respuesta){

                                    if(respuesta == 1 && (clave_ant === clave_act)){
                                        toastbox('userExist');
                                    }else{
                                       actualizarUsuario(id_user, user_act, clave_act);
                                    }

                                }
                                })

                        }    
                    }
        }

        function actualizarUsuario(id_user, user_act, clave_act){
            let accion = "actualizarUsuario";
            $.ajax({
                url: "./models/administrar_mi_cuenta.php",
                type: "POST",
                datatype: "json",
                data: {accion: accion, id_user: id_user, email: user_act, clave: clave_act},
                success: function(respuesta){
                    toastbox('cambioOK');
                }

            });
        }

        window.addEventListener("load", iniciarMiCuenta, false);

        
    </script>

</body>

</html>