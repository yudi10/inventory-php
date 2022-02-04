<?php 
include_once 'connectdb.php';

session_start();

 include_once'header.php'; 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Product
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
                <h3 class="box-title">View Product</h3>
            </div>
    <!-- /.box-header -->
    <!-- form start -->
            <div class="box-body">

                <?php 

                    $id = $_GET['id'];

                    $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
                    $select->execute();

                    while($row = $select->fetch(PDO::FETCH_OBJ)){
                        echo '
                            <div class="col-md-6">
                                <ul class="list-group">
                                <center><p class="list-group-item list-group-item-success"><b>Product Detail</b></p></center>
                                    <li class="list-group-item">ID <span class="badge">'.$row->pid.'</span></li>
                                    <li class="list-group-item">Product Name <span class="label label-info pull-right">'.$row->pname.'</span></li>
                                    <li class="list-group-item">Product Category <span class="label label-info pull-right">'.$row->pcategory.'</span></li>
                                    <li class="list-group-item">Purchase Price <span class="label label-info pull-right">'.$row->purchaseprice.'</span></li>
                                    <li class="list-group-item">Sales Price <span class="label label-info pull-right">'.$row->saleprice.'</span></li>
                                    <li class="list-group-item">Stock <span class="label label-info pull-right">'.$row->pstock.'</span></li>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <ul class="list-group">
                                <center><p class="list-group-item list-group-item-success"><b>Product Image</b></p></center>
                                    <li class="list-group-item"></li>
                                    <li class="list-group-item"></li>
                                    <li class="list-group-item"></li>
                                </ul>
                            </div>
                        ';
                    }
                
                ?>

            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php 
    include_once'footer.php';
?>