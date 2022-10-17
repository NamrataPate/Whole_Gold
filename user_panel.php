<?php
include 'conn.php';
include 'function.php';
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
?>
<div class="container-fluid">
    <div class="card mt-3">
        <div class="card-header">
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"> -->
            <strong>User Panel</strong>
            <!-- </button> -->
        </div>
        <div class="card-body py-0">
            <div class="card-title">
            </div>
            <div class="table-responsive">
                <table id="user_table" class="table table-sm table-bordered table-striped m-0" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Profile</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel" style="font-size:15px;">Add New User</h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body font-size">
                <form id="user-form" method="post">
                    <div class="modal-body">
                        <div id="alert_action"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user-name">User Name *</label>
                                    <input type="text" class="form-control form-control-sm" id="user-name" name="user_name" autocomplete="off" autofocus="" placeholder="Enter User Name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user-password">User Password *</label>
                                    <input type="password" class="form-control form-control-sm" id="user-password" name="user_password" autocomplete="off" placeholder="Enter User Password">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user-mobile">User Mobile *</label>
                                    <input type="text" class="form-control form-control-sm" id="user-mobile" name="user_mobile" autocomplete="off" placeholder="Enter User Mobile">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user-email">User Email</label>
                                    <input type="text" class="form-control form-control-sm" id="user-email" name="user_email" autocomplete="off" placeholder="Enter User Email">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user-address">User Address</label>
                                    <input type="text" class="form-control form-control-sm" id="user-address" name="user_address" autocomplete="off" placeholder="Enter User Address">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="btn_action" id="btn_action" value="Add">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Save Data</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var height = $('body').height() - $('.navbar').height() - $('.footer').height() - 150;

        var usertable = $('#user_table').DataTable({
        
            "processing": true,
            "serverSide": true,
            "scrollY": "430px",
            "scrollCollapse": true,
            "paging": false,
            "order": [],
            "ajax": {
                url: "user_action.php",
                type: "POST",
                data: {
                    btn_action: 'fetch'
                }
            },
            dom: 'Bfrtip', // lBfrtip
            buttons: [{
                    text: '<i class="far fa-user"></i> Add New User',
                    className: 'btn-sm btn-outline-secondary',
                    attr: {
                        title: 'Add New User',
                        id: 'add_button'
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary')
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="far fa-file-excel text-success"></i> Excel',
                    className: 'btn-sm btn-outline-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary')
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="far fa-file-pdf text-danger"></i> PDF',
                    className: 'btn-sm btn-outline-secondary',
                    // orientation: 'landscape', 
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
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
                    // orientation: 'landscape', 
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    title: 'Party List',
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary')
                    }
                }
            ],
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5, 6],
                "orderable": false,
            }]
            
        });


        $('#add_button').attr('data-bs-toggle', 'modal').attr('data-bs-target', '#userModal');

        $('#add_button').click(function() {
            $('#user-form')[0].reset();
        });

        $(document).on('submit', '#user-form', function(event) {
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: "user_action.php",
                method: "POST",
                data: form_data,
                // beforeSend: function() {
                //     $('#submit').attr('disabled', 'disabled');
                //     $('#submit').html('Submitting...');
                // },
                success: function(feedback) {
                    if ($('#btn_action').val() == 'Add') {
                        $('#user-form')[0].reset();
                        $('#user-name').focus();
                    }
                    $('#submit').html('Save Data');
                    $('#alert_action').fadeIn().html(feedback);
                    $('#submit').attr('disabled', false);
                    usertable.ajax.reload();
                }
            });
        });

        $(document).on('click', '.update', function() {
            var user_id = $(this).attr("id");
            $.ajax({
                url: "user_action.php",
                method: "POST",
                data: {
                    user_id: user_id,
                    btn_action: 'fetch_single'
                },
                dataType: "json",
                success: function(data) {
                    $('#userModal').modal('show');
                    // $('#userModal').modal({ backdrop: 'static', keyboard: false });
                    $('#user-name').val(data.user_name);
                    $('#user-password').val(data.user_password);
                    $('#user-mobile').val(data.mobile);
                    $('#user-email').val(data.email);
                    $('#user-address').val(data.address);
                    $('.modal-title').html("Edit User Details");
                    $('#user_id').val(user_id);
                    $('#btn_action').val('Edit');
                    $('#submit').html('<i class="fa fa-check"></i> Edit Data');
                }
            });
        });

        $(document).on('click', '.change-status', function() {
            var user_id = $(this).attr("id");
            var user_status = $(this).data('status');
            if (confirm('Are you sure you want to change User status ?')) {
                $.ajax({
                    url: "user_action.php",
                    method: "POST",
                    data: {
                        user_id: user_id,
                        user_status: user_status,
                        btn_action: 'status'
                    },
                    success: function(data) {
                        alert(data)
                        usertable.ajax.reload();
                    }
                });
            } else {
                return false;
            }
        });

        $(document).on('click', '.delete', function() {
            var user_id = $(this).attr("id");
            if (confirm('Are you sure you want to delete party Parmanent ?')) {
                $.ajax({
                    url: "user_action.php",
                    method: "POST",
                    data: {
                        user_id: user_id,
                        btn_action: 'delete'
                    },
                    success: function(data) {
                        alert(data)
                        usertable.ajax.reload();
                    }
                });
            } else {
                return false;
            }
        });
    });
</script>