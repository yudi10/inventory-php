<?php 

include_once 'connectdb.php';

// if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
//     header('location:index.php');
//   }

$id =$_POST['pidd'];

// DELETE table 1 and table 2 FROM table 1 INNER JOIN table 2 ON table 1.key = table 2.key Where condition table 1.key=id
$sql = "DELETE tbl_invoice , tbl_invoice_detail FROM tbl_invoice INNER JOIN tbl_invoice_detail ON tbl_invoice.invoice_id = tbl_invoice_detail.invoice_id WHERE tbl_invoice.invoice_id=$id";
// $sql = "DELETE FROM tbl_product WHERE pid=$id";

$delete = $pdo->prepare($sql);

if($delete->execute()){

}else{
    echo 'Error in Deleting';
}


?>