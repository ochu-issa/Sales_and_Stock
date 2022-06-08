<?php 
include 'include/header.php';
include 'include/nav.php';
 ?>

 <?php 
$productdate = date('y/m/d');
$userid = $take_name['userid'];
// add to cart
if (isset($_POST['cartbtn'])) {

	$product = $_POST['product'];
	$quantity = $_POST['quantity'];

	$selcart = mysqli_query($conn, "select * from carttable where productid = '$product' and userid = '$userid'");

	$allselect = mysqli_query($conn, "select * from producttable where productid = '$product'");
	$hs = mysqli_fetch_assoc($allselect);
	$productname = $hs['productname'];
	$producttype = $hs['producttype'];
	$qtyty = $hs['quantity'];
	$productamount = $hs['amount'];
	$totalamount = $quantity * $productamount;

	if (mysqli_num_rows($selcart)>0) {
		$error = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-ban"></i> Taarifa!</h5>
              Bidhaa uliochagua tayari imewekwa kwenye mkokoteni. Ondoa kwenye mkokoteni kisha iweke tena</div>';
	}
	elseif ($quantity > $qtyty) {
		$error = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-ban"></i> Taarifa!</h5>
              Bidhaa uliochagua ipo chini ya idadi uliyoeka</div>';
	}
	else{
		

		$queryinsert = "INSERT INTO carttable VALUES ('', '$product', '$quantity', '$totalamount', '".$take_name['userid']."')";
		$run = mysqli_query($conn, $queryinsert);
		$newquantity = $qtyty - $quantity;
		$updt = mysqli_query($conn, "update producttable set quantity = '$newquantity' where productid = '$product'");

		$success = '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i> Taarifa!</h5>
                  Bidhaa imewekwa kwenye mkokoteni
                </div>';
	}
}

// remove on cart
if (isset($_POST['remove'])) {
	$proid =  $_POST['proid'];

	$selcart = mysqli_query($conn, "select * from carttable where productid = '$proid'");
	$tak = mysqli_fetch_assoc($selcart);
	$cartquantity = $tak['quantity'];

	$allselect = mysqli_query($conn, "select * from producttable where productid = '$proid'");
	$hs = mysqli_fetch_assoc($allselect);
	$qtyty = $hs['quantity'];
	$newvalue = $cartquantity + $qtyty;
	$updt = mysqli_query($conn, "update producttable set quantity = '$newvalue' where productid = '$proid'");
	$del = mysqli_query($conn, "delete from carttable where productid = '$proid'");
	//header("location: mauzo.php?success=deleted");
}

