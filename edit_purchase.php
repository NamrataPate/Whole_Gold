<?php
// if (!isset($_SESSION['id'])) {
//     header("location:login.php");
// }
include 'function.php';
if (isset($_GET['pid'])) {
    $pid = convert_string('decrypt', $_GET['pid']);
    $statement = mysqli_query($db, "SELECT * FROM purchase_tbl WHERE pid = " . $pid);
    while ($row = mysqli_fetch_assoc($statement)) {
        $party_id = $row['party_id'];
        $party_name = return_value($db, "party_tbl", "party_name", "party_id='" . $party_id . "'");
        $purchase_no = $row['purchase_no'];
        $purchase_date = $row['purchase_date'];
        $methodtype = $row['methodtype'];
        // $total_weight = $row['total_weight'];
        $total_rate = $row['total_rate'];
        $total_amount = $row['total_amount'];
        $total_gst = $row['total_gst'];
        // $total_grnad_amount = $row['total_grnad_amount'];
        $discount = $row['discount'];
        $final_purchase_amount = $row['final_purchase_amount'];
        $party_disc1 = $row['party_description1'];
        $party_disc2 = $row['party_description2'];
    }
}
?>
<script>
    $(document).ready(function() {
        $('#pid').val("<?php echo $_GET['pid']; ?>");
        $('#purchase_no').val("<?php echo $purchase_no; ?>");
        $('#party_id').val("<?php echo $party_id; ?>");
        $('#party_name').val("<?php echo $party_name; ?>");
        $('#methodtype').val("<?php echo $methodtype; ?>");
        $('#purchase_date').val("<?php echo date('d-m-Y', strtotime($purchase_date)); ?>");
        $('#discount').val("<?php echo $discount; ?>");
        $('#party_desc1').val("<?php echo $party_disc1; ?>");
        $('#party_desc2').val("<?php echo $party_disc2; ?>");
    });
</script>
<script>
    $(function() {
        $(document).attr("title", "EDIT SALE PAGE");
    });
</script>

