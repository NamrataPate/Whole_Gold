<?php
if (!isset($_SESSION["id"])) {
  header("location:login.php");
}
?>
<script>
  $(function() {
    $(document).attr("title", "DAY BOOK REPORT");
  });
</script>
<div class="card">
  <div class="card-header">
    <strong>Day Book Data</strong>
  </div>
  <div class="card-body">
    <div class="card m-2">
      <div class="card-body">
        <form id="search-form" method="post">
          <div class="row">
            <div class="col-sm-3 mb-3 ">
              <label for="party_name" class="col-form-label-sm">Choose Date</label>

              <div class="input-group input-group-sm m-3" id="datepicker">
                <input type="text" class="form-control" name="from_date" id="from_date" autocomplete="off" placeholder="dd-mm-yy" aria-label="Username">
              </div>
            </div>

            <div class="col-sm-2 m-3">
              <div class="form-group"><br>
                <button type="submit" id="filter" class="btn btn-primary btn-sm mt-2">Search</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row m-2">
  <div class="col-sm-6">
    <table class="table table-bordered striped table-hover table-sm">
      <thead class="thead-light">
        <tr>
          <th class="text-center" colspan="7" style="font-size:12px;">JAMA SIDE (PURCHASE)</th>
        </tr>
        <tr>
          <th style="font-size:12px;">S.no</th>
          <th style="font-size:12px;">Date</th>
          <th style="font-size:12px;">Party</th>
          <th style="font-size:12px;" class="text-center">Weight <br>(In GM)</th>
          <th style="font-size:12px;" class="text-center">Amount <br>(In INR)</th>
          <th style="font-size:12px;">Desc.</th>
        </tr>
      </thead>
      <tbody id="jamaside">

      </tbody>
    </table>
  </div>
  <div class="col-sm-6">
    <table class="table table-bordered striped table-hover table-sm">
      <thead class="thead-light">
        <tr>
          <th class="text-center" colspan="7" style="font-size:12px;">NAAME SIDE (SALE)</th>
        </tr>
        <tr>
          <th style="font-size:12px;">S.no</th>
          <th style="font-size:12px;">Date</th>
          <th style="font-size:12px;">Party</th>
          <th style="font-size:12px;">Weight <br>(In GM)</th>
          <th style="font-size:12px;">Amount <br>(In INR)</th>
          <th style="font-size:12px;">Desc.</th>
        </tr>
      </thead>
      <tbody id="naameside">

      </tbody>
    </table>
  </div>

</div>

<script>
  $(document).ready(function() {

    var height = $('body').height() - $('.navbar').height() - $('#search-form').height() - 70;
    var trheight = $('tr').height();

    $('#from_date').datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true
    });


    function load_data(limit, start, btn_action, table_id, date, form = '') {
      // console.log(limit);
      // console.log(start);
      // console.log(btn_action);
      // console.log(table_id);
      // console.log(date);
      $.ajax({
        url: "transaction_filter.php",
        method: "POST",
        data: {
          limit: limit,
          start: start,
          btn_action: btn_action,
          day_date: date
        },
        success: function(data) {
          if (form == 'submit') {
            $('#' + table_id).html(data);
          } else {
            $('#' + table_id).append(data);
          }

          if (data == '') {
            action = 0;
          } else {
            action = 1;
          }
        }
      });
    }

    $(document).on('submit', '#search-form', function(event) {
      event.preventDefault();

      var limit = Math.round(height / trheight);
      var start = 0;
      var action = 1;
      var day_date = $('#from_date').val();

      load_data(limit, start, '1', 'jamaside', day_date, 'submit');
      load_data(limit, start, '2', 'naameside', day_date, 'submit');
    });



    $('#hdScrolljamaside').scroll(function() {
      if ($(this).scrollTop() + $(this).height() > $('#jamaside tbody').height() && action == 1) {
        action = 0;
        start = start + limit;

        setTimeout(function() {
          load_data(limit, start, '1', 'jamaside tbody', day_date);
        });
      }
    });

    $('#hdScrollnaameside').scroll(function() {
      if ($(this).scrollTop() + $(this).height() > $('#naameside tbody').height() && action == 1) {
        action = 0;
        start = start + limit;

        setTimeout(function() {
          load_data(limit, start, '2', 'naameside tbody', day_date);
        });
      }
    });

  });
</script>