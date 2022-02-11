<?php 
include_once 'connectdb.php';

session_start();

if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    header('location:index.php');
  }

 include_once'header.php'; 

 $id = $_GET['id'];

 $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
 $select->execute();

 $row = $select->fetch(PDO::FETCH_ASSOC);
 
 $id_db = $row['pid'];
 $productnam_db = $row['pname'];
 $category_db = $row['pcategory'];
 $purchaseprice_db = $row['purchaseprice'];
 $saleprice_db = $row['saleprice'];
 $stock_db = $row['pstock'];
 $description_db = $row['pdescription'];
 $productimage_db = $row['pimage'];

//  update data in to database
if(isset($_POST['btnupdate'])){

   $productname_txt   = $_POST['txtpname'];
   $category_txt      = $_POST['txtselect_option'];
   $purchaseprice_txt = $_POST['txtpprice'];
   $saleprice_txt     = $_POST['txtsaleprice'];
   $stock_txt         = $_POST['txtstock'];
   $description_txt   = $_POST['txtdescription'];

   $f_name = $_FILES['myfile']['name'];

   if(!empty($f_name)){

   $f_tmp  = $_FILES['myfile']['tmp_name'];
   $f_size = $_FILES['myfile']['size'];
   $f_extension = explode('.',$f_name);
   $f_extension = strtolower(end($f_extension));
   $f_newfile   = uniqid().'.'. $f_extension;
   $store       = "productimages/".$f_newfile;

   if($f_extension == 'jpg' || $f_extension == 'jpeg' || $f_extension == 'png' || $f_extension == 'gif'){
     if($f_size>=1000000){
       $error ='<script type="text/javascript">
       jQuery(function validation(){
         swal({
           title: "Error !!",
           text: "Max File should 1MB",
           icon: "warning",
           button: "OK",
         });
       });
   </script>';
   echo $error;
     }else{
       if(move_uploaded_file($f_tmp,$store)){
        $f_newfile;

         if(!isset($errorr)){
            $update = $pdo->prepare("UPDATE tbl_product SET pname=:pname, pcategory=:pcategory, purchaseprice=:pprice, saleprice=:saleprice, pstock=:pstock, pdescription=:pdescription, pimage=:pimage WHERE pid = $id");

            $update->bindParam(':pname',$productname_txt);
            $update->bindParam(':pcategory',$category_txt);
            $update->bindParam(':pprice',$purchaseprice_txt);
            $update->bindParam(':saleprice',$saleprice_txt);
            $update->bindParam(':pstock',$stock_txt);
            $update->bindParam(':pdescription',$description_txt);
            $update->bindParam(':pimage',$f_newfile);
     
          if($update->execute()){
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "success !!",
                text: "Update Product Success",
                icon: "success",
                button: "OK",
              });
            });
        </script>';
          }else{
           echo '<script type="text/javascript">
           jQuery(function validation(){
             swal({
               title: "error !!",
               text: "Update Product Fail",
               icon: "error",
               button: "OK",
             });
           });
       </script>';
          }
        }
       }
     }
   }else{
    $error ='<script type="text/javascript">
       jQuery(function validation(){
         swal({
           title: "warning !!",
           text: "only jpg png and gif can be upload",
           icon: "error",
           button: "OK",
         });
       });
   </script>';
   echo $error;
   }

   }else{

        $update = $pdo->prepare("UPDATE tbl_product SET pname=:pname, pcategory=:pcategory, purchaseprice=:pprice, saleprice=:saleprice, pstock=:pstock, pdescription=:pdescription, pimage=:pimage WHERE pid = $id");

        $update->bindParam(':pname',$productname_txt);
        $update->bindParam(':pcategory',$category_txt);
        $update->bindParam(':pprice',$purchaseprice_txt);
        $update->bindParam(':saleprice',$saleprice_txt);
        $update->bindParam(':pstock',$stock_txt);
        $update->bindParam(':pdescription',$description_txt);
        $update->bindParam(':pimage',$productimage_db);

        if($update->execute()){
            $error ='<script type="text/javascript">
                    jQuery(function validation(){
                        swal({
                        title: "Update Product Success",
                        text: "Update",
                        icon: "success",
                        button: "OK",
                        });
                    });
                </script>';
   echo $error;
        }else{
            $error ='<script type="text/javascript">
                    jQuery(function validation(){
                        swal({
                        title: "Error !!",
                        text: "Update Fail",
                        icon: "error",
                        button: "OK",
                        });
                    });
                </script>';
   echo $error;
        }

   }
}


$select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
 $select->execute();

 $row = $select->fetch(PDO::FETCH_ASSOC);
 
 $id_db = $row['pid'];
 $productnam_db = $row['pname'];
 $category_db = $row['pcategory'];
 $purchaseprice_db = $row['purchaseprice'];
 $saleprice_db = $row['saleprice'];
 $stock_db = $row['pstock'];
 $description_db = $row['pdescription'];
 $productimage_db = $row['pimage'];

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Form Update Product</h3>
            </div>
    <!-- /.box-header -->
    <!-- form start -->
            <form action="" method="post" name="formproduct" enctype="multipart/form-data"> 
                <div class="box-body">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="txtpname" class="form-control" value="<?= $productnam_db; ?>" placeholder="Enter Name Product" required>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select name="txtselect_option" class="form-control" required>
                            <option value="" disabled selected>Select Category</option>
                                <?php 
                                $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY catid DESC");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                    extract($row);
                                    ?>
                                <option <?php if($row['category']==$category_db) { ?> selected="selected" <?php  } ?> ><?php echo $row['category']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Purchase Price</label>
                            <input type="number" min="1" step="1" class="form-control" value="<?= $purchaseprice_db; ?>" name="txtpprice" placeholder="Enter Purchase Price" required>
                        </div>

                        <div class="form-group">
                            <label>Sale Price</label>
                            <input type="number" min="1" step="1" class="form-control" value="<?= $saleprice_db; ?>" name="txtsaleprice" placeholder="Enter Sale Price" required>
                        </div>

                        </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" min="1" step="1" class="form-control" value="<?= $stock_db; ?>" name="txtstock" placeholder="Enter Stock" required>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="txtdescription" class="form-control" rows="4"><?= $description_db; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Product Image</label>
                            <img src="productimages/<?= $productimage_db; ?>" class="img-responsive" width="50px" height="50px" /><br>
                            <input type="file" class="input-group" name="myfile">
                            <p>Upload Image</p>
                        </div>

                    </div>

                </div>

                <div class="box-footer">
            
                    <button type="submit" class="btn btn-info" name="btnupdate">Update</button>
            
                </div>
            </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php 
    include_once'footer.php';
?>