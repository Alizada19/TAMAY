<div>
<form id="reportform" action="<?=base_url('codeigniter/public/salary/updateSave/')?><?=$row->Id?>" method="post">
	<table class="table table-bordered table-hover" style="width:60%;text-align:center;margin-left:20%; margin-right:20%;">
		<thead>
		<tr>
			<td colspan="2"><input type="date" name="sdate" id="sdate" value="<?=$row->sdate?>" style="width:30%; border:none; text-align:center;">
		</td>
		</tr>
			<tr>
				<td  colspan="4" style="text-align:center;font-weight:bold;">User Details</td>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td>Employee Name</td>
			<td><?=getEmp($edetails->Id)?></td>
		</tr>
		<tr>
			<td>Nationality</td>
			<td><?=getNat2($edetails->nat)?></td>
		</tr>
		<tr>
			<td>Bank Name</td>
			<td><?=getbname($edetails->bname)?></td>
		</tr>
		<tr>
			<td>Account Number:</td>
			<td><?=$edetails->accno?></td>
		</tr>
		<tr>
			<td>Basic Salary:</td>
			<td><?=$edetails->bsalary?></td>
		</tr>
		<tr>
			<td>OT (HRS):</td>
			<td><input type="text" name="otHours" id="otHours" value="<?=$row->otHours?>" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Worked off day:</td>
			<td><input type="text" name="wod" id="wod" value="<?=$row->wod?>" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Public Holiday:</td>
			<td><input type="text" name="ph" id="ph" value="<?=$row->ph?>" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Claims:</td>
			<td><input type="text" name="claims" id="claims" value="<?=$row->claims?>" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>EPF:</td>
			<td><input type="text" name="epf" id="epf" value="<?=$row->epf?>" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Advance:</td>
			<td><input type="text" name="advance" id="advance" value="<?=$row->advance?>" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Absent Day:</td>
			<td><input type="text" name="abd" id="abd" value="<?=$row->abd?>" style="border:none; text-align:center;"></td>
		</tr>
		</tbody>
	</table>
	<input type="hidden" name="empId" id="empId" value="<?=$row->empId?>">
	<div class="row" style="margin:15px 15px 15px 20%;;width:60%;">	
	   <input type="submit" value="Save Details" name="btn_result" style="width:200px;" class="btn btn-primary line"></button>
	</div>
</form>	
</div>