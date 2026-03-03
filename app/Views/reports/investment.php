	
<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="9" align="center" style="width:100%;background-color:#4caf50;font-weight:bold;">Investment List</td>
	</tr>
	<tr>
		<td align="center" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Row</td>
		<td align="center" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">ID</td>
		<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Date</td>
		<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Amount</td>
		<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Description</td>
		<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Action</td>
		
	</tr>
	<?php   
	$i=1; 
	foreach($result As $row)
	{   
	?>
		<tr>
			<td align="center" style="width:5%;background-color:#b3d7ff87;"><?=$i?></td>
			<td align="center" style="width:5%;background-color:#b3d7ff87;"><?=$row->Id?></td>
			<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->sdate?></td>
			<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;">RM <?=number_format($row->amount,2)?></td>
			<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->description?></td>
			<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;">
				<a style="test-decoration: none;" title="View Record" href="<?=base_url('viewFund/')?><?=$row->Id?>/1" target="_blank">View</a>
				<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('editFund/')?><?=$row->Id?>" target="_blank">Edit</a>
			</td>
		</tr>
	
	<?php
		$i++;
	}
	?>
	<tr>
		<td colspan="5" align="center" style="width:5%;background-color:#b3d7ff87;font-weight:bold;">Total Amount:</td>
		<td style="width:5%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;">RM <?=number_format($total,2)?></td>
	</tr>
</table>
