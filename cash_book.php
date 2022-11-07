<?php
    // if (!isset($_SESSION['login.php'])) {
    //     header('location:login.php');
    // }
    include('conn.php');
    include('function.php');
    ?>
    <script>
        $(function() {
            $(document).attr("title", "CASH BOOK");
        });
    </script>

    <div class="card">
        <div class="card-header">
            <strong>Cash Book</strong>
        </div>
        <div class="card-body">
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
        </div>
        <div class="row m-2">
            <div class="col-sm-6">
                <table class="table table-bordered striped table-hover table-sm" id="jamaside">
                    <thead class="thead-light">
                        <tr>
                            <th style="font-size:12px;  background-color:#dee2e6;" class="text-center" colspan="7">JAMA SIDE</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;">S.no</th>
                            <th style="font-size:12px;">Date</th>
                            <th style="font-size:12px;">Party</th>
                            <th style="font-size:12px;" class="text-center">Weight <br> (In GM)</th>
                            <th style="font-size:12px;" class="text-center">Amount <br> (In INR)</th>
                            <th style="font-size:12px;">Desc.</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="table table-bordered striped table-hover table-sm" id="naameside">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="font-size:12px; background-color:#dee2e6;" colspan="7">NAAME SIDE</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;">S.no</th>
                            <th style="font-size:12px;">Date</th>
                            <th style="font-size:12px;">Party</th>
                            <th style="font-size:12px;" class="text-center">Weight <br> (In GM)</th>
                            <th style="font-size:12px;" class="text-center">Amount <br> (In INR)</th>
                            <th style="font-size:12px;">Desc.</th>
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

            $('#from_date, #to_date').datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true
            });

            function load_data(limit, start, btn_action, table_id, from_date = '', to_date = '', form = '') {

                $.ajax({
                    url: "transaction_filter.php",
                    method: "POST",
                    data: {
                        limit: limit,
                        start: start,
                        btn_action: btn_action,
                        from_date: from_date,
                        to_date: to_date
                    },
                    success: function(data) {
                        console.log(data)
                        if (form == 'submit') {
                            $('#' + table_id).append(data);

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
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                load_data(limit, start, '3', 'jamaside tbody', from_date, to_date, 'submit');
                load_data(limit, start, '4', 'naameside tbody', from_date, to_date, 'submit');
               // opening_closing('5', from_date, to_date);
            });
        });
    </script>