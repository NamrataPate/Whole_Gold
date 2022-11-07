<?php

include('conn.php');
include('function.php');

if(!isset($_SESSION['id']))
{
 header("location:login.php");
}
?>
<script>
$(function(){
   $(document).attr("title", "EDIT CASH ENTRY FORM");
});
</script>

<div class="card border-bottom-0 mb-0">
	<div class="card-header">
    	<strong>Edit Cash Transaction</strong>
  	</div>
  	<div class="card-body pt-3">
  		<div class="container">

			<div class="row mt-3">
				<?php
					if (isset($_GET['tid'], $_GET['type']))
					{ 
						$type = convert_string('decrypt', $_GET['type']);
						$tid = convert_string('decrypt', $_GET['tid']);

						if ($type == 'jama') 
						{
							$statement = mysqli_query($db, "SELECT bt.insdate, bt.party_id, bt.amount, bt.description, pt.party_name FROM bhaaw_tbl as bt JOIN party_tbl as pt ON pt.party_id=bt.party_id WHERE bt.tid = '".$tid."' ");
							while ($row = mysqli_fetch_assoc($statement)) 
							{
								$insdate =	date('d-m-Y', strtotime($row['insdate']));
								$party_id =	$row['party_id'];
								$party_name =	$row['party_name'];
								$amount =	$row['amount'];
								$description =	$row['description'];
							}
						?>
							<div class="col-md-6">
								<div class="card mb-0">
									<div class="card-header text-center bg-light text-dark">
								    	<strong style= "font-size: 12px;">EDIT CASH ENTRY JAMA SIDE</strong>
								  	</div>
								  	<div class="card-body pt-3">
								  		<form method="post" id="cashjama-form">
								  			<div class="form-group row mb-2">
											    <label for="insdate" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Date :</label>
											    <div class="col-sm-8">
											      <input type="text" class="form-control form-control-sm insdate" id="insdate" autocomplete="off" name="insdate" value="<?php echo $insdate; ?>">
											    </div>
											</div>
											<div class="form-group row mb-2">
											    <label for="party_name" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Enter Party Name :</label>
											    <div class="col-sm-8">
											    	<input type="hidden" name="party_id" class="party_id" value="<?php echo $party_id; ?>">
											    	<input type="hidden" name="tratype" value="PURCHASE">
									      			<input type="text" class="form-control form-control-sm party_name" autoFocus name="party_name" id="party_name" autocomplete="off" required="" value="<?php echo $party_name; ?>" >
											    </div>
											</div>
											<div class="form-group row mb-2">
											    <label for="amount" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Amount :</label>
											    <div class="col-sm-8">
									      			<input type="text" class="form-control form-control-sm amount" name="amount" id="amount" autocomplete="off" required="" value="<?php echo $amount; ?>">
											    </div>
											</div>
											<div class="form-group row mb-2">
											    <label class="col-sm-4 col-form-label-sm font-weight-bold text-right">Description :</label>
											    <div class="col-sm-8">
											    	<textarea name="description" rows="5" class="form-control form-control-sm"><?php echo $description; ?></textarea>
											    </div>
											</div>
											<div class="form-group row">
												<div class="offset-sm-2 col-sm-10 text-right">
											    	<input type="hidden" name="tid" value="<?php echo $_GET['tid']; ?>">
											    	<input type="hidden" name="btn_action" value="6">
											      	<button type="submit" id="submit" class="btn btn-sm btn-outline-secondary">Update</button>
											    </div>
											</div>
								  		</form>
								  	</div>
								</div>
							</div>
						<?php
						}

						if ($type == 'naame')
						{
							$statement = mysqli_query($db, "SELECT bt.insdate, bt.party_id, bt.amount, bt.description, pt.party_name FROM bhaaw_tbl as bt JOIN party_tbl as pt ON pt.party_id=bt.party_id WHERE bt.tid = '".$tid."' ");
							while ($row = mysqli_fetch_assoc($statement)) 
							{
								$insdate =	date('d-m-Y', strtotime($row['insdate']));
								$party_id =	$row['party_id'];
								$party_name =	$row['party_name'];
								$amount =	$row['amount'];
								$description =	$row['description'];
							}
						?>
							<div class="col-md-6">
								<div class="card mb-0">
									<div class="card-header text-center bg-light text-dark">
								    	<strong>EDIT CASH ENTRY NAAME SIDE</strong>
								  	</div>
								  	<div class="card-body pt-3">
								  		<form method="post" id="cashnaame-form">
								  			<div class="form-group row mb-0">
											    <label for="insdate" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Date :</label>
											    <div class="col-sm-8">
											      <input type="text" class="form-control form-control-sm insdate" id="insdate" autocomplete="off" name="insdate" value="<?php echo $insdate; ?>">
											    </div>
											</div>
											<div class="form-group row mb-0">
											    <label for="party_name" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Enter Party Name :</label>
											    <div class="col-sm-8">
											    	<input type="hidden" name="party_id" class="party_id" value="<?php echo $party_id; ?>">
											    	<input type="hidden" name="tratype" value="SALE">
									      			<input type="text" class="form-control form-control-sm party_name" name="party_name" id="party_name" autocomplete="off" required="" value="<?php echo $party_name; ?>">
											    </div>
											</div>
											<div class="form-group row mb-0">
											    <label for="amount" class="col-sm-4 col-form-label-sm font-weight-bold text-right">Amount :</label>
											    <div class="col-sm-8">
									      			<input type="text" class="form-control form-control-sm amount" name="amount" id="amount" autocomplete="off" required="" value="<?php echo $amount; ?>">
											    </div>
											</div>
											<div class="form-group row mb-2">
											    <label class="col-sm-4 col-form-label-sm font-weight-bold text-right">Description :</label>
											    <div class="col-sm-8">
											    	<textarea name="description" rows="5" class="form-control form-control-sm"><?php echo $description; ?></textarea>
											    </div>
											</div>
											<div class="form-group row">
												<div class="offset-sm-2 col-sm-10 text-right">
													<input type="hidden" name="tid" value="<?php echo $_GET['tid']; ?>">
											    	<input type="hidden" name="btn_action" value="6">
											      	<button type="submit" id="submit" class="btn btn-sm btn-outline-secondary">Update</button>
											    </div>
											</div>
								  		</form>
								  	</div>
								</div>
							</div>
						<?php
						} 
					}
				?>
				
			</div>
  		</div>
  	</div>
</div>

<div class="toast bg-info" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="position: absolute; top: 10px; right: 10px;min-width: 250px;">
  <div class="toast-body">
  	<button type="button" class="ml-2 mb-2 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <span class="message"></span>
  </div>
</div>
<script>
	$(document).ready(function(){

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
		       return false;
		    }
		  });
		});


		$(document).on('submit', '#cashjama-form, #cashnaame-form', function(event){
		  event.preventDefault();
		    var form_data = $(this).serialize();
		    var id = $(this).attr('id');
		    $(this).find('#submit').attr('disabled', 'disabled');
		    $.ajax({
		     url:"cashtransaction_action.php",
		     method:"POST",
		     data:form_data,
		     success:function(feedback)
		     {  		
		     	// $('#'+id)[0].reset();
		     	// $('#'+id+'  #party_name').focus();
		     	$('#'+id+ ' #submit').attr('disabled', false);
		     	$('.toast').toast('show');
		     	$('.message').html(feedback);
		     	// $('.toast').toast({animation: true, delay: 3000});
		     }
		  }); 
		});

		$('.insdate').datepicker({
		    format: "dd-mm-yyyy",
		    autoclose: true,
		    todayHighlight: true
		});

	});
</script>


