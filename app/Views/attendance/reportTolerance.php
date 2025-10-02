<!-- Table for displaying the punches -->
<div style="margin-left:50%; margin-bottom:5px; cursor:pointer;" title="Show/Hide">
	   <h4>
			<span class="toggle-icon glyphicon glyphicon-minus"></span>
	   </h4>
</div>
<div id="adisplay" style="margin-top:5px;">
<table class="table table-bordered table-hover" style="width:70%;margin-left:15%;margin-right:15%;text-align:center;">
	<thead>
		<tr>
			<td  colspan="6" style="text-align:left;font-weight:bold;">Note: A tolerance of [<?=$tolerance?>] minutes and up to [<?=$aoffday?>] off days are allowed based on the month for this user profile.</td>
		</tr>
		<tr>
			<td  colspan="6" style="text-align:center;font-weight:bold;"><?=getEmp($empId)?></td>
		</tr>
		<tr>
			<th>Date</th> 
			<th>Clock In</th>
			<th>Break In</th>
			<th>Break Out</th>
			<th>Clock Out</th>
			<th>OverTime</th>
		</tr>
	</thead>
	<tbody>
		<?=$mainStr?>
	</tbody>
</table>

<form id="reportform" action="<?=base_url('codeigniter/public/attendance/printpdf')?>" method="get" target="_blank">		
<!--	<table class="table table-bordered table-hover" style="width:40%;margin-left:15%;margin-right:15%;text-align:center;">
		<thead>
			<tr>
				<td  colspan="2" style="text-align:center;font-weight:bold;">User Summary</td>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td>Employee Name</td>
			<td><?//=$row->name?></td>
		</tr>
		<tr>
			<td>OT in Hours</td>
			<td><?//=$ot?><?//=$ut?></td>
		</tr>
		<tr>
			<td>off day</td>
			<td><?//=getDay($row->offday)?></td>
		</tr>
		<tr>
			<td>Worked off day</td>
			<td></td>
		</tr>
		<tr>
			<td>PH</td>
			<td><input type="text" name="ph" id="ph" style="border:none; text-align:center;"></td>
		</tr>
		<tr>
			<td>Basic Salary</td>
			<td><?//=$row->bsalary?></td>
		</tr>
		<tr>
			<td>Bonus</td>
			<td></td>
		</tr>
		<tr>
			<td>MC</td>
			<td></td>
		</tr>
		<tr>
			<td>A/L</td>
			<td></td>
		</tr>
		</tbody>
	</table>-->
	<input type="hidden" name="sdate" id="sdate" value="<?=$sdate?>">
	<input type="hidden" name="edate" id="edate" value="<?=$edate?>">
	<input type="hidden" name="location" id="location" value="<?=$location?>">
	<input type="hidden" name="emps" id="emps" value="<?=$emps?>">
	<div class="row" style="margin:15px 15px 15px 15%;;width:40%;">	
	   <input type="submit" value="PrintPDF" name="btn_result" style="width:200px;" class="btn btn-primary line"></button>
	</div>
</form>
</div>
<div>
<?php
if($myRole==1)
{	
?>
<form id="reportform" action="<?=base_url('codeigniter/public/salary/save')?>" method="post" target="_blank">
	<table class="table table-bordered table-hover" style="width:60%;text-align:center;margin-left:20%; margin-right:20%;">
		<thead>
			<tr>
				<td  colspan="4" style="text-align:center;font-weight:bold;">User Details</td>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td>Employee Name</td>
			<td><?=$row->fullName?></td>
		</tr>
		<tr>
			<td>Nationality</td>
			<td><?=$row->nat?></td>
		</tr>
		<tr>
			<td>Bank Name</td>
			<td><?=$row->bname?></td>
		</tr>
		<tr>
			<td>Account Number:</td>
			<td><?=$row->accno?></td>
		</tr>
		<tr>
			<td>Basic Salary:</td>
			<td><?=$row->bsalary?></td>
		</tr>
		<tr>
			<td>OT (HRS):</td>
			<td><input type="text" name="otHours" id="otHours" value="<?=$row->otHours?>" style="border:none; text-align:center;"></td>
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
			<td>Claims:</td>
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
			<td>Remark:</td>
			<td><input type="text" name="remark" id="remark" style="border:none; text-align:center;"></td>
		</tr>
		</tbody>
	</table>
	<!--Save details of salary--> 
	<input type="hidden" name="empId" id="empId" value="<?=$row->Id?>">
	<input type="hidden" name="sdate" id="sdate" value="<?=$sdate?>">
	<input type="hidden" name="nat" id="nat" value="<?=$row->nat?>">
	<input type="hidden" name="bname" id="bname" value="<?=$row->fullName?>">
	<input type="hidden" name="accno" id="accno" value="<?=$row->accno?>">
	<input type="hidden" name="bsalary" id="bsalary" value="<?=$row->bsalary?>">
	<input type="hidden" name="wdays" id="wdays" value="<?=$row->wdays?>">
	<input type="hidden" name="perday" id="perday" value="<?=$row->perday?>">
	<input type="hidden" name="wh" id="wh" value="<?=$row->wh-1?>">
	<input type="hidden" name="perhour" id="perhour" value="<?=$row->perhour?>">
	<input type="hidden" name="location" id="location" value="<?=$row->location?>">
	
	<!-- end of salary details-->
	<div class="row" style="margin:15px 15px 15px 20%;;width:60%;">	
	   <input type="submit" value="Save Details" name="btn_result" style="width:200px;" class="btn btn-primary line"></button>
	</div>
</form>
<?php
}
?>	
</div>
<script>
//Show Hide the display
$(document).ready(function () {
            $("h4").click(function () {
                const icon = $(this).find(".toggle-icon");
                $("#adisplay").slideToggle(); // Toggle content
                icon.toggleClass("glyphicon-minus glyphicon-plus"); // Toggle icons
            });
        });	
</script>