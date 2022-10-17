<?php
include('conn.php');
include('function.php');
// if(!isset($_SESSION['id'])) {
//     header("location:login.php");
//   }
if (isset($_POST['btn_action'])) {

    if ($_POST['btn_action'] == 1) {
        $total_weight = $total_rate = $total_amount = $total_lab_charge = $total_mcharge = $total_ocharge = $total_gst = $total_grand_amount = 0;
        $discount = clean_text($_POST['discount']);
        $purchase_date =  date('Y-m-d', strtotime($_POST['purchase_date']));
        $party_id =  clean_text($_POST['party_id']);

        $data = array(
            'party_id' =>  $party_id,
            'purchase_no' =>  clean_text($_POST['purchase_no']),
            'purchase_date' =>  $purchase_date,
            'methodtype' =>  $_POST['methodtype'],
            'discount' =>   $discount,
            'entry_date' =>  date('Y-m-d'),
            'party_description1' =>  clean_text($_POST['party_desc1']),
            'party_description2' =>  clean_text($_POST['party_desc2'])
        );

        if (insert_record($db, "purchase_tbl", $data)) {
            $pid  = mysqli_insert_id($db);
            for ($count = 0; $count < count($_POST["product_id"]); $count++) {
                if (!empty($_POST["code"][$count])) {
                    $array = array(
                        'pid' => $pid,
                        'party_id' => $party_id,
                        'purchase_date' => $purchase_date,
                        'product_id' => clean_text($_POST["product_id"][$count]),
                        'category_id' => clean_text($_POST["category_id"][$count]),
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

                    insert_record($db, "purchasedetail_tbl", $array);
                    $total_weight += clean_text($_POST["weight"][$count]);
                    $total_rate += clean_text($_POST["rate"][$count]);
                    $total_amount += clean_text($_POST["amount"][$count]);
                    $total_lab_charge += clean_text($_POST["lab_charge"][$count]);
                    $total_mcharge += clean_text($_POST["tmc"][$count]);
                    $total_ocharge += clean_text($_POST["other_charge"][$count]);
                    $total_gst  += clean_text($_POST["gst"][$count]);
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
                'final_purchase_amount'    =>    $total_grand_amount + $total_gst - $discount
            );

            update_record($db, "purchase_tbl", $data, ['pid' => $pid]);
            echo 'Data Saved';
        }
    }

    // if ($_POST['btn_action'] == 2) {
    //     $total_weight = $total_rate = $total_amount = $total_lab_charge = $total_mcharge = $total_ocharge = $total_gst = $total_grand_amount = 0;
    //     $discount = clean_text($_POST['discount']);
    //     $purchase_date =  date('Y-m-d', strtotime($_POST['purchase_date']));
    //     $party_id =  clean_text($_POST['party_id']);
    //     $pid = convert_string('decrypt', $_POST['pid']);
    //     $query = mysqli_query($db, "DELETE FROM purchasedetail_tbl WHERE pid =" . $pid);
    //     if ($query) {
    //         for ($count = 0; $count < count($_POST["product_id"]); $count++) {
    //             if (!empty($_POST["code"][$count])) {
    //                 $array = array(
    //                     'pid' => $pid,
    //                     'party_id' => $party_id,
    //                     'purchase_date' => $purchase_date,
    //                     'product_id' => clean_text($_POST["product_id"][$count]),
    //                     'category_id' => clean_text($_POST["category_id"][$count]),
    //                     'weight' => clean_text($_POST["weight"][$count]),
    //                     'melt' => clean_text($_POST["melt"][$count]),
    //                     'rate' => clean_text($_POST["rate"][$count]),
    //                     'bhaw' => clean_text($_POST["bhaw"][$count]),
    //                     'amount' => clean_text($_POST["amount"][$count]),
    //                     'lab_charge' => clean_text($_POST["lab_charge"][$count]),
    //                     'making_charge' => clean_text($_POST["tmc"][$count]),
    //                     'other_charge' => clean_text($_POST["other_charge"][$count]),
    //                     'gst' => clean_text($_POST["gst"][$count]),
    //                     'grand_total' => clean_text($_POST["grand_tot"][$count]),

    //                 );

    //                 insert_record($db, "purchasedetail_tbl", $array);
    //                 $total_weight += clean_text($_POST["weight"][$count]);
    //                 $total_rate += clean_text($_POST["rate"][$count]);
    //                 $total_amount += clean_text($_POST["amount"][$count]);
    //                 $total_lab_charge += clean_text($_POST["lab_charge"][$count]);
    //                 $total_mcharge += clean_text($_POST["tmc"][$count]);
    //                 $total_ocharge += clean_text($_POST["other_charge"][$count]);
    //                 $total_gst  += clean_text($_POST["gst"][$count]);
    //                 $total_grand_amount += clean_text($_POST["grand_tot"][$count]);
    //             }
    //         }
    //         $data = array(
    //             'party_id'  =>  $party_id,
    //             'purchase_no'  =>  $_POST['purchase_no'],
    //             'purchase_date'  =>  $purchase_date,
    //             'methodtype'  =>  $_POST['methodtype'],
    //             'total_weight'  =>  $total_weight,
    //             'total_rate'  =>  $total_rate,
    //             'total_amount'  =>  $total_amount,
    //             'total_lab_charge'  =>  $total_lab_charge,
    //             'total_mcharge' =>  $total_mcharge,
    //             'total_ocharge' =>  $total_ocharge,
    //             'total_gst' =>  $total_gst,
    //             'total_grand_amount'  =>  $total_grand_amount,
    //             'final_purchase_amount' =>  $total_grand_amount + $total_gst - $discount
    //         );

    //         update_record($db, "purchase_tbl", $data, ['pid' => $pid]);
    //         echo 'Data Saved';
    //     }
    // }

    // if ($_POST['btn_action'] == 3) {
    //     $output = '';
    //     $start = $_POST['start'] + 1;

    //     $query = "SELECT pt.pid, pt.purchase_date, pt.purchase_no, pt.methodtype, p.party_name FROM purchase_tbl as pt JOIN party_tbl as p ON p.party_id=pt.party_id WHERE pt.pid != 0 ";

    //     if (isset($_POST['party_id']) && !empty($_POST['party_id'])) {
    //         $query .= "AND pt.party_id ='" . $_POST['party_id'] . "' ";
    //     }

    //     if ($_POST['from_date'] != '') {
    //         $query .= "AND pt.purchase_date BETWEEN '" . date('Y-m-d', strtotime($_POST['from_date'])) . "' AND '" . date('Y-m-d', strtotime($_POST['to_date'])) . "' ";
    //     }

    //     $query .= "ORDER BY pt.purchase_date DESC LIMIT " . $_POST['start'] . ", " . $_POST['limit'] . "";

    //     $result = mysqli_query($db, $query);
    //     if (mysqli_num_rows($result) > 0) {
    //         while ($row = mysqli_fetch_assoc($result)) {
    //             $output .= '<tr id="' . convert_string('encrypt', $row['pid']) . '">
    //                 <td>' . $start++ . '</td>
    //                 <td>' . date('d-m-Y', strtotime($row['purchase_date'])) . '</td>
    //                 <td>' . $row['purchase_no'] . '</td>
    //                 <td>' . $row['methodtype'] . '</td>
    //                 <td>' . $row['party_name'] . '</td>
    //                 <td colspan="12" class="p-0">';

    //             $sql = "SELECT pt.item_name, pdt.weight, pdt.melt, pdt.rate, pdt.bhaw, pdt.amount, pdt.lab_charge, pdt.making_charge, pdt.other_charge, pdt.gst, pdt.grand_total FROM purchasedetail_tbl AS pdt JOIN product_tbl as pt ON pt.product_id=pdt.product_id WHERE pdt.pid=" . $row['pid'];
    //             $run = mysqli_query($db, $sql);
    //             $output .= '<table class="table table-bordered table-sm mb-0">';
    //             while ($subrow = mysqli_fetch_assoc($run)) {
    //                 $output .= '<tr>
    //                         <td>' . $subrow['item_name'] . '</td>
    //                         <td>' . $subrow['weight'] . '</td>
    //                         <td>' . $subrow['melt'] . '</td>
    //                         <td>' . $subrow['rate'] . '</td>
    //                         <td>' . $subrow['bhaw'] . '</td>
    //                         <td>' . $subrow['amount'] . '</td>
    //                         <td>' . $subrow['lab_charge'] . '</td>
    //                         <td>' . $subrow['making_charge'] . '</td>
    //                         <td>' . $subrow['other_charge'] . '</td>
    //                         <td>' . $subrow['gst'] . '</td>
    //                         <td>' . $subrow['grand_total'] . '</td>
                          
    //                     </tr>';
    //             }
    //             $output .= '</table>
    //             </td>
    //             <td align="center"><a href="index.php?edit_purchase&pid=' . convert_string('encrypt', $row['pid']) . '" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a></td>
    //             <td align="center"><button class="btn btn-sm delete_purchase p-0" id="' . convert_string('encrypt', $row['pid']) . '" ><i class="fas fa-trash-alt text-danger"></i></button></td>
    //             </tr>';
    //         }
    //     } else {
    //         $output .= '<tr><th colspan="19">No Data</th></tr>';
    //     }
    //     echo $output;
    // }


    // if($_POST['btn_action'] == 4){
    //     $pid = convert_string('decrypt', $_POST['pid']);
    //     $result = mysqli_query($db, 'DELETE FROM purchase_tbl WHERE pid='.$pid);
    //     if($result){
    //         echo 'Data Deleted!';
    //     }
    // }
}
?>
