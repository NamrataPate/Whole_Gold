<?php
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
?>
<div class="container-fluid">
    <div class="card mt-3">
        <div class="card-header">
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#partyModal"> -->
            <strong>Party panel</strong>
            <!-- </button> -->
        </div>
        <div class="card-body mt-1">
            <div class="card-title">
            </div>
            <div class="table-responsive">
                <table id="party_table" class="table table-sm table-bordered table-striped mt-3" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Party Name</th>
                            <th>Mobile</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Party Type</th>
                            <th>Opening Weight</th>
                            <th>Opening Value</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="partyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add new party</h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="party-form" method="post">
                    <div id="alert_action"></div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="party-name">NAME *</label>
                                <input type="text" class="form-control form-control-sm" id="party-name" name="party_name" autocomplete="off" autofocus="" placeholder="Enter Party Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="mobile" name="mobile" autocomplete="off" placeholder="Enter Mobile Number" pattern="[6-9]{1}[0-9]{9}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="city" name="city" autocomplete="off" placeholder="Enter City Name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="state" name="state" autocomplete="off" placeholder="Enter State Name">
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="form-group">

                                <input type="text" class="form-control form-control-sm" id="address" name="address" autocomplete="off" placeholder="Enter Address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <select name="party_type" id="party_type" class="form-control form-control-sm">
                                    <option value="1">DEBTORS</option>
                                    <option value="2">CREDITORS</option>
                                    <option value="3">PARTY ACCOUNT</option>
                                    <option value="4">EXPENSES</option>
                                    <option value="5">LOAN ACCOUNT</option>
                                    <option value="6">GIRVI ACCOUNT</option>
                                    <option value="7">BANK ACCOUNT</option>
                                    <option value="8">CAPITAL ACCPUNT</option>
                                    <option value="9">STAFF ACCOUNT</option>
                                    <option value="10">SELL / PURCHASE</option>
                                    <option value="11">INCOME</option>
                                    <option value="12">SGP NEW</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <input type="text" name="added_date" id="added_date" autocomplete="off" class="form-control form-control-sm" placeholder="Date..." value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="4">Party Opening</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="text-align: center;">Jama</th>
                                            <th colspan="2" style="text-align: center;">Naame</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: middle;"> Weight</td>
                                            <td>
                                                <input type="text" name="jamaw" id="jamaw" class="form-control form-control-sm" value="0">
                                            </td>
                                            <td style="vertical-align: middle;"> Weight</td>
                                            <td>
                                                <input type="text" name="naamew" id="naamew" class="form-control form-control-sm" value="0">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">Value</td>
                                            <td>
                                                <input type="text" name="jamav" id="jamav" class="form-control form-control-sm" value="0">
                                            </td>
                                            <td style="vertical-align: middle;">Value</td>
                                            <td>
                                                <input type="text" name="naamev" id="naamev" class="form-control form-control-sm" value="0">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="party_id" id="party_id">
                        <input type="hidden" name="btn_action" id="btn_action" value="Add">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Save Data</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var height = $('body').height() - $('.navbar').height() - $('.footer').height() - 150;

            let partytable = $('#party_table').DataTable({
                "processing": true,
                "serverSide": true,
                "scrollY": height + "px",
                "scrollCollapse": true,
                "paging": false,
                "order": [],
                "ajax": {
                    url: "party_action.php",
                    type: "POST",
                    data: {
                        btn_action: 'fetch'
                    }
                },
                dom: 'Bfrtip',
                buttons: [{
                        text: '<i class="far fa-user"></i> Add New Party',
                        className: 'btn-sm btn-outline-secondary',
                        attr: {
                            title: 'Add New Party',
                            id: 'add_button'
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('btn-secondary')
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        // text:'<i class="far fa-file-excel text-success"></li> Excel',
                        text: '<i class="far fa-file-excel text-success"></i> Excel',
                        className: 'btn-sm btn-outline-secondary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('btn-secondary')
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="far fa-file-pdf text-danger"></i> PDF',
                        className: 'btn-sm btn-outline-secondary',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Party List',
                        init: function(api, node, config) {
                            $(node).removeClass('btn-secondary')
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn-sm btn-outline-secondary',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Party List',
                        init: function(api, node, config) {
                            $(node).removeClass('btn-secondary')
                        }
                    }
                ],
                "columnDefs": [{
                        "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        "orderable": false,
                    },
                    {
                        "targets": [0, 6, 7, 8],
                        "class": 'text-center',
                    }
                ]
            });

            $('#add_button').attr('data-bs-toggle', 'modal').attr('data-bs-target', '#partyModal');

            $('#add_button').click(function() {
                $('#party_form')[0].reset();
            });

            $(document).on('submit', '#party-form', function(event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    url: "./party_action.php",
                    method: "POST",
                    data: form_data,
                    beforeSend: function() {
                        $('#submit').attr('disabled', 'disabled');
                        $('#submit').html('Submitting...');
                    },
                    success: function(feedback) {
                        if ($('#btn_action').val() == 'Add') {
                            $('#party-form')[0].reset();
                            $('#party_name').focus();
                        }
                        $('#submit').html('Save Data');
                        //$('#alert_action').fadeIn().html(feedback);
                        $('#alert_action').fadeIn().html('<div class="alert alert-success">' + feedback + '</div>');
                        setTimeout(function() {
                            $('#alert_action').fadeOut('fast');
                        }, 5000);
                        $('#submit').attr('disabled', false);
                        partytable.ajax.reload();
                    }
                });
            });

            $(document).on('click', '.update', function() {
                var party_id = $(this).attr("id");
                $.ajax({
                    url: "party_action.php",
                    method: "POST",
                    data: {
                        party_id: party_id,
                        btn_action: 'fetch_single'
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#partyModal').modal('show');
                        $('#party-name').val(data.party_name);
                        $('#mobile').val(data.mobile);
                        $('#city').val(data.city);
                        $('#state').val(data.state);
                        $('#address').val(data.address);
                        $('#party_type').val(data.party_type);
                        $('#added_date').val(data.added_date);
                        $('#jamaw').val(data.jamaw);
                        $('#jamav').val(data.jamav);
                        $('#naamew').val(data.naamew);
                        $('#naamev').val(data.naamev);
                        $('.modal-title').html("Edit Party Details");
                        $('#party_id').val(party_id);
                        $('#btn_action').val('Edit');
                        // console.log(data);
                        $('#submit').html('<i class="fa fa-check"></i> Edit Data');
                        partytable.ajax.reload();
                        // console.log(data);
                    }

                });
            });

            $(document).on('click', '.change-status', function() {
                var party_id = $(this).attr("id");
                var party_status = $(this).data('status');
                if (confirm('Are you sure you want to change party status ?')) {
                    $.ajax({
                        url: "party_action.php",
                        method: "POST",
                        data: {
                            party_id: party_id,
                            party_status: party_status,
                            btn_action: 'status'
                        },
                        success: function(data) {
                            alert(data)
                            partytable.ajax.reload();
                        }
                    });
                } else {
                    return false;
                }
            });

            $(document).on('click', '.delete', function() {
                var party_id = $(this).attr("id");
                if (confirm('Are you sure you want to delete party Parmanent ?')) {
                    $.ajax({
                        url: "party_action.php",
                        method: "POST",
                        data: {
                            party_id: party_id,
                            btn_action: 'delete'
                        },
                        success: function(data) {
                            alert(data)
                            partytable.ajax.reload();
                        }
                    });
                } else {
                    return false;
                }
            });

            $('#added_date').datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>