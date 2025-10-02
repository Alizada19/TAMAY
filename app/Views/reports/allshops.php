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
<body style="margin:0px 0px 0px 0px;">

<div id="container" style="padding:5px 5px 5px 5px;width:100%;">

	<div style="margin:5px 5px 5px 5px;">
		
		<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">Eden Fragrance</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Row</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Shop Name</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Sales</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Card</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Cash</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Net Cash</td>
			</tr>
			
			<?php
			if(isset($edensi->totalSales))
			{	
			?>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">1</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">ESI</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensi->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensi->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensi->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensi->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensi->totalNcash, 2)?></td>
			</tr>
			<?php
			}	
			?>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">2</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">ESW</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensw->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensw->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensw->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensw->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensw->totalNcash, 2)?></td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">3</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-Q</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edenjo->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edenjo->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edenjo->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edenjo->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edenjo->totalNcash, 2)?></td>
			</tr>
			<!--<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">4</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-2</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?//=number_format($edenjo2->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?//=number_format($edenjo2->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?//=number_format($edenjo2->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?//=number_format($edenjo2->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?//=number_format($edenjo2->totalNcash, 2)?></td>
			</tr>-->
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">5</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">E66A</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edena->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edena->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edena->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edena->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edena->totalNcash, 2)?></td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">1</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Johoni Scent JB</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($js->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($js->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($js->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($js->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($js->totalNcash, 2)?></td>
			</tr>
			<tr>
				<td align="center" colspan='2' style="width:10%;background-color:#b3d7ff87;">Total:</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalNcash, 2)?></td>
			</tr>
		</table>
		
		<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">Tamay Business Group</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Row</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Shop Name</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Sales</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Card</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Cash</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Net Cash</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">1</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Gilasco</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamay->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamay->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamay->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamay->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamay->totalNcash, 2)?></td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">2</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Gilasco Chocolate JB</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glsChocolate->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glsChocolate->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glsChocolate->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glsChocolate->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($glsChocolate->totalNcash, 2)?></td>
			</tr>
			<tr>
				<td align="center" colspan='2' style="width:10%;background-color:#b3d7ff87;">Total:</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamayTotal->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamayTotal->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamayTotal->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamayTotal->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamayTotal->totalNcash, 2)?></td>
			</tr>
		</table>
		
		<!--<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">Bergaya</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Row</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Shop Name</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Total Sales</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Card</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Cash</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Net Cash</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">1</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">B&S</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($bergaya->totalSales, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($bergaya->totalCard, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($bergaya->totalCash, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($bergaya->totaleamount, 2)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($bergaya->totalNcash, 2)?></td>
			</tr>
		</table>-->
		
		<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			<tr>
				<td colspan="7" align="center" style="width:100%;background-color:#4caf50;">All Shop Reports</td>
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