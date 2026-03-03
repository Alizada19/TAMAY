
<div style="width:98%; margin-right:1%; margin-left:1%;">	
	<table class="table table-borderless table-hover">
		<thead class="border-bottom fw-bold">
			<tr>
				<th>No</th>
				<th>DATE</th>
				<th>DESCRIPTION</th>
				<th>NET CASH IN</th>
				<th>NET CASH OUT</th>
				<th>ACTION</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$i=1;
		foreach($records AS $row)
		{
		?>
			<tr class="border-bottom">
				<td><?=$i?></td>
				<td><?=date('d-m-Y', strtotime($row->sdate))?></td>
				<td><?=$row->description?></td>
				<td>
				<?php
					if(isset($row->netcash))
					{
						echo '+ RM '.number_format($row->netcash, 2);
					}
					
				?>
				</td>
				<td>
				<?php
					if(isset($row->amount))
					{
						echo '- RM '.number_format($row->amount, 2);
					}
					
				?>
				</td>	
				<td>
				<?php
				if(isset($row->netcash))
				{
				?>
					<a style="test-decoration: none;" title="View Record" href="<?=base_url('johoniSalesView/')?><?=$row->Id?>/1" target="_blank">Details</a>
				<?php
				}	
				?>
				<?php
				if(isset($row->amount))
				{
				?> 
					<a style="test-decoration:none;" title="View Record" href="<?=base_url('viewCash/')?><?=$row->Id?>/1" target="_blank">Details</a>
				<?php
				}	
				?>
				</td>
			</tr>
		<?php
			$i++;
		}
		?>		
		</tbody>
		<tfoot style="font-weight:700 !important;">
			<tr>
				<td colspan="3" >Total:</td>
				<td colspan="1" >+ RM <?=number_format($totals->tnetcash, 2)?></td>
				<td colspan="1" >- RM <?=number_format($totals->tamount, 2)?></td>
			</tr>
			<tr>
				<td colspan="4" >Deduction:</td>
				<td colspan="1" >- RM <?=number_format($totals->tdeduction, 2)?></td>
				<?php
				   $balance = $totals->tnetcash - ($totals->tamount + $totals->tdeduction);
				?>
				<td colspan="1" >Balance: RM <?=number_format($balance, 2)?></td>
			</tr>
		</tfoot>
	</table>
</div>


