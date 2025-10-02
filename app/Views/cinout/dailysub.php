<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="5" style="width:2%;background-color:#b3d7ff87;">
			<select style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="shop" name="shop"  tabindex="107">
				<?=$str?>
			</select>
		  </td>
	</tr>
	<tr>
		<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">No</td>
		<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">Customer In</td>
		<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">Purchase</td>
		<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">Local/Foreigner</td>
		<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">Remark</td>
	</tr>
	<?php
	 $i=1;
	 foreach($res2 AS $row)
	 {	
	?>
	<tr>
		<td width="20%" align="center" style="background-color: #b3d7ff87"><?=$i?></td>
		<td width="20%" align="center" style="background-color: #b3d7ff87"><?=$row->cin?></td>
		<td width="20%" align="center" style="background-color: #b3d7ff87">
				<?php
					if($row->purchase == 1)
					{
						echo "Yes";
					}
					else if($row->purchasenot == 1)
					{
						echo "No";
					}		
				?>
		</td>
		<td width="20%" align="center" style="background-color: #b3d7ff87">
			<?php
				if($row->local == 1)
				{
					echo "Local";
				}
				else if($row->foreigner == 1)
				{
					echo "Foreigner";
				}		
			?>
		</td>
		<td width="20%" align="center" style="background-color: #b3d7ff87"><?=$row->remark?></td>
	</tr>
	<?php
		$i++;
	 }	
	?>
	<tr>
		<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">Toal</td>
		<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;"><?=$total->customers?></td>
		<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;"><?=$total->purchased?></td>
		<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">L:<?=$total->locals?>/F:<?=$total->foreigners?></td>
		<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">% <?=$percentage?></td>
	</tr>
</table>