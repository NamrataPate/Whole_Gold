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
}
?>