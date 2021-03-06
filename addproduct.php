<?php 

include_once 'connectdb.php';

session_start();

if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
  header('location:index.php');
}

 include_once'header.php';
 
 if (isset($_POST['btnaddproduct'])) {
   $productname   = $_POST['txtpname'];
   $category      = $_POST['txtselect_option'];
   $purchaseprice = $_POST['txtpprice'];
   $saleprice     = $_POST['txtsaleprice'];
   $stock         = $_POST['txtstock'];
   $description   = $_POST['txtdescription'];

  //  upload image
   $f_name = $_FILES['myfile']['name'];
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
         $productimage = $f_newfile;

         if(!isset($errorr)){
          $insert = $pdo->prepare("INSERT INTO tbl_product(pname,pcategory,purchaseprice,saleprice,pstock,pdescription,pimage) VALUES(:pname,:pcategory,:purchaseprice,:saleprice,:pstock,:pdescription,:pimage)");
     
          $insert->bindParam(':pname',$productname);
          $insert->bindParam(':pcategory',$category);
          $insert->bindParam(':purchaseprice',$purchaseprice);
          $insert->bindParam(':saleprice',$saleprice);
          $insert->bindParam(':pstock',$stock);
          $insert->bindParam(':pdescription',$description);
          $insert->bindParam(':pimage',$productimage);
     
          if($insert->execute()){
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "success !!",
                text: "Add Product Success",
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
               text: "Add Product Fail",
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

 }
 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Product
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
          <h3 class="box-title"><a href="productlist.php" class="btn btn-warning" role="button">Product List</a></h3>
        </div>

        <form action="" method="post" name="formproduct" enctype="multipart/form-data">
        <div class="box-body">

            <div class="col-md-6">

              <div class="form-group">
                <label>Name</label>
                <input type="text" name="txtpname" class="form-control" placeholder="Enter Name Product" required>
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
                      <option><?php echo $row['category']; ?></option>
                      <?php
                      }
                    ?>
                </select>
              </div>

              <div class="form-group">
                <label>Purchase Price</label>
                <input type="number" min="1" step="1" class="form-control" name="txtpprice" placeholder="Enter Purchase Price" required>
              </div>

              <div class="form-group">
                <label>Sale Price</label>
                <input type="number" min="1" step="1" class="form-control" name="txtsaleprice" placeholder="Enter Sale Price" required>
              </div>
            
            </div>

            <div class="col-md-6">

              <div class="form-group">
                <label>Stock</label>
                <input type="number" min="1" step="1" class="form-control" name="txtstock" placeholder="Enter Stock" required>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea name="txtdescription" class="form-control" rows="4"></textarea>
              </div>

              <div class="form-group">
                <label>Product Image</label>
                <input type="file" class="input-group" name="myfile" required>
                <p>Upload Image</p>
              </div>

            </div>
            
          </div>
          
          <div class="box-footer">
            
            <button type="submit" class="btn btn-info" name="btnaddproduct">Save</button>
            
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