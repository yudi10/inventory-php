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
        Admin Dashboard
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
                <h3 class="box-title">Order List</h3>
            </div>
            <!-- <form action="" method="post" name=""> -->
    <!-- /.box-header -->
    <!-- form start -->
                <div class="box-body">

                <div style="overflow-x:auto;">
                <table id="orderlisttable" class="table table-striped" >
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Payment Type</th>
                            <th>Print</th>
                            
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php     

                        $select = $pdo->prepare("SELECT * FROM tbl_invoice ORDER BY invoice_id DESC");

                        $select->execute();

                        while($row = $select->fetch(PDO::FETCH_OBJ)){
                            echo '<tr>
                                    <td>'.$row->invoice_id.'</td>
                                    <td>'.$row->customer_name.'</td>
                                    <td>'.$row->order_date.'</td>
                                    <td>'.$row->total.'</td>
                                    <td>'.$row->paid.'</td>
                                    <td>'.$row->due.'</td>
                                    <td>'.$row->payment_type.'</td>
                                    
                                    <td>
                                        <a href="invoice.php?id='.$row->invoice_id.'" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-print" style="color:#ffffff" data-toggle="tooltip" title="print invoice"></span></a>
                                    </td>
                                    <td>
                                        <a href="editorder.php?id='.$row->invoice_id.'" class="btn btn-warning" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="edit order"></span></a>
                                    </td>
                                    <td>
                                        <button id='.$row->invoice_id.' class="btn btn-danger btndelete" role="button"><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete order"></span></button>
                                    </td>
                            
                            </tr>';
                        }

                    ?>
                    </tbody>
                </table>
              </div>

                </div>

            <!-- </form> -->
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    $(document).ready( function () {
        $('#orderlisttable').DataTable({
            "order":[[0,"DESC"]]
        });
    } );
  </script>

<script>
    $(document).ready( function () {
        $('[data-toggle="tooltip"]').tooltip();
    } );


    $(document).ready(function(){

    $('.btndelete').click(function(){
      
        var tdh = $(this);
        var id = $(this).attr("id");

        swal({
              title:"Are you sure?",
              text:"Once deleted, you will not be able to recover this Order!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if(willDelete){

                $.ajax({
                    url: 'orderdelete.php',
                    type: 'post',
                    data:{
                      pidd:id
                    },
                    success: function(data){
                      tdh.parents('tr').hide();
                    }
                  });

                swal("Your order has been deleted!", {
                    icon: "success",
                });
              }else{
                swal("Your order is safe!");
              }
            });

        

    });

});

  </script>

<?php 
    include_once'footer.php';
?>