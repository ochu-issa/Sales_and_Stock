<?php 
include 'include/header.php';
include 'include/nav.php';
 ?>
 <?php  
$productdate = date('y/m/d');
$userid = $take_name['userid'];


  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="nav-icon fa  fa-bar-chart"></i> Historia ya mauzo</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Nyumbani</a></li>
              <li class="breadcrumb-item active">Historia ya mauzo</li>
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
              <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Mauzo Uliyofanya</h3>
                
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
                    <th>Kitendo</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php   
                    $no = 1;
                    $user = $take_name['userid'];
                    $select_sel = mysqli_query($conn, "select distinct invoice from selltable where userid = '$user' order by sellid desc");
                    while($hs = mysqli_fetch_assoc($select_sel))
                     {
                      $seldist = mysqli_query($conn, "select * from selltable where invoice = '".$hs['invoice']."'");
                      $sl = mysqli_fetch_assoc($seldist);
                      $idcashier = $sl['userid'];
                      $selfromuser = mysqli_query($conn, "select * from usertable where userid = '$idcashier'");
                      $tu = mysqli_fetch_assoc($selfromuser);

                      ?>
                      <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $sl['saledate']; ?></td>
                        <td><?php echo $hs['invoice']; ?></td>
                        <td><?php echo $tu['fname'].' '.$tu['lname']; ?></td>
                        <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg<?php echo $sl['invoice']; ?>"> <span class="fa fa-eye"></span> Bonyeza kuona bidhaa</button>
                      </td>

                      <form method="post">
                       <div class="modal fade" id="modal-lg<?php echo $sl['invoice']; ?>">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Historia ya mauzo <b class="text-primary"><?php echo $sl['invoice'].'</b> Tarehe <b class="text-bold text-primary">'.$sl['saledate'].'</b>'; ?></h4>
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
                                  $seldisto = mysqli_query($conn, "select * from selltable where invoice = '".$sl['invoice']."'");
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
                                     $totalquery2 = "SELECT sum(quantity) FROM selltable WHERE invoice = '".$sl['invoice']."'";
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
                                     $totalquery3 = "SELECT sum(amount) FROM selltable WHERE invoice = '".$sl['invoice']."'";
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

                      <td><?php echo mysqli_num_rows($seldist); ?></td>
                      <td><?php 
                      $totalquery4 = "SELECT sum(amount) FROM selltable WHERE invoice = '".$sl['invoice']."'";
                       $run4 = mysqli_query($conn, $totalquery4);
                       for ($i=0; $cxz = mysqli_fetch_assoc($run4); $i++) { 
                         $tmon4 = $cxz['sum(amount)'];
                         echo number_format($tmon4);
                       }?></td>
                      <td><a href="risiti.php?<?php echo $sl['invoice'];?>" class="btn btn-small btn-warning"><span class="fa fa-print"></span> Printi risiti</a></td>
                      </tr>
                      <?php $no++;} ?>
                  </tbody>
                 <tr>
                   <th colspan="5"></th>
                   <th>Jumla ya Bidhaa</th>
                   <th colspan="2">Jumla ya Bei</th>
                 </tr>
                 <tr>
                   <th colspan="5">Jumla</th>
                   <th  style="background: #ffc108; color: white;">
                     <?php   
                       $totalquery = "SELECT sum(quantity) FROM selltable WHERE userid = '$user'";
                       $run = mysqli_query($conn, $totalquery);
                       for ($i=0; $cxz = mysqli_fetch_assoc($run); $i++) { 
                         $tmon = $cxz['sum(quantity)'];
                         echo number_format($tmon);
                       }
                       ?>
                   </th>
                   <th colspan="2" style="background: #007bff; color: white;">
                     <?php   
                       $totalquery = "SELECT sum(amount) FROM selltable WHERE userid = '$user'";
                       $run = mysqli_query($conn, $totalquery);
                       for ($i=0; $cxz = mysqli_fetch_assoc($run); $i++) { 
                         $tmon = $cxz['sum(amount)'];
                         echo number_format($tmon).'  <i>/=Tsh</i>';
                       }
                       ?>
                   </th>
                 </tr>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php 
include 'include/footer.php';
include 'include/script.php';
 ?>