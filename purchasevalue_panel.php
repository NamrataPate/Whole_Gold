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
            <strong>parchase Panel</strong>
        </div>
        <div class="card-body mt-3">
            <span id="alert"></span>
            <form name="frm" id="parchase-form" method="post">
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
                        <!-- <div class="form-check bg-light m-1">
                            <input class="form-check-input" type="radio" id="" name="" onClick="document.location.href='index.php?cashtransaction'">
                            <label class="form-check-label" for="Value">
                                <strong style="font-size:14px;">Weight</strong>
                            </label>
                        </div> -->
                        <div class="form-check bg-light m-1">
                            <input class="form-check-input" type="radio" name="" id="" onClick="document.location.href='index.php?purchasevalue_panel'">
                            <label class="form-check-label" for="">
                                <strong style="font-size:14px;">Value</strong>
                            </label>
                        </div>

                        Invoive Details:
                        <div class="form-group my-1">
                            <input type="text" class="form-control form-control-sm" name="parchase_date" id="parchase_date" />
                        </div>
                        <div class="form-group mb-1">
                            <input type="text" name="parchase_no" id="parchase_no" value="" class="form-control form-control-sm" placeholder="Invoice No." />
                        </div>
                        <!-- <div class="form-group">
                            <select name="methodtype" id="methodtype" class="form-control form-control-sm">
                                <option value="value"  onClick="document.location.href='index.php?cashtransaction'">Weight</option>
                                <option value="value" onClick="document.location.href='index.php?journaltransaction'">Value</option>
                            </select>
                            
                            
                        </div> -->

                    </div>

                    <div class="col-sm-4">
                        <div id="balance_summary"></div>
                    </div>

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
                                    <input type="text" name="unit[]" id="unit1" class="form-control form-control-sm" data-srno="1" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="weight[]" id="weight1" value="" class="form-control form-control-sm" data-srno="1" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="melt[]" id="melt1" class="form-control form-control-sm melt" data-srno="1" autocomplete="off" required />
                                </td>

                                <td>
                                    <input type="text" name="wast[]" id="wast1" class="form-control form-control-sm wast" data-srno="1" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="rate[]" id="rate1" class="form-control form-control-sm rate" readonly data-srno="1" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="total_fine[]" id="total_fine1" class="form-control form-control-sm " readonly data-srno="1" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="price[]" id="price1" class="form-control  form-control-sm input-sm price" data-srno="1" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="amount[]" id="amount1" class="form-control form-control-sm amount" data-srno="1" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="lab_rate[]" id="lab_rate1" class="form-control form-control-sm lab_rate" data-srno="1" autocomplete="off" />
                                </td>

                                <td>
                                    <input type="text" name="other_charge[]" id="other_charge1" class="form-control form-control-sm  other_charge" data-srno="1" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="total_mcharge[]" id="total_mcharge1" class="form-control  form-control-sm total_mcharge" data-srno="1" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="grand_tot[]" id="grand_tot1" class="form-control form-control-sm" readonly data-srno="1" autocomplete="off" required />
                                </td>

                                <td><button type="button" id="1" class="btn btn-success btn-sm add_row pull-right">+</button></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="font-size:13px; text-align:left;" colspan="3">Total</th>
                                <th><span id="net_weight"></span></th>
                                <th></th>
                                <th></th>
                                <th><span id="net_rate"></span></th>
                                <th></th>
                                <th></th>
                                <th><span id="total_amount"></span></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><span id="final_grand_total"></span></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td colspan="14" class="text-right p-1" style="text-align:end;">Discount : </td>
                                <td>
                                    <input type="text" name="discount" id="discount" class="form-control form-control-sm discount">
                                </td>
                            </tr>
                            <!-- <tr>
                                <th colspan="14" class="text-right p-1">Total GST : </th>
                                <th class="p-1"><span id="total_gst_amount"></span></th>
                            </tr> -->
                            <tr>
                                <th colspan="14" class="text-right p-1" style="text-align:end;">Final Amt : </th>
                                <th class="p-1"><span id="final_amount"></span></th>
                            </tr>
                            <tr>
                                <td colspan="15" align="center" class="p-1">
                                    <input type="hidden" name="btn_action" id="btn_action" value="1" />
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


        function balance_summary(btn_action, party_id, from_date = '', to_date = '', ) {

            $.ajax({
                url: "partytransaction_action.php",
                method: "POST",
                data: {
                    btn_action: btn_action,
                    party_id: party_id,
                    from_date: from_date,
                    to_date: to_date
                },
                success: function(feedback) {
                    // console.log(feedback);

                    $('#balance_summary').html('Balance Details:' + feedback);
                    // $('#balance_summary1').html('Transaction Details:' + feedback);
                    // $('#balance_summary2').html('Balance Details:' + feedback);
                }
            })
        }

        $('#parchase_date').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        let count = 1
        $(document).on('click', '.add_row', function() {
            let id = $(this).attr('id');
            if ($('#product_id' + id).val() == '') {
                $('#code1').focus();
                return false;
            }

            $(this).replaceWith($('<button type="button" id="' + id + '" class="btn btn-danger btn-sm remove_row pull-right">-</button>'));

            count++;
            let html = '';
            html += `
                        <tr id="row_id_${count}">
                                <td>
                                <input type="hidden" name="product_id[]" id="product_id${count}" data-srno="${count}">
                            
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
                                    <input type="text" name="wast[]" id="wast${count}" class="form-control form-control-sm wast" data-srno="${count}" autocomplete="off" required />
                                </td>
                                <td>
                                    <input type="text" name="rate[]" id="rate${count}" class="form-control  form-control-sm rate"  readonly  data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="total_fine[]" id="total_fine${count}" class="form-control form-control-sm" readonly data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="price1[]" id="price${count}" class="form-control form-control-sm price" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="amount[]" id="amount${count}" class="form-control  form-control-sm input-sm amount" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="lab_rate[]" id="lab_rate${count}" class="form-control form-control-sm lab_rate" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="other_charge[]" id="other_charge${count}" class="form-control form-control-sm  other_charge" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="total_mcharge[]" id="total_mcharge${count}" class="form-control  form-control-sm total_mcharge" data-srno="${count}" autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" name="grand_tot[]" id="grand_tot${count}" class="form-control form-control-sm"  readonly data-srno="${count}" autocomplete="off" required />
                                </td>
            
                                <td><button type="button" id="${count}" class="btn btn-success btn-sm add_row pull-right">+</button></td>
                            </tr>
            `
            $('#maintable').append(html);
        });


        const cal_ = (count) => {

            var final_grand_total = 0;
            var total_amount = 0;
            var net_weight = 0;
            var net_rate = 0;
            var discount = 0;
            discount = $('#discount').val();
            for (let i = 1; i <= count; i++) {
                let melt = 0;
                let wast = 0;
                let rate = 0;
                let total_fine = 0;
                let amount = 0;
                let making_charge = 0;
                let lab_rate = 0;
                let other_charge = 0;
                let total_mcharge = 0;
                let grand_tot = 0;
                let price = 0;
                weight = $('#weight' + i).val();
                wast = $('#wast' + i).val();
                if (weight != '') {
                    melt = $('#melt' + i).val();

                    if (wast != '') {
                        rate = parseFloat(melt) + parseFloat(wast);
                    }
                    $('#rate' + i).val(rate.toFixed(2));

                    if (wast != '') {
                        total_fine = parseFloat((weight) * parseFloat(rate) / 100).toFixed(3);
                    }
                    $('#total_fine' + i).val(total_fine);

                    lab_rate = $('#lab_rate' + i).val();
                    other_charge = $('#other_charge' + i).val();

                    if (lab_rate != '') {
                        total_mcharge = parseFloat((weight) * parseFloat(lab_rate) / 1000).toFixed(3);
                    }
                    $('#total_mcharge' + i).val(total_mcharge);

                    if (lab_rate != '') {
                        grand_tot = parseFloat(other_charge) + parseFloat(total_mcharge);
                    }
                    $('#grand_tot' + i).val(grand_tot);
                    net_weight = parseFloat(net_weight) + parseFloat(weight);
                    net_rate = parseFloat(net_rate) + parseFloat(rate);
                    // total_amount = parseFloat(total_amount) + parseFloat(amount);
                    final_grand_total = parseFloat(final_grand_total) + parseFloat(grand_tot);

                }
                if ($('#unit' + i).val() == 'GM') {
                    price = $('#price' + i).val();
                    amount = price / 10;
                    $('#amount' + i).val(Number(amount).toFixed(3))
                    // console.log(price);
                }

            }
            $('#net_weight').text(net_weight.toFixed(2));
            $('#net_rate').text(net_rate.toFixed(2));
            $('#total_amount').text(Math.round(total_amount).toFixed(2));
            $('#total_').text(Math.round(total_amount).toFixed(2));
            $('#final_grand_total').text(Math.round(final_grand_total).toFixed(2) + Math.round(price).toFixed(2));
            $('#final_amount').text(Math.round(final_grand_total - discount).toFixed(2));

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

                }
            });
        });

        $(document).on('keyup', '.wast, .rate, .price, .lab_rate, .other_charge, .total_mcharge, .discount', function() {
            cal_(count)
        });


        $(document).on('click', '.remove_row', function() {
            var row_id = $(this).attr('id');
            $('#row_id_' + row_id).remove();
            count--;
        });

        function Submit_form() {
            $('#submit').attr('disabled', 'disabled');

            var form_data = $('#parchase-form').serialize();
            $.ajax({
                url: "parchase_action.php",
                method: "POST",
                data: form_data,
                success: function(feedback) {
                    $('#parchase-form')[0].reset();
                    $('#alert').html('<div class= "alert alert-success"><i class="fa fa-check"></i> ' + feedback + '</div>');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
        }

        $(document).on('submit', '#parchase-form', function(event) {
            event.preventDefault();
            Submit_form();
        });

    });
</script>