<?php
include('conn.php');
include('function.php');

if(isset($_POST['btn_action'])){
    if($_POST['btn_action'] == 0){
        $output = '
          	<table class="table table-bordered table-sm mt-2">
          		<thead class="thead-light">
          			<tr>

	          			<th class="text-center">Fine Weight</th>
	          			<th class="text-center">Amount</th>
	          		</tr>
          		</thead>
          		
			';
		if (isset($_POST['party_id']) && !empty($_POST['party_id'])) 
		{	
		
			$query = "CALL get_value_weight_pro('".$_POST['party_id']."', '', '')"; 
			$statement = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($statement))
			{
				$output .= '
					<tr>
					
						<td align="center">'.$row['gweight'].'</td>
						<td align="center">'.number_format(round($row['gvalue']),2).'</td>
					</tr>
				';
				$output .= '</table>';
			}
			echo $output;
		}
	}

	if ($_POST['btn_action'] == 1) 
	{	
		$output = '';
		$start = $_POST['start']+1;
		$total_weight = 0;
        $total_amount = 0;

		$query = "SELECT * FROM party_transaction INNER JOIN party_tbl ON party_tbl.party_id=party_transaction.party_id WHERE party_transaction.party_id='".$_POST['party_id']."' ";
		if ($_POST['from_date'] != '') 
		{
			$query .= "AND party_transaction.insdate BETWEEN '".date('Y-m-d', strtotime($_POST['from_date']))."' AND '".date('Y-m-d', strtotime($_POST['to_date']))."' ";
		}
		$query .= "AND party_transaction.accounttype='PURCHASE' ORDER BY insdate ASC LIMIT ".$_POST['start'].", ".$_POST['limit']."";
		$statement = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($statement)) 
        {
        	if(($row['transactiontype']=='weight' || $row['transactiontype']=='value') && $row['accounttype']=='PURCHASE')
          	{
            	$edit = '<a href="index.php?edit_purchase&pid='.convert_string('encrypt', $row['unicid']).'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a>';
            	$delete = '<button class="btn btn-sm delete_purchase p-0" id="'.convert_string('encrypt', $row['unicid']).'" ><i class="fas fa-trash-alt text-danger"></i></button>';
            	$desc = purchase_details($db, $row['unicid']);
          	} 
          	else if($row['transactiontype']=='BHAAW' && $row['accounttype']=='PURCHASE') 
	        {
	            $edit = '<a href="index.php?edit_bhaawtransaction&tid='.convert_string('encrypt', $row['unicid']).'&type='.convert_string('encrypt', 'jama').'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a>';
	            $delete = '<button class="btn btn-sm p-0 delete_bhaawjama" id="'.convert_string('encrypt', $row['unicid']).'" ><i class="fas fa-trash-alt text-danger"></i></button>';
	            $desc = 'Rate: '.$row['value']/$row['weight'].', Wt.: '.$row['weight'].', value '.$row['value'];
	        }
	        else if($row['transactiontype']=='JOURNAL' && $row['accounttype']=='PURCHASE') 
	        {
	            $edit = '<a href="index.php?edit_journaltransaction&traid='.convert_string('encrypt', $row['unicid']).'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a>';
	            $delete = '<button class="btn btn-sm p-0 delete_journaljama" id="'.convert_string('encrypt', $row['unicid']).'" ><i class="fas fa-trash-alt text-danger"></i></button>';
	            $desc = return_value($db,"bhaaw_tbl bt INNER JOIN party_tbl pt ON pt.party_id=bt.party_id","pt.party_name","bt.traid='".$row['unicid']."' AND bt.party_id != '".$row['party_id']."' LIMIT 1 ");
	        }
	        else if($row['transactiontype']=='CASH' && $row['accounttype']=='PURCHASE') 
          	{
            	$edit = '<a href="index.php?edit_cashtransaction&tid='.convert_string('encrypt', $row['unicid']).'&type='.convert_string('encrypt', 'jama').'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a>';
            	$delete = '<button class="btn btn-sm p-0 delete_cashjama" id="'.convert_string('encrypt', $row['unicid']).'" ><i class="fas fa-trash-alt text-danger"></i></button>';
            	$desc = 'CASH ENTRY';
          	}

          $output .= '<tr>
              <td>'.$start++.'</td>
              <td>'.date('d-m-Y', strtotime($row['insdate'])).'</td>
              <td>'.$desc.'</td>
              <td align="center">'.number_format($row['weight'],3).'</td>
              <td align="center">'.$row['amount'].'</td>
              <td>'.$row['description'].'</td>
              <td align="center">'.$edit.'</td>
              <td align="center">'.$delete.'</td>
          </tr>';
          // $total_weight += $row['weight'];
          // $total_amount += $row['amount'];
        }
        // $output .= '<tr>
        // 	<th colspan="3">Total</th>
        // 	<td>'.number_format($total_weight,3).'</td>
        // 	<td>'.number_format(round($total_amount),2).'</td>
        // 	<th colspan="3"></th>
        // 	</tr>';
        echo $output;
	}

	if ($_POST['btn_action'] == 2) 
	{	
		$output = '';
		$start = $_POST['start']+1;
		$total_weight = 0;
        $total_amount = 0;

		$query = "SELECT * FROM party_transaction INNER JOIN party_tbl ON party_tbl.party_id=party_transaction.party_id WHERE party_transaction.party_id='".$_POST['party_id']."' ";
		if ($_POST['from_date'] != '') 
		{
			$query .= "AND party_transaction.insdate BETWEEN '".date('Y-m-d', strtotime($_POST['from_date']))."' AND '".date('Y-m-d', strtotime($_POST['to_date']))."' ";
		}
		$query .= "AND party_transaction.accounttype='SALE' ORDER BY party_transaction.insdate ASC LIMIT ".$_POST['start'].", ".$_POST['limit']."";
		$statement = mysqli_query($db, $query);
		
		while ($row = mysqli_fetch_assoc($statement)) 
        {	
        	if(($row['transactiontype']=='weight' || $row['transactiontype']=='value') && $row['accounttype']=='SALE')
          	{
            	$edit = '<a href="index.php?edit_sale&sid='.convert_string('encrypt', $row['unicid']).'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a>';
            	$delete = '<button class="btn btn-sm delete_sale p-0" id="'.convert_string('encrypt', $row['unicid']).'" ><i class="fas fa-trash-alt text-danger"></i></button>';
            	$desc = sale_details($db, $row['unicid']);
          	} 
          	else if($row['transactiontype']=='BHAAW' && $row['accounttype']=='SALE') 
	        {
	            $edit = '<a href="index.php?edit_bhaawtransaction&tid='.convert_string('encrypt', $row['unicid']).'&type='.convert_string('encrypt', 'naame').'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a>';
	            $delete = '<button class="btn btn-sm p-0 delete_bhaawnaame" id="'.convert_string('encrypt', $row['unicid']).'" ><i class="fas fa-trash-alt text-danger"></i></button>';
	            $desc = 'Rate: '.$row['value']/$row['weight'].', Wt.: '.$row['weight'].', value '.$row['value'];
	        }
	        else if($row['transactiontype']=='JOURNAL' && $row['accounttype']=='SALE') 
	        {
	            $edit = '<a href="index.php?edit_journaltransaction&traid='.convert_string('encrypt', $row['unicid']).'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a>';
	            $delete = '<button class="btn btn-sm p-0 delete_journalnaame" id="'.convert_string('encrypt', $row['unicid']).'" ><i class="fas fa-trash-alt text-danger"></i></button>';
	            $desc = return_value($db,"bhaaw_tbl bt INNER JOIN party_tbl pt ON pt.party_id=bt.party_id","pt.party_name","bt.traid='".$row['unicid']."' AND bt.party_id != '".$row['party_id']."' LIMIT 1 ");
	        }
	        else if($row['transactiontype']=='CASH' && $row['accounttype']=='SALE') 
          	{
            	$edit = '<a href="index.php?edit_cashtransaction&tid='.convert_string('encrypt', $row['unicid']).'&type='.convert_string('encrypt', 'naame').'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a>';
            	$delete = '<button class="btn btn-sm p-0 delete_cashnaame" id="'.convert_string('encrypt', $row['unicid']).'" ><i class="fas fa-trash-alt text-danger"></i></button>';
            	$desc = 'CASH ENTRY';
          	}

          	$output .= '<tr>
              <td>'.$start++.'</td>
              <td>'.date('d-m-Y', strtotime($row['insdate'])).'</td>
              <td>'.$desc.'</td>
              <td align="center">'.number_format($row['weight'],3).'</td>
              <td align="center">'.$row['amount'].'</td>
              <td>'.$row['description'].'</td>
              <td align="center">'.$edit.'</td>
              <td align="center">'.$delete.'</td>
          	</tr>';
          	// $total_weight += $row['weight'];
           //  $total_amount += $row['amount'];
        }
        // $output .= '<tr>
        // 	<th colspan="3">Total</th>
        // 	<td>'.number_format($total_weight,3).'</td>
        // 	<td>'.number_format(round($total_amount),2).'</td>
        // 	<th colspan="3"></th>
        // </tr>';
        echo $output;
	}

	if ($_POST['btn_action'] == 3) 
	{
		$output = '';
		$i=1;
		// $start = $_POST['start']+1;
		
		// $query = "SELECT * FROM party_tbl WHERE party_status = 0 ";

		// if (isset($_POST['party_type']) && !empty($_POST['party_type']) ) 
		// {
		// 	$query .= "AND party_type = '".$_POST['party_type']."' ";
		// }
		// if (isset($_POST['party_id']) && !empty($_POST['party_id'])) 
		// {	
		// 	$query .= "AND party_id = '".$_POST['party_id']."' ";
		// }
		// $query .= "ORDER BY party_name ASC LIMIT ".$_POST['start'].", ".$_POST['limit']."";

		$party_type = isset($_POST['party_type']) ? $_POST['party_type'] : '';
		$party_id = isset($_POST['party_id']) ? $_POST['party_id'] : '';
		$to_date = !empty($_POST['to_date']) ? date('Y-m-d', strtotime($_POST['to_date'])) : '';

		$query = "CALL get_value_weight_pro('".$party_id."', '".$party_type."', '".$to_date."')";

		$statement = mysqli_query($db, $query);
		while ($row = mysqli_fetch_assoc($statement))
		{
			// if (isset($_POST['from_date']) && !empty($_POST['from_date'])) 
			// {	
			// 	// $grassweight = GrossWeightWithDate($db,$row['party_id'],$_POST['from_date'],$_POST['to_date']);
			// 	// $fineweight = FineWeightWithDate($db, $row['party_id'],$_POST['from_date'],$_POST['to_date']);
			// 	// $amount  = FineValueWithDate($db, $row['party_id'],$_POST['from_date'],$_POST['to_date']);
			// }
			// else
			// {
			// 	// $grassweight = GrossWeight($db, $row['party_id']);
			// 	// $fineweight = FineWeight($db, $row['party_id']);
			// 	// $amount = FineValue($db, $row['party_id']);
			// }
			
			if ($row['gvalue'] != 0 || $row['gweight'] != 0) 
			{
				$debit = '0.00';
				$credit = '0.00';
				if ($row['gvalue'] > 0) 
				{
					$debit = $row['gvalue'];
				} 
				else
				{
					$credit = abs($row['gvalue']);
				}
				$output .= '
					<tr>
						<td>'.$i++.'</td>
						<td>'.$row['party_name'].'</td>
						<td>'.$row['gweight'].'</td>
						<td>'.$debit.'</td>
						<td>'.$credit.'</td>
					</tr>
				';
			}
		}
		echo $output;	
	}
}
?>
