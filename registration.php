<?php 

include_once 'connectdb.php';

session_start();

if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    header('location:index.php');
  }

 include_once'header.php'; 

 error_reporting(0);

 $id = $_GET['id'];
 $delete = $pdo->prepare("DELETE FROM tbl_user WHERE userid=".$id);

 if($delete->execute()){
    echo '<script type="text/javascript">
    jQuery(function validation(){
      swal({
        title: "Good Job !!",
        text: "Deleted Successfull",
        icon: "success",
        button: "OK",
      });
    });
</script>';
 }
//  }else{
//     echo '<script type="text/javascript">
//     jQuery(function validation(){
//       swal({
//         title: "Error !!",
//         text: "Deleted Fail",
//         icon: "error",
//         button: "OK",
//       });
//     });
// </script>';
//  }


if(isset($_POST['btnsave'])){
    $username = $_POST['txtname'];
    $useremail = $_POST['txtemail'];
    $password = $_POST['txtpassword'];
    $userrole = $_POST['txtselect_option'];

    // echo $username ."-".$useremail."-".$password."-".$userrole;

    if(isset($_POST['txtemail'])){
        $select = $pdo->prepare("SELECT useremail FROM tbl_user WHERE useremail='$useremail'");
        $select->execute();

        if($select->rowCount() > 0){
            echo '<script type="text/javascript">
                jQuery(function validation(){
                  swal({
                    title: "Warning !!",
                    text: "Email Already Exist",
                    icon: "warning",
                    button: "OK",
                  });
                });
            </script>';
        }else{
            
            $insert = $pdo->prepare("INSERT INTO tbl_user(username,useremail,password,role) values(:name,:email,:pass,:role)");

            $insert->bindParam(':name',$username);
            $insert->bindParam(':email',$useremail);
            $insert->bindParam(':pass',$password);
            $insert->bindParam(':role',$userrole);

            if($insert->execute()){
                echo '<script type="text/javascript">
                jQuery(function validation(){
                  swal({
                    title: "Good Job !!",
                    text: "Registration Successfull",
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
                    text: "Registration Fail",
                    icon: "error",
                    button: "OK",
                  });
                });
            </script>';
            }
        }
    }

    

}

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Registration
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Registration Form</h3>
        </div>
    <!-- /.box-header -->
    <!-- form start -->
        <form role="form" action="" method="POST">
            <div class="box-body">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="txtname" placeholder="Enter Name" required>
                    </div>

                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" class="form-control" name="txtemail" placeholder="Enter email" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="txtpassword" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="txtselect_option" required>
                            <option value="" disabled selected>Select Role</option>
                            <option>User</option>
                            <option>Admin</option>
                        </select>
                    </div>

                    <button type="submit" name="btnsave" class="btn btn-info">Save</button>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $select = $pdo->prepare("SELECT * FROM tbl_user ORDER BY userid desc");

                                $select->execute();

                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    echo '
                                        <tr>
                                            <td>'.$row->userid.'</td>
                                            <td>'.$row->username.'</td>
                                            <td>'.$row->useremail.'</td>
                                            <td>'.$row->password.'</td>
                                            <td>'.$row->role.'</td>
                                            <td>
                                                <a href="registration.php?id='.$row->userid.'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" title="delete"></span></a>
                                            </td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
           
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