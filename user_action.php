
<?php
include('conn.php');
include('function.php');

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'fetch') {
        $output = array();
        $query = '';
        $query .= "SELECT * FROM user_tbl ";

        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE user_name LIKE "' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR mobile LIKE "' . $_POST["search"]["value"] . '%" ';
        }

        if (isset($_POST["order"])) {
            $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $query .= 'ORDER BY user_name DESC ';
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
            $user_id = convert_string('encrypt', $row['user_id']);
            $status = ($row['user_status'] == 0) ? 'Inactive' : 'Active';
            $action = '
            <li class="nav-item dropdown" style="list-style-type: none;">
            <button type="button" class="btn btn-sm btn-default dropdown-toggle nav-item dropdown p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action </button>
            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -2px, 0px);">
                <a class="dropdown-item update" id="' . $user_id . '" href="javascript:void();">Update</a>
                <a class="dropdown-item change-status" id="' . $user_id . '" data-status="' . $row['user_status'] . '" href="javascript:void();">' . $status . '</a>
            <a class="dropdown-item delete" id="' . $user_id . '" href="javascript:void();">Parmanent Delete</a>
            </div>
      ';

            $sub_array = array();
            $sub_array[] = $i++;
            $sub_array[] = $row['user_name'];
            $sub_array[] = $row['mobile'];
            $sub_array[] = $row['email'];
            $sub_array[] = $row['address'];
            $sub_array[] = $row['profile'];
            $sub_array[] = $action;
            $data[] = $sub_array;
        }

        $output = array(
            "draw"    => intval($_POST["draw"]),
            "recordsTotal"   =>  get_total_all_records($db, "user_tbl"),
            "recordsFiltered"  =>  $filtered_rows,
            "data"       =>  $data
        );
        echo json_encode($output);
    }


    if ($_POST['btn_action'] == 'Add') {
        $user_name = clean_text($_POST['user_name']);
        $statement = mysqli_query($db, "SELECT user_id FROM user_tbl WHERE user_name = '" . $user_name . "' ");
        if (mysqli_num_rows($statement) > 0) {
            echo '<div class="alert alert-warning" role="alert">
          <strong><i class="fas fa-check text-warning"></i> Success ! </strong> User Name Already Exist.
        </div>';
        } else {
            $data = array(
                'user_name'  =>  $user_name,
                'user_password'  =>  clean_text($_POST['user_password']),
                'mobile'  =>  clean_text($_POST['user_mobile']),
                'email'  =>  clean_text($_POST['user_email']),
                'address'  =>  clean_text($_POST['user_address']),
                'added_date'  =>  date('Y-m-d'),
                'user_status'  =>  0
            );
            if (insert_record($db, "user_tbl", $data)) {
                echo '<div class="alert alert-success" role="alert">
            <strong><i class="fas fa-check text-success"></i> Success ! </strong> New Party successfully Added.
          </div>';
            }
        }
    }

    if ($_POST['btn_action'] == 'fetch_single') {
        $statement = mysqli_query($db, "SELECT * FROM user_tbl WHERE user_id = '" . convert_string('decrypt', $_POST['user_id']) . "' ");
        while ($row = mysqli_fetch_assoc($statement)) {
            $output['user_name'] = $row['user_name'];
            $output['user_password'] = $row['user_password'];
            $output['mobile'] = $row['mobile'];
            $output['email'] = $row['email'];
            $output['address'] = $row['address'];
        }
        echo json_encode($output);
    }

    if ($_POST['btn_action'] == 'Edit') {
        $user_id = convert_string('decrypt', $_POST["user_id"]);
        $user_name = clean_text($_POST['user_name']);

        $query = "SELECT * FROM user_tbl WHERE user_id != '" . $user_id . "' AND user_name = '" . $user_name . "' ";
        $statement = mysqli_query($db, $query);
        if (mysqli_num_rows($statement) > 0) {
            echo '<div class="alert alert-warning" role="alert">
          <strong><i class="fas fa-check text-warning"></i> Warning ! </strong> User Name Already exist.
        </div>';
        } else {
            $where = array(
                'user_id'  =>  $user_id
            );
            $data = array(
                'user_name'  =>  $user_name,
                'user_password'  =>  clean_text($_POST['user_password']),
                'mobile'  =>  clean_text($_POST['user_mobile']),
                'email'  =>  clean_text($_POST['user_email']),
                'address'  =>  clean_text($_POST['user_address'])
            );
            if (update_record($db, "user_tbl", $data, $where)) {
                echo '<div class="alert alert-success" role="alert">
            <strong><i class="fas fa-check text-success"></i> Success ! </strong> User Details Updated.
          </div>';
            }
        }
    }

    if($_POST['btn_action'] == 'delete')
    {  
        $where = array(
        'user_id'  =>  convert_string('decrypt', $_POST['user_id'])
        );
        if(delete_record($db, "user_tbl", $where))
        {
        echo 'User Record Deleted Parmanent!';
        }
    }
}

?>