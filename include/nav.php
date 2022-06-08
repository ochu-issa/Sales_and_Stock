 <?php 
if ($_SESSION['uname']) {

}
  ?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
   
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">LENSHOP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $take_name['fname'].' '.$take_name['lname']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="mauzo.php" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart "></i>
              <p>
                Mauzo
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="bidhaa.php" class="nav-link">
              <i class="nav-icon fa fa-product-hunt"></i>
              <p>
                Bidhaa
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="wateja.php" class="nav-link">
              <i class="nav-icon fa fa-odnoklassniki"></i>
              <p>
                Wateja
              </p>
            </a>
          </li>
          <?php 
          if ($role_name == 'Msimamizi') {
           ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usimamizi wa Duka
                <i class="right fas fa-angle-left"></i> 
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="matawi.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Matawi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="wauzaji.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Wauzaji</p>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-item">
            <a href="historiamauzo.php" class="nav-link">
              <i class="nav-icon fa  fa-bar-chart"></i>
              <p>
                Historia ya mauzo
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="report.php" class="nav-link">
              <i class="nav-icon fa fa-folder-open"></i>
              <p>
                Ripoti
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="setting.php" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Mpangilio wa mfumo
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>
          <?php } ?>
          <?php if ($role_name == 'Muuzaji') {
           ?>
           <li class="nav-item">
            <a href="mauzomuuzaji.php" class="nav-link">
              <i class="nav-icon fa  fa-bar-chart"></i>
              <p>
                Historia ya mauzo
              </p>
            </a>
          </li>
          <?php } ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Wasifu
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fa fa-power-off"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
