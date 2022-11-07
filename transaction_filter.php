<?php
include('conn.php');
include('function.php');


if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 1)
	{
		$output = '';
		$start = $_POST['start']+1;

		$statement = mysqli_query($db, "SELECT * FROM daybook JOIN party_tbl ON party_tbl.party_id=daybook.party_id WHERE type = 'PURCHASE' AND insdate = '".date('Y-m-d', strtotime($_POST['day_date']))."' ORDER BY insdate DESC ");
		if (mysqli_num_rows($statement) > 0 ) 
		{
			while ($row = mysqli_fetch_assoc($statement)) 
            {
              $output .= '<tr>
              	<td>'.$start++.'</td>
              	<td>'.date('d.m.Y', strtotime($row['insdate'])).'</td>
              	<td>'.$row['party_name'].'</td>
              	<td align="center">'.$row['weight'].'</td>
              	<td align="center">'.$row['amount'].'</td>
              	<td>'.$row['description'].'</td>
              </tr>';
            }
		}
		else
		{
			$output .= '<tr>
				<th colspan="5">Data Not Found</th>
			</tr>';
		}
		echo $output;
	}

	if($_POST['btn_action'] == 2)
	{
		$output = '';
		$start = $_POST['start']+1;

		$statement = mysqli_query($db, "SELECT * FROM daybook JOIN party_tbl ON party_tbl.party_id=daybook.party_id WHERE type = 'SALE' AND insdate = '".date('Y-m-d', strtotime($_POST['day_date']))."' ORDER BY insdate DESC ");
		if (mysqli_num_rows($statement) > 0 ) 
		{
			while ($row = mysqli_fetch_assoc($statement)) 
            {
              $output .= '<tr>
              	<td>'.$start++.'</td>
              	<td>'.date('d.m.Y', strtotime($row['insdate'])).'</td>
              	<td>'.$row['party_name'].'</td>
              	<td align="center">'.$row['weight'].'</td>
              	<td align="center">'.$row['amount'].'</td>
              	<td>'.$row['description'].'</td>
              </tr>';
            }
		}
		else
		{
			$output .= '<tr>
				<th colspan="5">Data Not Found</th>
			</tr>';
		}
		echo $output;
	}

	if($_POST['btn_action'] == 3)
	{
		$output = '';
		$start = $_POST['start']+1;
		$from_date	=	date('Y-m-d',strtotime($_POST['from_date']));
		$to_date = date('Y-m-d',strtotime($_POST['to_date']));

		$query	= "SELECT * FROM cashbook JOIN party_tbl ON party_tbl.party_id=cashbook.party_id WHERE cashbook.tran_type ='PURCHASE' AND insdate BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY traid ASC";
		

		$result	= mysqli_query($db, $query);
		
		if (mysqli_num_rows($result) > 0 ) 
		{
			while ($row = mysqli_fetch_assoc($result)) 
            {
              $output .= '<tr>
              	<td>'.$start++.'</td>
              	<td>'.date('d-m-Y', strtotime($row['insdate'])).'</td>
              	<td>'.$row['party_name'].'</td>
              	<td align="center">'.number_format($row['weight'],3,'.','').'</td>
				<td align="center">'.number_format(round($row['amount']+$row['valu']),'2','.','').'</td>
				<td>'.$row['description'] .'</td>
              </tr>';
            }
		}
		else
		{
			$output .= '<tr>
				<th colspan="5">Data Not Found '.$query.'</th>
			</tr>';
		}
		echo $output;
	}

	if($_POST['btn_action'] == 4)
	{
		$output = '';
		$start = $_POST['start']+1;
		$from_date	=	date('Y-m-d',strtotime($_POST['from_date']));
		$to_date = date('Y-m-d',strtotime($_POST['to_date']));

		$query	= "SELECT * FROM cashbook JOIN party_tbl ON party_tbl.party_id=cashbook.party_id WHERE cashbook.tran_type ='SALE' AND insdate BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY traid ASC";
	
		$result	= mysqli_query($db, $query);
		if (mysqli_num_rows($result) > 0 ) 
		{
			while ($row = mysqli_fetch_assoc($result)) 
            {
              $output .= '<tr>
              	<td>'.$start++.'</td>
              	<td>'.date('d-m-Y', strtotime($row['insdate'])).'</td>
              	<td>'.$row['party_name'].'</td>
              	<td align="center">'.number_format($row['weight'],3,'.','').'</td>
				<td align="center">'.number_format(round($row['amount']+$row['valu']),'2','.','').'</td>
				<td>'.$row['description'] .'</td>
              </tr>';
            }
		}
		else
		{
			$output .= '<tr>
				<th colspan="5">Data Not Found</th>
			</tr>';
		}
		echo $output;
	}
	
}

?>