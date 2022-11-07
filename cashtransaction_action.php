<?php
include('conn.php');
include('function.php');

if (isset($_POST['btn_action'])) {

    if ($_POST['btn_action'] == 1) {

        if ($_POST['party_id'] != '') {
            $data = array(
                'party_id' => $_POST['party_id'],
                'insdate' => date('Y-m-d'),
                'tratype' => $_POST['tratype'],
                'amount' => $_POST['amount'],
                'description' => $_POST['description'],
                'transactionunder' => 'CASH'
            );

            if (insert_record($db, "bhaaw_tbl", $data)) {
                $traid = mysqli_insert_id($db);
                $query = mysqli_query($db, "UPDATE bhaaw_tbl SET traid='" . $traid . "' WHERE tid=" . $traid);
                echo 'Data Successfully Inserted';
            }
        } else {
            echo "Something error try again later";
        }
        
    }
    if($_POST['btn_action'] == 2){
        if ($_POST['party_id'] != '') 
		{
			$data = array(
				'party_id' => $_POST['party_id'],
			   	'insdate'	=>	date('Y-m-d',strtotime($_POST['insdate'])),
			   	'tratype'	=>	$_POST['tratype'],
			   	'amount'	=>	$_POST['amount'],
			   	'description'	=>	$_POST['description'],
			   	'transactionunder'	=>	'CASH'
			);
			if(insert_record($db, "bhaaw_tbl", $data))
			{
				$traid  = mysqli_insert_id($db);
			   	$query = mysqli_query($db, "UPDATE bhaaw_tbl SET traid='".$traid."' WHERE tid=".$traid);
			   	echo 'Data Successfully Inserted';
			}
		}
		else
		{
			echo "Something error try again later";
		}
    }
    if ($_POST['btn_action'] == 3) 
	{	
		$output = '';
		$start = $_POST['start']+1;

		$query = "SELECT bhaaw_tbl.tid,bhaaw_tbl.insdate,party_tbl.party_name, bhaaw_tbl.amount, bhaaw_tbl.description FROM bhaaw_tbl INNER JOIN party_tbl ON party_tbl.party_id=bhaaw_tbl.party_id WHERE ";
		
		if ($_POST['from_date'] != '') 
		{
			$query .= "insdate BETWEEN '".date('Y-m-d', strtotime($_POST['from_date']))."' AND '".date('Y-m-d', strtotime($_POST['to_date']))."' AND ";
		}
		
		$query .= "bhaaw_tbl.tratype='PURCHASE' AND bhaaw_tbl.transactionunder='CASH' ORDER BY bhaaw_tbl.insdate, bhaaw_tbl.tid DESC LIMIT ".$_POST['start'].", ".$_POST['limit']."";
		
		$statement = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($statement)) 
        {
          $output .= '<tr>
              <td>'.$start++.'</td>
              <td>'.date('d-m-Y', strtotime($row['insdate'])).'</td>
              <td>'.$row['party_name'].'</td>
              <td align="center">'.$row['amount'].'</td>
              <td>'.$row['description'].'</td>
              <td align="center"><a href="index.php?edit_cashtransaction&tid='.convert_string('encrypt', $row['tid']).'&type='.convert_string('encrypt', 'jama').'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a></td>
              <td align="center"><button class="btn btn-sm delete p-0" id="'.convert_string('encrypt', $row['tid']).'" ><i class="fas fa-trash-alt text-danger"></i></button></td>
          </tr>';
        }
        echo $output;
	}

	if ($_POST['btn_action'] == 4) 
	{	
		$output = '';
		$start = $_POST['start']+1;

		$query = "SELECT bhaaw_tbl.tid,bhaaw_tbl.insdate,party_tbl.party_name, bhaaw_tbl.amount, bhaaw_tbl.description FROM bhaaw_tbl INNER JOIN party_tbl ON party_tbl.party_id=bhaaw_tbl.party_id WHERE ";
		if ($_POST['from_date'] != '') 
		{
			$query .= "insdate BETWEEN '".date('Y-m-d', strtotime($_POST['from_date']))."' AND '".date('Y-m-d', strtotime($_POST['to_date']))."' AND ";
		}
		$query .= "bhaaw_tbl.tratype='SALE' AND bhaaw_tbl.transactionunder='CASH' ORDER BY bhaaw_tbl.insdate, bhaaw_tbl.tid DESC LIMIT ".$_POST['start'].", ".$_POST['limit']."";
		$statement = mysqli_query($db, $query);
		
		while ($row = mysqli_fetch_assoc($statement)) 
        {
          $output .= '<tr id="'.convert_string('encrypt', $row['tid']).'">
              <td>'.$start++.'</td>
              <td>'.date('d-m-Y', strtotime($row['insdate'])).'</td>
              <td>'.$row['party_name'].'</td>
              <td align="center">'.$row['amount'].'</td>
              <td>'.$row['description'].'</td>
              <td align="center"><a href="index.php?edit_cashtransaction&tid='.convert_string('encrypt', $row['tid']).'&type='.convert_string('encrypt', 'naame').'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a></td>
              <td align="center"><button class="btn btn-sm delete p-0" id="'.convert_string('encrypt', $row['tid']).'" ><i class="fas fa-trash-alt text-danger"></i></button></td>
          </tr>';
        }
        echo $output;
	}

	if ($_POST['btn_action'] == 5) 
	{
		$tid = convert_string('decrypt', $_POST['tid']);
	    $result = mysqli_query($db, "DELETE FROM bhaaw_tbl WHERE tid =".$tid);
	    if($result)
	    { 
	     echo 'Data Deleted!' ;
	    }
	}

	if ($_POST['btn_action'] == 6) 
	{
		$where = array('tid' =>	convert_string('decrypt', $_POST['tid']));
		$data = array(
			'party_id' => $_POST['party_id'],
		   	'insdate'	=>	date('Y-m-d',strtotime($_POST['insdate'])),
		   	'amount'	=>	$_POST['amount'],
		   	'description'	=>	$_POST['description']
		);
		if(update_record($db, "bhaaw_tbl", $data, $where))
		{
			echo "Data Successfully Updated";
		}
	}

}
