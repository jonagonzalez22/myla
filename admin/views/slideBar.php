<div class="main-header-left d-none d-lg-block">
            <div class="logo-wrapper"><a href="home_users.php"><!--<img src="assets/images/unibrica.png" alt="">--></a></div>
          </div>
          <div class="sidebar custom-scrollbar">
            <div class="sidebar-user text-center">
              <div><img class="img-60 rounded-circle" src="assets/images/dashboard/user.png" alt="#">
                <!--<div class="profile-edit"><a href="edit-profile.html" target="_blank"><i data-feather="edit"></i></a></div>-->
              </div>
              <h6 class="mt-3 f-14">
                  <?php 
                      if ($_SESSION['rowUsers']['perfil']==2) {
                        echo $_SESSION['rowUsers']['usuario']; 
                        $tipoUser= $_SESSION['rowUsers']['perfil'];
                      }else{
                        echo $_SESSION['rowUsers']['email']; 
                        $tipoUser = $_SESSION['rowUsers']['perfil'];
                      }
                  ?>

                </h6>
              <p><?php echo $tipoUser; ?></p>
            </div>
            <ul class="sidebar-menu">
              <!--<li><a class="sidebar-header" href="home_users.php"><i data-feather="home"></i><span>Dashboard</span>-->
                <!--<span class="badge badge-pill badge-primary">6</span>--></a>
              </li>

              <?php 
                if ($_SESSION['rowUsers']['id_perfil'] == 5) {
              ?>

              <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>AMB – Administrador</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Altas</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Empresas</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                          <li><a href="empresas.php"><i class="fa fa-circle"></i> ABM Empresas</a></li>
                          <li><a href="#"><i class="fa fa-circle"></i> Perfiles</a></li>
                          <li><a href="#"><i class="fa fa-circle"></i> Empleados</a></li>
                          <li><a href="#"><i class="fa fa-circle"></i> Jerarquias</a></li>
                        </ul>
                      </li>
                    </ul>
                    <ul class="sidebar-submenu">
                      <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Clientes</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                          <li><a href="#"><i class="fa fa-circle"></i> Contactos</a></li>
                          <li><a href="#"><i class="fa fa-circle"></i> Locaciones</a></li>
                          <li><a href="#"><i class="fa fa-circle"></i> Condiciones</a></li>
                        </ul>
                      </li>
                    </ul>
                    <ul class="sidebar-submenu">
                      <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Usuarios</span><i class="fa fa-angle-right pull-right"></i></a>
                        <ul class="sidebar-submenu">
                          <li><a href="usuarios.php"><i class="fa fa-circle"></i> Perfiles</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                </ul>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Parámetros</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="unidades.php"><i class="fa fa-circle"></i> Unidades</a></li>
                      <li><a href="rubros.php"><i class="fa fa-circle"></i> Rubros</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Puestos</a></li>
                      <li><a href="categorias_items.php"><i class="fa fa-circle"></i> Categorias</a></li>
                      <li><a href="tipos_items.php"><i class="fa fa-circle"></i> Tipos de productos</a></li>
                    </ul>
                  </li>
                </ul>
              </li>

              <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Maestro</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li>
                    <a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Usuarios ABM</span><i class="fa fa-angle-right pull-right"></i></a>
                      <ul class="sidebar-submenu">
                        <li>
                          <a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Accesos WEB</span><i class="fa fa-angle-right pull-right mt-2"></i></a>
                          <ul class="sidebar-submenu">
                            <li><a href="#"><i class="fa fa-circle"></i> Dashboard Genelar</a></li>

                            <li>
                              <a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Gestor tks</span><i class="fa fa-angle-right pull-right mt-2"></i></a>
                              <ul class="sidebar-submenu">
                                <li><a href="#"><i class="fa fa-circle"></i> Gestor de mant. prev.</a></li>
                                <li><a href="#"><i class="fa fa-circle"></i> Gestor de mant. correct.</a></li>
                                <li><a href="#"><i class="fa fa-circle"></i> Stock</a></li>
                                <li><a href="#"><i class="fa fa-circle"></i> Gestor administrativo</a></li>
                                <li><a href="#"><i class="fa fa-circle"></i> Gestor Geóposicion</a></li>
                                <li><a href="#"><i class="fa fa-circle"></i>AMB – Administrador</a></li>
                              </ul>
                            </li>


                          </ul>
                        </li>
                        <li>
                          <a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Accesos APP</span><i class="fa fa-angle-right pull-right mt-2"></i></a>
                        </li>
                      </ul>
                  </li>
                </ul>
              </li>


              <!--VIEJO MENÚ-->
              <!--<li><a class="sidebar-header" href="#"><i data-feather="settings"></i><span>Administrar</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a href="clientes.php"><i class="fa fa-circle"></i> Clientes</a></li>
                  <li><a href="usuarios.php"><i class="fa fa-circle"></i> Usuarios</a></li>
                </ul>
              </li>

              <li><a class="sidebar-header" href="#"><i data-feather="archive"></i><span>Stock</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a href="almacenes.php"><i class="fa fa-circle"></i> Almacenes</a></li>
                  <li><a href="proveedores.php"><i class="fa fa-circle"></i> Proveedores</a></li>
                  <li>
                    <a class="sidebar-header" href="items.php"><i class="fa fa-circle"></i><span>Items</a>
                  </li>
                  <li>
                    <a class="sidebar-header" href="stock.php"><i class="fa fa-circle"></i><span>Ver Stock</a>
                  </li>
                  <li>
                    <a class="sidebar-header" href="movimientos_stock.php"><i class="fa fa-circle"></i><span>Movimientos Stock</a>
                  </li>
                </ul>
              </li>

              <li><a class="sidebar-header" href="#"><i data-feather="zap"></i><span>Mantenimiento</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li>
                    <a class="sidebar-header" href="lista_de_precios.php"><i class="fa fa-circle"></i></i><span>Lista de precios</a>
                  </li>
                  <li>
                    <a class="sidebar-header" href="ordenes_de_compra.php"><i class="fa fa-circle"></i></i><span>Ordenes de compra</a>
                  </li>
                </ul>
              </li>-->

              <?php } else{ ?>
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Dashboard General</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Panel Gestion OTs</span><i class="fa fa-angle-right pull-right"></i></a>

                  <ul class="sidebar-submenu">
                    <li><a href="#"><i class="fa fa-circle"></i> ABM OTS</a></li>
                    <li><a href="#"><i class="fa fa-circle"></i> Agendar</a></li>
                    <li><a href="#"><i class="fa fa-circle"></i> Informes</a></li>
                  </ul>
                </li>
              </ul>
              </li>

              <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Gestor de Ticket</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Dashboard</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="#"><i class="fa fa-circle"></i> Generar Tkt AMB</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Informes</a></li>
                    </ul>
                  </li>
                </ul>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Alta</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="#"><i class="fa fa-circle"></i> Locación</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Contacto</a></li>
                    </ul>
                  </li>
                </ul>
              </li>

              <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Gestor Mant. Prevent.</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Alta</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="clientes.php"><i class="fa fa-circle"></i> Cliente</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Locación</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Sitios</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Elementos</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Tareas</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Frecuencia</a></li>
                    </ul>
                  </li>
                </ul>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Plan de Mantenim.</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="#"><i class="fa fa-circle"></i> Nuevo Plan</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Panel de control Operativo AMB</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Agendas</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Recursos</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Dashboard</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Informes</a></li>
                    </ul>
                  </li>
                </ul>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Archivo</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="#"><i class="fa fa-circle"></i> Plan de Mantenim.</a></li>
                    </ul>
                  </li>
                </ul>
              </li>


              <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Gestor Mant. Correct.</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Presupuestos</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="#"><i class="fa fa-circle"></i> Nuevo ppto</a></li>
                      <li><a href="lista_de_precios.php"><i class="fa fa-circle"></i> Lista de Precio</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Planificación</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Archivado</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Informes</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Dashboard</a></li>
                    </ul>
                  </li>
                </ul>
              </li>


              <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Gestor Obras</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Presupuestos</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="#"><i class="fa fa-circle"></i> Nuevo ppto</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Lista de Precio</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Planificación</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Nuevo gantt</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Archivado</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Informes</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Dashboard</a></li>
                    </ul>
                  </li>
                </ul>
              </li>


              <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Gestor Stock</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Altas</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="almacenes.php"><i class="fa fa-circle"></i> Almacén</a></li>
                      <li><a href="items.php"><i class="fa fa-circle"></i> Items</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Stock en transito</a></li>
                    </ul>
                  </li>
                </ul>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Stock</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="movimientos_stock.php"><i class="fa fa-circle"></i> Movimientos</a></li>
                      <li><a href="stock.php"><i class="fa fa-circle"></i> Existencia</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Informes</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Dashboard</a></li>
                    </ul>
                  </li>
                </ul>
              </li>


              <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Compras</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a href="#"><i class="fa fa-circle"></i> Solicitudes</a></li>
                  <li><a href="ordenes_de_compra.php"><i class="fa fa-circle"></i> Emisión OC</a></li>
                  <li><a href="#"><i class="fa fa-circle"></i> Informes</a></li>
                  <li><a href="#"><i class="fa fa-circle"></i> Dashboard</a></li>

                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Proveedores</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="proveedores.php"><i class="fa fa-circle"></i> Alta</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Cta Cte</a></li>
                    </ul>
                  </li>

                </ul>
              </li>


              <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Gestor Administrativo</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Administración</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="#"><i class="fa fa-circle"></i> Fondos Fijos</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Facturación</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Cta. Cte. Clientes</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Cta. Cte. Prov</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Pagos</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Cobranzas</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Echeq</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Chash Flow</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> IVA – Venta / Compra</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Informes</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Dashboard</a></li>
                    </ul>
                  </li>
                </ul>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>RRHH</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="#"><i class="fa fa-circle"></i> Empleados Alta – Baja</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Legajos</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Planillas de presentismo</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Sueldos</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Informes</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Archivos</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Dashboard</a></li>
                    </ul>
                  </li>
                </ul>
              </li>


              <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Gestor Geóposicion</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a class="sidebar-header" href="#"><i data-feather="plus"></i><span>Vehículos</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                      <li><a href="#"><i class="fa fa-circle"></i> Alta</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Documentos</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Fondos Fijos</a></li>
                      <li><a href="#"><i class="fa fa-circle"></i> Mantenimiento</a></li>
                    </ul>
                  </li>
                  <li><a href="#"><i class="fa fa-circle"></i> Dashboard</a></li>
                  <li><a href="#"><i class="fa fa-circle"></i> Informes</a></li>
                  <li><a href="#"><i class="fa fa-circle"></i> Archivos</a></li>
                </ul>
              </li>
              <?php } ?>
          </div>