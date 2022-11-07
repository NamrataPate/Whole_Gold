<?php
if(!isset($_SESSION['id']))
{
 header("location:login.php");
}
?>
<script>
$(function(){
   $(document).attr("title", "EXPENSES DETAILS");
});
</script>
<div class="card border-bottom-0 mb-0">
	<div class="card-header">
    	<strong>Expenses Details</strong>
  	</div>
  	<div class="card-body pt-3">
      <div class="card mb-2">
        <div class="card-body py-0">
          <form id="search-form" method="post">
            <div class="row">
              <div class="col-sm-3">
                  <label>Choose Date <span class="text-danger">*</span></label>
                  <div class="input-daterange input-group input-group-sm" id="datepicker">
                      <input type="text" class="form-control form-control-sm mb-2" name="from_date" id="from_date" autocomplete="off" >
                      <div class="input-group-prepend">
                        <span class="input-group-text mb-2" id="inputGroup-sizing-sm">to</span>
                      </div>
                      <input type="text" class="form-control form-control-sm mb-2" name="to_date" id="to_date" autocomplete="off" >
                  </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="party_name">Expense Name</label>
                  <input type="hidden" name="party_id" id="party_id">
                  <input type="text" name="party_name" id="party_name" class="form-control form-control-sm" required="">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group"><br>
                   <button type="submit" id="filter" class="btn btn-primary btn-sm mb-2" >Search</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
  		<div class="row">
  			<div class="col-sm-12 px-0" id="expenseData">
  				
  			</div>
  			
  		</div>
  	</div>
</div>
<script>
  $(document).ready(function(){ 

    var height = $('body').height() - $('.navbar').height() -  $('#search-form').height()-70;
    var trheight = $('tr').height();   

    $('#from_date, #to_date').datepicker({
       dataformat: 'dd/mm/yyyy',
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
          data: { search: request.term,request:2 },
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

    $(document).on('submit', '#search-form', function(event){
      event.preventDefault();
      var party_id = $("#party_id").val();
      var from_date = $("#from_date").val();
      var to_date = $("#to_date").val();
     $.ajax({
        url:"expenses_action.php",
        method:"POST",
        data:{btn_action:'0', party_id:party_id, from_date:from_date, to_date:to_date},
        success:function(data)
        { 
          $('#expenseData').html(data);
        }
      });
    });

 });
</script>