<div id="listCon" style="width:100%" style="margin-right:1%;">
<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="9" align="center" style="width:100%;background-color:#4caf50;font-weight:bold;">By Locality</td>
	</tr>
	<tr>
		<td align="center" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Row</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Date</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Local</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Foreigner</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">All Purchases</td>
	</tr>
	<?php
	$i=1;
	foreach($locality As $row)
	{
	?>
		<tr>
			<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=$i?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->date?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->locals?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->foreigner?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">	
			<?php
				echo $row->locals + $row->foreigner;
			?>
			</td>
		</tr>	
	<?php
		$i++;
	}
	?>
	<tr>
		<td colspan="2" align="center" style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Total</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$all->locals?></td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$all->foreigner?></td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">
		<?php
			echo $all->locals+$all->foreigner;
		?>
		</td>
	</tr>
</table>
</div>		
