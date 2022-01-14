<?php 

try{
    
    $pdo = new PDO('mysql:host=localhost;dbname=pos_db','root','');
    // echo 'Connection Success';
}catch(PDOException $f){
    echo $f->getMessage();
}



?>