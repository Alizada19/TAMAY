	
<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="11" align="center" style="width:100%;background-color:#4caf50;font-weight:bold;">Daily Sales List</td>
	</tr>
	<tr>
		<td align="center" style="width:5%;background-color:#b3d7ff87;font-weight:bold;">Row</td>
		<td align="center" style="width:5%;background-color:#b3d7ff87;font-weight:bold;">ID</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Date</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Total Sales</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Card</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Atome</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">OT</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Cash</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Expense</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Net Cash</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Actions</td>
		
	</tr>
	<?php   
	$i=1; 
	foreach($result As $row)
	{     
	?>
		<tr>
			<td align="center" style="width:5%;background-color:#b3d7ff87;"><?=$i?></td>
			<td align="center" style="width:5%;background-color:#b3d7ff87;"><?=$row->Id?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->sdate?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">RM <?=number_format($row->tsales,2)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">RM <?=number_format($row->card,2)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">RM <?=number_format($row->atome,2)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">RM <?=number_format($row->ot,2)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">RM <?php
				$cash = $row->tsales - ($row->card+$row->atome+$row->ot);
				echo number_format($cash,2);
			?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">RM <?=number_format($row->texpense,2)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">RM <?php
			$netCash = $cash - $row->texpense;
			echo number_format($netCash,2)
			?></td>
			
			<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;">
				<a style="test-decoration: none;" title="View Record" href="<?=base_url('codeigniter/public/johoniSalesView/')?><?=$row->Id?>/1" target="_blank">View</a>
				<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('codeigniter/public/editJohoniSales/')?><?=$row->Id?>" target="_blank">Edit</a>
			</td>
		</tr>
	
	<?php
		$i++;
	}
	?>
	<tr>
		<td colspan="3"  align="center" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Total</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">RM <?=number_format($total->tsales,2)?></td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">RM <?=number_format($total->tcard,2)?></td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">RM <?=number_format($total->atome,2)?></td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">RM <?=number_format($total->ot,2)?></td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">RM 
			<?php
				$tncash = $total->tsales - ($total->tcard + $total->atome + $total->ot);
				echo number_format($tncash,2);
			?>
		</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">RM <?=number_format($total->texpense,2)?></td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">RM 
			<?php
				$tncash = $total->tcash - $total->texpense;
				echo number_format($tncash,2);
			?>
		</td>
		<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;"></td>
		
		
	</tr>
</table>