<div class="card border-bottom-0 mb-0">
    <div class="card-header">
        <strong>Edit purchase Panel</strong>
    </div>
    <div class="card-body pt-3">
        <span id="alert"></span>
        <form name="frm" id="purchase-form" method="post">
            <div class="row">
                <div class="col-sm-2">
                    Invoive Details:
                    <div class="form-group my-1">
                        <input type="text" name="purchase_date" id="purchase_date" class="form-control form-control-sm mb-2" readonly="" />
                    </div>
                    <div class="form-group mb-1">
                        <input type="text" name="purchase_no" id="purchase_no" value="" class="form-control form-control-sm mb-2" placeholder="Invoice No." required="" />
                    </div>
                    <div class="form-group">
                        <select name="methodtype" id="methodtype" class="form-control form-control-sm mb-2" autofocus="">
                            <option value="weight">Weight</option>
                            <option value="value">Value</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    Party Details:
                    <div class="form-group my-1">
                        <input type="hidden" name="party_id" id="party_id" />
                        <input type="text" name="party_name" id="party_name" class="form-control form-control-sm mb-2" placeholder="Party Name" required />
                    </div>
                    <div class="form-group mb-1">
                        <input type="text" name="party_desc1" id="party_desc1" class="form-control form-control-sm mb-2">
                    </div>
                    <div class="form-group">
                        <input type="text" name="party_desc2" id="party_desc2" class="form-control form-control-sm mb-2">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm" width="100%">
                    <thead style="background: #337ab7;color: #fff;">
                        <tr>
                            <th style="font-size:13px;" width="4%">Code</th>
                            <th style="font-size:13px;" width="8%">Product</th>
                            <th style="font-size:13px;" width="5%">Unit</th>
                            <th style="font-size:13px;" width="5%">Weight(IN GM)</th>
                            <th style="font-size:13px;" width="5%">Melt(%)</th>
                            <th style="font-size:13px;" width="5%">Wast(%)</th>
                            <th style="font-size:13px;" width="5%">Rate(%)</th>
                            <th style="font-size:13px;" width="6%">Total Fine</th>
                            <th style="font-size:13px;" width="4%">Rate</th>
                            <th style="font-size:13px;" width="8%">Gold/S Amount</th>
                            <th style="font-size:13px;" width="5%">Lab Rate</th>
                            <th style="font-size:13px;" width="5%">Oth. Ch.</th>
                            <th style="font-size:13px;" width="5%">Total M. C.</th>
                            <th style="font-size:13px;" width="6%">Grand Total</th>
                            <th style="font-size:13px;" width="1%"></th>
                        </tr>
                    </thead>
                    <br><br>
                    <tbody id="maintable">
                        <?php
                        $statement = mysqli_query($db, "SELECT * FROM purchasedetail_tbl pdt INNER JOIN product_tbl pt ON pt.product_id=pdt.product_id WHERE pdt.pid =" . $pid);
                        $m = 0;
                        while ($sub_row = mysqli_fetch_assoc($statement)) {
                            $m = $m + 1;
                        ?>
                            <tr id="row_id_<?php echo $m; ?>">
                                <td>
                                    <input type="hidden" name="product_id[]" id="product_id<?php echo $m; ?>" data-srno="<?php echo $m; ?>" value="<?php echo $sub_row['item_name']; ?>">
                                    <input type="text" name="code[]" id="code<?php echo $m; ?>" class="form-control form-control-sm code" data-srno="<?php echo $m; ?>" value="<?php echo $sub_row['code']; ?>" autocomplete="off" required />
                                </td>
                                <td style="vertical-align: middle;font-size: 0.8375rem">
                                    <span id="item_name<?php echo $m; ?>" data-srno="<?php echo $m; ?>"><?php echo $sub_row['item_name']; ?></span>
                                </td>
                                <td>
                                    <input type="text" name="unit[]" id="unit<?php echo $m; ?>" value="<?php echo $sub_row['unit']; ?>" class="form-control form-control-sm" data-srno="<?php echo $m; ?>" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="weight[]" id="weight<?php echo $m; ?>" value="<?php echo $sub_row['weight']; ?>" class="form-control form-control-sm" data-srno="<?php echo $m; ?>" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="melt[]" id="melt<?php echo $m; ?>" value="<?php echo $sub_row['melt']; ?>" class="form-control form-control-sm melt" data-srno="<?php echo $m; ?>" autocomplete="off" required />
                                </td>

                                <td>
                                    <input type="text" name="wast[]" id="wast<?php echo $m; ?>" value="<?php echo $sub_row['wast']; ?>" class="form-control form-control-sm melt" data-srno="<?php echo $m; ?>" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="rate[]" id="rate<?php echo $m; ?>" value="<?php echo $sub_row['rate']; ?>" class="form-control form-control-sm" readonly data-srno="<?php echo $m; ?>" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="total_fine[]" id="total_fine<?php echo $m; ?>" value="<?php echo $sub_row['total_fine']; ?>" class="form-control form-control-sm " readonly data-srno="<?php echo $m; ?>" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="price1[]" id="price<?php echo $m; ?>" value="<?php echo $sub_row['price1']; ?>" class="form-control  form-control-sm input-sm lab_charge" data-srno="<?php echo $m; ?>" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="amount[]" id="amount<?php echo $m; ?>" value="<?php echo $sub_row['amount']; ?>" class="form-control form-control-sm" data-srno="<?php echo $m; ?>" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="lab_rate[]" id="lab_rate<?php echo $m; ?>" value="<?php echo $sub_row['lab_rate']; ?>" class="form-control form-control-sm" data-srno="<?php echo $m; ?>" onChange="CalAmount()" autocomplete="off" />
                                </td>

                                <td>
                                    <input type="text" name="other_charge[]" id="other_charge<?php echo $m; ?>" value="<?php echo $sub_row['other_charge']; ?>" class="form-control form-control-sm  other_charge" value="<?php echo $sub_row['other_charge']; ?>" data-srno="<?php echo $m; ?>" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="total_mcharge[]" id="total_mcharge<?php echo $m; ?>" value="<?php echo $sub_row['total_mcharge']; ?>" data-srno="<?php echo $m; ?>" class="form-control  form-control-sm gst" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="grand_tot[]" class="form-control form-control-sm" id="grand_tot<?php echo $m; ?>" value="<?php echo $sub_row['grand_tot']; ?>" data-srno="<?php echo $m; ?>" readonly autocomplete="off" required />
                                </td>
                                <!-- <td><button type="button" id="<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="btn btn-success btn-sm add_row">+</button></td> -->
                                <td><span id="<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="fas fa-times fa-lg text-danger remove_row"></span></td>

                            </tr>
                        <?php
                        }
                        ?>
                        <tr id="row_id_<?php echo $m + 1; ?>">
                            <td>
                                <input type="hidden" name="product_id[]" id="product_id<?php echo $m + 1; ?>" data-srno="<?php echo $m + 1; ?>" value="<?php echo $sub_row['item_name']; ?>">
                                <input type="text" name="code[]" id="code<?php echo $m + 1; ?>" class="form-control form-control-sm code" data-srno="<?php echo $m + 1; ?>" value="<?php echo $sub_row['code']; ?>" autocomplete="off" />
                            </td>
                            <td style="vertical-align: middle;font-size: 0.8375rem">
                                <span id="item_name<?php echo $m + 1; ?>" data-srno="<?php echo $m + 1; ?>"><?php echo $sub_row['item_name']; ?></span>
                            </td>
                            <td>
                                <input type="text" name="unit[]" id="unit<?php echo $m + 1; ?>" value="<?php echo $sub_row['unit']; ?>" class="form-control form-control-sm" data-srno="<?php echo $m + 1; ?>" autocomplete="off" />
                            </td>
                            <td>
                                <input type="text" name="weight[]" id="weight<?php echo $m + 1; ?>" value="<?php echo $sub_row['weight']; ?>" class="form-control form-control-sm" data-srno="<?php echo $m + 1; ?>" autocomplete="off" />
                            </td>
                            <td>
                                <input type="text" name="melt[]" id="melt<?php echo $m + 1; ?>" value="<?php echo $sub_row['melt']; ?>" class="form-control form-control-sm melt" data-srno="<?php echo $m + 1; ?>" autocomplete="off" />
                            </td>

                            <td>
                                <input type="text" name="wast[]" id="wast<?php echo $m + 1; ?>" value="<?php echo $sub_row['wast']; ?>" class="form-control form-control-sm melt" data-srno="<?php echo $m + 1; ?>" autocomplete="off" />
                            </td>
                            <td>
                                <input type="text" name="rate[]" id="rate<?php echo $m + 1; ?>" value="<?php echo $sub_row['rate']; ?>" class="form-control form-control-sm" readonly data-srno="<?php echo $m + 1; ?>" autocomplete="off" />
                            </td>
                            <td>
                                <input type="text" name="total_fine[]" id="total_fine<?php echo $m + 1; ?>" value="<?php echo $sub_row['total_fine']; ?>" class="form-control form-control-sm " readonly data-srno="<?php echo $m + 1; ?>" autocomplete="off" />
                            </td>
                            <td>
                                <input type="text" name="price1[]" id="price<?php echo $m + 1; ?>" value="<?php echo $sub_row['price1']; ?>" class="form-control  form-control-sm input-sm lab_charge" data-srno="<?php echo $m + 1; ?>" autocomplete="off" />
                            </td>
                            <td>
                                <input type="text" name="amount[]" id="amount<?php echo $m + 1; ?>" value="<?php echo $sub_row['amount']; ?>" class="form-control form-control-sm" data-srno="<?php echo $m + 1; ?>" autocomplete="off" />
                            </td>
                            <td>
                                <input type="text" name="lab_rate[]" id="lab_rate<?php echo $m + 1; ?>" value="<?php echo $sub_row['lab_rate']; ?>" class="form-control form-control-sm" data-srno="<?php echo $m + 1; ?>" onChange="CalAmount()" autocomplete="off" />
                            </td>

                            <td>
                                <input type="text" name="other_charge[]" id="other_charge<?php echo $m + 1; ?>" value="<?php echo $sub_row['other_charge']; ?>" class="form-control form-control-sm  other_charge" value="<?php echo $sub_row['other_charge']; ?>" data-srno="<?php echo $m + 1; ?>" autocomplete="off" />
                            </td>
                            <td>
                                <input type="text" name="total_mcharge[]" id="total_mcharge<?php echo $m + 1; ?>" value="<?php echo $sub_row['total_mcharge']; ?>" data-srno="<?php echo $m + 1; ?>" class="form-control  form-control-sm gst" autocomplete="off" />
                            </td>
                            <td>
                                <input type="text" name="grand_tot[]" class="form-control form-control-sm" id="grand_tot<?php echo $m + 1; ?>" value="<?php echo $sub_row['grand_tot']; ?>" data-srno="<?php echo $m + 1; ?>" readonly autocomplete="off" required />
                            </td>

                            <td><button type="button" id="<?php echo $m + 1; ?>" data-srno="<?php echo $m + 1; ?>" class="btn btn-success btn-sm add_row">+</button></td>
                            <!-- <td><span id="<?php echo $m + 1; ?>"  data-srno="<?php echo $m + 1; ?>" class="fas fa-times fa-lg text-danger remove_row"></span></td> -->
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="font-size:13px; text-align:left;" colspan="1">Total</th>
                            <th><span id="net_weight"></span></th>
                            <th></th>
                            <th><span id="fine_weight"></span></th>
                            <th></th>
                            <th><span id="total_amount"></span></th>
                            <th colspan="2"></th>
                            <th></th>
                            <th></th>
                            <th><span id="final_grand_total"> </span></th>
                            <th colspan="3"></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td style="font-size:13px; text-align:right;" colspan="13" class="text-right p-1"><strong>Discount</strong>:</td>
                            <td colspan="2">
                                <input type="text" name="discount" id="discount" class="form-control form-control-sm discount">
                            </td>
                        </tr>
                        <tr>
                            <th style="font-size:13px; text-align:right;" colspan="14" class="text-right p-1">Total GST : </th>
                            <th class="p-1"><span id="total_gst_amount"></span></th>
                        </tr>
                        <tr>
                            <th style="font-size:13px; text-align:right;" colspan="14" class="text-right p-1">Final Amt : </th>
                            <th class="p-1"><span id="final_amount"></span></th>
                        </tr>
                        <tr>
                            <td colspan="15" align="center" class="p-1">
                                <input type="hidden" name="pid" id="pid" />
                                <input type="hidden" name="btn_action" id="btn_action" value="2" />
                                <button type="submit" name="submit" id="submit" class="btn btn-primary btn">Submit</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </form>
    </div>
