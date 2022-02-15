<?php 

include_once 'connectdb.php';

// session_start();

$id = $_GET["id"];

$select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid = :ppid");
$select->bindParam(":ppid",$id);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$respone = $row;

header('Content-Type: application/json');

echo json_encode($respone);


?>