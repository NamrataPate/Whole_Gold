<?php
if (!isset($_SESSION['id'])) {
    header('Location:login.php');
}
?>
<script>
    $(function() {
        $(document).attr("title", "BHAAW ENTRY FORM");
    });
</script>

<div class="card border-bottom-0 mb-0">
    <div class="card-header">
        <strong>Cash/Jama/Bhaaw Panel</strong>
    </div>
    <div class="card-body pt-3">
        <div class="container" style="font-size:10px;">
            <div class="form-check bg-light m-1">
                <input class="form-check-input" type="radio" id="cash" name="name" onClick="document.location.href='index.php?cashtransaction'">
                <label class="form-check-label" for="cash">
                    <strong style="font-size:14px;">CASH ENTRY</strong>
                </label>
            </div>
            <div class="form-check bg-light m-1">
                <input class="form-check-input" type="radio" name="name" id="journal" onClick="document.location.href='index.php?journaltransaction'">
                <label class="form-check-label" for="journal">
                    <strong style="font-size:14px;">JOURNAL ENTRY</strong>
                </label>
            </div>
            <div class="form-check bg-light m-1">
                <input class="form-check-input" type="radio" name="name" id="bhaaw" checked>
                <label class="form-check-label" for="bhaaw">
                    <strong style="font-size:14px;">BHAAW ENTRY</strong>
                </label>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card mb-2">
                        <div class="card-header text-center bg-light text-dark">
                            <strong>BHAAW ENTRY JAMA SIDE</strong>
                        </div>
                        <div class="card-body pt-3">
                            <form method="post" id="bhaawjama-form">
                                <div class="form-group row mb-2">
                                    <label for="insdate" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Date :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm insdate" id="insdate" autocomplete="off" name="insdate" value="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="party_name" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Enter Party Name :</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="party_id" class="party_id">
                                        <input type="hidden" name="tratype" value="PURCHASE">
                                        <input type="text" class="form-control form-control-sm party_name" autoFocus name="party_name" id="party_name" placeholder="Enter Party Name" autocomplete="off" required="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="rate" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Rate :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm rate" name="rate" id="rate" autocomplete="off" required="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="weight" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Weight :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm weight" name="weight" id="weight" autocomplete="off" required="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="value" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Value :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm value" name="value" id="value" autocomplete="off" required="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-sm-4 col-form-label-sm font-weight-bold text-right">Description :</label>
                                    <div class="col-sm-8">
                                        <textarea name="description" rows="5" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="offset-sm-2 col-sm-10 text-right">
                                        <input type="hidden" name="btn_action" value="1">
                                        <button type="submit" id="submit" class="btn btn-sm btn-outline-secondary float-end">Submit</button>
                                    </div>
                                </div>

                                <div class="form-group row" id="">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div id="balance_summary" style="margin-top: -2rem;"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-0">
                        <div class="card-header text-center bg-light text-dark">
                            <strong>BHAAW ENTRY NAAME SIDE</strong>
                        </div>
                        <div class="card-body pt-3">
                            <form method="post" id="bhaawnaame-form">
                                <div class="form-group row mb-2">
                                    <label for="insdate" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Date :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm insdate" id="insdate1" autocomplete="off" name="insdate" value="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="party_name" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Enter Party Name :</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="party_id" class="party_id">
                                        <input type="hidden" name="tratype" value="SALE">
                                        <input type="text" class="form-control form-control-sm party_name" autoFocus name="party_name" placeholder="Enter Party Name" id="party_name" autocomplete="off" required="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="rate" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Rate :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm rate" name="rate" id="rate" autocomplete="off" required="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="weight" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Weight :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm weight" name="weight" id="weight" autocomplete="off" required="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="value" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Value :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm value" name="value" id="value" autocomplete="off" required="">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-sm-4 col-form-label-sm font-weight-bold text-right">Description :</label>
                                    <div class="col-sm-8">
                                        <textarea name="description" rows="5" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="offset-sm-2 col-sm-10 text-right">
                                        <input type="hidden" name="btn_action" value="1">
                                        <button type="submit" id="submit" class="btn btn-sm btn-outline-secondary float-end">Submit</button>
                                    </div>
                                </div>
                
                                <div class="form-group row" id="">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div id="balance_summary" style="margin-top: -2rem;"></div>
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
        <button type="button" class="btn-close btn btn-secondary"  aria-label="Close"  data-bs-dismiss="toast"></button>
        
        </button>
       
    </div>
</div>

<script>
    $(document).ready(function(){

        $('#insdate, #insdate1').datepicker({
            dateFormat:"dd-mm-yy",
            changeMonth: true,
            changeYear: true
        });

        $(document).on('keydown', '.party_name', function() {
		  $( '.party_name' ).autocomplete({
		    source: function( request, response ) {
		    $.ajax({
		      url: "partyName.php",
		      type: 'post',
		      dataType: "json",
		      data: { search: request.term,request:1 },
		      success: function( data ) { response( data ); }
		      });
		    },
			autoFocus:true,
		    select: function (event, ui) {
		       $(this).val(ui.item.label); 
		      var name = ui.item.value; 
		      var party_id = ui.item.party_id;
		       $('.party_id').val(party_id);
		       $(this).val(name);
		       var form = $(this).closest('form').attr('id');
		       balance_summary(0, party_id, form);
		       return false;
		    }
		  });
		});

        function balance_summary(btn_action, party_id, form_id, from_date='', to_date='')
	    {
	      $.ajax({
	        url:"partytransaction_action.php",
	        method:"POST",
	        data:{btn_action:btn_action, party_id:party_id, from_date:from_date, to_date:to_date},
	        success:function(feedback)
	        { 
	          $('#'+form_id+' #balance_summary').html('Balace Details:'+feedback);
	        }
	      });

        $(document).on('submit', '#bhaawjama-form, #bhaawnaame-form', function(event){
		  event.preventDefault();
		    var form_data = $(this).serialize();
		    var id = $(this).attr('id');
		    $(this).find('#submit').attr('disabled', 'disabled');
		    $.ajax({
		     url:"bhaawtransaction_action.php",
		     method:"POST",
		     data:form_data,
		     success:function(feedback)
		     {  		
		     	$('#'+id)[0].reset();
		     	$('#'+id+'  #party_name').focus();
		     	$('#'+id+ ' #submit').attr('disabled', false);
		     	$('#'+id+' #balance_summary').html('');
		     	$('.toast').toast('show');
		     	$('.message').html(feedback);
		     	$('.toast').toast({animation: true, delay: 3000});
		     }
		  }); 
		});
    }
    // function value_calculate(form_id)
    // 	{
	//         var rate = $('#'+form_id+' #rate').val();
	//         var weight = $('#'+form_id+' #weight').val();
	//         $('#'+form_id+' #value').val((rate*weight).toFixed(2));
    // 	}

	//     $(document).on('keyup', '.rate, .weight', function(){
	//     	var form_id = $(this).parent().parent().parent().attr('id');
	//       	value_calculate(form_id);
	//     });
    });
</script>