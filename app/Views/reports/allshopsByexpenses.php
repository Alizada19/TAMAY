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
				<td colspan="3" align="center" style="width:100%;background-color:#4caf50;">
				From <?=date_format(date_create($sdate), 'd/m/Y')?> To <?=date_format(date_create($edate), 'd/m/Y')?>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="center" style="width:100%;background-color:#4caf50;">ESI</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Shope Name</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses Type</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Amount</td>
				
			</tr>
			
			<?php
			if(isset($resultEsi->tsub1) AND $resultEsi->tsub1!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESI</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Target</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsi->tsub1, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsi->tsub2) AND $resultEsi->tsub2!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESI</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Commission</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsi->tsub2, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsi->tsub3) AND $resultEsi->tsub3!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESI</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Promoter</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsi->tsub3, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsi->tsub4) AND $resultEsi->tsub4!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESI</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Transport</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsi->tsub4, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsi->tsub5) AND $resultEsi->tsub5!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESI</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Voucher</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsi->tsub5, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsi->tsub6) AND $resultEsi->tsub6!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESI</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Advance</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsi->tsub6, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsi->tsub7) AND $resultEsi->tsub7!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESI</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Utility</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsi->tsub7, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsi->tsub8) AND $resultEsi->tsub8!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESI</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Other</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsi->tsub8, 2)?></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="2" align="center" style="width:90%;background-color:#b3d7ff87;">Total </td>
				<td colspan="1" align="center" style="width:10%;background-color:#b3d7ff87;"><?=round($sesi->totaleamount, 2)?></td>
			</tr>
			
			<tr>
				<td colspan="3" align="center" style="width:100%;background-color:#4caf50;">ESW</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Shope Name</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses Type</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Amount</td>
				
			</tr>
			
			<?php
			if(isset($resultEsw->tsub1) AND $resultEsw->tsub1!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESW</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Target</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsw->tsub1, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsw->tsub2) AND $resultEsw->tsub2!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESW</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Commission</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsw->tsub2, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsw->tsub3) AND $resultEsw->tsub3!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESW</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Promoter</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsw->tsub3, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsw->tsub4) AND $resultEsw->tsub4!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESW</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Transport</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsw->tsub4, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsw->tsub5) AND $resultEsw->tsub5!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESW</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Voucher</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsw->tsub5, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsw->tsub6) AND $resultEsw->tsub6!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESW</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Advance</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsw->tsub6, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsw->tsub7) AND $resultEsw->tsub7!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESW</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Utility</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsw->tsub7, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($resultEsw->tsub8) AND $resultEsw->tsub8!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ESW</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Other</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($resultEsw->tsub8, 2)?></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="2" align="center" style="width:90%;background-color:#b3d7ff87;">Total </td>
				<td colspan="1" align="center" style="width:10%;background-color:#b3d7ff87;"><?=round($sesw->totaleamount, 2)?></td>
			</tr>
			<tr>
				<td colspan="3" align="center" style="width:100%;background-color:#4caf50;">JOHONI-Q</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Shope Name</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses Type</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Amount</td>
				
			</tr>
			<?php
			if(isset($johoniq->tsub1) AND $johoniq->tsub1!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-Q</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Target</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($johoniq->tsub1, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($johoniq->tsub2) AND $johoniq->tsub2!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-Q</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Commission</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($johoniq->tsub2, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($johoniq->tsub3) AND $johoniq->tsub3!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-Q</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Promoter</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($johoniq->tsub3, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($johoniq->tsub4) AND $johoniq->tsub4!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-Q</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Transport</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($johoniq->tsub4, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($johoniq->tsub5) AND $johoniq->tsub5!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-Q</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Voucher</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($johoniq->tsub5, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($johoniq->tsub6) AND $johoniq->tsub6!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-Q</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Advance</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($johoniq->tsub6, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($johoniq->tsub7) AND $johoniq->tsub7!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-Q</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Utility</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($johoniq->tsub7, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($johoniq->tsub8) AND $johoniq->tsub8!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-Q</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Other</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($johoniq->tsub8, 2)?></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="2" align="center" style="width:90%;background-color:#b3d7ff87;">Total </td>
				<td colspan="1" align="center" style="width:10%;background-color:#b3d7ff87;"><?=round($sjohoni->totaleamount, 2)?></td>
			</tr>
			
			<tr>
				<td colspan="3" align="center" style="width:100%;background-color:#4caf50;">E66A</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Shope Name</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses Type</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Amount</td>
				
			</tr>
			<?php
			if(isset($r66a->tsub1) AND $r66a->tsub1!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">E66A</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Target</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($r66a->tsub1, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($r66a->tsub2) AND $r66a->tsub2!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">E66A</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Commission</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($r66a->tsub2, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($r66a->tsub3) AND $r66a->tsub3!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">E66A</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Promoter</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($r66a->tsub3, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($r66a->tsub4) AND $r66a->tsub4!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">E66A</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Transport</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($r66a->tsub4, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($r66a->tsub5) AND $r66a->tsub5!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">E66A</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Voucher</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($r66a->tsub5, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($r66a->tsub6) AND $r66a->tsub6!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">E66A</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Advance</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($r66a->tsub6, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($r66a->tsub7) AND $r66a->tsub7!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">E66A</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Utility</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($r66a->tsub7, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($r66a->tsub8) AND $r66a->tsub8!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">E66A</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Other</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($r66a->tsub8, 2)?></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="2" align="center" style="width:90%;background-color:#b3d7ff87;">Total </td>
				<td colspan="1" align="center" style="width:10%;background-color:#b3d7ff87;"><?=round($s66a->totaleamount, 2)?></td>
			</tr>
			
			<tr>
				<td colspan="3" align="center" style="width:100%;background-color:#4caf50;">GILASCO</td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Shope Name</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Expenses Type</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">Amount</td>
				
			</tr>
			<?php
			if(isset($glc->tsub1) AND $glc->tsub1!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">GILASCO</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Target</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($glc->tsub1, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($glc->tsub2) AND $glc->tsub2!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">GILASCO</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Commission</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($glc->tsub2, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($glc->tsub3) AND $glc->tsub3!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">GILASCO</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Promoter</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($glc->tsub3, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($glc->tsub4) AND $glc->tsub4!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">GILASCO</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Transport</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($glc->tsub4, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($glc->tsub5) AND $glc->tsub5!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">GILASCO</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Voucher</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($glc->tsub5, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($glc->tsub6) AND $glc->tsub6!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">GILASCO</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Advance</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($glc->tsub6, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($glc->tsub7) AND $glc->tsub7!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">GILASCO</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Utility</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($glc->tsub7, 2)?></td>
				</tr>
			<?php
			}
			?>
			<?php
			if(isset($glc->tsub8) AND $glc->tsub8!=0)
			{		
			?>	
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">GILASCO</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Other</td>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=round($glc->tsub8, 2)?></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="2" align="center" style="width:90%;background-color:#b3d7ff87;">Total </td>
				<td colspan="1" align="center" style="width:10%;background-color:#b3d7ff87;"><?=round($sglc->totaleamount, 2)?></td>
			</tr>
		</table>
		<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
		   <a style="" title="Update Current Record" href="<?=base_url('codeigniter/public/printpdfsreport/')?><?=$sdate?>/<?=$edate?>/<?=$loc?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
		</div>
	</div>
</div>	
</body>
</html>