// Sell codes
if (isset($_POST['sell'])) {
	$customername = $_POST['customername'];
	$totalmoney = $_POST['totalmoney'];
	$discount = $_POST['discount'];
	$checkout = $_POST['checkout'];

	$finish = 2;
  	while ($finish != 1) {
      $ver = "INV-".date("dm-").rand(10000,99999);
      $finish = 1;
      }


	$selcustomer = mysqli_query($conn, "select * from customertable where fullname = '$customername'");
	$ti = mysqli_fetch_assoc($selcustomer);
	$idcut = $ti['customerid'];
	$allincart = mysqli_query($conn, "select * from carttable");
	while ($lt = mysqli_fetch_assoc($allincart)) {
				
		$proid = $lt['productid'];
		$amount = $lt['amount'];
		$quantity = $lt['quantity'];

	$inserto = "INSERT INTO selltable VALUES ('', '$idcut', '$proid', '$quantity', '$amount', '$discount', '$checkout', '$userid', '$productdate', '$ver')";
	$runq = mysqli_query($conn, $inserto);
	$delcart = mysqli_query($conn, "delete from carttable");
	$success = '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i> Taarifa!</h5>
                  Mauzo yenye namba <b>'.$ver.'</b> yamefanyika kikamilifu. bonyeza <a href="historiamauzo.php">hapa</a> kuprinti risiti.
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
            <h1 class="m-0 text-dark"><i class="fas fa-shopping-cart"></i> Fanya Mauzo</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Nyumbani</a></li>
              <li class="breadcrumb-item active">Mauzo</li>
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
                <h3 class="card-title">
                  <i class="fas fa-shopping-cart"></i>
                  Weka Kwenye Mkokoteni
                </h3>
              </div>
              <div class="card-body">
              	<form method="post">
              	<div class="row">
              		<div class="col col-md-6">
              		<select class="form-control select2" name="product">
                    <option selected disabled>-Chagua Bidhaa-</option>
                    <?php 
                    $user = $take_name['userid'];
              				$choosepro = mysqli_query($conn, "select * from producttable where quantity > 0 order by productid desc");
              				while ($pr = mysqli_fetch_assoc($choosepro)) {              		
              				?>
              				<option value="<?php echo $pr['productid']; ?>"><?php echo $pr['productname'].':  Aina => ['.$pr['producttype'].']:   Bei => ['.$pr['amount'].']'; ?></option>
              			<?php } ?>
                  	</select>
              		</div>
              		<div class="col-md-3">
              			<input type="number" min="0" placeholder="-Weka idadi-" name="quantity" class="form-control">
              		</div>
              		<div class="col col-md-3">
              			<button class="btn btn-primary btn-block" name="cartbtn"><span class="fas fa-shopping-cart"></span>  Ongeza kwenye mkokoteni</button>
              		</div>
              	</div>
              	</form>
              </div>
              <!-- /.card -->
            </div>
        <!-- /.row -->
              <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"><span class="fas fa-shopping-cart "></span> Ulivoviweka kwenye Mkokoteni</h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S/no</th>
                    <th>Jina la Bidhaa</th>
                    <th>Aina</th>
                    <th>Idadi</th>
                    <th>Bei</th>
                    <th>Jumla</th>
                    <th>Kitendo</th>
                  </tr>
                  </thead>
                  <tbody>
                  	<?php 
                  	$cartselect = mysqli_query($conn, "select * from carttable where userid = '$user' order by cartid desc");
                  	$no = 1;
                  	while ($tk = mysqli_fetch_assoc($cartselect)) {
                  		$idpro = $tk['productid'];
                  		$allproselect = mysqli_query($conn, "select * from producttable where productid = '$idpro'");
						$has = mysqli_fetch_assoc($allproselect);
						$nameproduct = $has['productname'];
						$typeproduct = $has['producttype'];
						$amountproduct = $has['amount'];
						?>
                  	 <tr>
                  	 	<td><?php echo $no ?></td>
                  	 	<td><?php echo $nameproduct; ?></td>
                  	 	<td><?php echo $typeproduct; ?></td>
                  	 	<td><?php echo $tk['quantity']; ?></td>
                  	 	<td><?php echo number_format($amountproduct); ?></td>
                  	 	<td><?php echo number_format($tk['amount']); ?></td>
                  	 	<td>
	                      <button class="btn btn-small btn-danger" data-toggle="modal" data-target="#modal-danger<?php echo $idpro; ?>"><span class="fa fa-trash"></span></button>
                    	</td>
                    	<!-- modal -->
                    	<div class="modal fade" id="modal-danger<?php echo $idpro; ?>">
				        <div class="modal-dialog">
				          <div class="modal-content bg-danger">
				            <div class="modal-header">
				              <h4 class="modal-title">Ondoa kwenye mkokoteni</h4>
				              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                <span aria-hidden="true">&times;</span>
				              </button>
				            </div>
				            <div class="modal-body">
				            <form method="post">
				            	<input type="hidden" name="proid" value="<?php echo $idpro; ?>">
				              <p>Bidhaa hii itaondolewa kwenye mkokoteni</p>
				            </div>
				            <div class="modal-footer justify-content-between">
				              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Funga</button>
				              <button name="remove" class="btn btn-outline-light">Ondoa</button>
				              </form>
				            </div>


				          </div>
				          <!-- /.modal-content -->
				        </div>
				        <!-- /.modal-dialog -->
				      </div>
      <!-- /.modal -->
                  	 </tr>
                  	 <?php $no++; } ?>
                  </tbody>
                 <tr>
                 	<th colspan="5">Jumla</th>
                 	<th colspan="2">
                 		<?php   
                       $totalquery = "SELECT sum(amount) FROM carttable";
                       $run = mysqli_query($conn, $totalquery);
                       for ($i=0; $cxz = mysqli_fetch_assoc($run); $i++) { 
                         $tmon = $cxz['sum(amount)'];
                         echo number_format($tmon).'<i>/= (Tsh)</i>';
                       }
                       ?>
                 	</th>
                 </tr>
                </table> <br>
                <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-md"><span class="fa fa-plus"></span> Fanya Mauzo</button>
              </div>
              <!-- /.card-body -->
            </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <form method="post"> 
    <div class="modal fade" id="modal-md">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Fanya Mauzo</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>
                <div class="row">
                  <div class="col col-md-4">
                	 <label>Mteja</label>
                  </div>
                  <div class="col col-md-8">
                    <select name="customername" class="form-control select2">
                    	<option>--</option>
                    	<?php 
                    	$querycus = mysqli_query($conn, "select * from customertable");
                    	while ($cu = mysqli_fetch_assoc($querycus)) {
                    	 ?>
                    	 <option><?php echo $cu['fullname']; ?></option>
                    	<?php } ?>
                    </select>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col col-md-4">
                	 <label>Jumla</label>
                  </div>
                  <div class="col col-md-8">
                  	<?php   
                       $totalquery = "SELECT sum(amount) FROM carttable";
                       $run = mysqli_query($conn, $totalquery);
                       for ($i=0; $cxz = mysqli_fetch_assoc($run); $i++) { 
                         $tmon2 = $cxz['sum(amount)'];
                       ?>
                     <input type="hidden" name="totalmoney" value="<?php echo $tmon2; ?>">
                    <input type="text"  class="form-control"  value="<?php echo number_format($tmon2).' /='; ?>" disabled>
                <?php } ?>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col col-md-4">
                	 <label>Punguzo/Discount</label>
                  </div>
                  <div class="col col-md-8">
                    <input type="number" min="0" name="discount" class="form-control" placeholder="Weka punguzo" required>
                  </div>
                </div><br>	
                <div class="row">
                  <div class="col col-md-4">
                	 <label>Kiasi alichotoa mteja</label>
                  </div>
                  <div class="col col-md-8">
                    <input type="number" min="0" name="checkout" class="form-control" placeholder="Weka kiasi alichotoa mteja" required>
                  </div>
                </div>
              </p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Funga</button>
              <button name="sell" class="btn btn-primary">Uza</button>
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