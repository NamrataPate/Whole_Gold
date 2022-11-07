<?php
include('conn.php');
include('function.php');
// if (!isset($_SESSION['id'])) {
//     header("location:login.php");
// }
?>
<script>
    $(function() {
        $(document).attr("title", "PURCHASE REPORT");
    });
</script>
<div class="card">
    <div class="card-header">
        <strong>Purchase Report</strong>
    </div>
    <div class="card-body pt-3">
        <div class="card mb-2">
            <div class="card-body py-0">
                <form id="search-form" method="post">
                    <div class="row">
                        <div class="col-sm-3 offset-sm-2">
                            <div class="form-group">
                                <label for="party_name">Party Name</label>
                                <input type="hidden" name="party_id" id="party_id" class="form-control">
                                <input type="text" name="party_name" id="party_name" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-sm-3 mb-2">
                            <label class="text-sm-start">Choose Date </label>
                            <div class="input-group input-group-sm mb-3" id="datepicker">
                                <input type="text" class="form-control" name="from_date" id="from_date" placeholder="dd-mm-YY" autocomplete="off">
                                <span class="input-group-text">To</span>
                                <input type="text" class="form-control" name="to_date" id="to_date"  placeholder="dd-mm-YY">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group"><br>
                                <button type="submit" id="filter" class="btn btn-primary btn-sm">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-sm" style="font-size:12px;" id="purchaseTable">
                    <thead class="thead-light" style="background-color:rgb(189, 195, 199);">
                        <tr>
                            <th style="font-size:11px;">S.no</th>
                            <th style="font-size:11px;">Date</th>
                            <th style="font-size:11px;">Invoice</th> 
                            <th style="font-size:11px;">Type</th>
                            <th style="font-size:11px;">Party</th>
                            <th style="font-size:11px;"colspan="12" class="p-0">
                                <table class="table table-bordered table-sm mb-0">
                                    <thead class="thead-light">
                                        <tr style="font-size:11px;">
                                            <th style="font-size:11px;">Item</th>
                                            <th style="font-size:11px;">Weight</th>
                                            <th style="font-size:11px;">Melt</th>
                                            <th style="font-size:11px;">Wast</th>
                                            <th style="font-size:11px;">Rate%</th>
                                            <th style="font-size:11px;">Total fine</th>
                                            <th style="font-size:11px;">Rate</th>
                                            <th style="font-size:11px;">Gold/samount</th>
                                            <th style="font-size:11px;">Lab_Rate</th>
                                            <th style="font-size:11px;">Other_charge</th>
                                            <th style="font-size:11px;">Total_mc</th>
                                            <th style="font-size:11px;">Grand Total</th>
                                        </tr>
                                    </thead>
                                </table>
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

        
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        var height = $('body').height() - $('.navbar').height() - $('#search-form').height() - 70;
        var trheight = $('tr').height();


        $('#from_date').datepicker({
            dateFormat: 'dd-mm-yy',
            todayHighlight: true,
            autoclose: true
        });

        $('#to_date').datepicker({
            dateFormat: 'dd-mm-yy',
            todayHighlight: true,
            autoclose: true
        })

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
                    $(this).val(ui.item.label);
                    var name = ui.item.value;
                    var party_id = ui.item.party_id;
                    $('#party_id').val(party_id);
                    $(this).val(name);
                    return false;
                }
            });
        });


        var limit = Math.round(height / trheight);
        var start = 0;
        var action = 1;

        function load_data(limit, start, btn_action, party_id = '', from_date = '', to_date = '', form = '') {
            $.ajax({
                url: "purchase_action.php",
                method: "POST",
                data: {
                    limit: limit,
                    start: start,
                    btn_action: btn_action,
                    party_id: party_id,
                    from_date: from_date,
                    to_date: to_date
                },
                success: function(data) {
                    if (form == 'submit') {
                        $('#purchaseTable tbody').html(data);
                    } else {
                        $('#purchaseTable tbody').append(data);
                    }

                    if (data == '') {
                        action = 0;
                    } else {
                        action = 1;
                    }
                }
            });
        }

        var from_date = '';
        var to_date = '';
        var party_type = '';
        var party_id = '';

        if (action == 1) {
            action = 0;
            load_data(limit, start, '3');
        }

        $(document).on('submit', '#search-form', function(event) {
            event.preventDefault();

            limit = Math.round(height / trheight);
            start = 0;
            action = 1;
            party_id = $('#party_id').val();
            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

            load_data(limit, start, '3', party_id, from_date, to_date, 'submit');
        });

        $(document).on('click', '.delete_purchase', function(){
        var pid = $(this).attr("id");
        if(confirm("Are you sure you want to Delete Data?"))
        {
        $.ajax({
            url:"purchase_action.php",
            method:"POST",
            data:{pid:pid, btn_action:'4'},
            success:function(data)
            {	
                $('tr#'+pid).css('display','none');
                $('.toast').toast('show');
                $('.message').html(data);
            }
        });
        }
        else
        {
        return false;
        }
    });

});
</script>