<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="11" align="center" style="width:100%;background-color:#4caf50;">All Payments</td>
	</tr>
	<tr>
		<td align="center" style="width:5%;background-color:#b3d7ff87;">Row</td>
		<td style="width:5%;background-color:#b3d7ff87;">Invoice No</td>
		<td style="width:10%;background-color:#b3d7ff87;">Invoice Date</td>
		<td style="width:10%;background-color:#b3d7ff87;">Due Date</td>
		<td style="width:6%;background-color:#b3d7ff87;">Cheque No</td>
		<td style="width:10%;background-color:#b3d7ff87;">Amount</td>
		<td style="width:5%;background-color:#b3d7ff87;">Bank Name</td>
		<td style="width:19%;background-color:#b3d7ff87;">Paid to</td>
		<td style="width:5%;background-color:#b3d7ff87;">Status</td>
		<td style="width:15%;background-color:#b3d7ff87;">Remark</td>
		<td style="width:10%;background-color:#b3d7ff87;">Action</td>
	</tr>
<?php
$i=1;
foreach($allresult AS $result)
{
?>
	<tr>
		<td align="center" style="width:5%"><?=$i?></td>
		<td style="width:5%"><?=$result->invNo?></td>
		<td style="width:10%"><?=$result->invDate?></td>
		<td style="width:10%"><?=$result->ddate?></td>
		<td style="width:6%"><?=$result->cno?></td>
		<td style="width:10%">RM<?=number_format($result->amount, 2)?></td>
		<td style="width:5%"><?=bankName($result->bname)?></td>
		<td style="width:19%"><?=getdbc($result->pto)?></td>
		<td style="width:5%">
		<?php 
			if($result->status==1)
			{
				echo "Pending";
			}
			else if($result->status==2)
			{
				echo "Paid";
			}
			else if($result->status==3)
			{
				echo "Cancelled";
			}
			else if($result->status==4)
			{
				echo "Uncheduled";
			}
			else if($result->status==10)
			{
				echo "Not Issued";
			}
			$ctrl='';
			if($result->ptype==1)
			{
				$ctrl="paymentViewc/".$result->Id.'/2';
			}
			else if($result->ptype==2)
			{
				$ctrl="paymentViewoc/".$result->Id.'/2';
			}	
			?>
		
		</td>
		<td style="width:15%"><?=$result->remark?></td>
		<td style="width:10%">
			<a style="test-decoration: none;" title="View Record" href="<?=base_url('codeigniter/public/').$ctrl?>" target="_blank">View</a>
		</td>
	</tr>
	
<?php
	$i++;
}
?>
<tr>
	<td align="center" colspan="10" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Total</td>
	<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;">RM <?=number_format($alltotal->totalAmount, 2)?></td>
</tr>	
</table>
<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
  <form id="filter1" method="get" action="<?=base_url('codeigniter/public/printpdfAllSearchBydate')?>" target="_blank">	
		<input type="hidden" name="sdate" value="<?=$sdate?>">	
		<input type="hidden" name="edate" value="<?=$edate?>">	
		<input type="hidden" name="status" value="<?=$status?>">	 
		<input type="hidden" name="nsdate" value="<?=$nsdate?>">	 
		<input type="hidden" name="nedate" value="<?=$nedate?>">	 
		<input type="hidden" name="invNo" value="<?=$invNo?>">	 
		<input type="hidden" name="creditor" value="<?=$creditor?>">	 
		<input type="hidden" name="cno" value="<?=$cno?>">	 
		<input type="hidden" name="type" value="<?=$type?>">	 
	    <button type="submit"  class="btn btn-info">Export PDF</button>
   </form>
</div>