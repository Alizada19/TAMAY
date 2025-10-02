<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
	<h4>List of Subcategory</h4>
</div>
<div style="width:100%" style="margin-right:1%;">
<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="5" align="center" style="width:100%;background-color:#4caf50;font-weight:bold;">Subcategory List</td>
	</tr>
	<tr>
		<td align="center" style="width:5%;background-color:#b3d7ff87;font-weight:bold;">S.No</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Subcategory Name</td>
		<td style="width:13%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Created On</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Created By</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Action</td>
	</tr>
	<?php
	$i=1;
	foreach($result As $row)
	{
	?>
		<tr>
			<td align="center" style="width:5%;background-color:#b3d7ff87;"><?=$i?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->sname?></td>
			<td style="width:13%;background-color:#b3d7ff87;padding-left:5px;"><?=date_format(date_create($row->saveDate), 'Y-m-d')?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->username?></td>
			<td style="width:8%;padding-left:5px;background-color:#b3d7ff87;">
				<a style="test-decoration: none;" title="View Record" href="<?=base_url('codeigniter/public/expenses/subcategoryView/')?><?=$row->Id?>/2" target="_blank">View</a>
				<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('codeigniter/public/expenses/subcategoryEditView/')?><?=$row->Id?>" target="_blank">Edit</a>
			</td>
		</tr>
	
	<?php
		$i++;
	}
	?>
</table>
</div>		