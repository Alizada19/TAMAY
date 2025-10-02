<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
				<tr>
					<td colspan="9" align="center" style="width:100%;background-color:#4caf50;">Cheques</td>
				</tr>
				<tr>
					<td align="center" style="width:5%;background-color:#b3d7ff87;">Row</td>
					<td style="width:10%;background-color:#b3d7ff87;">Due Date</td>
					<td style="width:10%;background-color:#b3d7ff87;">Bank</td>
					<td style="width:7%;background-color:#b3d7ff87;">Cheque No</td>
					<td style="width:10%;background-color:#b3d7ff87;">Amount</td>
					<td style="width:28%;background-color:#b3d7ff87;">Paid to</td>
					<td style="width:13%;background-color:#b3d7ff87;">Remark</td>
					<td style="width:7%;background-color:#b3d7ff87;">Status</td>
					<td style="width:10%;background-color:#b3d7ff87;">Action</td>
				</tr>
			<?php
			$i=1;
			foreach($chequeresult AS $cheque)
			{
			?>
				<tr>
					<td align="center" style="width:5%"><?=$i?></td>
					<td style="width:10%"><?=$cheque->ddate?></td>
					<td style="width:10%"><?=bankName($cheque->bname)?></td>
					<td style="width:7%"><?=$cheque->cno?></td>
					<td style="width:10%">RM <?=number_format($cheque->amount, 2)?></td>
					<td style="width:28%"><?=getdbc($cheque->pto)?></td>
					<td style="width:13%"><?=$cheque->remark?></td>
					<td style="width:7%">
					<?php 
					if($cheque->status == 1)
					{
						echo "Pending";
					}
					else if($cheque->status == 2)
					{
						echo "Paid";
					}
					else if($cheque->status == 3)
					{
						echo "Cancelled";
					}
					?>
					</td>
					<td style="width:10%">
						<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('codeigniter/public/paymentupdatec/')?><?=$cheque->Id?>" target="_blank">Edit</a>
					</td>
				</tr>
				
			<?php
				$i++;
			}
			?>
			<tr>
				<td align="center" colspan="8" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Total</td>
				<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;">RM <?=number_format($chequetotal->totalAmount, 2)?></td>
			</tr>	
			</table>
<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
  <!-- <a style="" title="Print PDF Search" href="<?//=base_url('codeigniter/public/printpdfchequesearch/')?><?//=$sdate?>/<?//=$edate?>/<?//=$status?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>-->
   <form id="reportform" action="<?=base_url('codeigniter/public/printpdfchequesearch')?>" method="get" target="_blank">
		<input name="sdate" id="sdate" type="hidden" value="<?=$sdate?>"/>
		<input name="edate" id="sdate" type="hidden" value="<?=$edate?>"/>
		<input name="status" id="status" type="hidden" value="<?=$status?>"/>
		<input name="cno" id="cno" type="hidden" value="<?=$cno?>"/>
		<input type="submit" value="Export PDF" name="btn_result" style="width:200px;" class="btn btn-primary line"></button>
   </form>
</div>
