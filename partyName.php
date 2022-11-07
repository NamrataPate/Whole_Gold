<?php
include('conn.php');
include('function.php');

if (isset($_POST['request'])) 
{
    if($_POST['request'] == 1)
    {
        $search = $_POST['search'];
        $query = "SELECT party_id,party_name,mobile,address FROM party_tbl WHERE party_name LIKE '".$search."%' AND party_status = '0' ";
        $statement = mysqli_query($db, $query);

        while($row = mysqli_fetch_assoc($statement)){
            $response[] = array(
                "value" =>  $row['party_name'],
                "label"=>$row['party_name'], 
                "party_id"=>$row['party_id'],
                "address" => $row['address'],
                "mobile"=>$row['mobile']
            );
        }
        echo json_encode($response);
        exit;
    }

    if($_POST['request'] == 2)
    {
        $search = $_POST['search'];
        $query = "SELECT party_id,party_name,city FROM party_tbl WHERE party_name LIKE '".$search."%' AND party_type='4' AND party_status = '0' ";
        $statement = mysqli_query($db, $query);

        while($row = mysqli_fetch_assoc($statement)){
            $response[] = array(
                "value" =>  $row['party_name'],
                "label"=>$row['party_name'], 
                "party_id"=>$row['party_id']
            );
        }
        echo json_encode($response);
        exit;
    }
}


?>