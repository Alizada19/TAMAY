<table class="table table-striped" style=" background-color: #fff;font-family:'Sans-serif;'; margin-top:0px;">		
	<tr style="font-weight:bold; background: linear-gradient(135deg, #1f2837, #4a5568); color:rgb(255, 255, 255)">
	  <td>Row</td>
	  <td>Category</td>
	  <td>Amount</td>
	  <td>Ratio</td>
	  <td>View</td>
	</tr>

	<?php
	$i=1;
	foreach($result AS $row)
	{
	?>		
		<tr>
		  <td><?=$i?></td>
		  <td><?=cname($row->category)?></td>
		  <td>RM <?=number_format($row->amount,2)?></td>
		  <td>
		  <?php
			if($sum>0)
			{
				echo round($row->amount/$sum *100, 1).' %';
			}		
		  ?>
		  </td>
		    <td title="Click for more details">
				<a href="<?=base_url('codeigniter/public/expenses/categorybased')?>/<?=$row->category?>" target="_blank" style="text-decoration:none;">
					<img src="<?=base_url('codeigniter/public/')?>images/view.png" alt="View" style="width: 20px; height: 20px;">
				</a>	 
		    </td>
		</tr>
	<?php
		$i++;
	}
	?>	
	  <tr style="font-weight:bold;">
		 <td colspan="2">Totlal:</td>	
		 <td colspan="3">RM <?=number_format($sum, 2)?></td>	
	  </tr>	
</table>