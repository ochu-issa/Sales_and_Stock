<?php
include 'connection.php'; 
/* include autoloader */
require_once 'dompdf/autoload.inc.php';


/* reference the Dompdf namespace */
use Dompdf\Dompdf;


/* instantiate and use the dompdf class */
$dompdf = new Dompdf();

$html = array();
array_push($html,'
		<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sales and Stock Management System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
		<body>
		
		');
			$sql = "SELECT * FROM user";
					$queryrun = mysqli_query($conn,$sql);
			while ( $data = mysqli_fetch_assoc($queryrun)) {
				array_push($html, 
					'<tr>
					     <td>'.$data['fname'].'</td>
                  <td>'.$data['mname'].'</td>
                  <td>'.$data['lname'].'</td>
                  <td>'.$data['address'].'</td>    
                  <td>'.$data['phone'].'</td>
                  <td>'.$data['username'].'</td>
                  <td>'.$data['password'].'</td>

					</tr>'
				);
			}

	array_push($html,'</table>
		</div>
		</body>
		</html>');

	



			$count = count($html);
            $html2 = "";
            for ($i = 0; $i<$count; $i++) {
            	$html2 = $html2 . $html[$i];
            }

$dompdf->loadHtml($html2);


/* Render the HTML as PDF */

$dompdf->setPaper('A4','landscape');
$dompdf->render();
/* Output the generated PDF to Browser */
$dompdf->stream();
?>