<?php
if(!isset($_SESSION['id']))
{
 header("location:login.php");
}
?>
<script>
$(function(){
   $(document).attr("title", "PARTY BALANCE DETAILS");
});
</script>
<div class="card border-bottom-0 mb-0">
	<div class="card-header">
    	<strong>Party Balance Data List</strong>
  	</div>
  	<div class="card-body pt-3">

      <div class="card mb-2">
        <div class="card-body py-0">
          <form id="search-form" method="post">
            <div class="row">
            	<div class="col-sm-2">
			        <div class="form-group">
			          <label style="font-size:12px;" for="party_type">Party Type</label>
			          <select name="party_type" id="party_type" class="form-control form-control-sm">
			            <option value="">Party Type</option>
			            <option value="1">DEBTORS</option>
			            <option value="2">CREDITORS</option>
			            <option value="3">PARTY ACCOUNT</option>
			            <option value="4">EXPENSES</option>
			            <option value="5">LOAN ACCOUNT</option>
			            <option value="6">GIRVI ACCOUNT</option>
			            <option value="7">BANK ACCOUNT</option>
			            <option value="8">CAPITAL ACCPUNT</option>
			            <option value="9">STAFF ACCOUNT</option>
			            <option value="10">SELL/ PURCHASE</option>
			            <option value="11">INCOME</option>
			            <option value="12">SGP NEW</option>
			          </select>
			        </div>
			    </div>
			    <div class="col-sm-3">
			        <div class="form-group">
			          <label style="font-size:12px;" for="party_name">Party Name</label>
			          <input type="hidden" name="party_id" id="party_id" class="form-control">
			          <input type="text" name="party_name" id="party_name" class="form-control form-control-sm" placeholder="Enter Party name">
			        </div>
			    </div>
              	<div class="col-sm-3">
                  <label style="font-size:12px;">Choose Date </label>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-sm" name="from_date" id="from_date" placeholder="dd/mm/yy" autocomplete="off">
                    <span class="input-group-text">To</span>
                    <input type="text" class="form-control form-control-sm" name="to_date" id="to_date" placeholder="dd/mm/yy" autocomplete="off">
                  </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group"><br>
                   <button type="submit" id="filter" class="btn btn-primary btn-sm mt-2" >Search</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
  		<div class="row">
  			<div class="col-sm-12 px-0">
  				<table class="table table-bordered table-sm" id="partyBalanceTable" >
  					<thead class="thead-light">
  						<tr>
  							<th style="font-size:12px; background-color: #dee2e6;" class="text-center" colspan="7">PARTY BALANCE DETAIL</th>
  						</tr>
  						<tr>
  							<th style="font-size:12px;">S.no</th>
  							<th style="font-size:12px;">Party</th>
  							<th style="font-size:12px;">Weight</th>
  							<th style="font-size:12px;">Credit Amount</th>
                <th style="font-size:12px;">Debit Amount</th>
  						</tr>
  					</thead>
  					<tbody style="font-size:12px;">
                 
            </tbody>
  				</table>
  			</div>
  			
  		</div>
  	</div>
</div>
<script>
  $(document).ready(function(){ 

    var height = $('body').height() - $('.navbar').height() - $('#search-form').height()-70;
    var trheight = $('tr').height();    

    $('#from_date , #to_date').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

    $(document).on('keydown', '#party_name', function() {
      $( '#party_name' ).autocomplete({
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
           $('#party_id').val(party_id);
           $(this).val(name);
           return false;
        }
      });
    });


    var limit = Math.round(height/trheight); 
    var start = 0;
    var action = 1; 

    function load_data(btn_action, party_type='', party_id='', from_date='', to_date='', form='')
    {
      $.ajax({
        url:"partytransaction_action.php",
        method:"POST",
        data:{btn_action:btn_action, party_type:party_type, party_id:party_id, from_date:from_date, to_date:to_date},
        success:function(data)
        { 
          $('#partyBalanceTable tbody').html(data);
          
        }
      });
    }

    var from_date = '';
    var to_date = '';
    var party_type = '';
    var party_id = '';

    if (action == 1) 
    {
      action=0; 
      load_data('3');
    }

    $(document).on('submit', '#search-form', function(event){
      event.preventDefault();
     
      limit = Math.round(height/trheight); 
      start = 0;
   
      party_type = $('#party_type').val();
      party_id = $('#party_id').val();
      from_date = $('#from_date').val();
      to_date = $('#to_date').val();

      
      load_data('3', party_type, party_id, from_date, to_date);
    });

    $("#party_type").on('change', function(){

    	limit = Math.round(height/trheight); 
	    start = 0;
	    
	    party_type = $('#party_type').val();
	    party_id = $('#party_id').val();
	    from_date = $('#from_date').val();
	    to_date = $('#to_date').val();
     
       load_data('3', party_type, party_id);
    });
  
 });
</script>