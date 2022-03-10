<?php 

include_once 'connectdb.php';

session_start();

if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    header('location:index.php');
  }

function fill_product($pdo,$pid){
    $output='';

    $select = $pdo->prepare("SELECT * FROM tbl_product ORDER BY pname ASC");
    $select->execute();

    $result = $select->fetchAll();
    foreach($result as $row){
        $output.='<option value="'.$row["pid"].'"';
        if($pid==$row['pid']){
            $output.='selected';
        }
        $output.='>'.$row["pname"].'</option>';
    }
    return $output;
}

// edit data order
$id = $_GET['id'];
$select = $pdo->prepare("SELECT * FROM tbl_invoice WHERE invoice_id = $id");
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

    $customer_name = $row['customer_name'];
    $order_date = date('Y-m-d', strtotime($row['order_date']));
    $subtotal = $row["subtotal"];
    $tax = $row['tax'];
    $discount = $row['discount'];
    $total = $row['total'];
    $paid = $row['paid'];
    $due = $row['due'];
    $payment_type = $row['payment_type'];


    $select = $pdo->prepare("SELECT * FROM tbl_invoice_detail WHERE invoice_id = $id");
    $select->execute();
    $row_invoice_detail = $select->fetchAll(PDO::FETCH_ASSOC);


if(isset($_POST['btnupdateorder'])){

    // Steps for btnupdateorder button

    // - Get values from text feilds and from array in variable
    $txt_customer_name = $_POST['txtcustomer'];
    $txt_order_date = date('Y-m-d', strtotime($_POST['orderdate']));
    $txt_subtotal = $_POST["txtsubtotal"];
    $txt_tax = $_POST['txttax'];
    $txt_discount = $_POST['txtdiscount'];
    $txt_total = $_POST['txttotal'];
    $txt_paid = $_POST['txtpaid'];
    $txt_due = $_POST['txtdue'];
    $txt_payment_type = $_POST['rb'];
    // 

    $arr_productid = $_POST['productid'];
    $arr_productname = $_POST['productname'];
    $arr_stock = $_POST['stock'];
    $arr_qty = $_POST['qty'];
    $arr_price = $_POST['price'];
    $arr_total = $_POST['total'];

    // - Write update query for tbl_product stock
    foreach($row_invoice_detail as $item_invoice_detail){
        $updateproduct = $pdo->prepare("UPDATE tbl_product SET pstock=pstock+".$item_invoice_detail['qty']." WHERE pid='".$item_invoice_detail['product_id']."'");

        $updateproduct->execute();
    }

    // - write delete query for tbl_invoice_detail table data where invoice_id =$id
    $delete_invoice_detail = $pdo->prepare("DELETE FROM tbl_invoice_detail WHERE invoice_id=$id");
    
    $delete_invoice_detail->execute();


    // write update query for tbl_invoice table data
    $upate_invoice = $pdo->prepare("UPDATE tbl_invoice SET customer_name=:cust,order_date=:orderdate,subtotal=:stotal,tax=:tax,discount=:disc,total=:total,paid=:paid,due=:due,payment_type=:ptype WHERE invoice_id=$id");

    $upate_invoice->bindParam(':cust',$txt_customer_name);
    $upate_invoice->bindParam(':orderdate',$txt_order_date);
    $upate_invoice->bindParam(':stotal',$txt_subtotal);
    $upate_invoice->bindParam(':tax',$txt_tax);
    $upate_invoice->bindParam(':disc',$txt_discount);
    $upate_invoice->bindParam(':total',$txt_total);
    $upate_invoice->bindParam(':paid',$txt_paid);
    $upate_invoice->bindParam(':due',$txt_due);
    $upate_invoice->bindParam(':ptype',$txt_payment_type);

    $upate_invoice->execute();

    // insert to tbl_invoice_detail
    $invoice_id = $pdo->lastInsertId();
    if($invoice_id!=null){
        for($i=0 ; $i<count($arr_productid) ; $i++){

            // - write select query for tbl_product table to get out stock value
            $selectpdt = $pdo->prepare("SELECT * FROM tbl_product WHERE pid='".$arr_productid[$i]."'");
            $selectpdt->execute();

            while($rowpdt = $selectpdt->fetch(PDO::FETCH_OBJ)){

                    $db_stock[$i] = $rowpdt->pstock;

                $rem_qty = $db_stock[$i]-$arr_qty[$i]; 
                    if($rem_qty<0){
                        return "Order Is Not Complate";
                    }else{

                        // write update query for tbl_product table to update stock values
                $update = $pdo->prepare("UPDATE tbl_product SET pstock ='$rem_qty' WHERE pid='".$arr_productid[$i]."'");
                $update->execute();
                }
            }

            
            // write insert query for tbl_invoice_detail for insert new records
            $insert=$pdo->prepare("INSERT INTO tbl_invoice_detail(invoice_id,product_id,product_name,qty,price,order_date) VALUES(:invid,:pid,:pname,:qty,:price,:orderdate)");

            $insert->bindParam(':invid',$id);
            $insert->bindParam(':pid',$arr_productid[$i]);
            $insert->bindParam(':pname',$arr_productname[$i]);
            $insert->bindParam(':qty',$arr_qty[$i]);
            $insert->bindParam(':price',$arr_price[$i]);
            $insert->bindParam(':orderdate',$txt_order_date);

            $insert->execute();

            
        }

        // echo "SUccess Create data order";

        header('location:orderlist.php');
    }


    
    }


 include_once'header.php'; 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Edit Order
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
                    <h3 class="box-title">Edit Order</h3>
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
                                    <input type="text" class="form-control" name="txtcustomer" value="<?= $customer_name; ?>" required>
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
                            <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?= $order_date; ?>">
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
                            <?php 

                                foreach($row_invoice_detail as $item_invoice_detail){
                                    $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid = '{$item_invoice_detail['product_id']}'");
                                    $select->execute();
                                    $row_product = $select->fetch(PDO::FETCH_ASSOC); 
                                    
                            ?>
                            <tr>
                                <?php 

                                    echo '<td><input type="hidden" class="form-control pname" name="productname[]" value="'.$row_product['pname'].'" readonly></td>';
                                    echo '<td><select class="form-control productidedit" name="productid[]" style="width: 200px";><option value="">Select Option</option> '.fill_product($pdo, $item_invoice_detail['product_id']).' </select></td>';

                                    echo '<td><input type="text" class="form-control stock" name="stock[]" value="'.$row_product['pstock'].'" readonly></td>';
                                    echo '<td><input type="text" class="form-control price" name="price[]" value="'.$row_product['saleprice'].'" readonly></td>';
                                    echo '<td><input type="number" min="1" class="form-control qty" value="'.$item_invoice_detail['qty'].'" name="qty[]" ></td>';
                                    echo '<td><input type="text" class="form-control total" name="total[]" value="'.$row_product['saleprice']*$item_invoice_detail['qty'].'" readonly></td>';
                                    echo '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button></center></td>';

                                ?>
                            </tr>
                            <?php } ?>
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
                                    <input type="text" class="form-control" name="txtsubtotal" id="txtsubtotal" value="<?= $subtotal; ?>" required readonly>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Tax (10%)</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <input type="text" class="form-control" name="txttax" id="txttax" value="<?= $tax; ?>" required readonly>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Discount</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <input type="text" class="form-control" name="txtdiscount" id="txtdiscount" value="<?= $discount; ?>" required>
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
                                <input type="text" class="form-control" name="txttotal" id="txttotal" value="<?= $total; ?>" required readonly>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Paid</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <input type="text" class="form-control" name="txtpaid" id="txtpaid" value="<?= $paid; ?>" required>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Due</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <input type="text" class="form-control" name="txtdue" id="txtdue" value="<?= $due; ?>" required readonly>
                                </div>
                        </div>
                        <br>
                         <!-- radio -->
                        <label>Payment Method</label>
                        <div class="form-group">
                            <label>
                                <input type="radio" name="rb" class="minimal-red" value="Cash"<?php echo($payment_type=='Cash')?'checked':'' ?>>Cash
                            </label>
                            <label>
                                <input type="radio" name="rb" class="minimal-red" value="Card"<?php echo($payment_type=='Card')?'checked':'' ?>>Card
                            </label>
                            <label>
                                <input type="radio" name="rb" class="minimal-red" value="Check"<?php echo($payment_type=='Check')?'checked':'' ?>>Check
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <div align="center">
                    <input type="submit" name="btnupdateorder" value="UpdateOrder" class="btn btn-info">
                    <!-- <button type="submit" class="btn btn-info" name="btnsaveorder">SaveOrder</button> -->
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

        $('.productidedit').select2()

            $(".productidedit").on('change', function(e){
                var productid = this.value;
                var tr=$(this).parent().parent();

                $.ajax({
                    url:"getproduct.php",
                    method:"get",
                    data:{id:productid},
                    success:function(data){

                        // console.log(data);
                        tr.find(".pname").val(data["pname"]);
                        tr.find(".stock").val(data["pstock"]);
                        tr.find(".price").val(data["saleprice"]);
                        tr.find(".qty").val(1);
                        tr.find(".total").val( tr.find(".qty").val() * tr.find(".price").val() );
                        calculate(0,0);
                        $("#txtpaid").val("");
                    }
                })
            })


        $(document).on('click','.btnadd',function(){
            var html='';
            html+='<tr>';
            html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
            html+='<td><select class="form-control productid" name="productid[]" style="width: 200px";><option value="">Select Option</option><?= fill_product($pdo,''); ?></select></td>';

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
                        tr.find(".pname").val(data["pname"]);
                        tr.find(".stock").val(data["pstock"]);
                        tr.find(".price").val(data["saleprice"]);
                        tr.find(".qty").val(1);
                        tr.find(".total").val( tr.find(".qty").val() * tr.find(".price").val() );
                        calculate(0,0);
                        $("#txtpaid").val("");
                    }
                })
            })
        })

        $(document).on('click','.btnremove',function(){
            $(this).closest('tr').remove();
            calculate(0,0);
            $("#txtpaid").val("");
        })

        $("#producttable").delegate(".qty","keyup change", function(){

            var quantity = $(this);
            var tr=$(this).parent().parent();
            $("#txtpaid").val("");

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