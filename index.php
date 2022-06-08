<?php

session_start();

include 'database/connection.php';

$error=null;

if (isset($_POST['login'])) {

	$uid = $_POST['uname'];
	$pwd = $_POST['pwd'];

	$stmt = $conn->prepare("SELECT * FROM usertable WHERE email =?");
	$stmt->bind_param("s", $username);

	$username = $uid;
	//$password = $pwd;  //utaeka kulingana na user wanologin
	$stmt->execute();

	$result = $stmt->get_result();
	$rownum = $result->num_rows;

	if ($rownum > 0) {
		if ($row = $result->fetch_assoc()) {
			// $_SESSION['uname'] = $row['email'];
			$checkpwd = password_verify($pwd, $row['pwd']);

			if ($checkpwd == true) {
        // $rolename = $row['role'];
        // if ($rolename == '') {
        //   // code...
        // }
			
			$_SESSION['uname'] = $row['email'];
			$_SESSION['id'] = $row['userid'];
		    header("Location: dashboard.php");
		    exit();
			}elseif ($checkpwd == false) {
				$error = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Nenosiri sio sahihi</div>';
			}
		    
		}
	}else{
		$error = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Taarifa zako sio sahihi</div>';
	}	
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sales and stock Management System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index2.html"><b>SALES AND STOCKS MANAGEMENT SYSTEM</b> (SSMS)</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">| PANELI YA KUINGILIA |</p>
      <?php echo $error; ?>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" name="uname" class="form-control" placeholder="Barua pepe (Email)" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="pwd" class="form-control" placeholder="Nenosiri" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button name="login" class="btn btn-primary btn-block">Ingia</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#">Umesahau nenosiri?</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
