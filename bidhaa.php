<?php 
include 'include/header.php';
include 'include/nav.php';
 ?>


 <?php  
 $branchid = $take_name['branchid'];
 $productdate = date('y/m/d');

if (isset($_POST['addproduct'])) {
  $productname = $_POST['productname'];
  $producttype = $_POST['producttype'];
  $productamount = $_POST['productamount'];
  $productquantity = $_POST['productquantity'];


  $finish = 2;
  while ($finish != 1) {
      $ver = "IG0".date("m").rand(100000,999999);
      $selver = mysqli_query($conn, "select * from producttable where barcode = '$ver'");
      if (mysqli_num_rows($selver)>0)
       {

        $finish = 2;
      
      }else{
        $insertdata = "INSERT INTO producttable VALUES ('', '$productname', '$producttype', '$ver', '$productamount','$productquantity', '$productdate', '$branchid')";
        $runquery = mysqli_query($conn, $insertdata);
        $success = '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Taarifa!</h5>
                        Hongera! Taarifa zimepokelewa kikamilifu
                      </div>';
        $finish = 1;
      }
  }

}

if (isset($_POST['fileadd'])) 
{
  if ($_FILES['file']['name']) 
  {
    $filename = explode(".", $_FILES['file']['name']);
    if ($filename[1] == 'csv') 
    {
      $handle = fopen($_FILES['file']['tmp_name'], "r+");
      while ($data = fgetscv($handle)) 
      {
        $proname = mysqli_real_escape_string($conn,  $data[0]);
        $protype = mysqli_real_escape_string($conn,  $data[1]);
        $proamount = mysqli_real_escape_string($conn, $data[2]);
        $proquantity = mysqli_real_escape_string($conn, $data[3]);

        $finish = 2;
      while ($finish != 1) {
      $ver = "IG0".date("m").rand(100000,999999);
      $selver = mysqli_query($conn, "select * from producttable where barcode = '$ver'");
      if (mysqli_num_rows($selver)>0)
       {

        $finish = 2;
      
      }else{
        $insertdata = "INSERT INTO producttable VALUES ('', '$proname', '$protype', '$ver', '$proamount','$proquantity', '$productdate', '$branchid')";
        $runquery = mysqli_query($conn, $insertdata);
        $finish = 1;
      }
      }


      }
      fclose($handle);
      $success = '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Taarifa!</h5>
                        Hongera! Taarifa zimepokelewa kikamilifu
                      </div>';
    }
  }
}

$selectprodu = mysqli_query($conn,"select * from producttable");
$selectprodu5 = mysqli_query($conn,"select * from producttable where quantity < 5 ");
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="nav-icon fa fa-product-hunt"></i> Bidhaa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Nyumbani</a></li>
              <li class="breadcrumb-item active">Bidhaa</li>
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
    <?php echo $error; echo $success;?>
              <div class="card-body text-center text-bold ">
              	JUMLA YA BIDHAA : <i class="text-success"><?php echo mysqli_num_rows($selectprodu); ?></i><br>
              	BIDHAA <i class="text-danger"><?php echo mysqli_num_rows($selectprodu5); ?></i> ZIPO CHINI YA 5
              </div>
              <div class="row">
              	<div class="col col-md-4">
              		<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-lg"> <span class="fa fa-plus"></span> Weka Bidhaa Mpya</button>
              	</div>
                <div class="col col-md-4"><center>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg-file"> <span class="fa fa-file"></span> Weka File  la Bidhaa mpya</button></center>
                </div>
              	<div class="col col-md-4">
              		<button type="button" class="btn btn-warning float-left" data-toggle="modal" data-target="#modal-lg"> <span class="fa fa-print"></span> Print Barcode ya bidhaa</button>
              	</div>
              </div><br>

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
                    <th>Jina la bidhaa</th>
                    <th>Aina</th>
                    <th>Namba ya Barcode</th>
                    <th>Bei</th>
                    <th>Idadi</th>
                    <th>Jumla</th>
                    <th>Tarehe</th>
                    <?php 
                    if ($role_name == 'Msimamizi') {
                     ?>
                    <th>Vitendo</th>
                  <?php } ?>
                  </tr>
                  </thead>
                  <tbody>
                  <?php   
                  $no = 1;
                  $query = mysqli_query($conn, "select * from producttable order by productid desc");
                  while ($dt = mysqli_fetch_assoc($query)) {
                   ?>
                   <tr>
                     <td><?php echo $no; ?></td>
                     <?php 
                     if ($dt['quantity'] < 5) {
                      ?>
                     <td style="background: #b92c28;" class="text-white"><?php echo $dt['productname']; ?></td>
                   <?php }else{
                    ?>
                    <td><?php echo $dt['productname']; } ?></td>

                     <td><?php echo $dt['producttype']; ?></td>
                     <td><?php echo $dt['barcode']; ?></td>
                     <td><?php echo number_format($dt['amount']); ?></td>
                     <td><?php echo $dt['quantity']; ?></td>
                     <td><?php echo number_format($amount = $dt['amount'] * $dt['quantity']); ?></td>
                     <td><?php echo $dt['productdate']; ?></td>
                      <?php 
                      if ($role_name == 'Msimamizi') {
                       ?>
                       <td>
                      <button class="btn btn-small btn-danger"><span class="fa fa-trash"></span></button>
                      <button class="btn btn-small btn-secondary"><span class="fa fa-edit"></span></button>
                      </td>
                    <?php } ?>
                   </tr>
                   <?php $no++; } ?>
                   
                  </tbody>
                  <tr>
                     <th colspan="6">Jumla</th>
                     <th colspan="3">
                      <?php   
                       $totalquery = "SELECT sum(quantity * amount) FROM producttable";
                       $run = mysqli_query($conn, $totalquery);
                       for ($i=0; $cxz = mysqli_fetch_assoc($run); $i++) { 
                         $tmon = $cxz['sum(quantity * amount)'];
                         echo number_format($tmon).'<i>/= (Tsh)</i>';
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
    <form method="post">
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
              			<input type="number" name="productquantity" class="form-control" placeholder="Weka idadi ya bidhaa...">
              		</div>
              	</div>
              </p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Funga</button>
              <button name="addproduct" class="btn btn-primary">Ongeza</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      </form>

          <form method="post" enctype="multipart/form-data">
            <div class="modal fade" id="modal-lg-file">
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
                  <div class="col col-md-12">
                    <label>Weka File hapa (*SCV)</label>
                    <input type="file" name="file" class="form-control">
                  </div>
                </div>
              </p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Funga</button>
              <a href="include/file/file.csv" class="btn btn-warning" ><span class="fa fa-download"></span> Pakua sampuli ya file</a>
              <button name="fileadd" class="btn btn-primary">Ongeza</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      </form>
  </div>
  <!-- /.content-wrapper -->

 <?php 
include 'include/footer.php';
include 'include/script.php';
 ?>
Fatal error: Call to undefined function fgetscv() in E:\xampp\htdocs\SALES AND STOCKS\bidhaa.php on line 49