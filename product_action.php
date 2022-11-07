<?php
include('conn.php');
include('function.php');


if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'fetch') {
        $output = array();
        $query = '';

        $query .= "SELECT pt.*, pct.category_name, ist.jamagw, ist.jamafw, ist.naamegw, ist.naamefw FROM product_tbl pt INNER JOIN product_category_tbl pct ON pt.category_id = pct.category_id INNER JOIN itemopstock_tbl ist ON ist.product_id = pt.product_id ";
        // $query .= "SELECT pt.*, pct.category_name, ist.jamagw, ist.jamafw, ist.naamegw, ist.naamefw FROM product_tbl pt LEFT JOIN product_category_tbl pct ON pt.category_id = pct.category_id  LEFT JOIN itemopstock_tbl ist ON ist.product_id = pt.product_id ";
        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE pt.item_name LIKE "' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR pt.code LIKE "' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR pct.category_name LIKE "' . $_POST["search"]["value"] . '%" ';
        }

        if (isset($_POST["order"])) {
            $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $query .= 'ORDER BY pt.item_name DESC ';
        }

        $query1 = '';

        if ($_POST["length"] != -1) {
            $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }
        // SELECT pt.*, pct.category_name, ist.jamagw, ist.jamafw, ist.naamegw, ist.naamefw FROM product_tbl pt INNER JOIN product_category_tbl pct ON pt.category_id = pct.category_id INNER JOIN itemopstock_tbl ist ON ist.product_id = pt.product_id WHERE pt.item_name LIKE "%" OR pt.code LIKE "%" OR pct.category_name LIKE "%" GROUP BY pt.item_name ORDER BY pt.item_name DESC
        // echo $query;
        // exit();

        $statement = mysqli_query($db, $query);
        $filtered_rows = mysqli_num_rows($statement);
        $i = 1;

        $statement = mysqli_query($db, $query . $query1);
        $data = array();
        while ($row = mysqli_fetch_assoc($statement)) {
            $product_id = convert_string('encrypt', $row['product_id']);
            $status = ($row['product_status'] == 0) ? 'Inactive' : 'Active';
            $action = '
      <li class="nav-item dropdown" style="list-style-type: none;">
            <button type="button" class="btn btn-sm btn-default dropdown-toggle nav-item dropdown p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action </button>
            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -2px, 0px);">
                <a class="dropdown-item update" id="' . $product_id . '" href="javascript:void();">Edit</a>
                <a class="dropdown-item change-status" id="' . $product_id . '" data-status="' . $row['product_status'] . '" href="javascript:void();">' . $status . '</a>
            <a class="dropdown-item delete" id="' . $product_id . '" href="javascript:void();">Parmanent Delete</a>
            </div>
        </li>
      
      ';

            $sub_array = array();
            $sub_array[] = $i++;
            $sub_array[] = $row['code'];
            $sub_array[] = $row['item_name'];
            $sub_array[] = $row['category_name'];
            $sub_array[] = $row['unit'];
            $sub_array[] = ($row['jamagw'] - $row['naamegw']);
            $sub_array[] = ($row['jamafw'] - $row['naamefw']);
            $sub_array[] = $action;
            $data[] = $sub_array;
        }

        $output = array(
            "draw"    => intval($_POST["draw"]),
            "recordsTotal"   =>  get_total_all_records($db, "product_tbl"),
            "recordsFiltered"  =>  $filtered_rows,
            "data"       =>  $data
        );
        echo json_encode($output);
    }


    if ($_POST['btn_action'] == 'Add') {
        $code = clean_text($_POST['product_code']);
        $statement = mysqli_query($db, "SELECT product_id FROM product_tbl WHERE code = '" . $code . "' ");
        if (mysqli_num_rows($statement) > 0) {
            echo '<div class="alert alert-success" role="alert">
          <strong><i class="fas fa-check text-warning"></i> Warning ! </strong> Code Name Already exist.
        </div>';
        } else {
            $data = array(
                'category_id'  =>  clean_text($_POST['category_id']),
                'code'  =>  clean_text($_POST['product_code']),
                'item_name'  =>  clean_text($_POST['product_name']),
                'unit'  =>  clean_text($_POST['product_unit']),
                'product_status'  =>  0
            );
            if (insert_record($db, "product_tbl", $data)) {
                $product_id  = mysqli_insert_id($db);
                $array = array(
                    'category_id'  =>  clean_text($_POST['category_id']),
                    'product_id'  =>  $product_id,
                    'jamagw'  =>  clean_text($_POST["jamagw"]),
                    'jamafw'  =>  clean_text($_POST["jamafw"]),
                    'naamegw'  =>  clean_text($_POST["naamegw"]),
                    'naamefw'  =>  clean_text($_POST["naamefw"])
                );

                if (insert_record($db, "itemopstock_tbl", $array)) {
                    echo '<div class="alert alert-success" role="alert">
              <strong><i class="fas fa-check text-success"></i> Success ! </strong> New Product successfully Added.
            </div>';
                }
            }
        }
    }


    if ($_POST['btn_action'] == 'fetch_single') {
        $statement = mysqli_query($db, "SELECT * FROM product_tbl pt, itemopstock_tbl iot WHERE pt.product_id=iot.product_id AND pt.product_id = '" . convert_string('decrypt', $_POST['product_id']) . "' ");
        while ($row = mysqli_fetch_assoc($statement)) {
            $output['category_id'] = $row['category_id'];
            $output['product_code'] = $row['code'];
            $output['product_name'] = $row['item_name'];
            $output['product_unit'] = $row['unit'];
            $output['jamagw'] = $row['jamagw'];
            $output['jamafw'] = $row['jamafw'];
            $output['naamegw'] = $row['naamegw'];
            $output['naamefw'] = $row['naamefw'];
        }
        echo json_encode($output);
    }

    if ($_POST['btn_action'] == 'Edit') {
        $product_id = convert_string('decrypt', $_POST["product_id"]);
        $code = clean_text($_POST['product_code']);

        $query = "SELECT product_id FROM product_tbl WHERE product_id != '" . $product_id . "' AND code = '" . $code . "' ";
        $statement = mysqli_query($db, $query);
        if (mysqli_num_rows($statement) > 0) {
            echo '<div class="alert alert-warning" role="alert">
                <strong><i class="fas fa-check text-warning"></i> Warning ! </strong> Code Name Already exist.
                </div>';
        } else {
            $where = array(
                'product_id'  =>  $product_id
            );
            $data = array(
                'category_id'  =>  clean_text($_POST['category_id']),
                'code'  =>  clean_text($_POST['product_code']),
                'item_name'  =>  clean_text($_POST['product_name']),
                'unit'  =>  clean_text($_POST['product_unit'])
            );
            if (update_record($db, "product_tbl", $data, $where)) {
                $array = array(
                    'category_id'  =>  clean_text($_POST['category_id']),
                    'jamagw'  =>  clean_text($_POST["jamagw"]),
                    'jamafw'  =>  clean_text($_POST["jamafw"]),
                    'naamegw'  =>  clean_text($_POST["naamegw"]),
                    'naamefw'  =>  clean_text($_POST["naamefw"])
                );
                if (update_record($db, "itemopstock_tbl", $array, $where)) {
                    echo '<div class="alert alert-success" role="alert">
                    <strong><i class="fas fa-check text-success"></i> Success ! </strong> Product Details Updated.
                </div>';
                }
            }
        }
    }
    if ($_POST['btn_action'] == 'fetch-data') {
        $output = array();
        $query = '';
        $query .= "SELECT * FROM product_tbl pt INNER JOIN product_category_tbl pct ON pt.category_id = pct.category_id INNER JOIN itemopstock_tbl ist ON pt.product_id=ist.product_id ";

        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE pt.item_name LIKE "' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR pt.code LIKE "' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR pct.category_name LIKE "' . $_POST["search"]["value"] . '%" ';
        }

        if (isset($_POST["order"])) {
            $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $query .= 'ORDER BY pt.item_name DESC ';
        }

        $query1 = '';

        if ($_POST["length"] != -1) {
            $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }

        $statement = mysqli_query($db, $query);
        $filtered_rows = mysqli_num_rows($statement);
        $i = 1;

        $statement = mysqli_query($db, $query . $query1);
        $data = array();
        while ($row = mysqli_fetch_assoc($statement)) {
            $sub_array = array();
            $sub_array[] = $i++;
            $sub_array[] = $row['code'];
            $sub_array[] = $row['item_name'];
            $sub_array[] = $row['category_name'];
            $sub_array[] = $row['jamagw'];
            $sub_array[] = $row['jamafw'];
            $sub_array[] = $row['naamegw'];
            $sub_array[] = $row['naamefw'];
            $sub_array[] = '<button id=' . convert_string('encrypt', $row['product_id']) . ' class="btn btn-sm btn-warning update p-0 px-1">Edit</button>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"    => intval($_POST["draw"]),
            "recordsTotal"   =>  get_total_all_records($db, "product_tbl"),
            "recordsFiltered"  =>  $filtered_rows,
            "data"       =>  $data
        );
        echo json_encode($output);
    }

            if($_POST['btn_action'] == 'status')
        {
            $status = '0';  
            $product_status = $_POST['product_status'];
            if($product_status == 0)
            {
            $status = 1;
            }

            $query = "UPDATE product_tbl SET product_status = '".$status."' WHERE product_id=".convert_string('decrypt', $_POST['product_id']);
            $result = mysqli_query($db, $query);
            if(isset($result))
            {
            echo 'Status Changed!';
            }
        }

        if($_POST['btn_action'] == 'delete')
        {  
            $where = array(
            'product_id'  =>  convert_string('decrypt', $_POST['product_id'])
            );
            if(delete_record($db, "product_tbl", $where))
            {
            echo 'Product Record Deleted Parmanent!';
            }
        }
}
