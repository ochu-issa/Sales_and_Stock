<?php 
include 'include/header.php';
include 'include/nav.php';
 ?>
 <?php 

$url = $_SERVER['REQUEST_URI'];
$cut = explode("?", $url);
$inv = end($cut);

$seleinv = mysqli_query($conn, "select * from selltable where invoice = '$inv'");
$data = mysqli_fetch_assoc($seleinv);
$proid2 = $data['productid'];
$custid = $data['customerid'];
$useid = $data['userid'];

$setocu = mysqli_query($conn, "select * from customertable where customerid = '$custid'");
$tc = mysqli_fetch_assoc($setocu);

$setus = mysqli_query($conn, "select * from usertable where userid = '$useid'");
$tcuser = mysqli_fetch_assoc($setus);
// $selfrompro2 = mysqli_query($conn, "select * from producttable where productid = '$proid2'");
// $have2 = mysqli_fetch_assoc($selfrompro2);
$queryjoin = "SELECT producttable.branchid, branchtable.branchname FROM producttable INNER JOIN branchtable ON producttable.branchid = branchtable.branchid WHERE producttable.productid = '$proid2'";
$test = mysqli_query($conn, $queryjoin);
$ft = mysqli_fetch_assoc($test);
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><span class="fa fa-file-text-o"></span> Risiti </h1>
            <?php 
            if ($role_name == 'Msimamizi') {
             ?>
            <a href="historiamauzo.php" class="btn btn-primary"><span class="fa fa-arrow-left"></span> Rudi</a>
          <?php }elseif($role_name == 'Muuzaji'){
            ?>
            <a href="mauzomuuzaji.php" class="btn btn-primary"><span class="fa fa-arrow-left"></span> Rudi</a>
          <?php } ?>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Nyumbani</a></li>
              <li class="breadcrumb-item active">Risiti</li>
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


        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> SALES & STOCKS SHOP.
                    <small class="float-right">Tarehe: <?php echo '<b>'.date('D, M Y').'</b>'; ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Shop Name,</strong><br>
                    P.O.BOx 2022,<br>
                    <b><?php echo $ft['branchname']; ?></b><br>
                    <b>Namba ya simu:</b> (+255) 656-556-002,<br>
                    <b>Barua pepe:</b> info@shop.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <strong>Mteja</strong>
                  <address>
                    <?php echo $tc['fullname']; ?><br>
                    <?php echo $tc['address']; ?><br>
                    <?php echo $tc['phone']; ?><br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Namba ya mauzo: </b><b class="text-primary"> <?php echo $inv; ?></b><br>
                  <b>Tarehe ya mauzo:</b> <?php echo $data['saledate']; ?><br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>S/n</th>
                      <th>Jina la bidhaa</th>
                      <th>Idadi</th>
                      <th>Bei</th>
                      <th>Jumla</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- here your content -->
                    <?php 
                    $no2 = 1;
                    $seldisto = mysqli_query($conn, "select * from selltable where invoice = '$inv'");
                    while ($hold = mysqli_fetch_assoc($seldisto)) {
	                    $proid = $hold['productid'];
	                    $selfrompro = mysqli_query($conn, "select * from producttable where productid = '$proid'");
	                    $have = mysqli_fetch_assoc($selfrompro);
	                   ?>
                     <tr>
                     	<td><?php echo $no2; ?></td>
                     	<td><?php echo $have['productname']; ?></td>
                     	<td><?php echo $hold['quantity']; ?></td>
                     	<td><?php echo number_format($have['amount']); ?></td>
                     	<td><?php echo number_format($ttl = $hold['quantity'] * $have['amount']); ?></td>
                     </tr>
                     <?php $no2++;} ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <!-- /.col -->
                <div class="col-8">
                  <p class="lead">Taarifa za mauzo</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Idadi ya Bidhaa:</th>
                        <td>
                       <?php   
                         $totalquery2 = "SELECT sum(quantity) FROM selltable WHERE invoice = '$inv'";
                         $run2 = mysqli_query($conn, $totalquery2);
                         for ($i=0; $cxz = mysqli_fetch_assoc($run2); $i++) { 
                           $tmon2 = $cxz['sum(quantity)'];
                           echo $tmon2;
                         }
                         ?>
                        </td>
                      </tr>
                      <tr>
                        <th>Jumla</th>
                        <td>
                        <?php   
                         $totalquery3 = "SELECT sum(amount) FROM selltable WHERE invoice = '$inv'";
                         $run3 = mysqli_query($conn, $totalquery3);
                         for ($i=0; $cxz = mysqli_fetch_assoc($run3); $i++) { 
                           $tmon3 = $cxz['sum(amount)'];
                           echo number_format($tmon3).'  <i>/=Tsh</i>';
                         }
                         ?>
                        </td>
                      </tr>
                      <tr>
                        <th>Punguzo: </th>
                        <td><?php echo number_format($data['discount']).'  <i>/=Tsh</i>'; ?></td>
                      </tr>
                      <tr>
                        <th>Kiasi alichotoa mteja:</th>
                        <td><?php echo number_format($data['checkoutmoney']).'  <i>/=Tsh</i>'; ?></td>
                      </tr>
                      <tr>
                        <th>Kiasi cha kumrudishia mteja (change):</th>
                        <td><?php echo number_format($data['checkoutmoney'] - ($tmon3 - $data['discount'])).'  <i>/=Tsh</i>'; ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row">
              	<p class="lead">Mauzo haya yamefanywa na: <?php echo $tcuser['fname'].' '.$tcuser['lname']; ?></p>
              </div>

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="printi-risiti.php?<?php echo $inv; ?>"  class="btn btn-warning"><i class="fas fa-print"></i> Printi Risiti</a>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Tengeza PDF
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <footer class="main-footer">
    <strong>Mwisho wa risiti <a href="#"><?php echo $inv; ?></a>.</strong>
    <div class="float-right d-none d-sm-inline-block">
    </div>
  </footer>
  </div>
<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script>
</body>
</html>
