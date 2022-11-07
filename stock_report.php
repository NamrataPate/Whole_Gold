<?php
// if (!isset($_SESSION['login.php'])) {
//     header('location:login.php');
// }
include('conn.php');
include('function.php');
?>
<script>
    $(function() {
        $(document).attr("title", "STOCK POSITION");
    });
</script>

<div class="card">
    <div class="card-header">
        <strong>STOCK POSITION</strong>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="search-form" method="post">
                <div class="row">
                    <div class="col-sm-3 offset-sm-3">
                        <label for="party_name" class="col-form-label-sm">Choose Date</label>
                        <div class="input-group input-group-sm mb-3" id="datepicker">
                            <input type="text" class="form-control" name="from_date" id="from_date" autocomplete="off" placeholder="dd-mm-YY" aria-label="Username">
                            <span class="input-group-text">To</span>
                            <input type="text" class="form-control" name="to_date" id="to_date" autocomplete="off" placeholder="dd-mm-YY" aria-label="Server">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group"><br>
                            <button type="submit" id="filter" class="btn btn-primary btn-sm mt-2">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover table-sm" style="font-size:13px;" id="stockTable">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" colspan="7" style="font-size:13px;">STOCK POSITION</th>
                    </tr>
                    <tr>
                        <th style="font-size:12px;">Product</th>
                        <th class="text-center" style="font-size:12px;">Gross Weight (in GM)</th>
                        <th class="text-center" style="font-size:12px;">Fine Weight (in GM)</th>
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

        $('#from_date,#to_date').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        load_data('4');

        function load_data(btn_action, from_date = '', to_date = '') {
            $.ajax({
                url: "codewise_detail.php",
                method: "post",
                data: {
                    btn_action: btn_action,
                    from_date: from_date
                },
                success: function(data) {
                    $('#stockTable tbody').html(data);
                }
            });
        }

        $(document).on('submit', '#search-form', function(event) {
            event.preventDefault();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            console.log(from_date, to_date);
            // load_data('4', from_date, to_date);
        });

    });
</script>