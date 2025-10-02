<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>Nightly Sales Report For All Shops</title>
    <link href="<?=base_url('codeigniter/public/')?>css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="<?=base_url('codeigniter/public/')?>js/jq.js"></script>
	<style type="text/css">

	table, th, td {
	  border: 1px solid blue;
	}
	</style>
</head>
<body style="margin:0px 0px 0px 0px;font-family:'Sans-serif'">

<div id="container" style="padding:5px 5px 5px 5px;width:100%;">

	<div style="margin:5px 5px 5px 5px;">
		
		<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">Eden Fragrance</td>
			</tr>
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">ESI</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Row</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Date</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Sales</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Card</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Cash</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Net Cash</td>
			</tr>
			<?php
			$i=1;
			foreach($resultEsi AS $esi)
			{
			?>
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=$i?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=date_format(date_create($esi->sdate), 'd/m/Y')?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($esi->totalSales, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($esi->totalCard, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($esi->totalCash, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($esi->totaleamount, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($esi->totalNcash, 2)?></td>
				</tr>
			<?php
				$i++;
			}
			?>
			<tr style="">
				<td align="center" colspan='2' style="width:10%;background-color:#b3d7ff87;">Total:</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sesi->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sesi->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sesi->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sesi->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sesi->totalNcash, 2)?></td>
			</tr>
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">ESW</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Row</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Date</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Sales</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Card</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Cash</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Net Cash</td>
			</tr>
			<?php
			$i=1;
			foreach($resultEsw AS $esw)
			{
			?>
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=$i?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=date_format(date_create($esw->sdate), 'd/m/Y')?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($esw->totalSales, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($esw->totalCard, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($esw->totalCash, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($esw->totaleamount, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($esw->totalNcash, 2)?></td>
				</tr>
			<?php
				$i++;
			}
			?>
			<tr style="">
				<td align="center" colspan='2' style="width:10%;background-color:#b3d7ff87;">Total:</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sesw->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sesw->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sesw->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sesw->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sesw->totalNcash, 2)?></td>
			</tr>
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">JOHINI-Q</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Row</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Date</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Sales</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Card</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Cash</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Net Cash</td>
			</tr>
			<?php
			$i=1;
			foreach($resultJohoniq AS $jq)
			{
			?>
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=$i?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=date_format(date_create($jq->sdate), 'd/m/Y')?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($jq->totalSales, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($jq->totalCard, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($jq->totalCash, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($jq->totaleamount, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($jq->totalNcash, 2)?></td>
				</tr>
			<?php
				$i++;
			}
			?>
			<tr style="">
				<td align="center" colspan='2' style="width:10%;background-color:#b3d7ff87;">Total:</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sjohoniq->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sjohoniq->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sjohoniq->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sjohoniq->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($sjohoniq->totalNcash, 2)?></td>
			</tr>
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">E66A</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Row</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Date</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Sales</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Card</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Cash</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Net Cash</td>
			</tr>
			<?php
			$i=1;
			foreach($resultE66a AS $e66a)
			{
			?>
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=$i?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=date_format(date_create($e66a->sdate), 'd/m/Y')?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($e66a->totalSales, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($e66a->totalCard, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($e66a->totalCash, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($e66a->totaleamount, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($e66a->totalNcash, 2)?></td>
				</tr>
			<?php
				$i++;
			}
			?>
			<tr style="">
				<td align="center" colspan='2' style="width:10%;background-color:#b3d7ff87;">Total:</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($se66a->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($se66a->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($se66a->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($se66a->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($se66a->totalNcash, 2)?></td>
			</tr>
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#59b5f7;">TOTAL OF EDEN FRAGRANCE SHOPS</td>
			</tr>
			<tr style="">
				<td align="center" colspan='2' style="width:10%;background-color:#b3d7ff87;">Total:</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalNcash, 2)?></td>
			</tr>
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">GILASCO</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Row</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Date</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Sales</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Card</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Cash</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Net Cash</td>
			</tr>
			<?php
			$i=1;
			foreach($resultGlc AS $glc)
			{
			?>
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=$i?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;"><?=date_format(date_create($glc->sdate), 'd/m/Y')?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glc->totalSales, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glc->totalCard, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glc->totalCash, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glc->totaleamount, 2)?></td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glc->totalNcash, 2)?></td>
				</tr>
			<?php
				$i++;
			}
			?>
			<tr style="">
				<td align="center" colspan='2' style="width:10%;background-color:#b3d7ff87;">Total:</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glcsum->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glcsum->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glcsum->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glcsum->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glcsum->totalNcash, 2)?></td>
			</tr>
		</table>
	
		
		<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">All Shops</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Sales</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Card</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Cash</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Expenses</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Net Cash</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($allshops->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($allshops->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($allshops->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($allshops->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?php $all = $allshops->totalCash - $allshops->totaleamount; echo number_format($all)?></td>
			</tr>
		</table>
		<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
		   <a style="" title="Update Current Record" href="<?=base_url('codeigniter/public/printpdfsreport/')?><?=$sdate?>/<?=$edate?>/<?=$loc?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
		</div>
	</div>
</div>	
</body>
</html>