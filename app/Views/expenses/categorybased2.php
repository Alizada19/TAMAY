<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
	<h4>Category Based</h4>
</div>
<div id="listCon" style="width:100%" style="margin-right:1%;">
<table cellpadding="5px" style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="9" align="center" style="width:100%;background-color:#4caf50;font-weight:bold;">Expenses List</td>
	</tr>
	<tr>
		<td align="center" style="width:5%;background-color:#b3d7ff87;font-weight:bold;">Row</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Expense Date</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Amount</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Payment Type</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Groupe</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Category</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Subcategory</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Description</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Action</td>
		
	</tr>
	<?php
	$i=1;
	foreach($result As $row)
	{
	?>
		<tr>
			<td align="center" style="width:5%;background-color:#b3d7ff87;"><?=$i?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->pdate?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">RM <?=number_format($row->amount,2)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=ptype($row->ptype)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=gname($row->groupe)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=cname($row->category)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=sname($row->subcategory)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->des?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">
				<a style="test-decoration: none;" title="View Record" href="<?=base_url('codeigniter/public/expenses/view/')?><?=$row->Id?>/2" target="_blank">View</a>
				<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('codeigniter/public/expenses/editView/')?><?=$row->Id?>" target="_blank">Edit</a>
			</td>
		</tr>
	
	<?php
		$i++;
	}
	?>
	<tr>
		<td colspan="8" align="center" style="width:5%;background-color:#b3d7ff87;font-weight:bold;">Total Amount:</td>
		<td style="width:5%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;">RM <?=number_format($sum, 2)?></td>
	</tr>
</table>
</div>		
