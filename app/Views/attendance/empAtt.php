<!-- Table for displaying the punches -->
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Date</th> 
			<th>Employee Name</th>
			<th>Clock In</th>
			<th>Break In</th>
			<th>Break Out</th>
			<th>Clock Out</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach($records As $row)
	{

?>	
		<tr>
			<td><?=$row['pdate']?></td>  
			<td><?=getEmp($row['empId'])?></td>
			<td><?=$row['in']?></td>
			<td><?=$row['bin']?></td>
			<td><?=$row['bout']?></td>
			<td><?=$row['out']?></td>
			<td>
				<a href='<?=base_url('codeigniter/public/attendance/viewPunch/')?><?=$row['Id']?>' target="_blank" class='action-btn'>View</a>
				<a href='<?=base_url('codeigniter/public/attendance/deletePunch/')?><?=$row['Id']?>' target="_blank" class='action-btn'>Delete</a>
			</td>
		</tr>
<?php
	}
?>		
	</tbody>
</table>