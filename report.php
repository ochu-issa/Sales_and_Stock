<?php 
include 'include/header.php';
include 'include/nav.php';
 ?>
 <?php  
$datefromprint = null;
$datetoprint = null;

  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="nav-icon fa fa-folder-open"></i> Ripoti </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Nyumbani</a></li>
              <li class="breadcrumb-item active">Ripoti</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
            <form method="post">
              <div class="card-body text-center text-bold">
              	<div class="row">
              		<div class="col col-md-1">
              			<b>kuanzia:</b>
              		</div>
              		<div class="col col-md-3">
              			<input type="date" name="from" placeholder="" class="form-control"> 
              		</div>
              		<div class="col col-md-1">
              			<b>Hadi:</b>
              		</div>
              		<div class="col col-md-3">
              			<input type="date" name="to" placeholder=""  class="form-control">
              		</div>    
              		<div class="col col-md-4 ">
              			<button class="btn btn-primary" name="search"><span class="fa fa-search"></span> Tafuta</button> 
              			&nbsp;&nbsp;&nbsp;
              			<button class="btn btn-warning"><span class="fa fa-print"></span> Printi</button>
              		</div>
              	</div>
                
                  
              </div>
              </form>
              <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Bidhaa zilizopo</h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S/no</th>
                    <th>Tarehe</th>
                    <th>Namba ya mauzo (invoice)</th>
                    <th>Muuzaji</th>
                    <th>Jina la bidhaa</th>
                    <th>Idadi</th>
                    <th>Jumla</th>
                    <!-- <th>Kitendo</th> -->
                  </tr>
                  </thead>
                  <tbody>

                    <?php
                    if (isset($_POST['search'])) {
                    $from = $_POST['from'];
                    $to = $_POST['to'];

                    $timefrom = strtotime($from);
                    $timeto = strtotime($to);
                    $datefrom = date('Y-m-d', $timefrom);
                    $dateto = date('Y-m-d', $timeto);

                    $datefromprint = date('d, M Y', $timefrom);
                    $datetoprint = date('d, M Y', $timeto);
                    ?>
                    <div class="text-center text-bold ">
                    MAUZO KUANZIA : <i class="text-success"><?php echo $datefromprint; ?></i>
                     HADI : <i class="text-success"><?php echo $datetoprint; ?></i> 
                     <a href="" class="btn btn-warning"><span class="fa fa-print"></span> Printi Ripoti</a>
                  </div>
                    <?php
                    $no3=1;
                    $query_search = "SELECT DISTINCT invoice FROM selltable WHERE saledate BETWEEN '$datefrom' AND '$dateto' ORDER BY sellid DESC";
                    $run = mysqli_query($conn, $query_search);
                    if (mysqli_num_rows($run)>0) {
                      
                      while ($row = mysqli_fetch_assoc($run)) {
                        $seldist = mysqli_query($conn, "select * from selltable where saledate between '$datefrom' and '$dateto'");

                        $sl = mysqli_fetch_assoc($seldist);
                        $idcashier = $sl['userid'];
                        $selfromuser = mysqli_query($conn, "select * from usertable where userid = '$idcashier'");
                        $tu = mysqli_fetch_assoc($selfromuser);
                      ?>
                      <tr>
                        <td><?php echo $no3 ?></td>
                        <td><?php echo $sl['saledate']; ?></td>
                        <td><?php echo $row['invoice']; ?></td>
                        <td><?php echo $tu['fname'].' '.$tu['lname']; ?></td>
                        <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg<?php echo $row['invoice']; ?>"> <span class="fa fa-eye"></span> Bonyeza kuona bidhaa</button>
                      </td>

                      <form method="post">
                       <div class="modal fade" id="modal-lg<?php echo $row['invoice']; ?>">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Historia ya mauzo <b class="text-primary"><?php echo $row['invoice'].'</b> Tarehe <b class="text-bold text-primary">'.$sl['saledate'].'</b>'; ?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>
                                  <center>
                                  <div class="row text-bold">
                                    <div class="col col-md-1">S/n</div>
                                    <div class="col col-md-3">Jina la Bidhaa</div>
                                    <div class="col col-md-2">Idadi</div>
                                    <div class="col col-md-3">Bei</div>
                                    <div class="col col-md-3">Jumla</div>
                                  </div>

                                  <?php 
                                  $no2 = 1;
                                  $seldisto = mysqli_query($conn, "select * from selltable where invoice = '".$row['invoice']."'");
                                  while ($hold = mysqli_fetch_assoc($seldisto)) {
                                    $proid = $hold['productid'];
                                    $selfrompro = mysqli_query($conn, "select * from producttable where productid = '$proid'");
                                    $have = mysqli_fetch_assoc($selfrompro);
                                   ?>
                                  <div class="row">
                                    <div class="col col-md-1"><?php echo $no2; ?></div>
                                    <div class="col col-md-3"><?php echo $have['productname']; ?></div>
                                    <div class="col col-md-2"><?php echo $hold['quantity']; ?></div>
                                    <div class="col col-md-3"><?php echo number_format($have['amount']); ?></div>
                                    <div class="col col-md-3"><?php echo number_format($ttl = $hold['quantity'] * $have['amount']); ?></div>
                                  </div>
                                  <?php $no2++;} ?><br>

                                  <div class="row text-bold">
                                    <div class="col col-md-1"></div>
                                    <div class="col col-md-3 ">JUMLA</div>
                                  <div class="col col-md-2" style="background: #ffc108; color: white;">
                                      <?php   
                                     $totalquery2 = "SELECT sum(quantity) FROM selltable WHERE invoice = '".$row['invoice']."'";
                                     $run2 = mysqli_query($conn, $totalquery2);
                                     for ($i=0; $cxz = mysqli_fetch_assoc($run2); $i++) { 
                                       $tmon2 = $cxz['sum(quantity)'];
                                       echo $tmon2;
                                     }
                                     ?>
                                    </div>
                                    <div class="col col-md-3 text-bold"></div>
                                  <div class="col col-md-3" style="background: #007bff; color: white;">
                                    <?php   
                                     $totalquery3 = "SELECT sum(amount) FROM selltable WHERE invoice = '".$row['invoice']."'";
                                     $run3 = mysqli_query($conn, $totalquery3);
                                     for ($i=0; $cxz = mysqli_fetch_assoc($run3); $i++) { 
                                       $tmon3 = $cxz['sum(amount)'];
                                       echo number_format($tmon3).'  <i>/=Tsh</i>';
                                     }
                                     ?>
                                  </div>
                                  </div>
                                  </center>
                                </p>
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        </form>
                        <td><?php echo mysqli_num_rows($seldisto); ?></td>
                      <td><?php 
                      $totalquery4 = "SELECT sum(amount) FROM selltable WHERE invoice = '".$row['invoice']."'";
                       $run4 = mysqli_query($conn, $totalquery4);
                       for ($i=0; $cxz = mysqli_fetch_assoc($run4); $i++) { 
                         $tmon4 = $cxz['sum(amount)'];
                         echo number_format($tmon4);
                       }?></td>

                    </tr>
                      <?php $no3++;}
                  }else{
                   ?>
                   <tr>
                     <td colspan="8" class="text-bold text-center">Hakuna mauzo katika kipindi hiki</td>
                   </tr>
                 <?php }} ?>
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>

        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
            <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ongeza Bidhaa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>
              	<div class="row">
              		<div class="col col-md-6">
              			<label>Jina la Bidhaa</label>
              			<input type="text" name="productname" class="form-control" placeholder="Weka Jina la bidhaa...">
              		</div>
              		<div class="col col-md-6">
              			<label>Aina</label>
              			<input type="text" name="producttype" class="form-control" placeholder="Weka aina ya bidhaa...">
              		</div>
              	</div>
              	<div class="row">
              		<div class="col col-md-6">
              			<label>Bei ya Bidhaa</label>
              			<input type="text" name="productamount" class="form-control" placeholder="Weka Bei ya bidhaa...">
              		</div>
              		<div class="col col-md-6">
              			<label>Idadi</label>
              			<input type="number" name="quantity" class="form-control" placeholder="Weka idadi ya bidhaa...">
              		</div>
              	</div>
              </p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Funga</button>
              <button type="button" class="btn btn-primary">Ongeza</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
  </div>
  <!-- /.content-wrapper -->

 <?php 
include 'include/footer.php';
include 'include/script.php';
 ?>
