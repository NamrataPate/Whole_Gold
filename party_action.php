<?php
include('conn.php');
include('function.php');

// if(!isset($_SESSION['id'])) {
//     header("location:login.php");
//   }

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'fetch') {
        $output = array();
        $query = '';
        $query .= "SELECT pt.*, (jamaw-naamew) as weight, (jamav-naamev) as value FROM party_tbl pt LEFT JOIN partyopstock_tbl pst ON pst.party_id=pt.party_id ";

        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE pt.party_name LIKE "' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR pt.mobile LIKE "' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR pt.state LIKE "' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR pt.city LIKE "' . $_POST["search"]["value"] . '%" ';
        }

        if (isset($_POST["order"])) {
            $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $query .= 'ORDER BY pt.party_name DESC ';
        }
        // SELECT pt.*, (jamaw-naamew) as weight, (jamav-naamev) as value FROM party_tbl pt LEFT JOIN partyopstock_tbl pst ON pst.party_id=pt.party_id WHERE pt.party_name LIKE "%" OR pt.mobile LIKE "%" OR pt.state LIKE "%" OR pt.city LIKE "%" GROUP BY pt.party_name DESC
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
            $party_id = convert_string('encrypt', $row['party_id']);
            $status = ($row['party_status'] == 0) ? 'Inactive' : 'Active';
            $action = '
           <li class="nav-item dropdown" style="list-style-type: none;">
           <button type="button" class="btn btn-sm btn-default dropdown-toggle nav-item dropdown p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action </button>
           <div class="dropdown-menu hidden" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -2px, 0px);">
               <a class="dropdown-item update" id="' . $party_id . '" href="javascript:void();">Edit</a>
               <a class="dropdown-item change-status" id="' . $party_id . '" data-status="' . $row['party_status'] . '" href="javascript:void();">' . $status . '</a>
           <a class="dropdown-item delete" id="' . $party_id . '" href="javascript:void();">Parmanent Delete</a>
           </div>
           </li>
            ';
            $sub_array = array();
            $sub_array[] = $i++;
            $sub_array[] = $row['party_name'];
            $sub_array[] = $row['mobile'];
            $sub_array[] = $row['state'];
            $sub_array[] = $row['city'];
            $sub_array[] = party_type($row['party_type']);
            $sub_array[] = $row['weight'];
            $sub_array[] = $row['value'];
            $sub_array[] = $action;
            $data[] = $sub_array;
        }

        $output = array(
            "draw"    => intval($_POST["draw"]),
            "recordsTotal"   =>  get_total_all_records($db, "party_tbl"),
            "recordsFiltered"  =>  $filtered_rows,
            "data"       =>  $data
        );
        echo json_encode($output);
    }

    if ($_POST['btn_action'] == 'Add') {
        $data = array(
            'party_name'  =>  strtoupper(clean_text($_POST['party_name'])),
            'mobile'  =>  clean_text($_POST['mobile']),
            'address'  =>  clean_text($_POST['address']),
            'state'  =>  clean_text($_POST['state']),
            'city'  =>  clean_text($_POST['city']),
            'party_type'  =>  clean_text($_POST['party_type']),
            'party_status'  =>  0,
            'added_date'  =>  date('Y-m-d', strtotime($_POST["added_date"]))
        );

        if (insert_record($db, "party_tbl", $data)) {
            $party_id  = mysqli_insert_id($db); //1
            $array = array(
                'party_id'  =>  $party_id,
                'jamaw'  =>  clean_text($_POST["jamaw"]), //jama weight
                'jamav'  =>  clean_text($_POST["jamav"]), //jama value
                'naamew'  =>  clean_text($_POST["naamew"]), //nikalna weight
                'naamev'  =>  clean_text($_POST["naamev"])
            );
            if (insert_record($db, "partyopstock_tbl", $array)) {
                echo '<div class="alert alert-success" role="alert">
                    <strong><i class="fas fa-check text-success"></i> Success ! </strong> New Party successfully Added.
                  </div>';
                // echo json_encode($array);
            }
        }
    }

    if ($_POST['btn_action'] == 'fetch_single') {
        $statement = mysqli_query($db, "SELECT * FROM party_tbl WHERE party_id = '" . convert_string('decrypt', $_POST['party_id']) . "' ");
        while ($row = mysqli_fetch_assoc($statement)) {
            $output['party_name'] = $row['party_name'];
            $output['mobile'] = $row['mobile'];
            $output['address'] = $row['address'];
            $output['state'] = $row['state'];
            $output['city'] = $row['city'];
            $output['party_type'] = $row['party_type'];
            $output['added_date'] = date('d-m-Y', strtotime($row['added_date']));
        }

        $statement = mysqli_query($db, "SELECT * FROM partyopstock_tbl WHERE party_id = '" . convert_string('decrypt', $_POST['party_id']) . "' ");
        while ($row = mysqli_fetch_assoc($statement)) {
            $output['jamaw'] = $row['jamaw'];
            $output['jamav'] = $row['jamav'];
            $output['naamew'] = $row['naamew'];
            $output['naamev'] = $row['naamev'];
        }
        echo json_encode($output);
    }

    if ($_POST['btn_action'] == 'Edit') {
        $where = array(
            'party_id'  =>  convert_string('decrypt', $_POST['party_id'])
        );
        $data = array(
            'party_name'  =>  strtoupper(clean_text($_POST['party_name'])),
            'mobile'  =>  clean_text($_POST['mobile']),
            'address'  =>  clean_text($_POST['address']),
            'state'  =>  clean_text($_POST['state']),
            'city'  =>  clean_text($_POST['city']),
            'party_type'  =>  clean_text($_POST['party_type'])
        );

        if (update_record($db, "party_tbl", $data, $where)) {
            $array = array(
                'jamaw'  =>  clean_text($_POST["jamaw"]),
                'jamav'  =>  clean_text($_POST["jamav"]),
                'naamew'  =>  clean_text($_POST["naamew"]),
                'naamev'  =>  clean_text($_POST["naamev"])
            );
            $sql = "SELECT * FROM partyopstock_tbl WHERE party_id=" . convert_string('decrypt', $_POST['party_id']);
            $query = mysqli_query($db, $sql);
            if (mysqli_num_rows($query) > 0) {
                if (update_record($db, "partyopstock_tbl", $array, $where)) {
                    echo '<div class="alert alert-success" role="alert">
                            <strong><i class="fas fa-check text-success"></i> Success ! </strong> Party Details Updated.
                            </div>';
                    
                }
            } else {
                $myArray = array('party_id'  =>  convert_string('decrypt', $_POST['party_id'])) + $array;
                if (insert_record($db, "partyopstock_tbl", $myArray)) {
                    echo '<div class="alert alert-success" role="alert">
                <strong><i class="fas fa-check text-success"></i> Success ! </strong> Party Details Updated.
                </div>';
                }
            }
        }
       
    }

    if ($_POST['btn_action'] == 'delete') {
        $where = array(
            'party_id'  =>  convert_string('decrypt', $_POST['party_id'])
        );
        if (delete_record($db, "party_tbl", $where)) {
            echo 'Party Record Deleted Parmanent!';
        }
    }
   
}
