<?php

include ('conn.php');
include ('function.php');

if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
?>
<div class="card border-bottom-0 mb-0">
    <div class="card-header">
        <strong>Code Wise Stocks</strong>
    </div>
    <div class="card-body pt-3">
        <div class="card mb-2">
            <div class="card-body py-0">
                <div class="row">
                    <div class="col-sm-4">
                        <form id="search-form" method="post">
                            <div class="form-group row">
                                <label for="product_id">Code :</label>
                                <div class="col-sm-10 mt-3">
                                <select name="product_id" id="product_id" class="form-control form-control-sm">
                                    <?php echo list_value($db, "product_tbl", "code", "product_id", "Select Code"); ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label for="from_date" class="col-sm-4 col-form-label-sm font-weight-bold">From Date :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm date" placeholder="dd/mm/yy" id="from_date" autocomplete="off" name="from_date" required="">
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="to_date" class="col-sm-4 col-form-label-sm font-weight-bold">From Date :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm date"  placeholder="dd/mm/yy" id="to_date" autocomplete="off" name="to_date" required="">
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="col-sm-8 offset-sm-4 text-center">
                                    <button type="submit" id="filter" class="btn btn-primary btn-sm">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-4 offset-sm-4">
                        <div id="balance_summary">

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 px-0">
                <table class="table table-bordered table-sm" id="jamaside">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center"  style="font-size:12px; background-color: #e9ecef;" colspan="8">JAMA SIDE</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;">S.no</th>
                            <th style="font-size:12px;">Date</th>
                            <th style="font-size:12px;">Party</th>
                            <th style="font-size:12px;">Gross Wt.</th>
                            <th style="font-size:12px;">Fine Wt.</th>
                            <th style="font-size:12px;">Val.</th>
                            <th style="font-size:12px;"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="col-sm-6 px-0">
                <table class="table table-bordered table-sm" id="naameside">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center"  style="font-size:12px; background-color: #e9ecef;" colspan="8">NAAME SIDE</th>
                        </tr>
                        <tr style="font-size:12px;">
                            <th style="font-size:12px;">S.no</th>
                            <th style="font-size:12px;">Date</th>
                            <th style="font-size:12px;">Party</th>
                            <th style="font-size:12px;">Gross Wt.</th>
                            <th style="font-size:12px;">Fine Wt.</th>
                            <th style="font-size:12px;">Val.</th>
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
  $(document).ready(function(){ 

    var height = $('body').height() - $('.navbar').height() - $('#search-form').height()-70;
    var trheight = $('tr').height();    


    $('.date').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

    function load_data(limit, start, btn_action, table_id, category_id='', product_id='', from_date='', to_date='', form='')
    {
      $.ajax({
        url:"codewise_detail.php",
        method:"POST",
        data:{limit:limit, start:start, btn_action:btn_action, category_id:category_id, product_id:product_id, from_date:from_date, to_date:to_date},
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

    function balance_summary(btn_action, category_id='', product_id='', from_date='', to_date='')
    {
      $.ajax({
        url:"codewise_detail.php",
        method:"POST",
        data:{btn_action:btn_action, category_id:category_id, product_id:product_id, from_date:from_date, to_date:to_date},
        success:function(feedback)
        { 
          $('#balance_summary').html(feedback);
        }
      });
    }

    $(document).on('submit', '#search-form', function(event){
      event.preventDefault();
      
      var limit = Math.round(height/trheight); //20;
      var start = 0;
      var action = 1;
      var category_id = $('#category_id').val();
      var product_id = $('#product_id').val();
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();

      if (category_id != '' || product_id != '') 
      {
        load_data(limit, start, '1', 'jamaside tbody', category_id, product_id, from_date, to_date, 'submit');
        load_data(limit, start, '2', 'naameside tbody', category_id, product_id, from_date, to_date, 'submit');
        balance_summary('3', category_id, product_id, from_date, to_date);
      }
      else
      {
        alert('Please Select Category or Code');
      }

    });

   
    $('#hdScrolljamaside').scroll(function(){
      if ($(this).scrollTop() + $(this).height() > $('#jamaside tbody').height() && action == 1) 
      { 
        action = 0;
        start = start + limit;
        
        setTimeout(function(){
          load_data(limit, start, '1', 'jamaside tbody', category_id, product_id, from_date, to_date);  
        });
      }
    });

    
    $('#hdScrollnaameside').scroll(function(){
      if ($(this).scrollTop() + $(this).height() > $('#naameside tbody').height() && action == 1) 
      { 
        action = 0;
        start = start + limit;

        setTimeout(function(){
          load_data(limit, start, '2', 'naameside tbody', category_id, product_id, from_date, to_date);  
        });
      }
    });

 });
</script>