<?php
include('conn.php');
include('function.php');
   
if ($_POST['btn_action'] == 1) 
{
    if ($_POST['party_id1'] != '' && $_POST['party_id2'] != '') 
    {
        $data = array(
            'party_id' => $_POST['party_id1'],
               'insdate'	=>	date('Y-m-d',strtotime($_POST['insdate'])),
               'tratype'	=>	'PURCHASE',
               'amount'	=>	$_POST['amount'],
               'description'	=>	$_POST['description'],
               'transactionunder'	=>	'JOURNAL'
        );
        
        if(insert_record($db, "bhaaw_tbl", $data))
        {	
            $traid  = mysqli_insert_id($db);
               $update = mysqli_query($db, "UPDATE bhaaw_tbl SET traid='".$traid."' WHERE tid=".$traid);

            $data = array(
                'party_id' => $_POST['party_id2'],
                   'insdate'	=>	date('Y-m-d',strtotime($_POST['insdate'])),
                   'tratype'	=>	'SALE',
                   'amount'	=>	$_POST['amount'],
                   'traid'		=>	$traid,
                   'description'	=>	$_POST['description'],
                   'transactionunder'	=>	'JOURNAL'
            );
            insert_record($db, "bhaaw_tbl", $data);
               echo 'Data Successfully Inserted';
        }
    }
    else
    {
        echo "Something error try again later";
    }
    if ($_POST['btn_action'] == 3) 
	{	
		$output = '';
		$start = $_POST['start']+1;

		$query = "SELECT bhaaw_tbl.tid, bhaaw_tbl.traid, bhaaw_tbl.insdate,party_tbl.party_name, bhaaw_tbl.amount, bhaaw_tbl.description FROM bhaaw_tbl INNER JOIN party_tbl ON party_tbl.party_id=bhaaw_tbl.party_id WHERE ";
		if ($_POST['from_date'] != '') 
		{
			$query .= "insdate BETWEEN '".date('Y-m-d', strtotime($_POST['from_date']))."' AND '".date('Y-m-d', strtotime($_POST['to_date']))."' AND ";
		}
		$query .= "bhaaw_tbl.tratype='PURCHASE' AND bhaaw_tbl.transactionunder='JOURNAL' ORDER BY bhaaw_tbl.insdate, bhaaw_tbl.tid DESC LIMIT ".$_POST['start'].", ".$_POST['limit']."";
		$statement = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($statement)) 
        {
          $output .= '<tr>
              <td>'.$start++.'</td>
              <td>'.date('d-m-Y', strtotime($row['insdate'])).'</td>
              <td>'.$row['party_name'].'</td>
              <td align="center">'.$row['amount'].'</td>
              <td>'.$row['description'].'</td>
              <td align="center"><a href="index.php?edit_journaltransaction&traid='.convert_string('encrypt', $row['traid']).'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a></td>
              <td align="center"><button class="btn btn-sm delete p-0" id="'.convert_string('encrypt', $row['traid']).'" ><i class="fas fa-trash-alt text-danger"></i></button></td>
          </tr>';
        }
        echo $output;
	}

	if ($_POST['btn_action'] == 4) 
	{	
		$output = '';
		$start = $_POST['start']+1;

		$query = "SELECT bhaaw_tbl.tid, bhaaw_tbl.traid, bhaaw_tbl.insdate,party_tbl.party_name, bhaaw_tbl.amount, bhaaw_tbl.description FROM bhaaw_tbl INNER JOIN party_tbl ON party_tbl.party_id=bhaaw_tbl.party_id WHERE ";
		if ($_POST['from_date'] != '') 
		{
			$query .= "insdate BETWEEN '".date('Y-m-d', strtotime($_POST['from_date']))."' AND '".date('Y-m-d', strtotime($_POST['to_date']))."' AND ";
		}
		$query .= "bhaaw_tbl.tratype='SALE' AND bhaaw_tbl.transactionunder='JOURNAL' ORDER BY bhaaw_tbl.insdate, bhaaw_tbl.tid DESC LIMIT ".$_POST['start'].", ".$_POST['limit']."";
		$statement = mysqli_query($db, $query);
		
		while ($row = mysqli_fetch_assoc($statement)) 
        {
          $output .= '<tr id="'.convert_string('encrypt', $row['tid']).'">
              <td>'.$start++.'</td>
              <td>'.date('d-m-Y', strtotime($row['insdate'])).'</td>
              <td>'.$row['party_name'].'</td>
              <td align="center">'.$row['amount'].'</td>
              <td>'.$row['description'].'</td>
              <td align="center"><a href="index.php?edit_journaltransaction&traid='.convert_string('encrypt', $row['traid']).'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a></td>
              <td align="center"><button class="btn btn-sm delete p-0" id="'.convert_string('encrypt', $row['traid']).'" ><i class="fas fa-trash-alt text-danger"></i></button></td>
          </tr>';
        }
        echo $output;
	}

	if ($_POST['btn_action'] == 5) 
	{
		$traid = convert_string('decrypt', $_POST['traid']);
	    $result = mysqli_query($db, "DELETE FROM bhaaw_tbl WHERE traid =".$traid);
	    if($result)
	    { 
	     echo 'Data Deleted!' ;
	    }
	}

	if ($_POST['btn_action'] == 6) 
	{
		$where = array('traid' =>	convert_string('decrypt', $_POST['traid']), 'tratype' => 'PURCHASE');
		$where1 = array('traid' =>	convert_string('decrypt', $_POST['traid']), 'tratype' => 'SALE');
		if ($_POST['party_id1'] != '' && $_POST['party_id2'] != '') 
		{
			$data = array(
				'party_id' => $_POST['party_id1'],
			   	'insdate'	=>	date('Y-m-d',strtotime($_POST['insdate'])),
			   	'tratype'	=>	'PURCHASE',
			   	'amount'	=>	$_POST['amount'],
			   	'description'	=>	$_POST['description'],
			   	'transactionunder'	=>	'JOURNAL'
			);
			
			if(update_record($db, "bhaaw_tbl", $data, $where))
			{	
				$data1 = array(
					'party_id' => $_POST['party_id2'],
				   	'insdate'	=>	date('Y-m-d',strtotime($_POST['insdate'])),
				   	'tratype'	=>	'SALE',
				   	'amount'	=>	$_POST['amount'],
				   	'description'	=>	$_POST['description'],
				   	'transactionunder'	=>	'JOURNAL'
				);
				update_record($db, "bhaaw_tbl", $data1, $where1);
			   	echo 'Data Successfully updated';
			}
		}
	}
}
