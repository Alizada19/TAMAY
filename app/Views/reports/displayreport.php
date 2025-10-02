<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="7" align="center" style="width:100%;background-color:#b3d7ff87;"><?=bname($sname)?></td>
	</tr>
	
	<tr>
		<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Sales</td>
		<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Card</td>
		<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Cash</td>
		<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Expenses</td>
		<td align="center" style="width:10%;background-color:#b3d7ff87;">Net Cash</td>
	</tr>
	<tr>
		<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($result->totalSales, 2)?></td>
		<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($result->totalCard, 2)?></td>
		<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($result->totalCash, 2)?></td>
		<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($result->totaleamount, 2)?></td>
		<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?php echo number_format($result->totalCash - $result->totaleamount, 2)?></td>
	</tr>
</table>
<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
   <a style="" title="Update Current Record" href="<?=base_url('codeigniter/public/printpdfsreport/')?><?=$sdate?>/<?=$edate?>/<?=$sname?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
</div>