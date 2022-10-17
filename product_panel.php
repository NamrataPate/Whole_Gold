<?php
// include('conn.php');
include 'function.php';
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
?>
<div class="container-fluid">
    <div class="card mt-3">
        <div class="card-header">
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal"> -->
            <strong>Product panel</strong>
            <!-- </button> -->
        </div>
        <div class="card-body mt-3 py-0">
            <div class="card-title">
            </div>
            <div class="table-responsive">
                <table id="product-table" class="table table-sm table-bordered table-striped m-0" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Product Name</th>
                            <th>Product Category</th>
                            <th>Unit</th>
                            <th>Gross Wt</th>
                            <th>Fine Wt</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="productModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel" style="font-size:15px;">Add New Product</h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body font-size">
                <form id="product-form" method="post">
                    <div class="modal-body">
                        <div id="alert_action"></div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group" style="font-size:15px;">
                                    <label for="product-code">Product Code*</label>
                                    <input type="text" class="form-control form-control-sm" id="product-code" name="product_code" autocomplete="off" autofocus="" placeholder="Enter Product Code">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group" style="font-size:15px;">
                                    <label for="product-name">Product Name*</label>
                                    <input type="text" class="form-control form-control-sm" id="product-name" name="product_name" autocomplete="off" placeholder="Enter Product Name">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group" style="font-size:15px;">
                                    <label for="category-id">Product Category</label>
                                    <select name="category_id" id="category-id" class="form-control form-control-sm">
                                        <?php echo list_value($db, "product_category_tbl", "category_name", "category_id", "Select Category"); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group" style="font-size:15px;">
                                    <label for="product-unit">Product Unit</label>
                                    <select name="product_unit" id="product-unit" class="form-control form-control-sm">
                                        <option value="GM">GM</option>
                                        <option value="CARAT">CARAT</option>
                                        <option value="KG">KG</option>
                                        <option value="PCS">PCS</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="font-size:15px;">
                            <div class="col-md-12">
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
                                                <td style="vertical-align: middle;">Gross Weight</td>
                                                <td>
                                                    <input type="text" name="jamagw" id="jamagw" class="form-control form-control-sm" value="0">
                                                </td>
                                                <td style="vertical-align: middle;">Gross Weight</td>
                                                <td><input type="text" name="naamegw" id="naamegw" class="form-control form-control-sm" value="0"></td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle;">Fine Weight</td>
                                                <td><input type="text" name="jamafw" id="jamafw" class="form-control form-control-sm" value="0"></td>
                                                <td style="vertical-align: middle;">Fine Weight</td>
                                                <td><input type="text" name="naamefw" id="naamefw" class="form-control form-control-sm" value="0"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="product_id" id="product_id">
                            <input type="hidden" name="btn_action" id="btn_action" value="Add">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Save Data</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        let producttable = $('#product-table').DataTable({
            "processing": true,
            "serverSide": true,
            // "scrollY": height+"px",
            "scrollCollapse": true,
            "order": [],
            "ajax": {
                url: "product_action.php",
                type: "POST",
                data: {
                    btn_action: 'fetch'
                }
            },
            dom: 'Bfrtip',
            buttons: [{
                    text: '<i class="far fa-user"></i> Add New Product',
                    className: 'btn-sm btn-outline-secondary',
                    attr: {
                        title: 'Add New Product',
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
                        columns: [0, 1, 2, 3, 4, 5, 6]
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
                        columns: [0, 1, 2, 3, 4, 5, 6]
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
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    title: 'Party List',
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary')
                    }
                }
            ],
            "columnDefs": [{
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                    "orderable": false,
                },
                {
                    "targets": [0, 5, 6, 7],
                    "class": 'text-center',
                }
            ]
        });

        $('#add_button').attr('data-bs-toggle', 'modal').attr('data-bs-target', '#productModal');

        $('#add_button').click(function() {
            $('#product-form')[0].reset();
        });

        $(document).on('submit', '#product-form', function(event) {
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: "product_action.php",
                method: "POST",
                data: form_data,
                // beforeSend: function() {
                //     $('#submit').attr('disabled', 'disabled');
                //     $('#submit').html('Submitting...');
                // },
                success: function(feedback) {
                    if ($('#btn_action').val() == 'Add') {
                        $('#product-form')[0].reset();
                        $('#product_code').focus();
                    }
                    $('#submit').html('Save Data');
                    $('#alert_action').fadeIn().html(feedback);
                    $('#submit').attr('disabled', false);
                    producttable.ajax.reload();
                }
            });
        });

        $(document).on('click', '.update', function() {
            var product_id = $(this).attr("id");
            $.ajax({
                url: "product_action.php",
                method: "POST",
                data: {
                    product_id: product_id,
                    btn_action: 'fetch_single'
                },
                dataType: "json",
                success: function(data) {
                    $('#productModal').modal('show');
                    // $('#productModal').modal({ backdrop: 'static', keyboard: false });
                    $('#product-code').val(data.product_code);
                    $('#product-name').val(data.product_name);
                    $('#category-id').val(data.category_id);
                    $('#product-unit').val(data.product_unit);
                    $('#jamagw').val(data.jamagw);
                    $('#jamafw').val(data.jamafw);
                    $('#naamegw').val(data.naamegw);
                    $('#naamefw').val(data.naamefw);
                    $('.modal-title').html("Edit Product Details");
                    $('#product_id').val(product_id);
                    $('#btn_action').val('Edit');
                    $('#submit').html('<i class="fa fa-check"></i> Edit Data');
                }
            });


            $(document).on('click', '.change-status', function() {
                var product_id = $(this).attr("id");
                var product_status = $(this).data('status');
                if (confirm('Are you sure you want to change product status ?')) {
                    $.ajax({
                        url: "product_action.php",
                        method: "POST",
                        data: {
                            product_id: product_id,
                            product_status: product_status,
                            btn_action: 'status'
                        },
                        success: function(data) {
                            alert(data)
                            producttable.ajax.reload();
                        }
                    });
                } else {
                    return false;
                }
            });

            $(document).on('click', '.delete', function() {
                var product_id = $(this).attr("id");
                if (confirm('Are you sure you want to delete Product Parmanent ?')) {
                    $.ajax({
                        url: "product_action.php",
                        method: "POST",
                        data: {
                            product_id: product_id,
                            btn_action: 'delete'
                        },
                        success: function(data) {
                            alert(data)
                            producttable.ajax.reload();
                        }
                    });
                } else {
                    return false;
                }
            });
        });
    });
</script>