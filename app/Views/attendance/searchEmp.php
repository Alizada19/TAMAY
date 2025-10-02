<table cellpadding="5px" style="width:99%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="12" align="center" style="width:100%;background-color:#4caf50;font-weight:bold;">Employees List</td>
	</tr>
	<tr>
		<td align="center" style="width:5%;background-color:#b3d7ff87;font-weight:bold;">Row</td>
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Name</td>
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Last Name</td>
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Location</td>
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Department</td>
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Nationality</td>
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Contact No</td>
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Emergency Contact</td>
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Email</td>
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Join Date</td>
		<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Address</td>
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Action</td>
		
	</tr>
	<?php
	$i=1;
	foreach($result As $row)
	{
	?>
		<tr>
			<td align="center" style="width:5%;background-color:#b3d7ff87;"><?=$i?></td>
			<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->name?></td>
			<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->lname?></td>
			<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;"><?=location($row->location)?></td>
			<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;"><?=getDep($row->department)?></td>
			<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;"><?=getNat($row->nat)?></td>
			<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->phone1?></td>
			<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->phone2?></td>
			<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->email?></td>
			<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->jdate?></td>
			<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->addr?></td>
			<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;">
				<a style="test-decoration: none;" title="View Record" href="<?=base_url('codeigniter/public/attendance/viewemp/')?><?=$row->Id?>/2" target="_blank">View</a>
			</td>
		</tr>
	
	<?php
		$i++;
	}
	?>
</table>
