<?php
include('conn.php');
?>
<script>
    $(function() {
        $(document).attr('title', 'JOURNAL ENTRY FORM');
    });
</script>

<div class="card border-bottom-0 mb-0">
    <div class="card-header">
        <strong>Cash/Jama/Bhaaw Panel</strong>
    </div>
    <div class="card-body pt-3">
        <div class="container" style="font-size:10px;">
            <div class="form-check bg-light m-1">
                <input class="form-check-input" type="radio" id="cash" name="name" onClick="document.location.href='./index.php?cashtransaction'">
                <label class="form-check-label" for="cash">
                    <strong style="font-size:14px;">CASH ENTRY</strong>
                </label>
            </div>
            <div class="form-check bg-light m-1">
                <input class="form-check-input" type="radio" id="journal" checked>
                <label class="form-check-label" for="journal">
                    <strong style="font-size:14px;">JOURNAL ENTRY</strong>
                </label>
            </div>
            <div class="form-check bg-light m-1">
                <input class="form-check-input" type="radio" name="name" id="bhaaw" onClick="document.location.href='index.php?bhaawtransaction'">
                <label class="form-check-label" for="bhaaw">
                    <strong style="font-size:14px;">BHAAW ENTRY</strong>
                </label>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card mb-0">
                        <div class="card-header text-center bg-light text-dark">
                            <strong>JOURNAL ENTRY FORM</strong>
                        </div>
                        <div class="card-body pt-3">
                            <form method="post" id="journal-form">
                                <div class="form-group row mb-2">
                                    <label for="insdate" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Date :</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm insdate" id="insdate" autocomplete="off" name="insdate" value="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="debitor_party" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Party (DEBITOR) :</label>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="party_id2" id="party_id2">
                                        <input type="text" class="form-control form-control-sm party_name" autoFocus name="debitor_party" id="debitor_party"  placeholder="Enter Debitor Name" autocomplete="off" required="">
                                    </div>
                                    <div class="col-md-2"><b style="font-size:14px;">(NAAME)</b></div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="creditor_party" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Party (CREDITOR) :</label>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="party_id1" id="party_id1">
                                        <input type="text" class="form-control form-control-sm party_name" name="creditor_party"  placeholder="Enter Creditor Name" autocomplete="off" required="">
                                    </div>
                                    <div class="col-md-2"><b style="font-size:14px;">(JAMA)</b></div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="amount" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Amount :</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm amount" name="amount" id="amount" placeholder="0.000" autocomplete="off" required="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-sm-4 col-form-label-sm font-weight-bold text-right">Description :</label>
                                    <div class="col-sm-6">
                                        <textarea name="description" rows="5" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <input type="hidden" name="btn_action" value="1">
                                        <button type="submit" id="submit" class="btn btn-sm btn-primary float-end">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast bg-info" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="position: absolute; top: 10px; right: 10px;min-width: 250px;">

    <div class="toast-body">
    <span class="message"></span>
        <button type="button" class="btn-close btn btn-secondary"  data-bs-dismiss="toast" aria-label="Close"></button>
        
        </button>
       
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#insdate').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        $(document).on('keydown', '.party_name', function() {
            var party = $(this).attr('id');
            $('.party_name').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "partyName.php",
                        type: "POST",
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
                    $(this).val(ui.item.label); // display the selected text
                    var name = ui.item.value; //this value display in input 
                    var party_id = ui.item.party_id;
                    if (party == 'debitor_party') {
                        $('#party_id2').val(party_id);
                    } else {
                        $('#party_id1').val(party_id);
                    }
                    $(this).val(name);
                    return false;
                }
            });
        });
        
        $(document).on('submit', '#journal-form', function(event){
		  event.preventDefault();
		    var form_data = $(this).serialize();
		    $('#submit').attr('disabled', 'disabled');
		    $.ajax({
		     url:"journaltransaction_action.php",
		     method:"POST",
		     data:form_data,
		     success:function(feedback)
		     {  		
		     	$('#journal-form')[0].reset();
		     	$('#party_name').focus();
		     	$('#submit').attr('disabled',false);
		     	$('.toast').toast('show');
		     	$('.message').html(feedback);
		     	$('.toast').toast({animation: true, delay: 3000});
		     }
		  }); 
		});
    });
</script>