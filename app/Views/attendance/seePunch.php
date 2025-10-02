<!-- Table for displaying the punches -->
<div id="adisplay" style="margin-top:5px;">
<table class="table table-bordered table-hover" style="width:70%;margin-left:15%;margin-right:15%;text-align:center;">
	<thead>
		<tr>
			<td  colspan="9" style="text-align:left;font-weight:bold;">Note: A tolerance of [<?=$tolerance?>] minutes and up to [<?=$aoffday?>] off days are allowed based on the month for this user profile.</td>
		</tr>
		<tr>
			<td  colspan="9" style="text-align:center;font-weight:bold;"><?=getEmp($empId)?></td>
		</tr>
		<tr>
			<th>Date</th> 
			<th>Day</th> 
			<th>Clock In</th>
			<th>Break In</th>
			<th>Break Out</th>
			<th>Clock Out</th>
			<th>lateness</th>
			<th>Overtime</th>
			<th>Reasion</th>
		</tr>
	</thead>
	<tbody>
		<?=$mainStr?>
	</tbody>
</table>

<form id="reportform" action="<?=base_url('codeigniter/public/attendance/printpdf')?>" method="get" target="_blank">		
	<input type="hidden" name="sdate" id="sdate" value="<?=$sdate?>">
	<input type="hidden" name="edate" id="edate" value="<?=$edate?>">
	<input type="hidden" name="location" id="location" value="<?=$location?>">
	<input type="hidden" name="emps" id="emps" value="<?=$emps?>">
	<label style="margin-left:77%;cursor:pointer;" title="User Summary" onclick="showHide('usummary');">User Summary</label>
	<table id="usummary" class="table table-bordered table-hover" style="width:60%;text-align:center;margin-left:20%; margin-right:20%;display:none;">
		<thead>
			<tr>
				<td  colspan="4" style="text-align:center;font-weight:bold;">User Summary</td>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td>Basic Salary:</td>
			<td><input type="text" name="bsalary" id="bsalary" value="<?=$row->bsalary?>" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>OT (HRS):</td>
			<td><input type="text" name="otHours" id="otHours" value="<?=$finalTime?>" style="border:none; text-align:center;"></td>
		</tr>
		
		<tr>
			<td>Worked off day:</td>
			<td><input type="text" name="wod" id="wod" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Public Holiday:</td>
			<td><input type="text" name="ph" id="ph" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Bonus/Claims:</td>
			<td><input type="text" name="claims" id="claims" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>EPF:</td>
			<td><input type="text" name="epf" id="epf" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Advance:</td>
			<td><input type="text" name="advance" id="advance" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Absent Day:</td>
			<td><input type="text" name="abd" id="abd" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>MC:</td>
			<td><input type="text" name="mc" id="mc" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>AL:</td>
			<td><input type="text" name="al" id="al" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Remark:</td>
			<td><input type="text" name="remark" id="remark" style="border:none; text-align:center;"></td>
		</tr>
		</tbody>
	</table>
	<div class="row" style="margin:15px 15px 15px 15%;;width:40%;">	
	   <input type="submit" value="PrintPDF" name="btn_result" style="width:200px;" class="btn btn-primary line"></button>
	</div>
</form>
</div>
<div>

</div>
