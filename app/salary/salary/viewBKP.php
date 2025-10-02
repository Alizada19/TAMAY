<table class="table table-bordered table-hover" style="width:40%;text-align:center;margin-left:30%; margin-right:30%;">
	<thead>
		<tr>
			<td  colspan="4" style="text-align:center;font-weight:bold;">Salary Details</td>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td>Employee Name</td>
		<td><?=$edetails->name?></td>
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
		<td><?=number_format($edetails->bsalary, 2)?></td>
	</tr>
	<tr>
		<td>Days:</td>
		<td><?=$edetails->wdays?></td>
	</tr>
	<tr>
		<td>Per day:</td>
		<td><?=$edetails->perday?></td>
	</tr>
	<tr>
		<td>Hours:</td>
		<td><?=$edetails->wh?></td>
	</tr>
	<tr>
		<td>Per Hour:</td>
		<td><?=$edetails->perhour?></td>
	</tr>
	<tr>
		<td>OT (Hrs):</td>
		<td><?=$rdetails->otHours?></td>
	</tr>
	<tr>
		<td>OT Rate:</td>
		<td><?=$edetails->otRate?></td>
	</tr>
	<tr>
		<td>OT (RM):</td>
		<td><?=number_format($edetails->otRm, 2)?></td>
	</tr>
	<tr>
		<td>Worked off day:</td>
		<td><?=$rdetails->wod?></td>
	</tr>
	<tr>
		<td>Worked off day (RM):</td>
		<td>
			<?php
				if($rdetails->wod)
				{
					echo number_format($rdetails->wod * $edetails->perday, 2);
				}	
			?>
		</td>
	</tr>
	<tr>
		<td>Public Holiday:</td>
		<td><?=$rdetails->ph?></td>
	</tr>
	<tr>
		<td>Public Holiday (RM ):</td>
		<td>
			<?php
				if($rdetails->ph)
				{
					echo number_format($rdetails->ph * $edetails->perday, 2);
				}	
			?>
		</td>
	</tr>
	<tr>
		<td>Claims:</td>
		<td><?=number_format($rdetails->claims, 2)?></td>
	</tr>
	<tr>
		<td>Gross Salary:</td>
		<td>
			<?php
					$gsalary = $rdetails->claims + ($rdetails->ph * $edetails->perday)+ ($rdetails->wod * $edetails->perday) + $edetails->otRm + $edetails->bsalary;
					echo number_format($gsalary, 2); 
			?>
		</td>
	</tr>
	<tr>
		<td>EPF:</td>
		<td><?=$rdetails->epf?></td>
	</tr>
	<tr>
		<td>Advance:</td>
		<td><?=$rdetails->advance?></td>
	</tr> 
	<tr>
		<td>Absent Day:</td>
		<td><?=$rdetails->abd?></td>
	</tr>
	<tr>
		<td>Absent (RM):</td>
		<td><?=$rdetails->abrm?></td>
	</tr>
	<tr>
		<td>Lateness (Hrs):</td>
		<td>
			<?php 
				if($rdetails->otHours < 0)
				{
					echo $rdetails->otHours;
				} 
			?>
		</td>
	</tr>
	<tr>
		<td>Lateness (RM):</td>
		<td>
			<?php  
				if($rdetails->otHours < 0)
				{
					$lateness = abs($rdetails->otHours) * $edetails->perday;
					echo number_format($lateness, 2); 
				} 
			?>
		</td>
	</tr>
	<tr>
		<td>Total Deduction:</td>
		<td>
			<?php 
				if($rdetails->otHours < 0)
				{
					$deduction = $lateness + $rdetails->abrm + $rdetails->advance + $rdetails->epf;
					echo number_format($deduction, 2);
				}
				else
				{
					$deduction = $rdetails->abrm + $rdetails->advance + $rdetails->epf;
					echo number_format($deduction, 2);
				}		
			?>
		</td>
	</tr>
	<tr>
		<td>Net Salary:</td>
		<td>
			<?php 
				$netSalary = $gsalary - $deduction;
				echo number_format($netSalary, 2);	
			?>
		</td>
	</tr>
	</tbody>
</table>
<div class="row" style="margin:15px 15px 15px 30%;;width:40%;">	
   <a title="Edit Record" href="<?=base_url('codeigniter/public/salary/update/')?><?=$rdetails->Id?>"><input type="button" name="btn_result" style="width:200px;" class="btn btn-primary line" value="Update" /></a>
			
   <input type="submit" value="Generate Payslipt" name="btn_result" style="width:200px; margin-left:5px;" class="btn btn-primary line"></button>
</div>
