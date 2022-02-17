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
    <title>MYLA - Informe mantenimiento vehicular</title>
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
    <style type="text/css">
      input[type=number]::-webkit-inner-spin-button,
      input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
        margin: 0;
        }
    input[type=number] { -moz-appearance:textfield; }
    </style>
  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="loader bg-white">
        <div class="whirly-loader"> </div>
      </div>
    </div>
    <!-- Loader ends-->
    <?php
        include_once('./views/main_header.php');
      ?>
      <!-- Page Header Ends                              -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="page-sidebar">
           <?php
            include_once('./views/slideBar.php');
          ?>
        </div>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-header">
              <div class="row">
                <div class="col">
                  <div class="page-header-left">
                    <h3>Informe mantenimiento vehicular</h3>
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="home_users.php"><i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item active">Informe mantenimiento vehicular</li>
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
                  <!--<div class="card-header">
                    <h5>Filtrar</h5>
                  </div>-->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-3">
                        <label>Fecha desde:</label>
                        <input type="date" id="fdesde" class="form-control" value="<?=date("Y-m-d",strtotime(date("Y-m-d")." -1 month"))?>">
                      </div>
                      <div class="col-3">
                        <label>Fecha hasta:</label>
                        <input type="date" id="fhasta" class="form-control" value="<?=date("Y-m-d")?>">
                      </div>
                      <!-- <div class="col-3">
                        <label>Vehiculo:</label>
                        <select class="form-control" id="vehiculo">
                          <option value="">Seleccione</option>
                        </select>
                      </div> -->
                      <div class="col-3 align-self-end">
                        <button class="btn btn-success btnBuscar">Buscar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="row">
                <div class="col-xl-12">
                  <div class="card">
                    <div class="card-header">
                      <h5>Tareas de mantenimiento</h5>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive" id="contTablaListas" >
                        <table class="table table-hover" id="tablaMovimientos">
                          <thead class="text-center">
                            <tr>
                              <th>Fecha</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Patente</th>
                              <th>Año</th>
                              <th>Detalle tarea</th>
                              <th>Costo estimado</th>
                              <th>Realizado</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Fecha</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Patente</th>
                              <th>Año</th>
                              <th>Detalle tarea</th>
                              <th>Costo estimado</th>
                              <th>Realizado</th>
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
      </div>
    </div>

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
    <!-- <script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/buttons.html5.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/buttons.print.min.js"></script> -->

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
    <script src="assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.colReorder.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.scroller.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/custom.js"></script>

    <script src="assets/js/chart/chartjs/chart.min.js"></script>
    <script src="assets/js/sweet-alert/sweetalert.min.js"></script>
    <script src="assets/js/chat-menu.js"></script>
    <script src="assets/js/tooltip-init.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
    <!--<script src="assets/js/theme-customizer/customizer.js"></script>-->
    <!-- Plugin used-->
    <script type="text/javascript">

      var accion = "";
      $(document).ready(function(){
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
        /*tablaMovimientos= $('#tablaMovimientos').DataTable({
            "ajax": {
                "url" : "./models/administrar_vehiculos.php?accion=traerTareasMantenimientoInforme",
                "dataSrc": "",
              },
            "columns":[
              {"data": "id_movimiento"},
              {"data": "id_stock"},
              {"data": "item"},
              {"data":"cantidad"},
              {"data": "usuario"},
              {"data": "tipo_movimiento"},
              {"data": "fecha"}
            ],
            "language":  idiomaEsp
        });*/
        cargarDataTable()
      });

      $(document).on("click", ".btnBuscar", function(){
          cargarDataTable();
      })

      function cargarDataTable(){
          let desde = $("#fdesde").val();
          let hasta =$("#fhasta").val();
          //let id_vehiculo =$("#vehiculo").val();
          if(fdesde ==="" || fhasta ===""){
              swal({
                icon: 'error',
                title: 'Debe seleccionar fecha desde y fecha hasta'
              });
          }else{
              $("#tablaMovimientos").dataTable().fnDestroy();
              tablaMovimientos= $('#tablaMovimientos').DataTable({
                "ajax": {
                    "url" : "./models/administrar_vehiculos.php?accion=traerTareasMantenimientoInforme&desde="+desde+"&hasta="+hasta,//&id_vehiculo="+id_vehiculo+"
                    "dataSrc": "",
                  },
                "columns":[
                  {"data": "fecha_mostrar"},
                  {"data": "marca"},
                  {"data": "modelo"},
                  {"data": "patente"},
                  {"data": "anio"},
                  {"data": "detalle"},
                  {"data": "costo_estimado_mostrar"},
                  {"data": "realizado_mostrar"}
                ],
                "language":  idiomaEsp,
                dom: '<"mr-2 d-inline"l>Bfrtip',
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel',
                        title:     "Informe mantenimiento vehicular",
                        className: 'btn-success',
                        exportOptions: {
                            //columns: ':not(:last-child)',
                            format: {
                                body: function ( data, row, column, node ) {
                                    // Strip $ from salary column to make it numeric
                                    return column === 7 ? data.replace( /[$.]/g, '' ).replace( /[,]/g, '.' ) : data;
                                }
                            }
                        }
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        title:     "Informe mantenimiento vehicular",
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
                  })
                }
              });
          }
      }

      $(document).on('click', '#btnExportar', function(){
        let almacen = $("#almacen").val();
        let proveedor =$("#proveedor").val();
        accion="traerStockFiltro";
        $.ajax({
              url: "models/administrar_stock.php",
              type: "GET",
              datatype: "json",
              data: {accion: accion, proveedor: proveedor, almacen: almacen},
              success: function(response){

                let respuestaJson= JSON.parse(response);
                if(respuestaJson.length > 0){

                  let stockExportar = JSON.stringify(respuestaJson); 
                  window.open('./exportarstock.php?stock='+stockExportar,+'_blank');

                }else{
                  swal("No hay datos", "No se encontraron datos para exportar", "error");
                }
              }
            })
      });

    </script>
  </body>
</html>