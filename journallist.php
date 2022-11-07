<?php
if(!isset($_SESSION['id']))
{
 header("location:login.php");
}
?>
<script>
$(function(){
   $(document).attr("title", "JOURNAL DATA");
});
</script>
<div class="card border-bottom-0 mb-0">
	<div class="card-header">
    	<strong>Journal Data List</strong>
  	</div>
  	<div class="card-body pt-3">

      <div class="card mb-2">
        <div class="card-body py-0">
          <form id="search-form" method="post">
            <div class="row">
              <div class="col-sm-3">
                  <label>Choose Date <span class="text-danger">*</span></label>
                  <div class="input-daterange input-group input-group-sm mb-2" id="datepicker">
                      <input type="text" class="form-control form-control-sm mb-2" name="from_date" id="from_date" autocomplete="off" required="">
                      <div class="input-group-prepend">
                        <span class="input-group-text mb-2" id="inputGroup-sizing-sm">to</span>
                      </div>
                      <input type="text" class="form-control form-control-sm mb-2" name="to_date" id="to_date" autocomplete="off" required="">
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
  			<div class="col-sm-6 px-0">
  				<table class="table table-bordered table-sm" id="jamaside" >
  					<thead class="thead-light">
  						<tr>
  							<th class="text-center" style="font-size:12px; background-color: #e9ecef;" colspan="7">JAMA SIDE</th>
  						</tr>
  						<tr>
  							<th style="font-size:12px;">S.no</th>
  							<th style="font-size:12px;">Date</th>
  							<th style="font-size:12px;">Party</th>
  							<th style="font-size:12px;">Amount</th>
  							<th style="font-size:12px;">Desc.</th>
  							<th></th>
  							<th></th>
  						</tr>
  					</thead>
  					<tbody style="font-size:12px;">
                 
            </tbody>
  				</table>
  			</div>
  			<div class="col-sm-6 px-0">
  				<table class="table table-bordered table-sm" id="naameside" >
  					<thead class="thead-light">
  						<tr>
  							<th class="text-center" style="font-size:12px; background-color: #e9ecef;" colspan="7">NAAME SIDE</th>
  						</tr>
  						<tr>
  							<th style="font-size:12px;">S.no</th>
  							<th style="font-size:12px;">Date</th>
  							<th style="font-size:12px;">Party</th>
  							<th style="font-size:12px;">Amount</th>
  							<th style="font-size:12px;">Desc.</th>
  							<th></th>
  							<th></th>
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

    var height = $('body').height() - $('.navbar').height()  - $('#search-form').height()-70;
    var trheight = $('tr').height();   

    $('#from_date, #to_date').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true
    });

 
    var limit = Math.round(height/trheight);
    var start = 0;
    var action = 1; 

    function load_data(limit, start, btn_action, table_id, from_date='', to_date='', form='')
    {
      $.ajax({
        url:"journaltransaction_action.php",
        method:"POST",
        data:{limit:limit, start:start, btn_action:btn_action, from_date:from_date, to_date:to_date},
        success:function(data)
        { 
          if (form == 'submit') 
          {
            $('#'+table_id).html(data);
          }
          else
          {
            $('#'+table_id).append(data);
          }

          if (data == '') 
          {
            action = 0;
          }
          else
          {
            action = 1;
          }
        }
      });
    }

    var from_date = '';
    var to_date = '';

    if (action == 1) 
    {
      action=0; 
      load_data(limit, start, '3', 'jamaside tbody');
      load_data(limit, start, '4', 'naameside tbody');
    }

    $(document).on('submit', '#search-form', function(event){
      event.preventDefault();
    
      limit = Math.round(height/trheight); 
      start = 0;
      action = 1;
      from_date = $('#from_date').val();
      to_date = $('#to_date').val();

      load_data(limit, start, '3', 'jamaside tbody', from_date, to_date, 'submit');
      load_data(limit, start, '4', 'naameside tbody', from_date, to_date, 'submit');
    });
   

    
    $('#hdScrolljamaside').scroll(function(){
      if ($(this).scrollTop() + $(this).height() > $('#jamaside tbody').height() && action == 1) 
      { 
        action = 0;
        start = start + limit;
        
        setTimeout(function(){
          load_data(limit, start, '3', 'jamaside tbody', from_date, to_date);  
        });
      }
    });

    
    $('#hdScrollnaameside').scroll(function(){
      if ($(this).scrollTop() + $(this).height() > $('#naameside tbody').height() && action == 1) 
      { 
        action = 0;
        start = start + limit;

        setTimeout(function(){
          load_data(limit, start, '4', 'naameside tbody', from_date, to_date);  
        });
      }
    });


    $(document).on('click', '.delete', function(){
    var traid = $(this).attr("id");
    if(confirm("Are you sure you want to Delete Data?"))
    {
     $.ajax({
      url:"journaltransaction_action.php",
      method:"POST",
      data:{traid:traid, btn_action:'5'},
      success:function(data)
      {
        location.reload();
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