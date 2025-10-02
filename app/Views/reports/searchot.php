<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="9" align="center" style="width:100%;background-color:#4caf50;">Creditors</td>
	</tr>
	<tr>
		<td align="center" style="width:5%;background-color:#b3d7ff87;">Row</td>
		<td style="width:10%;background-color:#b3d7ff87;">Invoice Date</td>
		<td style="width:10%;background-color:#b3d7ff87;">Due Date</td>
		<td style="width:10%;background-color:#b3d7ff87;">Invoice No</td>
		<td style="width:10%;background-color:#b3d7ff87;">Amount</td>
		<td style="width:18%;background-color:#b3d7ff87;">Paid to</td>
		<td style="width:10%;background-color:#b3d7ff87;">Remark</td>
		<td style="width:7%;background-color:#b3d7ff87;">Status</td>
		<td style="width:10%;background-color:#b3d7ff87;">Action</td>
	</tr>
<?php
$i=1;
foreach($otresult AS $ocash)
{
		/*$ocstr='';
		if($ocash->oc == 1)
		{
			$ocstr="OT";
		}
		else if($ocash->oc == 2)
		{
			$ocstr="Cash";
		}*/
?>
	<tr>
		<td align="center" style="width:5%"><?=$i?></td>
		<td style="width:10%"><?=$ocash->invDate?></td>
		<td style="width:10%"><?=$ocash->ddate?></td>
		<td style="width:10%"><?=$ocash->invNo?></td>
		<td style="width:10%">RM <?=number_format($ocash->amount, 2)?></td>
		<td style="width:18%"><?=getdbc($ocash->pto)?></td>
		<td style="width:10%"><?=$ocash->remark?></td>
		<td style="width:7%">
		<?php
		if($ocash->status == 1)
		{
			echo "Pending";
		}
		else if($ocash->status == 2)
		{
			echo "Paid";
		}
		else if($ocash->status == 3)
		{
			echo "Cancelled";
		}	
		?>
		</td>
		<td style="width:10%">
			<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('codeigniter/public/paymentupdateoc/')?><?=$ocash->Id?>" target="_blank">Edit</a>
		</td>
	</tr>
<?php
	$i++;
}
?>	
<tr>
	<td align="center" colspan="8" style="font-weight:bold;">Total</td>
	<td style="font-weight:bold;">RM <?=number_format($ottotal->totalAmount, 2)?></td>
</tr>
</table>
<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
   <form id="reportform" action="<?=base_url('codeigniter/public/printpdfotsearch')?>" method="get" target="_blank">
		<input name="sdate" id="sdate" type="hidden" value="<?=$sdate?>"/>
		<input name="edate" id="sdate" type="hidden" value="<?=$edate?>"/>
		<input name="status" id="status" type="hidden" value="<?=$status?>"/>
		<input type="submit" value="Export PDF" name="btn_result" style="width:200px;" class="btn btn-primary line"></button>
   </form>
</div>