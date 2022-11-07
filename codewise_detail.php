<?php
include('conn.php');
include('function.php');

// if(!isset($_SESSION['id'])) {
// 	header("location:login.php");
// 	}

	if(isset($_POST['btn_action']))
	{
		if ($_POST['btn_action'] == 1) 
		{
			$output = '';
			$start = $_POST['start']+1;
			$product_id = $_POST['product_id'];
			$category_id = $_POST['category_id'];

			$pgrandtotwe	=	0;
			$pgrandtotva	=	0;
			$tot_value	=	0;

			$query = "SELECT * FROM purchase_tbl WHERE purchase_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' ORDER BY purchase_date,pid";
			$run = mysqli_query($db,$query);
			while ($row = mysqli_fetch_assoc($run)) 
			{	
				if (isset($_POST['category_id']) && !empty($_POST['category_id'])) 
				{
					$totwe = return_value($db,"purchasedetail_tbl","sum(weight)","pid='".$row['pid']."' AND category_id='".$category_id."' ");
					$totva = return_value($db,"purchasedetail_tbl","sum(rate)","pid='".$row['pid']."' AND category_id='".$category_id."' ");
					$totamt = return_value($db,"purchasedetail_tbl","sum(amount)","pid='".$row['pid']."' AND category_id='".$category_id."' ");
				}
				else
				{
					$totwe = return_value($db,"purchasedetail_tbl","sum(weight)","pid='".$row['pid']."' AND product_id='".$product_id."' ");
					$totva = return_value($db,"purchasedetail_tbl","sum(rate)","pid='".$row['pid']."' AND product_id='".$product_id."' ");
					$totamt = return_value($db,"purchasedetail_tbl","sum(amount)","pid='".$row['pid']."' AND product_id='".$product_id."' ");
				}
				if($row['methodtype']=="weight")
				{
					$pgrandtotwe = $pgrandtotwe+$totwe;
				}
				else
				{
					$pgrandtotwe = $pgrandtotwe+$totwe;
				}
				$tot_value = $tot_value+$totamt;
				$pgrandtotva = $pgrandtotva+$totva;
				if($totwe > 0 || $totva > 0 || $totamt > 0)
				{
				
					$output .= '<tr>
						<td>'.$start++.'</td>
						<td style="font-size:12px"; align="center">'. date('d-m-Y',strtotime($row['purchase_date'])).'</td>	
						<td>'. return_value($db, "party_tbl","party_name","party_id='".$row['party_id']."' ").'</td>
						<td style="font-size:12px"; align="center">'. number_format($totwe,'3','.','').'</td>	
						<td style="font-size:12px"; align="center">'. number_format($totva,'3','.','').'</td>					
						<td style="font-size:12px"; align="center">'. number_format($totamt,'2','.','').'</td>					
						<td style="font-size:12px"; align="center"><a href="index.php?edit_purchase&pid='.convert_string('encrypt', $row['pid']).'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a></td>
				
						<td align="center"><button class="btn btn-sm delete_purchase p-0" id="'.convert_string('encrypt', $row['pid']).'" ><i class="fas fa-trash-alt text-danger"></i></button></td>		
					</tr>';
				}
			}
			$output .= '<tr>
				<td style="font-size:12px"; colspan="3" align="right"><b>Total</b></td>
				<td style="font-size:12px";><b>'.number_format($pgrandtotwe,3,'.','').'</b></td>
				<td style="font-size:12px"; align="center"><b>'.number_format($pgrandtotva,3,'.','').'</b></td>			
				<td style="font-size:12px"; align="center"><b>'.number_format($tot_value,2,'.','').'</b></td>			
				<td></td>
				<td></td>
			</tr>';
			echo $output;		
		}

		if ($_POST['btn_action'] == 2) 
		{
			$output = '';
			$start = $_POST['start']+1;
			$product_id = $_POST['product_id'];
			$category_id = $_POST['category_id'];

			$sgrandtotwe	=	0;
			$sgrandtotva	=	0;
			$tot_value	=	0;

			$query = "SELECT * FROM sale_tbl WHERE sale_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' ORDER BY sale_date,sid";
			$run = mysqli_query($db,$query);
			while ($row = mysqli_fetch_assoc($run)) 
			{	
				if (isset($_POST['category_id']) && !empty($_POST['category_id'])) 
				{
					$totwe = return_value($db,"saledetail_tbl","sum(weight)","sid='".$row['sid']."' AND category_id='".$category_id."' ");
					$totva = return_value($db,"saledetail_tbl","sum(rate)","sid='".$row['sid']."' AND category_id='".$category_id."' ");
					$totamt = return_value($db,"saledetail_tbl","sum(amount)","sid='".$row['sid']."' AND category_id='".$category_id."' ");
				}
				else
				{
					$totwe = return_value($db,"purchasedetail_tbl","sum(weight)","sid='".$row['sid']."' AND product_id='".$product_id."' ");
					$totva = return_value($db,"purchasedetail_tbl","sum(rate)","sid='".$row['sid']."' AND product_id='".$product_id."' ");
					$totamt = return_value($db,"purchasedetail_tbl","sum(amount)","sid='".$row['sid']."' AND product_id='".$product_id."' ");
				}
				if($row['methodtype']=="weight") 
				{
					$sgrandtotwe	=	$sgrandtotwe+$totwe;
				}
				else
				{
					$sgrandtotwe	=	$sgrandtotwe+$totwe;
				}
				$tot_value	=	$tot_value+$totamt;		
				$sgrandtotva	=	$sgrandtotva+$totva;		
				if($totwe > 0 || $totva > 0 || $totamt > 0)
				{
				
					$output .= '<tr>
						<td>'.$start++.'</td>
						<td align="center">'. date('d-m-Y',strtotime($row['sale_date'])).'</td>	
						<td>'. return_value($db, "party_tbl","party_name","party_id='".$row['party_id']."' ").'</td>
						<td align="center">'. number_format($totwe,'3','.','').'</td>	
						<td align="center">'. number_format($totva,'3','.','').'</td>					
						<td align="center">'. number_format($totamt,'3','.','').'</td>					
						<td align="center"><a href="index.php?edit_sale&sid='.convert_string('encrypt', $row['sid']).'" target="_blank"><button class="btn btn-sm p-0"><i class="fas fa-edit text-warning"></i></button></a></td>
				
						<td align="center"><button class="btn btn-sm delete_sale p-0" id="'.convert_string('encrypt', $row['sid']).'" ><i class="fas fa-trash-alt text-danger"></i></button></td>		
					</tr>';
				}
			}
			$output .= '<tr>
				<td style="font-size:12px"; colspan="3" align="right"><b>Total</b></td>
				<td style="font-size:12px"; align="center"><b>'.number_format($sgrandtotwe,3,'.','').'</b></td>
				<td style="font-size:12px"; align="center"><b>'.number_format($sgrandtotva,3,'.','').'</b></td>			
				<td style="font-size:12px"; align="center"><b>'.number_format($tot_value,3,'.','').'</b></td>			
				<td></td>
				<td></td>
			</tr>';
			echo $output;		
		}

		if ($_POST['btn_action'] == 3) 
		{
			$output = '';
			$product_id = $_POST['product_id'];
			$category_id = $_POST['category_id'];

			$pgrandtotwe = 0;
			$sgrandtotwe = 0;
			$pgrandtotcwe = 0;
			$sgrandtotdwe = 0;

			if (isset($_POST['category_id']) && !empty($_POST['category_id'])) 
			{
				$query = "SELECT * FROM purchase_tbl pr,purchasedetail_tbl prd WHERE pr.pid=prd.pid AND pr.purchase_date < '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  prd.category_id='".$category_id."' ";
				$result = mysqli_query($db, $query);
				$opening = return_value($db,"itemopstock_tbl","jamagw","category_id='".$category_id."'");
			}
			else
			{
				$query = "SELECT * FROM purchase_tbl pr,purchasedetail_tbl prd WHERE pr.pid=prd.pid AND pr.purchase_date < '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  prd.product_id='".$product_id."' ";
				$result = mysqli_query($db, $query);
				$opening = return_value($db,"itemopstock_tbl","jamagw","product_id='".$product_id."'");
			}
			$totwep = 0;
			$totfwep = 0;
			while($row=mysqli_fetch_assoc($result))
			{
				$totwep = $totwep + $row['weight'];
				$totfwep = $totwep + $row['rate'];				
			}
			$pgrandtotwe =	$pgrandtotwe+$totwep+$opening;
			//$pgrandtotfwe =	$pgrandtotfwe+$totfwep+return_value($db,"itemopstock_tbl","jamafw","product_id='".$product_id."'");

			if (isset($_POST['category_id']) && !empty($_POST['category_id'])) 
			{
				$query = "SELECT * FROM sale_tbl sr,saledetail_tbl srd WHERE sr.sid=srd.sid AND sr.sale_date < '".date('Y-m-d',strtotime($_POST['from_date']))."' AND srd.category_id='".$category_id."' ";
				$opening_naame = return_value($db,"itemopstock_tbl","naamegw","category_id='".$category_id."'");
			}
			else
			{
				$query = "SELECT * FROM sale_tbl sr,saledetail_tbl srd WHERE sr.sid=srd.sid AND sr.sale_date < '".date('Y-m-d',strtotime($_POST['from_date']))."' AND srd.product_id='".$product_id."' ";
				$opening_naame = return_value($db,"itemopstock_tbl","naamegw","product_id='".$product_id."'");
			}
			$totwes = 0;
			$totfwes = 0;
			$result = mysqli_query($db, $query);
			while($row = mysqli_fetch_assoc($result))
			{
				$totwes =	$totwes + $row['weight'];
				$totfwes =	$totfwes + $row['rate'];				
			}
			$sgrandtotwe =	$sgrandtotwe+$totwes+$opening_naame;
			// $sgrandtotfwe =	$sgrandtotfwe+$totfwes+return_value($db,"itemopstock_tbl","naamefw","product_id='".$product_id."'");
			//credit
			if (isset($_POST['category_id']) && !empty($_POST['category_id'])) 
			{
				$query = "SELECT * FROM purchase_tbl pr,purchasedetail_tbl prd WHERE pr.pid=prd.pid AND pr.purchase_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' AND  prd.category_id='".$category_id."' ";		
			}
			else
			{
				$query = "SELECT * FROM purchase_tbl pr,purchasedetail_tbl prd WHERE pr.pid=prd.pid AND pr.purchase_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' AND  prd.product_id='".$product_id."' ";
			}
			$result = mysqli_query($db, $query);
			$totwec = 0;
			$totfwec = 0;
			while($row = mysqli_fetch_assoc($result))
			{
				$totwec			=	$totwec+$row['weight'];
				$totfwec		=	$totfwec+$row['rate'];				
			}
			$pgrandtotcwe	=	$pgrandtotcwe+$totwec;
			//$pgrandtotfcwe	=	$pgrandtotfcwe+$totfwec;	

			if (isset($_POST['category_id']) && !empty($_POST['category_id'])) 
			{
				$query = "SELECT * FROM sale_tbl sr,saledetail_tbl srd WHERE sr.sid=srd.sid AND sr.sale_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' AND srd.category_id='".$category_id."' ";			
			} 
			else
			{
				$query = "SELECT * FROM sale_tbl sr,saledetail_tbl srd WHERE sr.sid=srd.sid AND sr.sale_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' AND srd.product_id='".$product_id."' ";
			}
			$result = mysqli_query($db, $query);
			$totwed = 0;
			$totfwed = 0;
			while($row = mysqli_fetch_assoc($result))
			{
				$totwed			=	$totwed+$row['weight'];
				$totfwed		=	$totfwed+$row['rate'];		
			}
			$sgrandtotdwe	=	$sgrandtotdwe+$totwed;
			//$sgrandtotfdwe	=	$sgrandtotfdwe+$totfwed;

			$output .= '<table class="table table-bordered table-sm mt-4">
						<tr class="thead-light">
							<th rowspan="2" style="vertical-align:middle; font-size:12px; text-align:center; background-color: #e9ecef;">GROSS WEIGHT</th>
							<th style="font-size:12px;" class="text-center">OPENING <br> (IN GM)</th>
							<th style="font-size:12px;" class="text-center">CREDIT  <br>(IN GM)</th>
							<th style="font-size:12px;" class="text-center">DEBIT <br> (IN GM)</th>
							<th style="font-size:12px;" class="text-center">CLOSING <br> (IN GM)</th>
						</tr>
					<tr>
						<td style="font-size:12px; align="center"><b>'.number_format($pgrandtotwe-$sgrandtotwe,'3','.','').'</b></td>
						<td style="font-size:12px; align="center"><b>'.number_format($pgrandtotcwe,'3','.','').'</b></td>
						<td style="font-size:12px; align="center"><b>'.number_format($sgrandtotdwe,'3','.','').'</b></td>
						<td style="font-size:12px; align="center"><b>'.number_format($pgrandtotwe-$sgrandtotwe+$pgrandtotcwe-$sgrandtotdwe,'3','.','').'</b></td>
					</tr>
			</table>';
			echo $output;
		}

		if ($_POST['btn_action'] == 4) 
		{
			$output ='';

			$query =  "SELECT product_id,code,item_name FROM product_tbl";
			$statement = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($statement)) 
			{	
				$pweight = 0;
				$query = "SELECT SUM(weight) as weight FROM purchasedetail_tbl WHERE product_id=".$row['product_id']." ";
				if (isset($_POST['from_date'], $_POST['to_date']) && !empty($_POST['from_date']) && !empty($_POST['to_date'])) 
				{
					$query .= "AND purchase_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' ";
				}
				$result = mysqli_query($db, $query);
				$rows = mysqli_fetch_assoc($result);
				$pweight = $rows['weight'] + $pweight;

				$query =  mysqli_query($db, "SELECT jamagw FROM itemopstock_tbl WHERE product_id=".$row['product_id']);
				$row_s = mysqli_fetch_assoc($query);
				$opweight = $row_s['jamagw'];				

				$sweight = 0;
				$query = "SELECT sum(weight) as weight FROM saledetail_tbl WHERE product_id='".$row['product_id']."' ";
				if (isset($_POST['from_date'], $_POST['to_date'])) 
				{
					$query .= "AND sale_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' ";
				}
				$result = mysqli_query($db, $query);
				$rows = mysqli_fetch_assoc($result);
				$sweight = $rows['weight'] + $sweight;

				$query =  mysqli_query($db, "SELECT naamegw FROM itemopstock_tbl WHERE product_id=".$row['product_id']);
				$row_s = mysqli_fetch_assoc($query);
				$osweight = $row_s['naamegw'];
				$gross_weight = $pweight+$opweight-$sweight-$osweight ;


				$prate = 0;
				$query = "SELECT sum(rate) as rate FROM purchasedetail_tbl WHERE product_id='".$row['product_id']."' ";
				if (isset($_POST['from_date'], $_POST['to_date']) && !empty($_POST['from_date']) && !empty($_POST['to_date'])) 
				{
					$query .= "AND purchase_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' ";
				}
				$result = mysqli_query($db, $query);
				$rows = mysqli_fetch_assoc($result); 
        	$prate = $rows['rate'] + $prate;

        	$query =  mysqli_query($db, "SELECT jamafw FROM itemopstock_tbl WHERE product_id=".$row['product_id']);
		  	$row_s = mysqli_fetch_assoc($query);
		  	$oprate = $row_s['jamafw'];				

        	$srate = 0;
        	$query = "SELECT sum(rate) as rate FROM saledetail_tbl WHERE product_id='".$row['product_id']."' ";
        	if (isset($_POST['from_date'], $_POST['to_date'])) 
        	{
        		$query .= "AND sale_date BETWEEN '".date('Y-m-d',strtotime($_POST['from_date']))."' AND '".date('Y-m-d',strtotime($_POST['to_date']))."' ";
        	}
        	$result = mysqli_query($db, $query);
        	$rows = mysqli_fetch_assoc($result);
        	$srate = $rows['rate'] + $srate;

        	$query =  mysqli_query($db, "SELECT naamefw FROM itemopstock_tbl WHERE product_id=".$row['product_id']);
		   	$row_s = mysqli_fetch_assoc($query);
		   	$osrate = $row_s['naamefw'];
		  	$fine_weight = $prate+$oprate-$srate-$osrate ;

	
        	$output .= '<tr>
                <td>'.$row['item_name'].' [ '.$row['code'].' ] ['.$row['product_id'].'] </td>
                <td align="center">'.$gross_weight.'</td>
                <td align="center">'.$fine_weight.'</td>
              </tr>';	
        }
		
		echo $output;
	}
}

?>