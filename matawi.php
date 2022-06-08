<?php 
include 'include/header.php';
include 'include/nav.php';
 ?>

 <?php  
if (isset($_POST['addbranch'])) {
  $branchname = $_POST['branchname'];

  $query = mysqli_query($conn, "select * from branchtable where branchname = '$branchname'");
  if (mysqli_num_rows($query)>0) {
    $error = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-ban"></i> Taarifa!</h5>
                  Jina la tawi tayari lipo</div>';
  }else{
   
    $inserquery = "INSERT INTO branchtable VALUES ('', '$branchname')";
    $runinsertquery = mysqli_query($conn, $inserquery);
    $success = '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i> Taarifa!</h5>
                  Hongera! Taarifa zimepokelewa kikamilifu
                </div>';
  }
}
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><span class="fa fa-map-marker"></span> Matawi</h1>
            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Nyumbani</a></li>
              <li class="breadcrumb-item active">Matawi</li>
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
    <?php echo $error; echo $success; ?>

              <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Matawi yaliyopo</h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-md"> <span class="fa fa-plus"></span> Ongeza tawi</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S/no</th>
                    <th>Jina la tawi</th>
                    <th>Idadi ya wauzaji</th>
                    <th>Kitendo</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $queryselect = mysqli_query($conn, "select * from branchtable order by branchid desc");
                  $no = 1;
                  while ($data = mysqli_fetch_assoc($queryselect)) {
                    $selectpeople = mysqli_query($conn, "select * from usertable where branchid = '".$data['branchid']."'");
                   ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data['branchname'] ?></td>
                    <td><?php echo mysqli_num_rows($selectpeople); ?></td>
                    <td>
                      <button class="btn btn-small btn-danger"><span class="fa fa-trash"></span></button>
                      <button class="btn btn-small btn-secondary"><span class="fa fa-edit"></span></button>
                    </td>
                  </tr>
                  <?php $no++; } ?>
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>

        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <form method="post">
        <div class="modal fade" id="modal-md">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ongeza Tawi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>
              	<div class="row">
              		<div class="col col-md-12">
              			<label>Jina la Tawi</label>
              			<input type="text" name="branchname" class="form-control" placeholder="Weka jina la tawi...">
              		</div>
              	</div>
              </p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Funga</button>
              <button name="addbranch" class="btn btn-primary">Ongeza</button>
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