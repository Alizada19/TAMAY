<div id="listCon" style="width:100%" style="margin-right:1%;">
<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="9" align="center" style="width:100%;background-color:#4caf50;font-weight:bold;">Purchases</td>
	</tr>
	<tr>
		<td align="center" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Row</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Date</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Total Visitors</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Total Purchasers</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Conversion Rate</td>
	</tr>
	<?php
	$i=1;
	$tcrate=0;
	if($all->visitors!='' AND $all->visitors!=0)
	{
		$tcrate= round(($all->purchases/$all->visitors)*100, 2);
	}		
	foreach($result As $row)
	{
			$crate=0;
			if($row->visitors!='' AND $row->visitors!=0)
			{
				$crate = round(($row->purchases/$row->visitors)*100, 2);
			}			
	?>
		<tr>
			<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=$i?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->date?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->visitors?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->purchases?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$crate?> %</td>
		</tr>	
	<?php
		$i++;
	}
	?>
	<tr>
		<td colspan="2" align="center" style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Total</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$all->visitors?></td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$all->purchases?></td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$tcrate?> %</td>
	</tr>
</table>
<!--<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
   <form id="reportform" action="<?=base_url('codeigniter/public/cinoutreport/cinout')?>" method="get" target="_blank">
		<input name="sdate" id="sdate" type="hidden" value="$sdate"/>
		<input name="edate" id="sdate" type="hidden" value="$edata"/>
		<input name="type" id="type" type="hidden" value="<?=$type?>"/>
		<input name="shop" id="shop" type="hidden" value="<?=$shop?>"/>
		<input type="submit" value="Export PDF" name="btn_result" style="width:200px;" class="btn btn-primary line"></button>
   </form>
</div>-->
</div>		
