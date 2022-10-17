<?php
include('conn.php');
include('function.php');
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
?>
<div class="container-fluid" onkeydown="return (event.keyCode != 116)">
    <div class="card mt-3">
        <div class="card-header">
            <strong>sale Panel</strong>
        </div>
        <div class="card-body mt-3">
            <span id="alert"></span>
            <form name="frm" id="sale-form" method="post">
                <div class="row">
                    <div class="col-sm-4">
                        Party Details:
                        <div class="form-group my-1">
                            <input type="hidden" name="party_id" id="party_id" />
                            <input type="text" name="party_name" id="party_name" class="form-control form-control-sm" placeholder="Party Name" required autofocus="" />
                        </div>
                        <div class="form-group mb-1">
                            <input type="text" name="party_desc1" id="party_desc1" class="form-control form-control-sm" placeholder="Address">
                        </div>
                        <div class="form-group">
                            <input type="text" name="party_desc2" id="party_desc2" class="form-control form-control-sm" placeholder="Mobile no">
                        </div>
                    </div>
                    
                    <div class="col-sm-2">
                        Invoive Details:
                        <div class="form-group my-1">
                            <input type="text" class="form-control form-control-sm" name="sale_date" id="sale_date" />
                        </div>
                        <div class="form-group mb-1">
                            <input type="text" name="sale_no" id="sale_no" value="" class="form-control form-control-sm" placeholder="Invoice No." />
                        </div>
                        <div class="form-group">
                            <select name="methodtype" id="methodtype" class="form-control form-control-sm">
                                <option value="value">Value</option>
                                <option value="weight">Weight</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-sm-4">
                            <div id="balance_summary"></div>
                        </div>
                        <div class="col-sm-4">
                            <div id="balance_summary1"></div>
                        </div>
                        <div class="col-sm-4">
                            <div id="balance_summary2"></div>
                        </div>
                    </div> -->
                </div>
                </br></br>
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
                        <tbody id="maintable">
                            <tr id="row_id_1">
                                <td>
                                    <input type="hidden" name="product_id[]" id="product_id1" data-srno="1">
                                    <input type="text" name="code[]" id="code1" class="form-control form-control-sm code" data-srno="1" autocomplete="off" required />
                                </td>
                                <td style="vertical-align: middle;font-size: 0.8375rem">
                                    <span id="item_name1" data-srno="1"></span>
                                </td>
                                <td>
                                    <input type="text" name="unit[]" id="unit1" class="form-control form-control-sm" data-srno="1" onChange="Calci()" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="weight[]" id="weight1" onChange="Calci()" value= "" class="form-control form-control-sm"  data-srno="1" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="melt[]" id="melt1"  onChange="Calci()" class="form-control form-control-sm melt" data-srno="1" autocomplete="off" required />
                                </td>
                            
                                <td>
                                    <input type="text" name="wast[]" id="wast1"   onChange="Calci()" class="form-control form-control-sm melt" data-srno="1" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="rate[]" id="rate1"  onChange="CalRate()"  class="form-control form-control-sm" readonly data-srno="1" autocomplete="off"  required />
                                </td>
                                <td>
                                    <input type="text" name="total_fine[]" id="total_fine1" class="form-control form-control-sm " readonly data-srno="1" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="price1[]" id="price1" class="form-control  form-control-sm input-sm lab_charge" data-srno="1" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="amount[]" id="amount1" class="form-control form-control-sm" data-srno="1" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="lab_rate[]" id="lab_rate1" class="form-control form-control-sm"  data-srno="1" onChange="CalAmount()" autocomplete="off" />
                                </td>

                                <td>
                                    <input type="text" name="other_charge[]" id="other_charge1" class="form-control form-control-sm  other_charge" onChange="CalAmount()" data-srno="1" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="total_mcharge[]" id="total_mcharge1" class="form-control  form-control-sm gst" data-srno="1" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="grand_tot[]" id="grand_tot1" class="form-control form-control-sm"  readonly data-srno="1" autocomplete="off" required />
                                </td>
                                
                                <td><button type="button" id="1" class="btn btn-success btn-sm add_row pull-right">+</button></td>
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
                                    <input type="hidden" name="btn_action" id="btn_action" value="1"/>
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary btn">Submit</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // function Calci()
    // {
    //     var a = document.getElementById("melt1").value;
    //     var b = document.getElementById("wast1").value;
    //     // console.log(a);
    //     // console.log(b);
    //     var d = parseFloat(a) + parseFloat(b);
    //     var c = document.getElementById("weight1").value;
    //     document.getElementById("rate1").value = d;
    //     document.getElementById("total_fine1").value = (parseFloat(c)* d) / 100;
    // }
    //     function CalAmount(){
    //         var a = document.getElementById("lab_rate1").value;
    //         var b = document.getElementById("other_charge1").value;
    //         var g = document.getElementById("weight1").value;

    //         var c = parseFloat(g) * parseFloat(a)/1000;
    //         document.getElementById("total_mcharge1").value = c;
    //         var d = c;
    //         var e = parseFloat(b) + parseFloat(d);
    //         document.getElementById("grand_tot1").value = e;

    //     }

        // function CalRate(){
        //     var a = document.getElementById("melt1").value;
        //     var b = document.getElementById("rate1").value;
        //     var c = parseFloat(b)- parseFloat(a);
        //     console.log(c);
        //     document.getElementById("wast1") = c;

        // }

    
    $(document).ready(function() {
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
                    $('#party_desc1').val(ui.item.address);
                    $('#party_desc2').val(ui.item.mobile);
                    balance_summary(0, party_id);
                    return false;
                }
            });
        });
    
       
        // function balance_summary(btn_action, party_id, from_date = '', to_date = '', ) {

        //     $.ajax({
        //         url: "partytransaction_action.php",
        //         method: "POST",
        //         data: {
        //             btn_action: btn_action,
        //             party_id: party_id,
        //             from_date: from_date,
        //             to_date: to_date
        //         },
        //         success: function(feedback) {
        //             // console.log(feedback);
                 
        //             $('#balance_summary').html('Balance Details:' + feedback);
        //             $('#balance_summary1').html('Transaction Details:' + feedback);
        //             // $('#balance_summary2').html('Balance Details:' + feedback);
        //         }
        //     })
        // }

        $('#sale_date').datepicker({
            dateFormat: 'dd-mm-yy'
        });

        let count = 1
        $(document).on('click', '.add_row', function() {
            let id = $(this).attr('id');
            if ($('#product_id' + id).val() == '') {
                $('#submit').focus();
                return false;
            }
            $(this).replaceWith($('<span id="' + id + '"class="fa fa-remove text-danger remove_row" style="font-size:16px;color:red;"><span>'));

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
                                    <input type="text" name="rate[]" id="rate${count}" class="form-control  form-control-sm bhaw" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="total_fine[]" id="total_fine${count}" class="form-control form-control-sm" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="price1[]" id="price${count}" class="form-control form-control-sm" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="amount[]" id="amount${count}" class="form-control  form-control-sm input-sm lab_charge" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="lab_rate[]" id="lab_rate${count}" class="form-control form-control-sm" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="other_charge[]" id="other_charge${count}" class="form-control form-control-sm  other_charge" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="total_mcharge[]" id="total_mcharge${count}" class="form-control  form-control-sm gst" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="grand_tot[]" id="grand_tot${count}" class="form-control form-control-sm" data-srno="${count}" autocomplete="off" required />
                                </td>
            
                                <td><button type="button" id="${count}" class="btn btn-success btn-sm add_row pull-right">+</button></td>
                            </tr>
            `
            $('#maintable').append(html);
        });

        
        const cal_ = (count) => {
        
                let melt= 0;
                let wast = 0;
                let rate = 0;
                let total_fine = 0;
                let amount = 0;
                let making_charge = 0;
                let lab_rate = 0;
                let other_charge = 0;
                let total_mcharge = 0;
                let grand_tot = 0;
               weight = $('#weight').val();


              $('#rate').val(( melt + wast).toFixed(2));        
  
        }



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
                    return false;
                }
            });
        });

        $(document).on('keyup', ' .lab_rate, .other_charge, .total_mcharge, .discount, .melt', function() {
            cal_(count)
        });

        
        $(document).on('click', '.remove_row', function() {
            var row_id = $(this).attr('id');
            $('#row_id_' + row_id).remove();
            count--;
        });

        function Submit_form(){
            $('#submit').attr('disabled', 'disabled');

            var form_data = $('#sale-form').serialize();
            $.ajax({
                url:"sale_action.php",
                method:"POST",
                data:form_data,
                success:function(feedback)
                {
                    $('#sale-form')[0].reset();
                    $('#alert').html('<div class= "alert alert-success"><i class="fa fa-check"></i> '+feedback+'</div>');
                    setTimeout(function(){
                        location.reload();
                    }, 2000);
                }
            });
        }
        
        $(document).on('submit', '#sale-form', function(event){
		  event.preventDefault();
		  Submit_form();
		});

    });
</script>