<div id="tblCon">
	<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
		<tr>
			<td colspan="6" align="center" style="width:100%;background-color:#4caf50;">All Debtors & Creditors</td>
		</tr>
		<tr>
			<td align="center" style="width:5%;background-color:#b3d7ff87;">Row</td>
			<td style="width:47%;background-color:#b3d7ff87;padding-left:5px;">D/C</td>
			<td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Type</td>
			<td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Debit</td>
			<td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Credit</td>
			<td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Balance</td>
		</tr>
	<?php
	$i=1;
	$bal='';
	//echo "<pre />"; print_r($result); exit;
	foreach($result AS $row)
	{
	    if(!empty($row->type))
		{		
		
				
	?>
		<tr class="phover" style=" cursor: pointer;" title='Click To See Details' onclick="window.open('<?=base_url('codeigniter/public/cdbtorsList2/')?><?=$row->dbc?>', '_blank');">
			<td align="center" style="width:5%"><?=$i?></td>
			<td style="width:47%;padding-left:5px;"><?=getdbc($row->dbc)?></td>
			<td style="width:12%;padding-left:5px;"><?=dbcType($row->type)?></td>
			<td style="width:12%;padding-left:5px;">
				<?=number_format(round($row->tamount, 2), 2)?>
			</td>
			<td style="width:12%;padding-left:5px;">
				<?=number_format(round($row->damount, 2), 2)?>
			</td>
			<td style="width:12%;padding-left:5px;">
				<?php
					echo number_format(round($row->tamount - $row->damount, 2), 2);
				?>
			</td>
		</tr>
		
	<?php
		}
		$i++;
	}
	?>
	<tr>
		<td align="center" colspan="3" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Total</td>
		<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;"><?=number_format(round($dbcTotal->td, 2), 2)?></td>
		<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;"><?=number_format(round($dbcTotal->tc, 2), 2)?></td>
		<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;">
		<?php
			echo number_format(round($dbcTotal->td - $dbcTotal->tc, 2), 2);
		?>
		</td>
	</tr>	
	</table>
	<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
		<?php
			if($type=='')
			{
				$type=0;
			}		
		?>
	   <a style="" title="Export PDF" href="<?=base_url('codeigniter/public/printpdfbaltype2')?>/<?=$type?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
	</div>
	<div class="row" style="margin:5px 5px 5px 0px;width:100%;">
	<?//=displayPagination()?>	
	</div>
	
</div>
