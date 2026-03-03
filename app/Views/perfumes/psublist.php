<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="9" align="center" style="width:100%;background-color:#4caf50;font-weight:bold;">Perfume List</td>
	</tr>
	<tr>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">ID</td>
		<td style="width:30%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Name</td>
		<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Groupe</td>
		<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Category</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Remark</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Image</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">View</td>
	</tr>
<?php
	foreach($perfume As $row)
	{		
?>	
		<tr>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;"><?=$row->Id?></td>
			<td style="width:30%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;"><?=$row->name?></td>
			<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;"><?=pgname($row->group)?></td>
			<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;"><?=pcname($row->category)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Remark</td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">
				<img src="<?= base_url()?><?=getImage($row->Id)?>" alt="No Image" style="width: 30px; height: 30px;">
			</td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">
				<a style="test-decoration: none;" title="View Record" href="<?=base_url('perfumes/view/')?><?=$row->Id?>/2" target="_blank">View</a>
			</td>
		</tr>
<?php
	}
?>	
	<a href="<?=base_url('perfumes/add')?>" target="_blank" title="Add Perfume">Add Perfume</a>
</table>
