<?php
include('conn.php');
include('function.php');

// if(!isset($_SESSION['id'])) {
//   header("location:login.php");
// }

if(isset($_POST['btn_action']))
{
	if ($_POST['btn_action'] == 0) 
	{
		if ($_POST['party_id'] != '') 
		{	
			$output = ''; 
			$total_receive = 0;
			$total_pay = 0;
			$i = 1;
			$title = '';

			$query = "SELECT * FROM expense_tbl WHERE party_id ='".$_POST['party_id']."' ";

			if(isset($_POST["from_date"], $_POST["to_date"]) && !empty($_POST['from_date']) && !empty($_POST['to_date']))
			{
				$query .= "AND insdate BETWEEN '".date('Y-m-d',strtotime($_POST["from_date"]))."' AND '".date('Y-m-d',strtotime($_POST["to_date"]))."' ";

				$title = 'BETWEEN '.date('Y-m-d',strtotime($_POST["from_date"])).' AND '.date('Y-m-d',strtotime($_POST["to_date"]));
			}
			

			$statement = mysqli_query($db, $query);
			if (mysqli_num_rows($statement) > 0) 
			{	
				$output .= '<table class="table table-bordered table-sm" id="expenseTable" >
  					<thead class="thead-light">
	  					<tr>
							<th colspan="6" class="text-center">EXPENSES DETAIL ' .$title.' </th>
						</tr>
  						<tr>
  							<th>S.no</th>
  							<th>Date</th>
  							<th>Name</th>
  							<th>Receive Amt</th>
  							<th>Pay Amt.</th>
  							<th>Desc.</th>
  						</tr>
  					</thead>
  					<tbody>';
				while ($row = mysqli_fetch_array($statement)) 
				{
					$receive_amount = 0;
					$pay_amount = 0;
					if ($row['b'] == 'PURCHASE') 
					{
						$receive_amount = $row['amount'];
					}
					else
					{
						$pay_amount = $row['amount'];
					}

					$output .= '
					<tr>
						<td>'.$i++.'</td>
						<td>'.date('d-m-Y',strtotime($row["insdate"])).'</td>
						<td>'.$row['party_name'].'</td>
						<td>'.$receive_amount.'</td>
						<td>'.$pay_amount.'</td>
						<td>'.$row['description'].'</td>
					</tr>';
					$total_receive += $receive_amount;
					$total_pay += $pay_amount;
				}
				$output .= '
				<tr>
					<th colspan="3">Total</th>
					<th>'.$total_receive.'</th>
					<th>'.$total_pay.'</th>
					<th></th>
				</tr>
				';
			}
			else
			{
				$output .= '<h3>Data Not Found</h3>';
			}
			$output .= '</tbody></table>';
		}
		else
		{
			$output = "Something error try again later";
		}
		echo $output;
	}
}
?>