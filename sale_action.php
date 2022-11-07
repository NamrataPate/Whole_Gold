<?php
include('conn.php');
include('function.php');

// if(!isset($_SESSION['id'])){
//     header("loaction:login.php");
// }

if (isset($_POST['btn_action'])) {
if ($_POST['btn_action'] == 1) {

    $total_weight = $total_rate = $total_amount = $total_lab_charge = $total_mcharge = $total_ocharge = $total_gst = $total_grand_amount = 0;

    $sale_date =  date('Y-m-d', strtotime($_POST['sale_date']));
    $discount = clean_text($_POST['discount']);
    $party_id =  clean_text($_POST['party_id']);

    $data = array(
        'party_id' =>  $party_id,
        'sale_no' =>  clean_text($_POST['sale_no']),
        'sale_date' =>  $sale_date,
        'methodtype' =>  $_POST['methodtype'],
        'discount' =>   $discount,
        'entry_date' =>  date('Y-m-d'),
        'party_description1' =>  clean_text($_POST['party_desc1']),
        'party_description2' =>  clean_text($_POST['party_desc2'])
    );

    if (insert_record($db, "sale_tbl", $data)) {
        $sid  = mysqli_insert_id($db);
        for ($count = 0; $count < count($_POST["product_id"]); $count++) {
            if (!empty($_POST["code"][$count])) {
                $array = array(
                    'sid' => $sid,
                    'party_id' => $party_id,
                    'sale_date' => $sale_date,
                    'product_id' => clean_text($_POST["product_id"][$count]),
                    //'category_id' => clean_text($_POST["category_id"][$count]),
                    'weight' => clean_text($_POST["weight"][$count]),
                    'melt' => clean_text($_POST["melt"][$count]),
                    'wast' => clean_text($_POST["wast"][$count]),
                    'rate' => clean_text($_POST["rate"][$count]),
                    'total_fine' => clean_text($_POST["total_fine"][$count]),
                    'price1' => clean_text($_POST["price1"][$count]),
                    'amount' => clean_text($_POST["amount"][$count]),
                    'lab_rate' => clean_text($_POST["lab_rate"][$count]),
                    'other_charge' => clean_text($_POST["other_charge"][$count]),
                    'total_mcharge' => clean_text($_POST["total_mcharge"][$count]),
                    'grand_tot' => clean_text($_POST["grand_tot"][$count]),
                );

                insert_record($db, "saledetail_tbl", $array);
                $total_weight += clean_text($_POST["weight"][$count]);
                $total_rate += clean_text($_POST["rate"][$count]);
                $total_amount += clean_text($_POST["amount"][$count]);
                $total_ocharge += clean_text($_POST["other_charge"][$count]);
                $total_grand_amount += clean_text($_POST["grand_tot"][$count]);
            }
        }

        $data = array(
            'total_weight'    =>    $total_weight,
            'total_rate'    =>    $total_rate,
            'total_amount'    =>    $total_amount,
            'total_lab_charge'    =>    $total_lab_charge,
            'total_mcharge'    =>    $total_mcharge,
            'total_ocharge'    =>    $total_ocharge,
            'total_gst'    =>    $total_gst,
            'total_grand_amount'    =>    $total_grand_amount,
            'final_sale_amount'    =>    $total_grand_amount + $total_gst - $discount
        );

        update_record($db, "sale_tbl", $data, ['sid' => $sid]);
        echo 'Data Saved';
    }
}

if ($_POST['btn_action'] == 2) {
    // print_r($_POST);
    // exit();
    $total_weight = $total_rate = $total_amount = $total_lab_charge = $total_mcharge = $total_ocharge = $total_gst = $total_grand_amount = 0;
    $discount = clean_text($_POST['discount']);
    $sale_date =  date('Y-m-d', strtotime($_POST['sale_date']));
    $party_id =  clean_text($_POST['party_id']);
    $sid = convert_string('decrypt', $_POST['sid']);
    $query = mysqli_query($db, "DELETE FROM saledetail_tbl WHERE sid =" . $sid);
    
    if ($query) {
        for ($count = 0; $count < count($_POST["product_id"]); $count++) {
            if (!empty($_POST["code"][$count])) {
                $array = array(
                    'sid' => $sid,
                    'party_id' => $party_id,
                    'sale_date' => $sale_date,
                    'product_id' => clean_text($_POST["product_id"][$count]),
                    //'category_id' => clean_text($_POST["category_id"][$count]),
                    'weight' => clean_text($_POST["weight"][$count]),
                    'melt' => clean_text($_POST["melt"][$count]),
                    'wast' => clean_text($_POST["wast"][$count]),
                    'rate' => clean_text($_POST["rate"][$count]),
                    'total_fine' => clean_text($_POST["total_fine"][$count]),
                    'price1' => clean_text($_POST["price1"][$count]),
                    'amount' => clean_text($_POST["amount"][$count]),
                    'lab_rate' => clean_text($_POST["lab_rate"][$count]),
                    'other_charge' => clean_text($_POST["other_charge"][$count]),
                    'total_mcharge' => clean_text($_POST["total_mcharge"][$count]),
                    // 'gst' => clean_text($_POST["gst"][$count]),
                    'grand_tot' => clean_text($_POST["grand_tot"][$count]),
                   
                );

                insert_record($db, "saledetail_tbl", $array);
                $total_weight += clean_text($_POST["weight"][$count]);
                $total_rate += clean_text($_POST["rate"][$count]);
                $total_amount += clean_text($_POST["amount"][$count]);
               // $total_lab_charge += clean_text($_POST["lab_charge"][$count]);
               // $total_mcharge += clean_text($_POST["tmc"][$count]);
                $total_ocharge += clean_text($_POST["other_charge"][$count]);
              //  $total_gst  += clean_text($_POST["gst"][$count]);
                $total_grand_amount += clean_text($_POST["grand_tot"][$count]);
            }
        }
        $data = array(
            'party_id'  =>  $party_id,
            'sale_no'  =>  $_POST['sale_no'],
            'sale_date'  =>  $sale_date,
            'methodtype'  =>  $_POST['methodtype'],
            'total_weight'  =>  $total_weight,
            'total_rate'  =>  $total_rate,
            'total_amount'  =>  $total_amount,
            'total_lab_charge'  =>  $total_lab_charge,
            'total_mcharge' =>  $total_mcharge,
            'total_ocharge' =>  $total_ocharge,
           //'total_gst' =>  $total_gst,
            'total_grand_amount'  =>  $total_grand_amount,
            'final_sale_amount' =>  $total_grand_amount + $total_gst - $discount
        );
        update_record($db, "sale_tbl", $data, ['sid' => $sid]);
        echo 'Data Saved';
    }
}
 

if ($_POST['btn_action'] == 3) {
    $output = '';
    $start = $_POST['start'] + 1;

    $query = "SELECT st.sid, st.sale_date, st.sale_no, st.methodtype, p.party_name FROM sale_tbl as st JOIN party_tbl as p ON p.party_id=st.party_id WHERE st.sid != 0 ";

    if (isset($_POST['party_id']) && !empty($_POST['party_id'])) {
        $query .= "AND st.party_id ='" . $_POST['party_id'] . "' ";
    }

    if ($_POST['from_date'] != '') {
        $query .= "AND st.sale_date BETWEEN '" . date('Y-m-d', strtotime($_POST['from_date'])) . "' AND '" . date('Y-m-d', strtotime($_POST['to_date'])) . "' ";
    }

    $query .= "ORDER BY st.sale_date DESC LIMIT " . $_POST['start'] . ", " . $_POST['limit'] . "";
   
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<tr id="' . convert_string('encrypt', $row['sid']) . '">
            <td>' . $start++ . '</td>
            <td>' . date('d-m-Y', strtotime($row['sale_date'])) . '</td>
            <td>' . $row['sale_no'] . '</td>
            <td>' . $row['methodtype'] . '</td>
            <td>' . $row['party_name'] . '</td>
            <td colspan="12" class="p-0">';

             $sql = "SELECT pt.item_name, sdt.weight, sdt.melt, sdt.wast, sdt.rate, sdt.total_fine, sdt.price1, sdt.amount, sdt.lab_rate, sdt.other_charge, sdt.total_mcharge, sdt.grand_tot FROM saledetail_tbl AS sdt JOIN product_tbl as pt ON pt.product_id=sdt.product_id WHERE sdt.sid=" . $row['sid'];
           
            $run = mysqli_query($db, $sql);
            
            $output .= '<table class="table table-bordered table-sm mb-0" style="font-size:14px;">';
            while ($subrow = mysqli_fetch_assoc($run)) {
                $output .= '<tr>
                    <td>' . $subrow['item_name'] . '</td>
                    <td>' . $subrow['weight'] . '</td>
                    <td>' . $subrow['melt'] . '</td>
                    <td>' . $subrow['wast'] . '</td>
                    <td>' . $subrow['rate'] . '</td>
                    <td>' . $subrow['total_fine'] . '</td>
                    <td>' . $subrow['price1'] . '</td>
                    <td>' . $subrow['amount'] . '</td>
                    <td>' . $subrow['lab_rate'] . '</td>
                    <td>' . $subrow['other_charge'] . '</td>
                    <td>'.  $subrow['total_mcharge'].'</td>
                    <td>' . $subrow['grand_tot'] . '</td>
                </tr>';
            }
            $output .= '</table>
        </td>
            <td align="center"><a href="index.php?edit_sale&sid=' . convert_string('encrypt', $row['sid']) . '" ><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a></td>
            <td align="center"><button class="btn btn-sm delete_sale p-0" id="' . convert_string('encrypt', $row['sid']) . '" ><i class="fas fa-trash-alt text-danger"></i></button></td>
        </tr>';
        }
    } else {
        $output .= '<tr><th colspan="19">No Data</th></tr>';
    }
    echo $output;
}


if($_POST['btn_action'] == 4){
    $sid = convert_string('decrypt', $_POST['sid']);
    $result = mysqli_query($db, "DELETE FROM  sale_tbl WHERE sid =".$sid);
    if($result){
        echo 'Data Deleted!';
    }
}
}
?>
