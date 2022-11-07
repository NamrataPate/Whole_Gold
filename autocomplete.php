<?php
include('conn.php');
include('function.php');

if (isset($_POST['request']))
{
    if($_POST['request'] == 1)
    {
        $search = $_POST['search'];
        $query = "SELECT * FROM product_tbl WHERE code LIKE '".$search."%' AND product_status = '0' ";
        $statement = mysqli_query($db, $query);
        while($row = mysqli_fetch_assoc($statement)){
            $response[] = array(
                "value" =>  $row['code'],
                "unit" => $row['unit'],
                "label"=>$row['code'],
                "product_id"=>$row['product_id'],
                "item_name"=>$row['item_name'],
                "weight" => '0',
                "melt"=> '100',
                "price"=> '0',
                "amount"=> '0',
                "lab_rate"=> '0',
                "other_charge"=> '0',
                "total_mcharge"=> '0'

            );
        }
        echo json_encode($response);
        exit;
    }
}

?>