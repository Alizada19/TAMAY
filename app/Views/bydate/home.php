
<div id="tblCon">
	<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
		<tr>
			<td colspan="9" align="center" style="width:100%;background-color:#4caf50;">Payment</td>
		</tr>
		<tr>
			<td align="center" style="width:10%;background-color:#b3d7ff87;">Row</td>
			<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Day</td>
			<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Due Date</td>
			<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Amount</td>
		</tr>
	<?php
	$i=1;
	//define start date
	$cdate = date_format(date_create($sdate), 'Y-m-d');	
	foreach($allresult AS $result)
	{
		$bgc='';
			//missing dates
			if($result->ddate>$cdate)
			{	
				
				for($j=$cdate; $j<$result->ddate; $j++)
				{	
					?>
						<tr class="phover" style="<?=$bgc?>; cursor: pointer;" >
							<td align="center" style="width:10%"><?=$i?></td>
							<td style="width:10%;padding:0px 5px 0px 5px;"><?=date('l', strtotime($j))?></td>
							<td style="width:10%;padding:0px 5px 0px 5px;"><?=date_format(date_create($j), 'd/m/Y')?></td>
							
							<td style="width:10%;padding:0px 5px 0px 5px;">RM 0</td>
						</tr>
					<?php
					$i++;		
				}		
			}		
	?>
		<tr class="phover" style="<?=$bgc?>; cursor: pointer;" title='Click To See Details' onclick="window.open('<?=base_url('codeigniter/public/byonedaylist/')?><?=$result->ddate?>', '_blank');">
			<td align="center" style="width:10%"><?=$i?></td>
			<td style="width:10%;padding:0px 5px 0px 5px;"><?=date('l', strtotime($result->ddate))?></td>
			<td style="width:10%;padding:0px 5px 0px 5px;"><?=date_format(date_create($result->ddate), 'd/m/Y')?></td>
			
			<td style="width:10%;padding:0px 5px 0px 5px;">RM <?=number_format($result->totalAmount, 2)?></td>
		</tr>
		
	<?php
		$i++;
		
		//Plus one the date
		$cdate = date("Y-m-d", strtotime($result->ddate. "+1 days"));
	}
	?>
	<tr style="background-color: #b3d7ff87;">
		<td colspan="3" style="width:10%;font-weight:bold;padding:0px 5px 0px 5px;">Total Amount</td>
		<td style="width:10%;font-weight:bold;padding:0px 5px 0px 5px;">RM <?=number_format($total->totalAmount, 2)?></td>
	</tr>	
	</table>
	<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
	   <a style="" title="Export PDF" href="<?=base_url('codeigniter/public/printpdfbydates/')?><?=$sdate?>/<?=$edate?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
	</div>
</div>
		