</div>
<script>
    selecttext();

    function selecttext() {
        $("input[type=text]").focus(function() {
            $(this).select();
        });
    }
    $(document).ready(function() {

        //cal_(<?php echo $m; ?>);

        var count = <?php echo $m + 1; ?>;
        // console.log(count);


        $(document).on('click', '.add_row', function() {
            var id = $(this).data('srno');
            //console.log(id);
            if ($('#code' + id).val() == '') {
                $('#discount').focus();
                return false;
            }
            $('#remove' + id).replaceWith($('<span id="' + id + '" class="fas fa-times fa-lg text-danger remove_row"></span>'));
           // $(this).replaceWith($('<span id="' + id + '" class="fas fas-times text-danger remove_row"></span>'));
            count++;
            let html = '';
            html += `
                        <tr id="row_id_${count}">
                                <td>
                                <input type="hidden" name="product_id[]" id="product_id${count}" data-srno="${count}" onChange="count()">
                            
                                <input type="text" name="code[]" id="code${count}" class="form-control form-control-sm code" data-srno="${count}" autocomplete="off" required />
                            </td>
                                <td style="vertical-align: middle;font-size: 0.8375rem">
                                    <span id="item_name${count}" data-srno="${count}"></span>
                                </td>
                                <td>
                                    <input type="text" name="unit[]" id="unit${count}" class="form-control form-control-sm" data-srno="${count}" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="weight[]" id="weight${count}" class="form-control form-control-sm" data-srno="${count}" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="melt[]" id="melt${count}" class="form-control form-control-sm melt" data-srno="${count}" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="wast[]" id="wast${count}" class="form-control form-control-sm" data-srno="${count}" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="rate[]" id="rate${count}" class="form-control  form-control-sm "  readonly  data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="total_fine[]" id="total_fine${count}" class="form-control form-control-sm" readonly data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="price1[]" id="price${count}" class="form-control form-control-sm" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="amount[]" id="amount${count}" class="form-control  form-control-sm input-sm " data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="lab_rate[]" id="lab_rate${count}" class="form-control form-control-sm" lab_rate data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="other_charge[]" id="other_charge${count}" class="form-control form-control-sm  other_charge" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="total_mcharge[]" id="total_mcharge${count}" class="form-control  form-control-sm" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="grand_tot[]" id="grand_tot${count}" class="form-control form-control-sm"  readonly data-srno="${count}" autocomplete="off" required />
                                </td>
                                <td><button type="button" id="${count}" class="btn btn-success btn-sm add_row pull-right">+</button></td>
                                <td><span id="remove${count}"  class="form-control form-control-sm"  readonly data-srno="${count}" autocomplete="off" required ></span></td>';
    		                        
                            </tr>
            `
            $('#maintable').append(html);
            $('#code' + count).focus();
            selecttext();
        });
    });


    $(document).on('keydown', '#party_name', function() {
        $('#party_name').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "partyName.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term,
                        request: 1
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            autoFocus: true,
            select: function(event, ui) {
                var party_name = $(this).val(ui.item.label);
                var party_name = ui.item.value;
                var party_id = ui.item.party_id;
                $('#party_id').val(party_id);

                return false;
            }
        });
    });

    $(document).on('keydown', '.code', function() {
        var srno = $(this).data('srno');
        $('.code').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "autocomplete.php",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        search: request.term,
                        request: 1
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            autoFocus: true,
            select: function(event, ui) {
                $(this).val(ui.item.label);
                var code = ui.item.value;
                $('#product_id' + srno).val(ui.item.product_id);
                $('#item_name' + srno).html(ui.item.item_name);
                $('#unit' + srno).val(ui.item.unit);
                $('#weight' + srno).val(ui.item.weight);
                $('#melt' + srno).val(ui.item.melt);
                $('#price' + srno).val(ui.item.price);
                $('#amount' + srno).val(ui.item.amount);
                $('#lab_rate' + srno).val(ui.item.lab_rate);
                $('#other_charge' + srno).val(ui.item.other_charge);
                $('#total_mcharge' + srno).val(ui.item.total_mcharge);
                cal_(count);
                $('#weight' + srno).select();
                return false;

            }
        });
    });

    $(document).on('keyup', ' .lab_rate, .other_charge, .total_mcharge, .discount, .melt', function() {
        cal_(count)
    });

    $('#sale_date').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true
    });

    function Submit_form() {
        $('#submit').attr('disabled', 'disabled');
        // var form_data = $(this).serialize();
        var form_data = $('#purchase-form').serialize();
        $.ajax({
            url: "purchase_action.php",
            method: "POST",
            data: form_data,
            success: function(feedback) {
                $('#alert').html('<div class="alert alert-success"><i class="fa fa-check"></i> ' + feedback + '</div>');
                // setTimeout(function() {
                //     location.reload();
                // }, 1000);
            }
        });
    }
    $(document).on('click', '.remove_row', function() {
        var row_id = $(this).attr('id');
        $('#row_id_' + row_id).remove();
        count--;
    });

    $(document).on('click', '.code', function() {
	      var srno = $(this).data('srno');
	      // $('#weight'+srno).focus();
	      $('#weight'+srno).select();
	  	});


    function Submit_form() {
        $('#submit').attr('disabled', 'disabled');

        var form_data = $('#purchase-form').serialize();
        $.ajax({
            url: "purchase_action.php",
            method: "POST",
            data: form_data,
            success: function(feedback) {

                $('#alert').html('<div class= "alert alert-success"><i class="fa fa-check"></i> ' + feedback + '</div>');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        });
    }

    $(document).on('submit', '#purchase-form', function(event) {
        event.preventDefault();
        Submit_form();
    });
</script>