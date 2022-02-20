<?php
  session_start();
  include_once('./../conexion.php');
  date_default_timezone_set("America/Buenos_Aires");
  $hora = date('Hi');
  if (!isset($_SESSION['rowUsers']['id_usuario'])) {
      header("location:./models/redireccionar.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="endless admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, endless admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <!--<link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">-->
    <title>MYLA - Tareas de Mantenimiento Preventivo</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/flag-icon.css">
     <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="assets/css/datatables.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="assets/css/sweetalert2.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link id="color" rel="stylesheet" href="assets/css/light-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fullCalendar/main.min.css">
    <style type="text/css">
      input[type=number]::-webkit-inner-spin-button,
      input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
        margin: 0;
        }
      input[type=number] { -moz-appearance:textfield; }
      .fa-angle-down {
        transition: all 0.3s ease;
      }
      .card-header a.collapsed .fa-angle-down {
        transform: rotate(180deg);
      }
      #modalCRUD .card-header{
        background-color: #2f3c4e;
      }
      #modalCRUD a .card-header h6{
        color: #f6f7fb;
      }
    </style>
  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="loader bg-white">
        <div class="whirly-loader"> </div>
      </div>
    </div>
    <!-- Loader ends--><?php
      include_once('./views/main_header.php');?>
      <!-- Page Header Ends                              -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="page-sidebar"><?php
          include_once('./views/slideBar.php');?>
        </div>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-header">
              <div class="row">
                <div class="col">
                  <div class="page-header-left">
                    <h3>Tareas de Mantenimiento Preventivo</h3>
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="home_users.php"><i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item active">Tareas de Mantenimiento Preventivo</li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <!-- Ajax Generated content for a column start-->
              <div class="col-xl-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="d-inline">Calendario de tareas</h5>
                  </div>
                  <div class="card-body">
                    <div id="cal-agenda-view"></div>
                  </div>
                </div>
              </div>
              </div>

              <div class="row">
                <div class="col-xl-12">
                  <div class="card">
                    <div class="card-header">
                      <h5>Grilla de tareas</h5>
                      <button id="btnNuevoMantenimientoPreventivo" type="button" class="btn btn-primary mt-2" data-toggle="modal"><i class="fa fa-check-square-o"></i> Nuevo tarea</button>
                    </div><?php
                    //var_dump($_SESSION["rowUsers"]["id_empresa"]);?>
                    <div class="card-body">
                      <div class="table-responsive" id="contTablaListas" >
                        <table class="table table-hover" id="tablaTareas">
                          <thead class="text-center">
                            <tr>
                              <th class="text-center">#ID</th>
                              <th>Activo</th>
                              <th>Asunto</th>
                              <th>Detalle</th>
                              <th>Ejecucion desde</th>
                              <th>Ejecucion hasta</th>
                              <th>Estado</th>
                              <th>Contacto</th>
                              <!-- <th>Vehiculo</th> -->
                              <!-- <th>Costo estimado de movilidad</th> -->
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Ajax Generated content for a column end-->
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 footer-copyright">
                <p class="mb-0"></p>
              </div>
              <div class="col-md-6">
                <p class="pull-right mb-0"></p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>

    <!--Modal para CRUD-->
    <!-- <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <span id="id_mantenimiento_preventivo" class="d-none"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formMantenimientoPreventivo">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Cliente:</label>
                    <select class="form-control" id="cliente">
                      <option value="">Seleccione</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Elemento</label>
                    <select class="form-control" id="id_elemento_cliente" required>
                      <option value="">Seleccione</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Asunto:</label>
                    <input type="text" class="form-control" id="asunto" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Detalle:</label>
                    <input type="text" class="form-control" id="detalle" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Contacto:</label>
                    <select class="form-control" id="id_contacto_cliente" required>
                      <option value="">Seleccione</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Vehiculo:</label>
                    <select class="form-control" id="id_vehiculo_asignado" required>
                      <option value="">Seleccione</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Costo de movilidad estimado:</label>
                    <input type="number" class="form-control" id="costo_movilidad_estimado" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12 text-center font-weight-bold">Fechas y hora de ejecucion</div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Desde:</label>
                    <input type="datetime-local" class="form-control" id="fecha_hora_ejecucion_desde" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Hasta:</label>
                    <input type="datetime-local" class="form-control" id="fecha_hora_ejecucion_hasta" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div> -->
    <!-- FINAL MODAL CRUD-->

    <!--Modal para CRUD-->
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <span id="id_mantenimiento_preventivo" class="d-none"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formMantenimientoPreventivo" >
            <div class="modal-body">
              <!--Accordion wrapper-->
              <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                <!-- Accordion card -->
                <div class="card border-secondary">
                  <!-- Card header -->
                  <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                    <div class="card-header" role="tab" id="headingOne1">
                      <h6 class="mb-0">Datos principales <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                    </div>
                  </a>
                  <!-- Card body -->
                  <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                    <div class="card-body border-secondary">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Cliente:</label>
                            <select class="form-control" id="cliente">
                              <option value="">Seleccione</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Ubicacion</label>
                            <select class="form-control" id="ubicacion" required>
                              <option value="">Seleccione</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Contacto:</label>
                            <select class="form-control" id="id_contacto_cliente" required>
                              <option value="">Seleccione</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Elemento</label>
                            <select class="form-control" id="id_elemento_cliente" required>
                              <option value="">Seleccione</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Accordion card -->
                <!-- Accordion card -->
                <div class="card border-secondary">
                  <!-- Card header -->
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                    <div class="card-header" role="tab" id="headingTwo2">
                      <h6 class="mb-0">Datos de la tarea <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                    </div>
                  </a>
                  <!-- Card body -->
                  <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
                    <div class="card-body border-secondary">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Asunto:</label>
                            <input type="text" class="form-control" id="asunto" required>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Detalle:</label>
                            <input type="text" class="form-control" id="detalle" required>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="" class="col-form-label">Adjuntos:</label>
                            <input type="file" class="form-control" id="adjuntos" multiple>
                          </div>
                        </div>
                      </div> -->
                      <div class="row">
                        <div class="col-lg-4 mb-2"><button id="btnAddAdjuntos" class="btn btn-secondary"> Agregar adjuntos</button></div>
                        <div class="col-lg-12 d-none" id="masAdjuntos">
                          <div id="dropMasArchivos"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Accordion card -->
                <!-- Accordion card -->
                <!-- <div class="card border-secondary">
                  <div class="card-header" role="tab" id="headingThree3">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3"
                      aria-expanded="false" aria-controls="collapseThree3">
                      <h6 class="mb-0">Datos del contacto (que realiza el pedido) <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                    </a>
                  </div>
                  <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3" data-parent="#accordionEx">
                    <div class="card-body border-secondary">
                      <div class="row">
                        
                      </div>
                    </div>
                  </div>
                </div> -->
                <!-- Accordion card -->
                <!-- Accordion card -->
                <div class="card border-secondary">
                  <!-- Card header -->
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree4" aria-expanded="false" aria-controls="collapseThree4">
                    <div class="card-header" role="tab" id="headingThree4">
                      <h6 class="mb-0">Fechas y hora de ejecucion <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                    </div>
                  </a>
                  <!-- Card body -->
                  <div id="collapseThree4" class="collapse" role="tabpanel" aria-labelledby="headingThree4" data-parent="#accordionEx">
                    <div class="card-body border-secondary">
                      <!-- <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Vehiculo:</label>
                            <select class="form-control" id="id_vehiculo_asignado" required>
                              <option value="">Seleccione</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Costo de movilidad estimado:</label>
                            <input type="number" class="form-control" id="costo_movilidad_estimado" required>
                          </div>
                        </div>
                      </div> -->
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Desde:</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora_ejecucion_desde" value="<?=$desde=date("Y-m-d\TH:i")?>" required>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Hasta:</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora_ejecucion_hasta" value="<?=date("Y-m-d\TH:i",strtotime($desde."+8 hours"))?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-2">
                          <div class="form-group">
                            <label for="" class="col-form-label">Repetir cada:</label>
                          </div>
                        </div>
                        <div class="col-lg-2">
                          <div class="form-group">
                            <input type="number" step="1" class="form-control" id="frecuencia_cantidad" placeholder="cantidad">
                          </div>
                        </div>
                        <div class="col-lg-2">
                          <div class="form-group">
                            <select id="frecuencia_repeticion" class="form-control">
                              <option value="days">Días</option>
                              <option value="week">Semanas</option>
                              <option value="month">Meses</option>
                              <option value="year">Años</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-2">
                          <div class="form-group">
                          <label for="" class="col-form-label">Hasta el:</label>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <input type="datetime-local" class="form-control" id="frecuencia_stop" placeholder="cantidad">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Accordion card -->
                <!-- Accordion card -->
                <div class="card border-secondary">
                  <!-- Card header -->
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree5" aria-expanded="false" aria-controls="collapseThree5">
                    <div class="card-header" role="tab" id="headingThree5">
                    
                      <h6 class="mb-0">Materiales previstos <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                    
                    </div>
                  </a>
                  <!-- Card body -->
                  <div id="collapseThree5" class="collapse" role="tabpanel" aria-labelledby="headingThree5" data-parent="#accordionEx">
                    <div class="card-body border-secondary">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Almacenes:</label>
                            <select class="form-control" id="id_almacen" required>
                              <option value="">Seleccione</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="table-responsive tablaItems">
                        <table class="table table-hover" id="tablaItems">
                          <thead class="text-center">
                            <tr>
                              <!-- <th>#ID</th> -->
                              <th>Item</th>
                              <th>UM</th>
                              <th>Proveedor</th>
                              <th>Tipo</th>
                              <th>Categoría</th>
                              <th>Cantidad estimada</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <!-- <th>#ID</th> -->
                              <th>Item</th>
                              <th>UM</th>
                              <th>Proveedor</th>
                              <th>Tipo</th>
                              <th>Categoría</th>
                              <th>Cantidad estimada</th>
                            </tr>
                          </tfoot>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Accordion card -->
              </div>
              <!-- Accordion wrapper -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- FINAL MODAL CRUD-->

    <!-- MODAL ver detalle empresa y linea de tiempo -->
    <div class="modal fade mt-5" id="verDetalleVehiculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Detalle vehiculo</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body"></div>
        </div>
      </div>
    </div>
    <!-- FIN MODAL ver detalle empresa y linea de tiempo-->

    <!--Modal para añadir tarea de mantenimiento-->
    <div class="modal fade" id="modalAddMantenimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelMantenimiento"></h5>
            <span id="id_vehiculo_mantenimiento" class="d-none"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formTareaMantenimiento">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Detalle:</label>
                    <input type="text" class="form-control" id="detalle" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Costo estimado</label>
                    <input type="text" class="form-control" id="costo_estimado" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Fecha:</label>
                    <input type="date" class="form-control" id="fecha_mantenimiento" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="" class="col-form-label">*Hora</label>
                    <input type="time" class="form-control" id="hora_mantenimiento" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="" class="col-form-label">Comentarios:</label>
                    <textarea id="comentarios_tarea_mantenimiento" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="btnGuardarTareaMantenimiento" class="btn btn-dark">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- FINAL MODAL para añadir tarea de mantenimiento-->

    <!--Modal con opciones para tareas de mantenimiento-->
    <div class="modal fade" id="modalOpcionesTareas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">¿Qué desea hacer con la tarea?</h5>
            <span id="id_tarea_mantenimiento" class="d-none"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <button type="button" data-dismiss="modal" class="btn btn-success" id="btnEditarTarea"><i class='fa fa-edit'></i> Editar</button>
            <button type="button" data-dismiss="modal" class="btn btn-dark"  data-toggle="modal" data-target="#modalMarcarTareaCompleta"><i class="fa fa-check"></i> Completar</button>
            <button type="button" data-dismiss="modal" class="btn btn-danger" id="btnBorrarTarea"><i class="fa fa-trash-o"></i> Borrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- FINAL MODAL con opciones para tareas de mantenimiento-->

    <!--Modal para marcar tarea completa-->
    <div class="modal fade" id="modalMarcarTareaCompleta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Marcar tarea completa</h5>
            <!-- <span id="id_tarea_mantenimiento_completar" class="d-none"></span> -->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formTareaMantenimiento">
            <div class="modal-body">¿Esta seguro que desea marcar como completa esta tarea?</div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnMarcarTareaMantenimientoRealizada" class="btn btn-dark">Completar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- FINAL MODAL para marcar tarea completa-->

    <!-- latest jquery-->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="assets/js/bootstrap/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.js"></script>
    <!-- feather icon js-->
    <script src="assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/chart/chartjs/chart.min.js"></script>
    <script src="assets/js/sweet-alert/sweetalert.min.js"></script>
    <script src="assets/js/chat-menu.js"></script>
    <script src="assets/js/tooltip-init.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>

    <script src="assets/js/fullCalendar/main.min.js"></script>
    <script src="assets/js/fullCalendar/locales/es.js"></script>
    <!--<script src="assets/js/theme-customizer/customizer.js"></script>-->
    <!-- Plugin used-->
    <script type="text/javascript">

      var accion = "";
      $(document).ready(function(){
        //armarCalendario();
        cargarDatosComponentes();
        idiomaEsp = {
                        "autoFill": {
                            "cancel": "Cancelar",
                            "fill": "Llenar las celdas con <i>%d<i><\/i><\/i>",
                            "fillHorizontal": "Llenar las celdas horizontalmente",
                            "fillVertical": "Llenar las celdas verticalmente"
                        },
                        "decimal": ",",
                        "emptyTable": "No hay datos disponibles en la Tabla",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                        "infoFiltered": "Filtrado de _MAX_ entradas totales",
                        "infoThousands": ".",
                        "lengthMenu": "Mostrar _MENU_ entradas",
                        "loadingRecords": "Cargando...",
                        "paginate": {
                            "first": "Primera",
                            "last": "Ultima",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                        "processing": "Procesando...",
                        "search": "Busqueda:",
                        "searchBuilder": {
                            "add": "Agregar condición",
                            "button": {
                                "0": "Constructor de búsqueda",
                                "_": "Constructor de búsqueda (%d)"
                            },
                            "clearAll": "Quitar todo",
                            "condition": "Condición",
                            "conditions": {
                                "date": {
                                    "after": "Luego",
                                    "before": "Luego",
                                    "between": "Entre",
                                    "empty": "Vacio",
                                    "equals": "Igual"
                                }
                            },
                            "data": "Datos",
                            "deleteTitle": "Borrar regla de filtrado",
                            "leftTitle": "Criterio de alargado",
                            "logicAnd": "Y",
                            "logicOr": "O",
                            "rightTitle": "Criterio de endentado",
                            "title": {
                                "0": "Constructor de búsqueda",
                                "_": "Constructor de búsqueda (%d)"
                            },
                            "value": "Valor"
                        },
                        "searchPlaceholder": "Ingrese caracteres de busqueda",
                        "thousands": ".",
                        "zeroRecords": "No se encontraron registros que coincidan con la búsqueda",
                        "datetime": {
                            "previous": "Anterior",
                            "next": "Siguiente",
                            "hours": "Hora",
                            "minutes": "Minuto",
                            "seconds": "Segundo"
                        },
                        "editor": {
                            "close": "Cerrar",
                            "create": {
                                "button": "Nuevo",
                                "title": "Crear nueva entrada",
                                "submit": "Crear"
                            },
                            "edit": {
                                "button": "Editar",
                                "title": "Editar entrada",
                                "submit": "Actualizar"
                            },
                            "remove": {
                                "button": "Borrar",
                                "title": "Borrar",
                                "submit": "Borrar",
                                "confirm": {
                                    "_": "Está seguro que desea borrar %d filas?",
                                    "1": "Está seguro que desea borrar 1 fila?"
                                }
                            },
                            "multi": {
                                "title": "Múltiples valores",
                                "info": "La selección contiene diferentes valores para esta entrada. Para editarla y establecer todos los items al mismo valor, clickear o tocar aquí, de otra manera conservarán sus valores individuales.",
                                "restore": "Deshacer cambios",
                                "noMulti": "Esta entrada se puede editar individualmente, pero no como parte de un grupo."
                            }
                        }
                    }


        //debugger;
        tablaTareas= $('#tablaTareas').DataTable({
          "ajax": {
              "url" : "./models/administrar_mantenimieno_preventivo.php?accion=traerMantenimientoPreventivo",
              "dataSrc": "",
            },
          "columns":[
            {"data": "id_mantenimiento_preventivo"},
            {"data": "descripcion_activo"},
            {"data": "asunto"},
            {"data": "detalle"},
            {"data": "fecha_hora_ejecucion_desde_mostrar"},
            {"data": "fecha_hora_ejecucion_hasta_mostrar"},
            {"data": "estado"},
            {"data": "contacto_cliente"},
            //{"data": "vehiculo"},
            // {"data": "costo_movilidad_estimado_mostrar"},
            {"defaultContent" : "<div class='text-center'><div class='btn-group'><button class='btn btn-success btnEditar'><i class='fa fa-edit'></i></button><button class='btn btn-warning btnVer'><i class='fa fa-eye'></i></button><button class='btn btn-danger btnBorrar'><i class='fa fa-trash-o'></i></button></div></div>"},//<button class='btn btn-primary btnAddMantenimiento' title='Añadir tarea de mantenimiento'><i class='fa fa-wrench'></i></button>
          ],
          "language":  idiomaEsp
        });

        //var calendarEl = document.getElementById('cal-agenda-view');
        calendar = new FullCalendar.Calendar(document.getElementById('cal-agenda-view'), {
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            //right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
          },
          //events: eventosJSON,
          events: "./models/administrar_mantenimieno_preventivo.php?accion=traerMantenimientoPreventivoCalendario",
          locale: "es",
          //defaultDate: '2016-06-12',
          //defaultView: 'agendaWeek',
          //editable: true,
          selectable: true,
          weekNumbers: true,
          navLinks: true, // can click day/week names to navigate views
          selectable: true,
          nowIndicator: true,
          dayMaxEvents: true, // allow "more" link when too many events
          //selectHelper: true,
          //droppable: true,
          //eventLimit: true,
          eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',
            //second: '2-digit',
            //meridiem: false
          },
          eventClick: function(info) {
            info.jsEvent.preventDefault(); // don't let the browser navigate
            var event=info.event;
            if(event.extendedProps.realizado==0){
                //$('#modalOpcionesTareas').modal('show');
                var modalOpcionesTareas=$('#modalOpcionesTareas');
                modalOpcionesTareas.modal('show');
                modalOpcionesTareas.find("#id_tarea_mantenimiento").html(event.id);

                /*var modalMarcarTareaCompleta=$('#modalMarcarTareaCompleta');
                modalMarcarTareaCompleta.modal('show');
                modalMarcarTareaCompleta.find("#id_tarea_mantenimiento").html(event.id);*/
                /*if (event.url) {
                  window.open(event.url, "_blank");
                  return false;
                }*/
            }
          },
          eventDidMount: function(info) {
            el=info.el;
            event=info.event;
            $(el).popover({
              title: "#"+event.id+" - "+event.title,
              content: event.extendedProps.description,
              trigger: 'hover',
              placement: 'top',
              container: 'body',
              html: true
            });
          },
        });
        calendar.render();

        $('#modalCRUD').on('hidden.bs.modal', function (e) {
          document.getElementById('dropMasArchivos').innerHTML="";
          document.getElementById('masAdjuntos').classList.toggle("d-none");
        });
      });

      function cargarDatosComponentes(){
        let datosIniciales = new FormData();
        datosIniciales.append('accion', 'traerDatosInicialesMantenimientoPreventivo');
        $.ajax({
          data: datosIniciales,
          url: "./models/administrar_mantenimieno_preventivo.php",
          method: "post",
          cache: false,
          contentType: false,
          processData: false,
          beforeSed: function(){
              //$('#addProdLocal').modal('hide');
          },
          success: function(respuesta){
            //console.log(respuesta);
            /*Convierto en json la respuesta del servidor*/
            respuestaJson = JSON.parse(respuesta);
            //console.log(respuestaJson);

            /*Identifico el select de vehiculos*/
            $selectAlmacenes= document.getElementById("id_almacen");
            //Genero los options del select de vehiculos
            respuestaJson.almacenes.forEach((almacen)=>{
                $option = document.createElement("option");
                let optionText = document.createTextNode(almacen.almacen);
                $option.appendChild(optionText);
                $option.setAttribute("value", almacen.id_almacen);
                $selectAlmacenes.appendChild($option);
            });

            /*Identifico el select de vehiculos*/
            /*$selectVehiculos= document.getElementById("id_vehiculo_asignado");
            //Genero los options del select de vehiculos
            respuestaJson.vehiculos.forEach((vehiculo)=>{
                $option = document.createElement("option");
                let optionText = document.createTextNode(vehiculo.vehiculo);
                $option.appendChild(optionText);
                $option.setAttribute("value", vehiculo.id_vehiculo);
                $selectVehiculos.appendChild($option);
            });*/

            /*Identifico el select de clientes*/
            $selectClientes= document.getElementById("cliente");
            //Genero los options del select de clientes
            respuestaJson.clientes.forEach((cliente)=>{
                $option = document.createElement("option");
                let optionText = document.createTextNode(cliente.razon_social);
                $option.appendChild(optionText);
                $option.setAttribute("value", cliente.id_cliente);
                $selectClientes.appendChild($option);
            });

          }
        });
      }

      $(document).on("change", "#id_almacen", function(){
        let id_almacen=this.value;
        $("#tablaItems").dataTable().fnDestroy();
        tablaItems=$('#tablaItems').DataTable({
          "ajax": {
              "url" : "./models/administrar_stock.php?accion=traerItems&id_almacen="+id_almacen,
              "dataSrc": "",
            },
          "columns":[
            //{"data": "id_item"},
            {"data": "item"},
            {"data": "unidad_medida"},
            {"data": "proveedor"},
            {"data": "tipo"},
            {"data": "categoria"},
            {
              render: function(data, type, full, meta) {
                return ()=>{
                  return `
                  <input type='hidden' id='proveedor-item-`+full.id_item+`' value=`+full.id_proveedor+`>
                  <input type='number' class='items' id='item-`+full.id_item+`' placeholder='Cantidad estimada'>`;//
                };
              }
            },
          ],
          "language":  idiomaEsp,
          initComplete: function(){
            var b=1;
            var c=0;
            this.api().columns.adjust().draw();//Columns sin parentesis
            this.api().columns().every(function(){//Columns() con parentesis
              if(b!=6){
                var column=this;
                var name=$(column.header()).text();
                var select=$("<select id='filtro"+name.replace(/ /g, "")+"' class='form-control form-control-sm filtrosTrato'><option value=''>Todos</option></select>")
                  .appendTo($(column.footer()).empty())
                  .on("change",function(){
                    var val=$.fn.dataTable.util.escapeRegex(
                      $(this).val()
                    );
                    column.search(val ? '^'+val+'$':'',true,false).draw();
                  });
                column.data().unique().sort().each(function(d,j){
                  var val=$("<div/>").html(d).text();
                  if(column.search()==='^'+val+'$'){
                    select.append("<option value='"+val+"' selected='selected'>"+val+"</option>");
                  }else{
                    select.append("<option value='"+val+"'>"+val+"</option>");
                  }
                })
              }
              b++;
            })
          }
        });
      });

      $(document).on('click', '#btnAddAdjuntos', function(e){
        e.preventDefault();
        $rowMasAdjuntos = document.getElementById("masAdjuntos");
        $rowMasAdjuntos.classList.toggle("d-none");
        $.ajax({
            url: "dropAdjuntosMantenimientoPreventivo.html",
            type: "POST",
            datatype:"json",    
            data:  {},    
            success: function(response) {
              $('#dropMasArchivos').html(response);
            }
          });
      });

      $(document).on("change", "#cliente", function(){
        getUbicacionesCliente();
      });

      function getUbicacionesCliente(id_cliente,id_ubicacion_cliente){
        let datosIniciales = new FormData();
        if(id_cliente==undefined){
          id_cliente=document.getElementById("cliente").value;
        }
        datosIniciales.append('id_cliente', id_cliente);
        datosIniciales.append('accion', 'traerDirecciones');
        $.ajax({
          data: datosIniciales,
          url: "./models/administrar_clientes.php",
          method: "post",
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta){
            console.log(respuesta);
            /*Convierto en json la respuesta del servidor*/
            respuestaJson = JSON.parse(respuesta);
            console.log(respuestaJson);
            let listaUbicaciones=respuestaJson;

            /*Identifico el select de direcciones*/
            $selectUbicacionesCliente= document.getElementById("ubicacion");
            $selectUbicacionesCliente.innerHTML = "";
            /*Genero los options del select de direcciones*/
            $option = document.createElement("option");
            let texto="Sin resultados";
            if(listaUbicaciones.length>0){
              texto="Seleccione una ubicacion";
            }
            let optionText = document.createTextNode(texto);
            $option.appendChild(optionText);
            $selectUbicacionesCliente.appendChild($option);
            
            listaUbicaciones.forEach((ubicaciones_cliente)=>{
                $option = document.createElement("option");
                let optionText = document.createTextNode(ubicaciones_cliente.direccion);
                $option.appendChild(optionText);
                $option.setAttribute("value", ubicaciones_cliente.id_direccion);
                if(id_ubicacion_cliente==ubicaciones_cliente.id_direccion){
                  $option.setAttribute("selected", true);
                }
                $selectUbicacionesCliente.appendChild($option);
            });

          }
        });
      }

      $(document).on("change", "#ubicacion", function(){
        getContactosUbicacion();
        getElementosUbicacion();
      });

      function getContactosUbicacion(id_ubicacion,id_contacto_cliente){
        let datosIniciales = new FormData();
        if(id_ubicacion==undefined){
          id_ubicacion=document.getElementById("ubicacion").value;
        }
        datosIniciales.append('id_ubicacion', id_ubicacion);
        datosIniciales.append('accion', 'traerContactos');
        $.ajax({
          data: datosIniciales,
          url: "./models/administrar_clientes.php",
          method: "post",
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta){
            console.log(respuesta);
            /*Convierto en json la respuesta del servidor*/
            respuestaJson = JSON.parse(respuesta);
            console.log(respuestaJson);
            let listaContactos=respuestaJson.contactos;

            /*Identifico el select de direcciones*/
            $selectContactosCliente= document.getElementById("id_contacto_cliente");
            $selectContactosCliente.innerHTML = "";
            /*Genero los options del select de direcciones*/
            $option = document.createElement("option");
            let texto="Sin resultados";
            if(listaContactos.length>0){
              texto="Seleccione un contacto";
            }
            let optionText = document.createTextNode(texto);
            $option.appendChild(optionText);
            $selectContactosCliente.appendChild($option);
            
            listaContactos.forEach((contacto_cliente)=>{
                $option = document.createElement("option");
                let optionText = document.createTextNode(contacto_cliente.nombre_completo);
                $option.appendChild(optionText);
                $option.setAttribute("value", contacto_cliente.id_contacto);
                if(id_contacto_cliente==contacto_cliente.id_contacto){
                  $option.setAttribute("selected", true);
                }
                $selectContactosCliente.appendChild($option);
            });

          }
        });
      }

      function getElementosUbicacion(id_ubicacion,id_elemento_cliente){
        let datosIniciales = new FormData();
        if(id_ubicacion==undefined){
          id_ubicacion=document.getElementById("ubicacion").value;
        }
        datosIniciales.append('id_ubicacion', id_ubicacion);
        datosIniciales.append('accion', 'trerElementosCliente');
        $.ajax({
          data: datosIniciales,
          url: "./models/administrar_elementos.php",
          method: "post",
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta){
            console.log(respuesta);
            /*Convierto en json la respuesta del servidor*/
            respuestaJson = JSON.parse(respuesta);
            console.log(respuestaJson);

            /*Identifico el select de direcciones*/
            $selectElementosCliente= document.getElementById("id_elemento_cliente");
            $selectElementosCliente.innerHTML = "";
            /*Genero los options del select de direcciones*/
            $option = document.createElement("option");
            let texto="Sin resultados";
            if(respuestaJson.length>0){
              texto="Seleccione un elemento";
            }
            let optionText = document.createTextNode(texto);
            $option.appendChild(optionText);
            $selectElementosCliente.appendChild($option);
            
            respuestaJson.forEach((elemento)=>{
                $option = document.createElement("option");
                let optionText = document.createTextNode(elemento.descripcion);
                $option.appendChild(optionText);
                $option.setAttribute("value", elemento.id_elemento);
                if(id_elemento_cliente==elemento.id_elemento){
                  $option.setAttribute("selected", true);
                }
                $selectElementosCliente.appendChild($option);
            });

          }
        });
      }

      $('#formMantenimientoPreventivo').submit(function(e){
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página   
        
        let datosEnviar = new FormData();
        datosEnviar.append("id_elemento_cliente", $.trim($('#id_elemento_cliente').val()));
        //datosEnviar.append("fecha_alta", $.trim($('#fecha_alta').val()));
        datosEnviar.append("asunto", $.trim($('#asunto').val()));
        datosEnviar.append("detalle", $.trim($('#detalle').val()));
        datosEnviar.append("id_contacto_cliente", $.trim($('#id_contacto_cliente').val()));
        datosEnviar.append("id_almacen", $.trim($('#id_almacen').val()));
        //datosEnviar.append("costo_movilidad_estimado", $.trim($('#costo_movilidad_estimado').val()));
        datosEnviar.append("fecha_hora_ejecucion_desde", $.trim($('#fecha_hora_ejecucion_desde').val()));
        datosEnviar.append("fecha_hora_ejecucion_hasta", $.trim($('#fecha_hora_ejecucion_hasta').val()));

        datosEnviar.append("frecuencia_cantidad", $.trim($('#frecuencia_cantidad').val()));
        datosEnviar.append("frecuencia_repeticion", $.trim($('#frecuencia_repeticion').val()));
        datosEnviar.append("frecuencia_stop", $.trim($('#frecuencia_stop').val()));

        //let items= new Array();
        let items= {};

        $(".items").each(function(){
          let cantidad_item=this.value;
          if(cantidad_item!="" && cantidad_item!=0){
            items[this.id]={
              "cantidad":cantidad_item,
              "proveedor":$("#proveedor-"+this.id).val()
            };
          }
        });
        datosEnviar.append("itemsJSON", JSON.stringify(items));
        
        datosEnviar.append("id_mantenimiento_preventivo", $.trim($('#id_mantenimiento_preventivo').html()));
        datosEnviar.append("accion", accion);
        //console.log(accion);

        let cantArchivos = 0;
        if(typeof arrayFiles !== 'undefined'){
          for(let i = 0; i < arrayFiles.length; i++) {
            datosEnviar.append('file'+i, arrayFiles[i]);
            cantArchivos++;
          };
        }else{
          let arrayFiles = "";
        }
        datosEnviar.append('cantAdjuntos', cantArchivos);

        $.ajax({
          data: datosEnviar,
          url: "models/administrar_mantenimieno_preventivo.php",
          method: "post",
          cache: false,
          contentType: false,
          processData: false,     
          success: function(data) {
            if(data==""){
              tablaTareas.ajax.reload(null, false);
              calendar.refetchEvents();

              $('#modalCRUD').modal('hide'); 
          
              swal({
                icon: 'success',
                title: 'Accion realizada correctamente'
              });
            }else{
              swal({
                title: 'Ha ocurrido un error!'
              });
            }
          }
        });
      });

      $("#btnNuevoMantenimientoPreventivo").click(function(){
          accion = "addMantenimientoPreventivo"
          $("#formMantenimientoPreventivo").trigger("reset");
          $(".modal-header").css( "background-color", "#17a2b8");
          $(".modal-header").css( "color", "white" );
          $(".modal-title").text("Nueva tarea de mantenimiento preventivo");
          $('#tablaItems').DataTable().clear().draw();
          $("#tablaItems").dataTable().fnDestroy();
          $("#tablaItems").dataTable({"language":  idiomaEsp});
          $('#modalCRUD').modal('show');
          $selectElementosCliente= document.getElementById("id_elemento_cliente");
          $selectElementosCliente.innerHTML = "";
          $option = document.createElement("option");
          let optionTextA = document.createTextNode("Sin resultados");
          $option.appendChild(optionTextA);
          $selectElementosCliente.appendChild($option);
          
          $selectContactosCliente= document.getElementById("id_contacto_cliente");
          $selectContactosCliente.innerHTML = "";
          $option = document.createElement("option");
          let optionTextB = document.createTextNode("Sin resultados");
          $option.appendChild(optionTextB);
          $selectContactosCliente.appendChild($option);

          //tablaItems.ajax.reload(null, false);
      });

      $(document).on("click", ".btnEditar", function(){
        $(".modal-header").css( "background-color", "#22af47");
        $(".modal-header").css( "color", "white" );
        $(".modal-title").text("Editar tarea de mantenimiento preventivo");
        $("#formMantenimientoPreventivo").trigger("reset");
        $('#modalCRUD').modal('show');
        fila = $(this).closest("tr");
        let id_mantenimiento_preventivo = fila.find('td:eq(0)').text();

        /*let datosUpdate = new FormData();
        datosUpdate.append('accion', 'traerMantenimientoPreventivoUpdate');
        datosUpdate.append('id_mantenimiento_preventivo', id_mantenimiento_preventivo);*/
        $.ajax({
          //data: datosUpdate,
          //url: './models/administrar_mantenimieno_preventivo.php',
          url: './models/administrar_mantenimieno_preventivo.php?accion=traerMantenimientoPreventivo&id_mantenimiento_preventivo='+id_mantenimiento_preventivo,
          method: "post",
          cache: false,
          contentType: false,
          processData: false,
          beforeSed: function(){
            //$('#procesando').modal('show');
          },
          success: function(datosProcesados){
            console.log(datosProcesados);
            let datosInput = JSON.parse(datosProcesados);
            let datos=datosInput[0];
            console.log(datos);

            //$("#fecha_alta").val(datosInput.datos.fecha_alta);
            $("#cliente").val(datos.id_cliente);
            $("#ubicacion").val(datos.id_direccion_cliente);
            $("#id_elemento_cliente").val(datos.id_activo_cliente);
            $("#asunto").val(datos.asunto);
            $("#detalle").val(datos.detalle);
            $("#id_contacto_cliente").val(datos.id_contacto_cliente);
            //$("#id_vehiculo_asignado").val(datos.id_vehiculo_asignado);
            //$("#costo_movilidad_estimado").val(datos.costo_movilidad_estimado);
            $("#fecha_hora_ejecucion_desde").val(datos.fecha_hora_ejecucion_desde);
            $("#fecha_hora_ejecucion_hasta").val(datos.fecha_hora_ejecucion_hasta);

            getUbicacionesCliente(datos.id_cliente,datos.id_direccion_cliente);
            getContactosUbicacion(datos.id_cliente,datos.id_contacto_cliente)
            getElementosUbicacion(datos.id_cliente,datos.id_activo_cliente)
            
            $('#id_mantenimiento_preventivo').html(id_mantenimiento_preventivo);
            
            accion = "updateMantenimientoPreventivo";
          }
        });

        $('#modalCRUD').modal('show');
      });

      $(document).on("click", ".btnBorrar", function(){
        fila = $(this);           
        id_mantenimiento_preventivo = parseInt($(this).closest('tr').find('td:eq(0)').text());       

        swal({
          title: "Estas seguro?",
          text: "Una vez eliminado este vehiculo, no volveras a verlo",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            accion = "eliminarMantenimientoPreventivo";
            $.ajax({
              url: "models/administrar_mantenimieno_preventivo.php",
              type: "POST",
              datatype:"json",    
              data:  {accion:accion, id_mantenimiento_preventivo:id_mantenimiento_preventivo},    
              success: function() {
                tablaTareas.row(fila.parents('tr')).remove().draw();                  
              }
            }); 
          } else {
            swal("El registro no se eliminó!");
          }
        })
      });

    </script>
  </body>
</html>