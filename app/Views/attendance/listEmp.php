<div style="clear:both;font-weight:bold;cursor:pointer;margin-left:2%;" title="Filter" onclick="showHideFilter();">
	Fiter
</div>
<div id="sfilter" style="background-color: lavenderblush;clear:both;padding:5px 5px 5px 5px; border: 1px solid gray;display:none; margin-left:10px;width:99%;">
    <form id="filter1" method="get" action="">	
		<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
			<div class="col-sm-4" style="font-weight:bold;"><label for="amount">Commencement Date:</label></div>
			<div class="col-sm-1" style="font-weight:bold;"><label for="sdate">From:</label></div>
			<div class="col-sm-2" style="padding:0 0 0 0;">
				<input type="date" class="form-control" name="sdate" id="sdate">
			</div>
			<div class="col-sm-2" style="font-weight:bold;"><label for="edate">To:</label></div>
			<div class="col-sm-2" style="padding:0 0 0 0;">
				<input type="date" class="form-control" name="edate" id="edate">
			</div>
		</div>
		<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
			<div class="col-sm-3" style="padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="emp" name="emp">
					<option value="">Employee</option>		
						<?=$allEmps?>	
				</select>
			</div>
			<div class="col-sm-3" style="padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="location" name="location">
					<option value="">Location</option>	
						<?=$shops?>	
				</select>
			</div>
			<div class="col-sm-3" style="background-color:lavender;padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="dep" name="dep">
					<option value="">Department</option>
							<?=$allDeps?>
				</select>
			</div>
			<div class="col-sm-3" style="background-color:lavender;padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="nat" name="nat">
					<option value="">Nationality</option>	
					<?=$allNats?>
				</select>
			</div>
		</div>
		<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
			<div class="col-sm-3" style="background-color:lavender;padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="status" name="status">
					<option value="">Select Status</option>	
					<option value="1">Active</option>	
					<option value="2">Deactive</option>	
					
				</select>
			</div>
			<div class="col-sm-2" style="background-color:lavenderblush;font-weight:bold;"><label for="bsalary">Basic Salary:</label></div>
			<div class="col-sm-2" style="background-color:lavender;padding:0 0 0 0;">
				<input type="text" class="form-control" name="bsalary" id="bsalary">
			</div>
			<div class="col-sm-1" style="font-weight:bold;">
				<button type="button" onclick="filterSearch(); hideSearch();" class="btn btn-info">Search</button>
			</div>
			<div class="col-sm-4" style="font-weight:bold;">
				<button type="button" onclick="clearBoxes();" class="btn btn-info">Reset</button>
			</div>
		</div>
	</form>	
</div>
<div id="listCon" style="width:100%;margin-right:10px; margin-left:10px;">
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
		<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Emergency Contacts</td>
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
</div>		
<script>
function showHideFilter()
{
	$("#sfilter").slideToggle();
}

//Filter search
function filterSearch()
{  
	var formData = $("#filter1").serialize(); 
	$.ajax({
				 type: 'get',
				 url: "<?=base_url('codeigniter/public/attendance/searchEmp')?>",
				 data: formData,
				 success: function(result) {
					$("#listCon").empty(); 
					$("#listCon").append(result);
				  }
				});	
}
</script>