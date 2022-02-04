<?php 

include_once 'connectdb.php';

session_start();

if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
  header('location:index.php');
}

 include_once'header.php'; 

 if(isset($_POST['btnsave'])){
     $category = $_POST['txtcategory'];

     if(empty($category)){
         $error ='<script type="text/javascript">
         jQuery(function validation(){
           swal({
             title: "Feild is empty",
             text: "please fill Feild",
             icon: "error",
             button: "OK",
           });
         });
     </script>';

     echo $error;

     }

     if(!isset($error)){
         $insert = $pdo->prepare("INSERT INTO tbl_category(category) VALUES(:category)");

         $insert->bindParam(':category',$category);

         if($insert->execute()){
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Good Job !!",
                text: "Inser Category Successfull",
                icon: "success",
                button: "OK",
              });
            });
        </script>';
         }else{
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Error !!",
                text: "Query Fail",
                icon: "error",
                button: "OK",
              });
            });
        </script>';
         }
     }
 } // end btn insert

//  star btn update
if(isset($_POST['btnupdate'])){
    $category = $_POST['txtcategory'];
    $id = $_POST['txtid'];

    if(empty($category)){
        $errorupdate = '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Feild is empty",
            text: "please fill Feild",
            icon: "error",
            button: "OK",
          });
        });
    </script>';

    echo $errorupdate;
    }

    if(!isset($errorupdate)){
        $update = $pdo->prepare("UPDATE tbl_category SET category=:category WHERE catid=".$id);
        $update->bindParam(':category',$category);

        if($update->execute()){
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Good Job !!",
                text: "Update Category Successfull",
                icon: "success",
                button: "OK",
              });
            });
        </script>';
        }else{
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Error !!",
                text: "Query Fail",
                icon: "error",
                button: "OK",
              });
            });
        </script>';
        }
    }
} // end btn update

if(isset($_POST['btndelete'])){
    $delete = $pdo->prepare("DELETE FROM tbl_category WHERE catid=".$_POST['btndelete']);

    if($delete->execute()){
        echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Good Job !!",
                text: "Delete Category Successfull",
                icon: "success",
                button: "OK",
              });
            });
        </script>';
    }else{
        echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Error !!",
                text: "Query Fail",
                icon: "error",
                button: "OK",
              });
            });
        </script>';
    }
}

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category
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
            <h3 class="box-title">Category Form</h3>
        </div>
    <!-- /.box-header -->
    <!-- form start -->
        <div class="box-body">
            <form role="form" action="" method="POST">

            <?php 
                if(isset($_POST['btnedit'])){
                    
                    $select = $pdo->prepare("SELECT * FROM tbl_category WHERE catid=".$_POST['btnedit']);
                    $select->execute();
                    if($select){
                        $row = $select->fetch(PDO::FETCH_OBJ);
                        echo '<div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <input type="hidden" class="form-control" name="txtid" value="'.$row->catid.'" placeholder="Enter Category">
                            <input type="text" class="form-control" name="txtcategory" value="'.$row->category.'" placeholder="Enter Category">
                        </div>


                        <button type="submit" name="btnupdate" class="btn btn-warning">Update</button>
                      </div>';
                    }

                }else{
                    echo '<div class="col-md-4">
                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" class="form-control" name="txtcategory" placeholder="Enter Category">
                            </div>


                            <button type="submit" name="btnsave" class="btn btn-info">Save</button>
                          </div>';
                }
            ?>


                

                <div class="col-md-8">
                    <table id="tableCategory" class="table table-striped" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php     

                            $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY catid DESC");

                            $select->execute();

                            while($row = $select->fetch(PDO::FETCH_OBJ)){
                                echo '<tr>
                                        <td>'.$row->catid.'</td>
                                        <td>'.$row->category.'</td>
                                        <td>
                                            <button type="submit" value="'.$row->catid.'" name="btnedit" class="btn btn-warning">Edit</button>
                                        </td>
                                        <td>
                                        <button type="submit" value="'.$row->catid.'" name="btndelete" class="btn btn-danger">Delete</button>
                                        </td>
                                
                                </tr>';
                            }

                        ?>
                        </tbody>
                    </table>
                </div>
                
            </form> 
        </div>
            <!-- /.box-body -->

            <div class="box-footer">
           
            </div>
    </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    $(document).ready( function () {
        $('#tableCategory').DataTable();
    } );
  </script>

<?php 
    include_once'footer.php';
?>