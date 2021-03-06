<?php
session_start();
include_once('./../conexion.php');
date_default_timezone_set("America/Buenos_Aires");
$hora = date('Hi');
if (!isset($_SESSION['rowUsers']['id_usuario'])) {
    header("location:./models/redireccionar.php");
}?>
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
    <title>MYLA - Presupuestos</title>
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
      a.collapsed .card-header .fa-angle-down {
        transform: rotate(180deg);
      }
      .modal .card-header{
        background-color: #2f3c4e;
      }
      .modal a .card-header h6{
        color: #f6f7fb;
      }

      .modal-dialog{
        overflow-y: initial !important
      }
      .modal-body{
        max-height: 75vh;
        overflow-y: auto;
      }
      .modal-lg, .modal-xl {
        max-width: 1000px;
      }
      #tablaTotales{
        width: 80vw;
      }
      .lblTotales{
        width: 20vw;
      }
      .montoTotales{
        width: 20vw;
      }
      .porcentajeTotales{
        width: 10vw;
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
    <!-- Page Header Ends-->
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
                  <h3>Presupuestos</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home_users.php"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item active">Presupuestos</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <!-- Ajax Generated content for a column start-->
          <!-- <div class="row">
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
          </div> -->

          <div class="row">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-header">
                  <h5>Grilla de presupuestos</h5>
                  <!-- <button id="btnNuevoPresupuesto" type="button" class="btn btn-primary mt-2" data-toggle="modal"><i class="fa fa-check-square-o"></i> Nuevo presupuesto</button> -->
                </div><?php
                //var_dump($_SESSION["rowUsers"]["id_empresa"]);?>
                <div class="card-body">
                  <div class="table-responsive" id="contTablaListas" >
                    <table class="table table-hover" id="tablaPresupuestos">
                      <thead class="text-center">
                        <tr>
                          <th class="text-center">#ID</th>
                          <th>Cliente</th>
                          <th>Direccion</th>
                          <th>Contacto</th>
                          <th>Total</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tfoot class="text-center">
                        <tr>
                          <th class="text-center">#ID</th>
                          <th>Cliente</th>
                          <th>Direccion</th>
                          <th>Contacto</th>
                          <th>Total</th>
                          <th>Acciones</th>
                        </tr>
                      </tfoot>
                      <tbody></tbody>
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

    <!--Modal para CRUD-->
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <span id="id_presupuesto" class="d-none"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formPresupuesto" >
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
                        <!-- <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Elemento</label>
                            <select class="form-control" id="id_elemento_cliente" required>
                              <option value="">Seleccione</option>
                            </select>
                          </div>
                        </div> -->
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
                            <label for="" class="col-form-label">*Descripcion:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Prioridad:</label>
                            <select class="form-control" id="prioridad">
                              <option value="">Seleccione</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <button id="btnAddAdjuntos" class="btn btn-secondary"> Agregar adjuntos</button>
                        <div class="col-lg-12 d-none" id="masAdjuntos">
                          <div id="dropMasArchivos"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Accordion card -->
                <!-- Accordion card -->
                <div class="card border-secondary">
                  <!-- Card header -->
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree4" aria-expanded="false" aria-controls="collapseThree4">
                    <div class="card-header" role="tab" id="headingThree4">
                      <h6 class="mb-0">Datos del presupuesto <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                    </div>
                  </a>
                  <!-- Card body -->
                  <div id="collapseThree4" class="collapse" role="tabpanel" aria-labelledby="headingThree4" data-parent="#accordionEx">
                    <div class="card-body border-secondary">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Fecha:</label>
                            <input type="date" class="form-control" id="fecha" value="<?=date("Y-m-d")?>" required>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*N??mero:</label>
                            <input type="text" class="form-control" id="numero" value="" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Caducidad:</label>
                            <input type="date" class="form-control" id="caducidad" value="" required>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Tipo:</label>
                            <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input" name="tipo" id="tipo_urgente" value="Urgente" required> 
                              <label class="custom-control-label" for="tipo_urgente">Urgente</label>
                            </div>
                            <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input" name="tipo" id="tipo_cotizar" value="Cotizar" required>
                              <label class="custom-control-label" for="tipo_cotizar">Cotizar</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="" class="col-form-label">*Comentarios:</label>
                            <textarea name="comentarios" id="comentarios" class="form-control"></textarea>
                          </div>
                        </div>
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

    <!--Modal para cotizar-->
    <div class="modal fade" id="modalCotizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelCotizar" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabelCotizar"></h5>
            <span id="id_presupuesto_cotizar" class="d-none"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formCotizar" >
            <div class="modal-body">
              <!--Accordion wrapper-->
              <div class="accordion md-accordion" id="accordionCotizar" role="tablist" aria-multiselectable="true">
                <!-- Accordion card -->
                <div class="card border-secondary">
                  <!-- Card header -->
                  <a data-toggle="collapse" data-parent="#accordionCotizar" href="#collapseOne1Cotizar" aria-expanded="true" aria-controls="collapseOne1Cotizar">
                    <div class="card-header" role="tab" id="headingOne1Cotizar">
                      <h6 class="mb-0">Datos del presupuesto <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                    </div>
                  </a>
                  <!-- Card body -->
                  <div id="collapseOne1Cotizar" class="collapse show" role="tabpanel" aria-labelledby="headingOne1Cotizar" data-parent="#accordionCotizar">
                    <div class="card-body border-secondary">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label font-weight-bold">Cliente: </label><span id="lblCliente"></span>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label font-weight-bold">Ubicacion: </label><span id="lblUbicacion"></span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label font-weight-bold">Contacto: </label><span id="lblContacto"></span>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label font-weight-bold">Prioridad: </label><span id="lblPrioridad"></span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="" class="col-form-label font-weight-bold">Descripcion: </label><span id="lblDescripcion"></span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label font-weight-bold">Fecha: </label><span id="lblFecha"></span>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label font-weight-bold">N??mero: </label><span id="lblNumero"></span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label font-weight-bold">Caducidad: </label><span id="lblCaducidad"></span>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label font-weight-bold">Tipo: </label><span id="lblTipo"></span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="" class="col-form-label font-weight-bold">Comentarios: </label><span id="lblComentarios"></span>
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
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordionCotizar" href="#collapseTwo2Cotizar" aria-expanded="false" aria-controls="collapseTwo2Cotizar">
                    <div class="card-header" role="tab" id="headingTwo2Cotizar">
                      <h6 class="mb-0">Materiales <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                    </div>
                  </a>
                  <!-- Card body -->
                  <div id="collapseTwo2Cotizar" class="collapse" role="tabpanel" aria-labelledby="headingTwo2Cotizar" data-parent="#accordionCotizar">
                    <div class="card-body border-secondary">
                      <!-- <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="" class="col-form-label">ingrese 3 letras para buscar:</label>
                            <input type="text" name="" class="form-control" id="item_buscar">
                            <div style="background-color:#EBF5FB; border-radius: 0 0 5px 5px;" id="resultadoSearch"></div>
                          </div>
                        </div>
                        <div class="d-none col-lg-5" id="contAgregarProdItem">
                          <div class="row">
                            <div class="col-lg-6">
                              <input type="hidden" id="id_item_agragar">
                              <label for="" class="col-form-label">Cantidad:</label>
                              <input type="number" name="" id="cantidad" class="form-control">
                            </div>
                            <div class="col-lg-6 align-self-end mt-2 mt-lg-0">
                              <button class='btn btn-success btnAgregarProdItem'><i class='fa fa-plus-circle'></i></button>
                            </div>
                          </div>
                        </div>
                      </div> -->
                      <div class="table-responsive" id="contTablaOrden" style="">
                        <table class="table table-hover" id="tablaItems">
                          <thead class="text-center">
                            <tr>
                              <th>Item</th>
                              <th>Imagen</th>
                              <th>UM</th>
                              <th>Proveedor</th>
                              <th>Tipo</th>
                              <th>Categor??a</th>
                              <th>Precio unit.</th>
                              <th>Cantidad</th>
                              <th>Subtotal</th>
                            </tr>
                          </thead>
                          <tfoot class="text-center">
                            <tr>
                              <th>Item</th>
                              <th>Imagen</th>
                              <th>UM</th>
                              <th>Proveedor</th>
                              <th>Tipo</th>
                              <th>Categor??a</th>
                              <th>Precio unit.</th>
                              <th>Cantidad</th>
                              <th>Subtotal</th>
                            </tr>
                          </tfoot>
                          <tbody></tbody>
                        </table>
                      </div>
                      <div class="row">
                        <div class="col-12 mt-3">
                          <span class="float-right">
                            <label class="font-weight-bold h4">Total:</label>
                            <span class="subtotalMaterialesFormateado h4">$ 0,00</span>
                            <span class="subtotalMateriales d-none"></span>
                          </span>
                        </div>
                      </div>
                      <!-- <div class="row">
                        <div class="col-12 mt-3">
                          <label class="font-weight-bold h4">Total:</label>
                          <span class="totalFormateado h4 float-right">$ 0,00</span>
                          <span class="total d-none"></span>
                        </div>
                      </div> -->
                      <div id="contAddItem" class="d-none border p-3 rounded border-dark">
                        <h5 class="d-block text-center font-weight-bold">Agregar Item</h5>
                        <form id="formAddItem">
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label for="" class="col-form-label">Descripci??n:</label>
                                <input type="text" class="form-control" id="descripcion_producto" required>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label for="" class="col-form-label">Categoria:</label>
                                <select class="form-control" id="categoria" required>
                                  <option value="">Seleccione</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label for="" class="col-form-label">Unidad de medida:</label>
                                <select class="form-control" id="Umedida" required>
                                  <option value="">Seleccione</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row"> 
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label for="" class="col-form-label">Tipo</label>
                                <select class="form-control" id="tipo" required>
                                  <option value="">Seleccione</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label for="" class="col-form-label">Punto de reposici??n:</label>
                                <input type="number" class="form-control" id="preposicion" required>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label for="" class="col-form-label">Precio</label>
                                <input type="number" class="form-control" id="precioNewItem">
                              </div>
                            </div>
                            <!--<div class="col-lg-4">
                              <div class="form-group">
                                <label for="" class="col-form-label">Centro de costos</label>
                                <select class="form-control" id="cCostos" required>
                                  <option value="">Seleccione</option>
                                </select>
                              </div>
                            </div>-->
                          </div>
                          <div class="row">
                            <div class="col-lg-4">    
                              <div class="form-group">
                                <label for="" class="col-form-label">Estado</label>
                                <select class="form-control" id="estado" required>
                                  <option value="">Seleccione</option>
                                  <option value="Activo">Activo</option>
                                  <option value="Inactivo">Inactivo</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-lg-8">
                              <div class="form-group">
                                <label for="" class="col-form-label">Link video:</label>
                                <input type="url" class="form-control" id="linkVideo">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-8">
                              <div class="form-group">
                                <label for="" class="col-form-label">Imagen:</label>
                                <input class="form-control" type="file" id="imagen" accept="image/*">
                              </div>
                            </div>
                          </div>
                          <button type="button" class="btn btn-light bntCancelAddItem">Cancelar</button>
                          <button type="submit" id="" class="btn btn-dark">Guardar</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Accordion card -->
                <!-- Accordion card -->
                <div class="card border-secondary">
                  <!-- Card header -->
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordionCotizar" href="#collapseThree3Cotizar" aria-expanded="false" aria-controls="collapseThree3Cotizar">
                    <div class="card-header" role="tab" id="headingThree3Cotizar">
                      <h6 class="mb-0">Cargos <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                    </div>
                  </a>
                  <!-- Card body -->
                  <div id="collapseThree3Cotizar" class="collapse" role="tabpanel" aria-labelledby="headingThree3Cotizar" data-parent="#accordionCotizar">
                    <div class="card-body border-secondary">
                      <div class="table-responsive tablaCargos">
                        <table class="table table-hover" id="tablaCargos">
                          <thead class="text-center">
                            <tr>
                              <th>#ID</th>
                              <th>Cargo</th>
                              <th>$/hs</th>
                              <th>Jornadas</th>
                              <th>Hs/Jornada</th>
                              <th>Subtotal</th>
                            </tr>
                          </thead>
                          <tfoot class="text-center">
                            <tr>
                              <th>#ID</th>
                              <th>Cargo</th>
                              <th>$/hs</th>
                              <th>Jornadas</th>
                              <th>Hs/Jornada</th>
                              <th>Subtotal</th>
                            </tr>
                          </tfoot>
                          <tbody></tbody>
                        </table>
                      </div>
                      <div class="row">
                        <div class="col-12 mt-3">
                          <span class="float-right">
                            <label class="font-weight-bold h4">Total:</label>
                            <span class="subtotalCargosFormateado h4">$ 0,00</span>
                            <span class="subtotalCargos d-none"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Accordion card -->
                <!-- Accordion card -->
                <div class="card border-secondary">
                  <!-- Card header -->
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordionCotizar" href="#collapseFour4Cotizar" aria-expanded="false" aria-controls="collapseFour4Cotizar">
                    <div class="card-header" role="tab" id="headingFour4Cotizar">
                      <h6 class="mb-0">Totales <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                    </div>
                  </a>
                  <!-- Card body -->
                  <div id="collapseFour4Cotizar" class="collapse" role="tabpanel" aria-labelledby="headingFour4Cotizar" data-parent="#accordionCotizar">
                    <div class="card-body border-secondary">
                      <!-- <table id="tablaTotales">
                        <tr>
                          <td class="lblTotales"><label class="font-weight-bold">Total materiales y cargos:</label></td>
                          <td class="montoTotales">
                            <span class="subtotalCargosFormateado">$ 0,00</span>
                            <span class="subtotalCargos d-none"></span>
                          </td>
                          <td class="porcentajeTotales"></td>
                        </tr>
                        <tr>
                          <td class="lblTotales"><label class="font-weight-bold">Gastos generales:</label></td>
                          <td class="montoTotales">
                            <span class="subtotalGastosGeneralesFormateado">$ 0,00</span>
                            <span class="subtotalGastosGenerales d-none"></span>
                          </td>
                          <td class="porcentajeTotales">
                            <div class="input-group">
                              <input type="number" class="form-control" id="porcentaje_gastos_generales">
                              <div class="input-group-append">
                                <span class="input-group-text">%</span>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="lblTotales"><label class="font-weight-bold">Movilidad:</label></td>
                          <td class="montoTotales">
                            <span class="subtotalMovilidadFormateado">$ 0,00</span>
                            <span class="subtotalMovilidad d-none"></span>
                          </td>
                          <td class="porcentajeTotales">
                            <div class="input-group">
                              <input type="number" class="form-control" id="porcentaje_movilidad">
                              <div class="input-group-append">
                                <span class="input-group-text">%</span>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="lblTotales"><label class="font-weight-bold">Rentabilidad:</label></td>
                          <td class="montoTotales">
                            <span class="subtotalRentabilidadFormateado">$ 0,00</span>
                            <span class="subtotalRentabilidad d-none"></span>
                          </td>
                          <td class="porcentajeTotales">
                            <div class="input-group">
                              <input type="number" class="form-control" id="porcentaje_rentabilidad">
                              <div class="input-group-append">
                                <span class="input-group-text">%</span>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </table> -->
                      <div class="row">
                        <div class="col-4 mt-3 d-flex align-items-center">
                          <label class="font-weight-bold w-100 text-right">Total materiales y cargos:</label>
                        </div>
                        <div class="col-3 mt-3 align-self-center">
                          <span class="subtotalCargosFormateado pull-right">$ 0,00</span>
                          <span class="subtotalCargos d-none"></span>
                        </div>
                        <div class="col-2 mt-3"></div>
                      </div>
                      <div class="row">
                        <div class="col-4 mt-3 d-flex align-items-center">
                          <label class="font-weight-bold w-100 text-right">Gastos generales:</label>
                        </div>
                        <div class="col-3 mt-3 align-self-center">
                          <span class="subtotalGastosGeneralesFormateado pull-right">$ 0,00</span>
                          <span class="subtotalGastosGenerales d-none"></span>
                        </div>
                        <div class="col-2 mt-3">
                          <div class="input-group">
                            <input type="number" class="form-control" id="porcentaje_gastos_generales">
                            <div class="input-group-append">
                              <span class="input-group-text">%</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-4 mt-3 d-flex align-items-center">
                          <label class="font-weight-bold w-100 text-right">Movilidad:</label>
                        </div>
                        <div class="col-3 mt-3 align-self-center">
                          <span class="subtotalMovilidadFormateado pull-right">$ 0,00</span>
                          <span class="subtotalMovilidad d-none"></span>
                        </div>
                        <div class="col-2 mt-3">
                          <div class="input-group">
                            <input type="number" class="form-control" id="porcentaje_movilidad">
                            <div class="input-group-append">
                              <span class="input-group-text">%</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-4 mt-3 d-flex align-items-center">
                          <label class="font-weight-bold w-100 text-right">Rentabilidad:</label>
                        </div>
                        <div class="col-3 mt-3 align-self-center">
                          <span class="subtotalRentabilidadFormateado pull-right">$ 0,00</span>
                          <span class="subtotalRentabilidad d-none"></span>
                        </div>
                        <div class="col-2 mt-3">
                          <div class="input-group">
                            <input type="number" class="form-control" id="porcentaje_rentabilidad">
                            <div class="input-group-append">
                              <span class="input-group-text">%</span>
                            </div>
                          </div>
                        </div>
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
    <!-- FINAL MODAL cotizar-->

    <!--Modal para Ver Detalle-->
    <div class="modal fade" id="modalVerDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDetalle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelDetalle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!--Accordion wrapper-->
            <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
              <!-- Accordion card -->
              <div class="card border-secondary">
                <!-- Card header -->
                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1Detalle" aria-expanded="true" aria-controls="collapseOne1Detalle">
                  <div class="card-header" role="tab" id="headingOne1Detalle">
                    <h6 class="mb-0">Datos principales <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                  </div>
                </a>
                <!-- Card body -->
                <div id="collapseOne1Detalle" class="collapse show" role="tabpanel" aria-labelledby="headingOne1Detalle" data-parent="#accordionEx">
                  <div class="card-body border-secondary">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="" class="col-form-label">Cliente: <span id="lblCliente"></span></label>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="" class="col-form-label">Ubicacion: <span id="lblUbicacion"></span></label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="" class="col-form-label">Contacto: <span id="lblContacto"></span></label>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="" class="col-form-label">Elemento: <span id="lblElemento"></span></label>
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
                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2Detalle" aria-expanded="false" aria-controls="collapseTwo2Detalle">
                  <div class="card-header" role="tab" id="headingTwo2Detalle">
                    <h6 class="mb-0">Datos de la tarea <i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                  </div>
                </a>
                <!-- Card body -->
                <div id="collapseTwo2Detalle" class="collapse" role="tabpanel" aria-labelledby="headingTwo2Detalle" data-parent="#accordionEx">
                  <div class="card-body border-secondary">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="" class="col-form-label">Asunto: <span id="lblAsunto"></span></label>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="" class="col-form-label">Detalle: <span id="lblDetalle"></span></label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="" class="col-form-label">Prioridad: <span id="lblPrioridad"></span></label>
                        </div>
                      </div>
                    </div>
                    <div class="table-responsive tablaAdjuntos">
                      <table class="table table-hover" id="tablaAdjuntosDetalle">
                        <thead class="text-center">
                          <tr>
                            <th>#ID</th>
                            <th>Archivo</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Accordion card -->
              
              <!-- Accordion card -->
              <div class="card border-secondary">
                <!-- Card header -->
                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree4Detalle" aria-expanded="false" aria-controls="collapseThree4Detalle">
                  <div class="card-header" role="tab" id="headingThree4Detalle">
                    <h6 class="mb-0">Fecha y hora de ejecucion<i class="fa fa-angle-down rotate-icon float-right"></i></h6>
                  </div>
                </a>
                <!-- Card body -->
                <div id="collapseThree4Detalle" class="collapse" role="tabpanel" aria-labelledby="headingThree4Detalle" data-parent="#accordionEx">
                  <div class="card-body border-secondary">
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="" class="col-form-label">Fecha: <span id="lblFecha"></span></label>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="" class="col-form-label">Hora desde: <span id="lblHoraDesde"></span></label>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="" class="col-form-label">Hora Hasta: <span id="lblHoraHasta"></span></label>
                        </div>
                      </div>
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
          </div>
        </div>
      </div>
    </div>
    <!-- FINAL MODAL Ver Detalle-->

    <!--Modal con opciones para tareas de mantenimiento-->
    <div class="modal fade" id="modalOpcionesEliminarTareas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">??Qu?? tareas desea eliminar?</h5>
            <span id="id_tarea_mantenimiento_borrar" class="d-none"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <button type="button" data-dismiss="modal" class="btn btn-dark" id="btnBorrarSeleccionado"><i class="fa fa-check"></i> Eliminar solo esta</button>
            <button type="button" data-dismiss="modal" class="btn btn-danger" id="btnBorrarPendientes"><i class="fa fa-trash-o"></i> Esta y sus repeticiones pendientes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- FINAL MODAL con opciones para tareas de mantenimiento-->

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
    <!-- <script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script> -->
    <script src="assets/js/chart/chartjs/chart.min.js"></script>
    <script src="assets/js/sweet-alert/sweetalert.min.js"></script>
    <script src="assets/js/chat-menu.js"></script>
    <script src="assets/js/tooltip-init.js"></script>

    <script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/jszip.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/pdfmake.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/vfs_fonts.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.autoFill.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.select.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/buttons.html5.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/buttons.print.min.js"></script>
    <!-- <script src="assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js"></script> -->
    <script src="assets/js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.colReorder.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.scroller.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/custom.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>

    <script src="assets/js/fullCalendar/main.min.js"></script>
    <script src="assets/js/fullCalendar/locales/es.js"></script>
    <!--<script src="assets/js/theme-customizer/customizer.js"></script>-->
    <!-- Plugin used-->
    <script type="text/javascript">
      var accion = "";
      var tablaItems=$('#tablaItems');
      var tablaCargos=$('#tablaCargos');

      $(document).ready(function(){
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
                            "add": "Agregar condici??n",
                            "button": {
                                "0": "Constructor de b??squeda",
                                "_": "Constructor de b??squeda (%d)"
                            },
                            "clearAll": "Quitar todo",
                            "condition": "Condici??n",
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
                                "0": "Constructor de b??squeda",
                                "_": "Constructor de b??squeda (%d)"
                            },
                            "value": "Valor"
                        },
                        "searchPlaceholder": "Ingrese caracteres de busqueda",
                        "thousands": ".",
                        "zeroRecords": "No se encontraron registros que coincidan con la b??squeda",
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
                                    "_": "Est?? seguro que desea borrar %d filas?",
                                    "1": "Est?? seguro que desea borrar 1 fila?"
                                }
                            },
                            "multi": {
                                "title": "M??ltiples valores",
                                "info": "La selecci??n contiene diferentes valores para esta entrada. Para editarla y establecer todos los items al mismo valor, clickear o tocar aqu??, de otra manera conservar??n sus valores individuales.",
                                "restore": "Deshacer cambios",
                                "noMulti": "Esta entrada se puede editar individualmente, pero no como parte de un grupo."
                            }
                        }
                    }


        //debugger;
        tablaPresupuestos=$('#tablaPresupuestos').DataTable({
          "ajax": {
              "url" : "./models/administrar_presupuestos.php?accion=traerPresupuestos",
              "dataSrc": "",
            },
          "stateSave": true,
          "columns":[
            {"data": "id_presupuesto"},
            {"data": "cliente"},
            {"data": "direccion"},
            {"data": "contacto_cliente"},
            {"data": "total_mostrar"},
            //{"data": "vehiculo"},
            // {"data": "costo_movilidad_estimado_mostrar"},
            {
              render: function(data, type, full, meta) {
                return ()=>{
                  //si la orden esta finalizada no se puede editar
                  
                  let btnEditar="<button class='btn btn-success btnEditar'><i class='fa fa-edit'></i></button>";
                  //let btnVer="<button class='btn btn-warning btnVer'><i class='fa fa-eye'></i></button>";
                  let btnVer="";
                  let btnBorrar="<button class='btn btn-danger btnBorrar'><i class='fa fa-trash-o'></i></button>";
                  let btnOrdenTrabajo="<button class='btn btn-primary btnOrdenTrabajo'><i class='fa fa-briefcase'></i></button>";

                  if(full.id_estado==3){
                    btnBorrar=btnEditar="";
                  }
                  let buttons=btnOrdenTrabajo+btnEditar+btnVer+btnBorrar;
                  return `
                  <div class='text-center'>
                    <div class='btn-group'>${buttons}</div>
                  </div>`;
                };
              }
            },
          ],
          "language":  idiomaEsp,
          dom: '<"mr-2 d-inline"l>Bfrtip',
          buttons: [
            {
              extend:    'excelHtml5',
              text:      '<i class="fa fa-file-excel-o"></i>',
              titleAttr: 'Excel',
              title:     "Presupuestos",
              className: 'btn-success',
              exportOptions: {
                columns: ':not(:last-child)',
                /*format: {
                  body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    return column === 7 ? data.replace( /[$.]/g, '' ).replace( /[,]/g, '.' ) : data;
                  }
                }*/
              }
            },
            {
              extend:    'pdfHtml5',
              text:      '<i class="fa fa-file-pdf-o"></i>',
              title:     "Presupuestos",
              titleAttr: 'PDF',
              download: 'open',
              className: 'btn-danger',
              exportOptions: {
                columns: ':not(:last-child)',
              }
            }
          ],
          initComplete: function(){
            var b=1;
            var c=0;
            this.api().columns.adjust().draw();//Columns sin parentesis
            this.api().columns().every(function(){//Columns() con parentesis
              if(b!=1 && b!=6){
                var column=this;
                var name=$(column.footer()).text();
                var select=$("<select id='filtro"+name+"' class='form-control form-control-sm filtrosTrato'><option value=''>Todos</option></select>")
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

        $('#modalCRUD').on('hidden.bs.modal', function (e) {
          document.getElementById('dropMasArchivos').innerHTML="";
          document.getElementById('masAdjuntos').classList.toggle("d-none");
        });
      });

      function cargarDatosComponentes(){
        let datosIniciales = new FormData();
        datosIniciales.append('accion', 'traerDatosInicialesPresupuestos');
        $.ajax({
          data: datosIniciales,
          url: "./models/administrar_presupuestos.php",
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

            //Identifico el select de vehiculos
            $selectPrioridades= document.getElementById("prioridad");
            //Genero los options del select de vehiculos
            respuestaJson.prioridades.forEach((prioridad)=>{
                $option = document.createElement("option");
                let optionText = document.createTextNode(prioridad.prioridad);
                $option.appendChild(optionText);
                $option.setAttribute("value", prioridad.id_prioridad);
                $selectPrioridades.appendChild($option);
            });

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

      $(document).on("click", "#btnNuevoAdjunto", function(){
        $("#inputFile").removeClass("d-none");
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
            //console.log(respuesta);
            /*Convierto en json la respuesta del servidor*/
            respuestaJson = JSON.parse(respuesta);
            //console.log(respuestaJson);
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
            //console.log(respuesta);
            /*Convierto en json la respuesta del servidor*/
            respuestaJson = JSON.parse(respuesta);
            //console.log(respuestaJson);
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

      $('#formPresupuesto').submit(function(e){
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la p??gina   
        
        swal({
                icon: 'success',
                title: 'Accion realizada correctamente'
              });
        /*let datosEnviar = new FormData();
        datosEnviar.append("id_elemento_cliente", $.trim($('#id_elemento_cliente').val()));
        //datosEnviar.append("fecha_alta", $.trim($('#fecha_alta').val()));
        datosEnviar.append("asunto", $.trim($('#asunto').val()));
        datosEnviar.append("detalle", $.trim($('#detalle').val()));
        datosEnviar.append("id_contacto_cliente", $.trim($('#id_contacto_cliente').val()));
        datosEnviar.append("id_almacen", $.trim($('#id_almacen').val()));
        //datosEnviar.append("costo_movilidad_estimado", $.trim($('#costo_movilidad_estimado').val()));
        datosEnviar.append("fecha", $.trim($('#fecha').val()));
        datosEnviar.append("hora_desde", $.trim($('#hora_desde').val()));
        datosEnviar.append("hora_hasta", $.trim($('#hora_hasta').val()));

        datosEnviar.append("prioridad", $.trim($('#prioridad').val()));

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
        
        datosEnviar.append("id_presupuesto", $.trim($('#id_presupuesto').html()));
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
          url: "models/administrar_presupuestos.php",
          method: "post",
          cache: false,
          contentType: false,
          processData: false,     
          success: function(data) {
            if(data==""){
              tablaPresupuestos.ajax.reload(null, false);
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
        });*/
      });

      $("#btnNuevoPresupuesto").click(function(){
        accion = "addPresupuesto"
        $("#formPresupuesto").trigger("reset");
        $(".modal-header").css( "background-color", "#17a2b8");
        $(".modal-header").css( "color", "white" );
        $(".modal-title").text("Nuevo presupuesto");
        $('#modalCRUD').modal('show');
        
        $selectContactosCliente= document.getElementById("id_contacto_cliente");
        $selectContactosCliente.innerHTML = "";
        $option = document.createElement("option");
        let optionTextB = document.createTextNode("Sin resultados");
        $option.appendChild(optionTextB);
        $selectContactosCliente.appendChild($option);

      });

      $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        let id_presupuesto = fila.find('td:eq(0)').text();

        $(".modal-header").css( "background-color", "#22af47");
        $(".modal-header").css( "color", "white" );
        $(".modal-title").text("Editar presupuesto ID "+id_presupuesto);
        $("#formCotizar").trigger("reset");
        $('#modalCRUD').modal('show');

        let datosUpdate = new FormData();
        datosUpdate.append('accion', 'traerPresupuestos');
        datosUpdate.append('id_presupuesto', id_presupuesto);
        $.ajax({
          data: datosUpdate,
          url: './models/administrar_presupuestos.php',
          //url: './models/administrar_presupuestos.php?accion=traerPresupuestos&id_presupuesto='+id_presupuesto,
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
            console.log(datosInput);
            //let dmp=datosInput.datos_mantenimiento_preventivo;
            //console.log(dmp);

            $("#cliente").val(datosInput.id_cliente);
            //$("#ubicacion").val(datosInput.id_direccion_cliente);
            getUbicacionesCliente(datosInput.id_cliente,datosInput.id_direccion_cliente);
            getContactosUbicacion(datosInput.id_cliente,datosInput.id_contacto_cliente);

            $("#descripcion").val(datosInput.descripcion);
            $("#detalle").val(datosInput.detalle);
            //$("#id_contacto_cliente").val(datosInput.id_contacto_cliente);
            
            console.log($("input[type='radio']"));
            console.log($("input[type='radio'][value='"+datosInput.tipo+"']"));
            $("input[type='radio'][value='"+datosInput.tipo+"']").attr("checked",true);
            $("#fecha").val(datosInput.fecha);
            $("#numero").val(datosInput.numero);
            $("#caducidad").val(datosInput.caducidad);
            $("#comentarios").val(datosInput.comentarios)
            
            $('#id_presupuesto').html(id_presupuesto);
            
            accion = "updateMantenimientoPreventivo";
          }
        });

      });

      $(document).on("click", ".btnCotizar", function(){
        fila = $(this).closest("tr");
        let id_presupuesto = fila.find('td:eq(0)').text();

        /*$(".modal-header").css( "background-color", "#22af47");
        $(".modal-header").css( "color", "white" );*/
        $(".modal-title").text("Cotizar presupuesto ID "+id_presupuesto);
        $("#formPresupuesto").trigger("reset");
        $('#modalCotizar').modal('show');
        /*document.getElementById("item_buscar").value="";
        document.getElementById("id_item_agragar").value="";
        document.getElementById("cantidad").value = "";
        document.getElementById("contAgregarProdItem").classList.add("d-none")

        document.getElementById("contAddItem").classList.add("d-none");
        document.getElementById("contTablaOrden").classList.remove("d-none");
        document.getElementById("resultadoSearch").innerHTML="";
        document.getElementById("item_buscar").focus();*/

        getItems();//tablaItems.ajax.reload(null, false);//getItems();
        getCargos();

        let datosUpdate = new FormData();
        datosUpdate.append('accion', 'traerPresupuestos');
        datosUpdate.append('id_presupuesto', id_presupuesto);
        $.ajax({
          data: datosUpdate,
          url: './models/administrar_presupuestos.php',
          //url: './models/administrar_presupuestos.php?accion=traerPresupuestos&id_presupuesto='+id_presupuesto,
          method: "post",
          cache: false,
          contentType: false,
          processData: false,
          beforeSed: function(){
            //$('#procesando').modal('show');
          },
          success: function(datosProcesados){
            //console.log(datosProcesados);
            let datosInput = JSON.parse(datosProcesados);
            console.log(datosInput);
            //let dmp=datosInput.datos_mantenimiento_preventivo;
            //console.log(dmp);

            $("#lblCliente").html(datosInput.cliente);
            $("#lblUbicacion").html(datosInput.direccion);
            $("#lblContacto").html(datosInput.contacto_cliente);
            $("#lblPrioridad").html(datosInput.prioridad);
            $("#lblDescripcion").html(datosInput.descripcion);
            $("#lblFecha").html(datosInput.fecha_mostrar);
            $("#lblNumero").html(datosInput.numero);
            $("#lblCaducidad").html(datosInput.caducidad_mostrar);
            $("#lblTipo").html(datosInput.tipo);
            $("#lblComentarios").html(datosInput.comentarios);
            
            $('#id_presupuesto').html(id_presupuesto);
            
            accion = "updateMantenimientoPreventivo";
          }
        });

      });

      function getItems(aItems){
        //console.log(tablaItems);
        tablaItems.dataTable().fnDestroy();
        tablaItems.DataTable({
          "ajax": {
              "url" : "./models/administrar_stock.php?accion=traerItems",
              "dataSrc": "",
            },
          "columns":[
            //{"data": "id_item"},
            {"data": "item"},
            {
              render: function(data, type, full, meta) {
                return ()=>{
                  let $img = " ";
                  if (full.imagen !=""){
                    $img=`<img src="./views/img_items/${full.imagen}" class="img-thumbnail">`;
                  }
                  return $img;
                };
              }
            },
            {"data": "unidad_medida"},
            {"data": "proveedor"},
            {"data": "tipo"},
            {"data": "categoria"},
            {"data": "precio_unitario"},
            {
              render: function(data, type, full, meta) {
                return ()=>{
                  let cantidad="";
                  if(aItems!=undefined){
                    aItems.forEach((items)=>{
                      if(full.id_item==items.id_item && full.id_proveedor==items.id_proveedor){
                        cantidad=items.cantidad;
                      }
                    })
                  }
                  return `
                  <input type='hidden' id='proveedor-item-${full.id_item}' value='${full.id_proveedor}'>
                  <input type='number' class='form-control items' id='item-${full.id_item}' value='${cantidad}' data-precio-unitario='${full.precio_unitario_sin_formato}' placeholder='Cantidad'>`;
                };
              }
            },
            {
              render: function(data, type, full, meta) {
                return ()=>{
                  return `<label id='subtotal-item-${full.id_item}'`;
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
              if(b<7 && b!=2){
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
      }

      function getCargos(aCargos){
        console.log(tablaCargos);
        tablaCargos.dataTable().fnDestroy();
        tablaCargos.DataTable({
          "ajax": {
              "url" : "./models/administrar_cargos.php?accion=traerCargos",
              "dataSrc": "",
            },
          "columns":[
            {"data": "id_cargo"},
            {"data": "cargo"},
            {"defaultContent": "<input type='text' class='form-control valor_hora'>"},
            {"defaultContent": "<input type='text' class='form-control cant_jornadas'>"},
            {"defaultContent": "<input type='text' class='form-control horas_jornada'>"},
            {"defaultContent": "<label class='subtotal_cargos'></label>"},
          ],
          "language":  idiomaEsp,
          initComplete: function(){
            var b=1;
            var c=0;
            this.api().columns.adjust().draw();//Columns sin parentesis
            this.api().columns().every(function(){//Columns() con parentesis
              if(b==2){
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
      }

      /*$(document).on("keyup", "#item_buscar", function(){
        let palabraABuscar = $(this).val();
        let $divResultadoSearch = document.getElementById("resultadoSearch");
        let $id_item_agragar = document.getElementById("id_item_agragar");
        let contador = 0;

        if(palabraABuscar.length > 2){
          $id_item_agragar.value = "";
          $divResultadoSearch.innerHTML="";
          for(let[key, value] of itemsXProveedor){

            //console.log(value.item.toLowerCase().indexOf(palabraABuscar.toLowerCase()))

            if (value.item.toLowerCase().indexOf(palabraABuscar.toLowerCase())!=-1){
              let precio = new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(value.precio);
              let $span = `<a href="" class="selItem" id="${key}">
                            <span class="d-block p-1">
                              ${value.item}  ${precio}
                            </span>
                          </a>`
              $divResultadoSearch.innerHTML+=$span;
              contador++;
            }
          }

          if(contador == 0 && document.getElementById("proveedor").value !=0){
            let $spanNone = `<span class="d-block p-2 text-center">
                          No se encontraron resultados.<br>
                          <button class="btn btn-success btnAgregarNuevoProducto" data-original-title="" title="">Agregar</button>
                    </span>`
            $divResultadoSearch.innerHTML+=$spanNone;
          }

          if(contador == 0 && document.getElementById("proveedor").value ==0){
            let $spanNone = `<span class="d-block p-2 text-center">
                          Seleccione proveedor.<br>
                    </span>`
            $divResultadoSearch.innerHTML+=$spanNone;
          }

        }else{
          $divResultadoSearch.innerHTML="";
        }
      })

      $(document).on("click", ".selItem", function(){
        event.preventDefault();

        let id_producto = $(this).attr("id");
        let $item_buscar = document.getElementById("item_buscar");
        let $resultadoSearch = document.getElementById("resultadoSearch");
        let $contAgregarProdItem = document.getElementById("contAgregarProdItem");
        let $id_item_agragar = document.getElementById("id_item_agragar");
        let $cantidadEnviar = document.getElementById("cantidad");

        $item_buscar.value=itemsXProveedor.get(id_producto).item;
        $resultadoSearch.innerHTML="";
        $id_item_agragar.value=id_producto;
        $contAgregarProdItem.classList.remove("d-none");
        document.getElementById("contTablaOrden").classList.remove("d-none");
        $cantidadEnviar.focus();
      });


      $(document).on("click", ".btnAgregarProdItem", function(){
        let id_empresa = parseInt(document.getElementById("id_empresa").innerText);
        let id_proveedor = $('#proveedor').val();
        let cCostos = $('#cCostos').val();
        let id_almacen = $('#almacen').val();
        let id_item_agragar = document.getElementById("id_item_agragar").value;
        let cantidad_agregar = document.getElementById("cantidad").value;

        let totalEnviar = parseFloat($('.total').text());
        let id_orden= parseInt($(".id_ordenEditar").text());
        let comentarios = $("#comentarios").val();

        if (id_almacen == 0 || id_proveedor ==0 || id_item_agragar =="" || cCostos ==0) {
          swal({
            icon: 'error',
            title: 'Debe seleccionar proveedor, almacen, centro de costos e items'
          });
        }else{
          const itemsOrdenArray = [];

          let precio = parseFloat(itemsXProveedor.get(id_item_agragar).precio);
          itemsOrdenArray.push({
            id: id_item_agragar,
            valor: cantidad_agregar,
            precio
          })

          items = JSON.stringify(itemsOrdenArray);

          if (!isNaN(cantidad_agregar)) {
            let precioTotal = precio * cantidad_agregar;
            let monto = parseFloat($('.total').text()) +precioTotal
            let montoFormateado= new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(monto);
            $('.totalFormateado').text(montoFormateado);
            $('.total').text(monto)
            montoTotalOC.set(parseInt(id_item_agragar), precioTotal)
          }

          let totalEnviar = parseFloat($('.total').text());
          //let totalEnviar = precio * parseFloat(cantidad_agregar);

          if(!isNaN(id_orden)){
            window.accion = "UpdateOrden";
          }else{
            //window.accion = "addOrdenCompraaaa"
          }

          $.ajax({
            url: "models/administrar_ordenes.php",
            type: "POST",
            datatype:"json",    
            data:  {accion: accion,items:items, total:totalEnviar, proveedor: id_proveedor, almacen: id_almacen, cCostos: cCostos, id_orden: id_orden, comentarios: comentarios, id_empresa: id_empresa},    
            success: function(respuesta) {
              
              //$('#modalCRUD').modal('hide');
              tablaOrdenes.ajax.reload(null, false);

              document.getElementById("item_buscar").value="";
              document.getElementById("item_buscar").focus();
              document.getElementById("id_item_agragar").value="";
              document.getElementById("cantidad").value = "";
              document.getElementById("contAgregarProdItem").classList.add("d-none")
              
              document.querySelector(".id_ordenEditar").innerHTML = respuesta;
              window.accion = "UpdateOrden";
              reloadTablaItems("traerItemsUpdateOrden",id_proveedor, respuesta);
            }
          })
        }
      })

      $(document).on("keypress", "#cantidad", function(e){
        if(e.keyCode == 13){
          document.querySelector(".btnAgregarProdItem").click();
        }
      });

      function reloadTablaItems(accion, id_proveedor, id_orden){
        $("#tablaItems").dataTable().fnDestroy();
        tablaItems= $('#tablaItems').DataTable({
          "ajax": {
            "url" : "./models/administrar_ordenes.php?accion="+accion+"&id_proveedor="+id_proveedor+"&id_orden="+id_orden,
            "dataSrc": "",
          },
          "columns":[
            {"data": "id_item"},
            {
              render: function(data, type, full, meta) {
                return ()=>{
                  let $img = "";
                  if (full.imagen !=""){
                    return `<img src="./views/img_items/${full.imagen}" class="img-thumbnail">`;
                  }else{
                    return ""
                  }
                };
              }
            },
            {"data": "item"},
            {
              render: function(data, type, full, meta) {
                return `<input class="cantidadPedir form-control quitFlechas" type="number" value="${full.cantidad}" min="0" step="0" >`;
              }
            },
            {
              render: function(data, type, full, meta) {
                return '<span class="d-none">'+full.precio+'</span><span class="">'+new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format(full.precio)+'</span>';
              }
            }
          ],
          "language":  idiomaEsp
        });
      }

      $(document).on("click", ".btnAgregarNuevoProducto", function(){
        document.getElementById("contTablaOrden").classList.add("d-none");
        document.getElementById("resultadoSearch").innerHTML="";
        document.getElementById("descripcion_producto").value = document.getElementById("item_buscar").value;
        document.getElementById("item_buscar").value="";
        document.getElementById("contAddItem").classList.remove("d-none");
        document.getElementById("descripcion_producto").focus();
        document.getElementById("footerOC").classList.add("d-none");
      })

      $(document).on("click", ".bntCancelAddItem", function(){
        document.getElementById("contAddItem").classList.add("d-none");
        document.getElementById("contTablaOrden").classList.remove("d-none");
        document.getElementById("resultadoSearch").innerHTML="";
        document.getElementById("item_buscar").focus();
        document.getElementById("footerOC").classList.remove("d-none");
        $("#formAddItem").trigger("reset");
      })*/

      $(document).on("click", ".btnVer", function(){
        fila = $(this).closest("tr");
        let id_presupuesto = fila.find('td:eq(0)').text();

        $(".modal-title").text("Ver tarea de mantenimiento preventivo N?? "+id_presupuesto);
        $('#modalVerDetalle').modal('show');

        let datosUpdate = new FormData();
        datosUpdate.append('accion', 'traerDetalleMantenimientoPreventivo');
        datosUpdate.append('id_presupuesto', id_presupuesto);
        $.ajax({
          data: datosUpdate,
          url: './models/administrar_presupuestos.php',
          //url: './models/administrar_presupuestos.php?accion=traerPresupuestos&id_presupuesto='+id_presupuesto,
          method: "post",
          cache: false,
          contentType: false,
          processData: false,
          beforeSed: function(){
            //$('#procesando').modal('show');
          },
          success: function(datosProcesados){
            //console.log(datosProcesados);
            let datosInput = JSON.parse(datosProcesados);
            console.log(datosInput);
            let dmp=datosInput.datos_mantenimiento_preventivo;
            console.log(dmp);

            $("#lblCliente").html(dmp.cliente);
            $("#lblUbicacion").html(dmp.direccion);
            $("#lblElemento").html(dmp.descripcion_activo);
            $("#lblAsunto").html(dmp.asunto);
            $("#lblDetalle").html(dmp.detalle);
            $("#lblPrioridad").html(dmp.prioridad);

            $tabla = document.getElementById("tablaAdjuntosDetalle");
            $bodyTablaAdjuntos = $tabla.querySelector("tbody");
            $bodyTablaAdjuntos.innerHTML="";

            let amp=datosInput.adjuntos_mantenimiento_preventivo;
            //console.log(amp);

            if(amp.length>0){
              amp.forEach((adjunto)=>{
                //console.log(adjunto);
                $tr=`<tr>
                      <td>${adjunto.id_adjunto}</td>
                      <td><a href="./views/mantenimiento_preventivo/adj_${id_presupuesto}_${adjunto.archivo}" target="_blank" >${adjunto.archivo}</a></td>
                      <td>${adjunto.usuario}</td>
                      <td>${adjunto.fecha_hora}</td>
                      <td><button class='btn btn-danger btnBorrarAdjunto'><i class='fa fa-trash-o'></i></button></td>
                  </tr>`;
                $bodyTablaAdjuntos.innerHTML +=$tr;
              })
            }else{
              $bodyTablaAdjuntos.innerHTML=`<tr>
                      <td colspan="5" class="text-center">No se han encontrado registros</td>
                  </tr>`;
            }

            $("#lblContacto").html(dmp.contacto_cliente);
            //$("#lblid_vehiculo_asignado").html(dmp.id_vehiculo_asignado);
            //$("#lblcosto_movilidad_estimado").html(dmp.costo_movilidad_estimado);
            $("#lblFecha").html(dmp.fecha_mostrar);
            $("#lblHoraDesde").html(dmp.hora_desde_mostrar);
            $("#lblHoraHasta").html(dmp.hora_hasta_mostrar);

            $('#id_presupuesto').html(id_presupuesto);
            
            accion = "updateMantenimientoPreventivo";
          }
        });

      });

      $(document).on("click", ".btnBorrarAdjunto", function(){
        fila = $(this).closest("tr");
        let id_adjunto = fila.find('td:eq(0)').text();
        let nombre_adjunto = fila.find('td:eq(1)').text()
        let accion = "borrarAdjunto";

        swal({
          title: "Estas seguro?",
          text: "Una vez eliminado este archivo, no volveras a verlo",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            //accion = "borrarAdjunto";
            $.ajax({
              url: "models/administrar_presupuestos.php",
              type: "POST",
              datatype:"json",    
              data:  {accion: accion, id_adjunto: id_adjunto, nombre_adjunto: nombre_adjunto},    
              success: function(data) {
                fila.remove();
                swal({
                  icon: 'success',
                  title: 'Archivo eliminado exitosamente'
                });
              }
            }) 
          } else {
            swal("El registro no se elimin??!");
          }
        })
      });

      $(document).on("click", ".btnBorrar", function(){
        fila = $(this);           
        let id_presupuesto = parseInt($(this).closest('tr').find('td:eq(0)').text());
        $("#id_tarea_mantenimiento_borrar").html(id_presupuesto);

        $("#modalOpcionesEliminarTareas").modal("show");

      });

      $(document).on("click", "#btnBorrarSeleccionado", function(){
        let id_presupuesto=$("#id_tarea_mantenimiento_borrar").html();
        swal({
          title: "Estas seguro?",
          text: "Una vez eliminada esta tarea no volveras a verlo",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            accion = "eliminarMantenimientoPreventivoIndividual";
            $.ajax({
              url: "models/administrar_presupuestos.php",
              type: "POST",
              datatype:"json",    
              data:  {accion:accion, id_presupuesto:id_presupuesto},    
              success: function() {
                tablaPresupuestos.row(fila.parents('tr')).remove().draw();                  
              }
            }); 
          } else {
            swal("El registro no se elimin??!");
          }
        })
      });

      $(document).on("click", "#btnBorrarPendientes", function(){
        let id_presupuesto=$("#id_tarea_mantenimiento_borrar").html();
        swal({
          title: "Estas seguro?",
          text: "Una vez eliminadas estas tareas no volveras a verlas",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            accion = "eliminarMantenimientoPreventivoPendientes";
            $.ajax({
              url: "models/administrar_presupuestos.php",
              type: "POST",
              datatype:"json",    
              data:  {accion:accion, id_presupuesto:id_presupuesto},    
              success: function() {
                tablaPresupuestos.ajax.reload(null, false);
              }
            }); 
          } else {
            swal("El registro no se elimin??!");
          }
        })
      });

    </script>
  </body>
</html>