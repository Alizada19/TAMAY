<table class="table table-bordered table-hover" style="width:40%;text-align:center;margin-left:30%; margin-right:30%;">
	<thead>
		<tr>
			<td  colspan="4" style="text-align:center;font-weight:bold;">Salary Details</td>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td>Employee Name</td>
		<td><?=getEmp($rdetails->empId)?></td>
	</tr>
	<tr>
		<td>Nationality</td>
		<td><?=getNat2($rdetails->nat)?></td>
	</tr>
	<tr>
		<td>Bank Name</td>
		<td><?=getbname($rdetails->bname)?></td>
	</tr>
	<tr>
		<td>Account Number:</td>
		<td><?=$rdetails->accno?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Basic Salary:</td>
		<td><?='RM '.number_format($rdetails->bsalary, 2)?></td>
	</tr>
	<tr>
		<td>Days:</td>
		<td><?=$rdetails->wdays?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Per day:</td>
		<td><?='RM '.number_format($rdetails->perday, 2)?></td>
	</tr>
	<tr>
		<td>Hours:</td>
		<td><?=$rdetails->wh?></td>
	</tr>
	
	<tr style="background-color: #E6F5E6;">
		<td>Per Hour:</td>
		<td><?='RM '.number_format($rdetails->perhour, 2)?></td>
	</tr>
	<tr>
		<td>OT (Hrs):</td>
		<td><?=$rdetails->otHours?></td>
	</tr>
	<tr>
		<td>OT Rate:</td>
		<td><?=$rdetails->otRate?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>OT (RM):</td>
		<td><?='RM '.number_format($rdetails->otRm, 2)?></td>
	</tr>
	<tr>
		<td>Worked off day:</td>
		<td><?=$rdetails->wod?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Worked off day (RM):</td>
		<td><?='RM '.number_format($rdetails->wodRm, 2)?></td>
	</tr>
	<tr>
		<td>Public Holiday:</td>
		<td><?=$rdetails->ph?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Public Holiday (RM ):</td>
		<td><?='RM '.number_format($rdetails->phRm, 2)?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Claims:</td>
		<td><?='RM '.number_format($rdetails->claims, 2)?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Gross Salary:</td>
		<td><?='RM '.number_format($rdetails->gSalary, 2)?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>EPF:</td>
		<td><?='RM '.number_format($rdetails->epf, 2)?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Advance:</td>
		<td><?='RM '.number_format($rdetails->advance, 2)?></td>
	</tr> 
	<tr>
		<td>Absent Day:</td>
		<td><?=$rdetails->abd?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Absent (RM):</td>
		<td><?='RM '.number_format($rdetails->abdRm, 2)?></td>
	</tr>
	<tr>
		<td>Lateness (Hrs):</td>
		<td><?=$rdetails->lathrs?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Lateness (RM):</td>
		<td><?=$rdetails->lateness?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Total Deduction:</td>
		<td><?='RM '.number_format($rdetails->deduction, 2)?></td>
	</tr>
	<tr style="background-color: #E6F5E6;">
		<td>Net Salary:</td>
		<td><?='RM '.number_format($rdetails->netSalary, 2)?></td>
	</tr>
	</tbody>
</table>
<div class="row" style="margin:15px 15px 15px 30%;;width:40%;">	
   <a title="Edit Record" href="<?=base_url('codeigniter/public/salary/update/')?><?=$rdetails->Id?>"><input type="button" name="btn_result" style="width:200px;" class="btn btn-primary line" value="Update" /></a>
			
   <a title="Edit Record" href="<?=base_url('codeigniter/public/salary/generatePayslipt/')?><?=$rdetails->Id?>"><input type="button" name="btn_result" style="width:200px;margin-left:5px;" class="btn btn-primary line" value="Generate Payslipt" /></a>
   </button>
</div>
