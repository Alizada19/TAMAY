
<div style="width:98%; margin-right:1%; margin-left:1%;">	
	<table class="table table-borderless table-hover">
		<thead class="border-bottom fw-bold">
			<tr>
				<th>No</th>
				<th>DATE</th>
				<th>DESCRIPTION</th>
				<th>CASH IN</th>
				<th>CASH OUT</th>
				<th>BALANCE</th>
				<th>DETAILS</th>
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
				<td><?=date('d-m-Y', strtotime($row->tdate))?></td>
				<td><?=getDesType($row->category)?></td>
				<td>
				<?php
					if(isset($row->type) AND $row->type == 1)
					{
						echo '+ RM '.number_format($row->amount, 2);
					}
						
				?>
				</td>
				<td>
				<?php
					if(isset($row->type) AND $row->type == 2)
					{
						echo '- RM '.number_format($row->amount, 2);
					}
					
				?>
				</td>	
				<td>
					RM <?=number_format($row->balance, 2)?>
				</td>
				<td>
				<?php
				if(isset($row->table) AND $row->table == 'johoni')
				{
				?>
					<a style="test-decoration: none;" title="View Record" href="<?=base_url('codeigniter/public/johoniSalesView/')?><?=$row->pid?>/1" target="_blank">View</a>
				<?php
				}	
				?>
				<?php
				if(isset($row->table) AND $row->table == 'investment')
				{
				?>
					<a style="test-decoration: none;" title="View Record" href="<?=base_url('codeigniter/public/viewFund/')?><?=$row->pid?>/1" target="_blank">View</a>
				<?php
				}	
				?>
				<?php
				if(isset($row->table) AND $row->table == 'expenses')
				{
				?>
					<a style="test-decoration: none;" title="View Record" href="<?=base_url('codeigniter/public/expenses/view/')?><?=$row->pid?>/1" target="_blank">View</a>
				<?php
				}	
				?>
				<?php
				if(isset($row->table) AND $row->table == 'cashdeposit')
				{
				?>
					<a style="test-decoration: none;" title="View Record" href="<?=base_url('codeigniter/public/viewCash/')?><?=$row->pid?>/1" target="_blank">View</a>
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
				
			</tr>
		</tfoot>
	</table>
</div>


