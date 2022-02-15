<?php 

include_once 'connectdb.php';

session_start();

function fill_product($pdo){
    $output='';

    $select = $pdo->prepare("SELECT * FROM tbl_product ORDER BY pname ASC");
    $select->execute();

    $result = $select->fetchAll();
    foreach($result as $row){
        $output.='<option value="'.$row["pid"].'">'.$row["pname"].'</option>';
    }
    return $output;
}


 include_once'header.php'; 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Create Order
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
            <form action="" method="post" name="">
                <div class="box-header with-border">
                    <h3 class="box-title">New Order</h3>
                </div>
        <!-- /.box-header -->
        <!-- form start -->
                <div class="box-body">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Customer Name</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" name="txtcustomer" placeholder="Enter Customer Name" required>
                                </div>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Date:</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                            <input type="text" class="form-control pull-right" id="datepicker">
                            </div>
                            <!-- /.input group -->
                        </div>

                    </div>

                </div>

                <div class="box-body">
                    <div class="col-md-12">
                        <div style="overflow-x:auto;">
                        <table id="producttable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product name</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Enter Quantity</th>
                                    <th>Total</th>
                                    <th>
                                        <center><button type="button" name="add" class="btn btn-info btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button></center>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>SubTotal</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-usd"></i>
                                    </div>
                                    <input type="text" class="form-control" name="txtsubtotal" id="txtsubtotal" required>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Tax (10%)</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <input type="text" class="form-control" name="txttax" id="txttax" required>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Discount</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <input type="text" class="form-control" name="txtdiscount" id="txtdiscount" required>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <input type="text" class="form-control" name="txttotal" id="txttotal" required>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Paid</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <input type="text" class="form-control" name="txtpaid" id="txtpaid" required>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Due</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <input type="text" class="form-control" name="txtdue" id="txtdue" required>
                                </div>
                        </div>
                        <br>
                         <!-- radio -->
                        <label>Payment Method</label>
                        <div class="form-group">
                            <label>
                                <input type="radio" name="r1" class="minimal-red" checked>Cash
                            </label>
                            <label>
                                <input type="radio" name="r1" class="minimal-red">Card
                            </label>
                            <label>
                                <input type="radio" name="r1" class="minimal-red">Check
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <div align="center">
                    <input type="text" name="btnsaveorder" value="Save Order" class="btn btn-info">
                </div>
                <hr>
            </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })

    $(document).ready(function(){
        $(document).on('click','.btnadd',function(){
            var html='';
            html+='<tr>';
            html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
            html+='<td><select class="form-control productid" name="productid[]" style="width: 200px";><option value="">Select Option</option><?= fill_product($pdo); ?></select></td>';

            html+='<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
            html+='<td><input type="text" class="form-control price" name="price[]" readonly></td>';
            html+='<td><input type="number" min="1" class="form-control qty" name="qty[]" ></td>';
            html+='<td><input type="text" class="form-control total" name="total[]" readonly></td>';
            html+='<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button></center></td>';
            $('#producttable').append(html);

            //Initialize Select2 Elements
            $('.productid').select2()

            $(".productid").on('change', function(e){
                var productid = this.value;
                var tr=$(this).parent().parent();

                $.ajax({
                    url:"getproduct.php",
                    method:"get",
                    data:{id:productid},
                    success:function(data){

                        // console.log(data);
                        tr.find(".stock").val(data["pstock"]);
                        tr.find(".price").val(data["saleprice"]);
                        tr.find(".qty").val(1);
                        tr.find(".total").val( tr.find(".qty").val() * tr.find(".price").val() );
                        calculate(0,0);
                    }
                })
            })
        })

        $(document).on('click','.btnremove',function(){
            $(this).closest('tr').remove();
            calculate(0,0);
            $("#txtpaid").val(0);
        })

        $("#producttable").delegate(".qty","keyup change", function(){

            var quantity = $(this);
            var tr=$(this).parent().parent();

            if( (quantity.val()-0)>(tr.find(".stock").val()-0) ){

                swal("WARNING!","Sorry the much of quantity is not available","warning");
                quantity.val(1);
                tr.find(".total").val(quantity.val() * tr.find(".price").val());
                calculate(0,0);
            }else{
                tr.find(".total").val(quantity.val() * tr.find(".price").val());
                calculate(0,0);
            }

        })

        function calculate(dis,paid){
            var subtotal = 0;
            var tax = 0;
            var discount = dis;
            var net_total = 0;
            var paid_amt = paid;
            var due = 0;

            $(".total").each(function(){
                subtotal = subtotal+($(this).val()*1);
            })
            tax = 0.1*subtotal;
            net_total = tax+subtotal;
            net_total = net_total-discount;
            due = net_total-paid_amt;

            $("#txtsubtotal").val(subtotal.toFixed(0));
            $("#txttax").val(tax.toFixed(0));
            $("#txttotal").val(net_total.toFixed(0));
            $("#txtdiscount").val(discount);
            $("#txtdue").val(due.toFixed(0));
        }

        $("#txtdiscount").keyup(function(){
            var discount = $(this).val();
            calculate(discount,0);
        })

        $("#txtpaid").keyup(function(){
            var paid = $(this).val();
            var discount = $("#txtdiscount").val();
            calculate(discount,paid);
        })

    });

  </script>

<?php 
    include_once'footer.php';
?>