<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>D/C Details</title>
    <link href="<?=base_url('codeigniter/public/')?>css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url('codeigniter/public/')?>css/temp/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?=base_url('codeigniter/public/')?>css/w3school.css">
	<script type="text/javascript" src="<?=base_url('codeigniter/public/')?>js/jq.js"></script>
	<style type="text/css">

	table, th, td {
	  border: 1px solid blue;
	}
	</style>
</head>
<body style="margin:0px 0px 0px 0px;font-family:'Sans-serif'">
<?php $this->session = \Config\Services::session();?>
<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  
  <a href="<?=base_url('codeigniter/public/').'cdbtorsAdd'?>" target="_blank" class="w3-bar-item w3-button">Add Invoice</a>
  <a href="<?=base_url('codeigniter/public/').'cdbtorsAddPay'?>" target="_blank" class="w3-bar-item w3-button">Payment Invoice</a>
</div>
<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  <a href="<?=base_url('codeigniter/public/').'payment'?>" class="w3-bar-item w3-button">Add Payments</a>
  <a href="<?=base_url('codeigniter/public/').'debtorcreditor/2'?>" class="w3-bar-item w3-button">Add Debtors/Creditors</a>
</div>

<div id="main">

<div class="w3-teal">
  <div class="w3-container">
    <div style=" ">
		<div style="display:inline-block; margin-top:0px; font-size:20px;">
		<h6>Username:  <?php $this->session = \Config\Services::session(); echo $this->session->get('name');?></h6>
		</div>
		<div style="display:inline-block; margin-top:0px; font-size:20px; float:right;">
			<h6><a href="<?=base_url('/login')?>" title="Logout" style="text-decoration:none;color: inherit;">Logout</a></h6>
		</div>
		
	</div>
	
  </div>
</div>
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
	<div style="margin:5px 5px 5px 5px;">
		<div style="display:inline-block;float:left;width:40%;">
			<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
			<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
		</div>
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Bergaya</h4>
			<h4>Balance Sheet</h4>
			
			
		</div>
		<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
			<h5>Today: <?=date('d/m/Y')?></h5>
			
		</div>
	</div>
	<div style="margin:5px 5px 5px 5px;">
		<div id="tblCon">
			<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
				<tr>
					<td colspan="9" align="center" style="width:100%;background-color:#ADFF2F;font-weight:bold;">CREDITOR: <?=getdbc($dbc)?></td>
				</tr>
				<tr>
					<td colspan="8" align="center" style="width:100%;background-color:#F0E68C;font-weight:bold;">SOA AS AT  <?=date('d/m/Y')?></td>
				</tr>
				<tr>
					<td align="center" style="width:5%;background-color:#b3d7ff87;">Row</td>
					<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Date</td>
					<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Invoice No</td>
					<td style="width:26%;background-color:#b3d7ff87;padding-left:5px;">Reference</td>
					<td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Debit</td>
					<td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Credit</td>
					<td style="width:13%;background-color:#b3d7ff87;padding-left:5px;">Balance</td>
					<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;">Action</td>
				</tr>
			<?php
			$i=1;
			$bal='';
			//echo "<pre />"; print_r($result); exit;
			foreach($result AS $row)
			{
				
				$debit='';
				$credit='';
				$addorpay='';
				$vaddorpay='';
				if($row->paid==1)
				{
					$debit = $row->damount;
					$bal=floatval($bal)+floatval($debit);
					$addorpay="cdbtorsEdit";
					$vaddorpay="cdbtorsView";
				}
				else if($row->paid==2)
				{
					$credit = $row->camount;
					$bal=floatval($bal)-floatval($credit);
					$addorpay="cdbtorsEditPay";
					$vaddorpay="cdbtorsViewPay";
				}
						
			?>
				<tr>
					<td align="center" style="width:5%"><?=$i?></td>
					<td style="width:10%;padding-left:5px;"><?=date_format(date_create($row->ddate), 'd/m/Y')?></td>
					<td style="width:10%;padding-left:5px;"><?=$row->dinvNo?></td>
					<td style="width:13%;padding-left:5px;"><?=$row->ddescrip?></td>
					<td style="width:12%;padding-left:5px;">
						<?php 
							if($debit)
							{	
								echo 'RM '.number_format(round($debit, 2), 2);
							}
						?>
					</td>
					<td style="width:12%;padding-left:5px;">
						<?php 
							if($credit)
							{	
								echo 'RM '.number_format(round($credit, 2), 2);
							}
						?>
					</td>
					<td style="width:13%;padding-left:5px;">
						<?php 
							if($bal)
							{	
								echo 'RM '.number_format(round($bal, 2), 2);
							}
						?>
					</td>
				<td style="width:7%;padding-left:5px;">
					<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('codeigniter/public/')?><?=$vaddorpay?>/<?=$row->Id?>/2" target="_blank">View</a>
					<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('codeigniter/public/')?><?=$addorpay?>/<?=$row->Id?>" target="_blank">Edit</a>
				</td>
				</tr>
				
			<?php
				$i++;
			}
			?>
			<tr>
				<td align="center" colspan="4" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Total</td>
				<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;"><?='RM '.number_format(round($total->damount, 2), 2)?></td>
				<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;"><?='RM '.number_format(round($total->camount, 2), 2)?></td>
				<td colspan="5%" style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;">
				<?php
					echo 'RM '.number_format(round($total->damount, 2)-round($total->camount, 2),2);
				?>
				</td>
			</tr>	
			</table>
			<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;cursor:pointer;" title="Pendings">
				<tr onclick="showHideAllpending();">
					<td align="center" style="width:100%;background-color:#F0E68C ;font-weight:bold;">Pendings</td>
				</tr>
			</table>
			<div id="allPendings" style="display:none;">
				<?php
				if($pdc)
				{	
				?>	
					<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
						<tr>
							<td colspan="8" align="center" style="width:100%;background-color:#F0E68C;font-weight:bold;">POST DATED CHEQUES ISSUED</td>
						</tr>
						<tr>
							<td align="center" style="width:5%;background-color:#b3d7ff87;">ROW</td>
							<td style="width:9%;background-color:#b3d7ff87;padding-left:5px;">Due Date</td>
							<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;">Cheque No</td>
							<td style="width:9%;background-color:#b3d7ff87;padding-left:5px;">Invoice No</td>
							<td style="width:33%;background-color:#b3d7ff87;padding-left:5px;">D/C</td>
							<td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Amount</td>
							<td style="width:24%;background-color:#b3d7ff87;padding-left:5px;">Remark</td>
							
						</tr>
						<?php
						$i=1;	
						foreach($pdc AS $row)
						{
						?>	
							<tr>
								<td align="center" style="width:5%;"><?=$i?></td>
								<td style="width:9%;padding-left:5px;"><?=$row->ddate?></td>
								<td style="width:8%;padding-left:5px;"><?=$row->cno?></td>
								<td style="width:9%;padding-left:5px;"><?=$row->invNo?></td>
								<td style="width:33%;padding-left:5px;"><?=getdbc($row->pto)?></td>
								<td style="width:12%;padding-left:5px;"><?=number_format($row->amount, 2)?></td>
								<td style="width:24%;padding-left:5px;"><?=$row->remark?></td>
							</tr>
						<?php
							$i++;
						}
						?>	
						<tr>
							<td align="center" colspan='5' style="font-weight:bold;padding-left:5px;">Total</td>
							<td style="font-weight:bold;padding-left:5px;"><?=number_format($pdcTotal->tamount, 2)?></td>
						</tr>
						</table>
					<?php
					}
					else
					{
						echo "No Pending Cheques Yet!".'<br>';
					}
					?>	
				
				<?php
				if($onaResult)
				{	
				?>	
					<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
						<tr>
							<td colspan="7" align="center" style="width:100%;background-color:#90EE90;font-weight:bold;">PENDING ON ACCOUNTS</td>
						</tr>
						<tr>
							<td align="center" style="width:5%;background-color:#b3d7ff87;">ROW</td>
							<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Invoice No</td>
							<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Invoice Date</td>
							<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Due Date</td>
							<td style="width:45%;background-color:#b3d7ff87;padding-left:5px;">D/C</td>
							<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Amount</td>
							<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Remark</td>
							
						</tr>
						<?php
						$i=1;	
						foreach($onaResult AS $row)
						{
						?>	
							<tr>
								<td align="center" style="width:5%;"><?=$i?></td>
								<td style="width:10%;padding-left:5px;"><?=$row->invNo?></td>
								<td style="width:10%;padding-left:5px;"><?=$row->invDate?></td>
								<td style="width:10%;padding-left:5px;"><?=$row->ddate?></td>
								<td style="width:45%;padding-left:5px;"><?=getdbc($row->pto)?></td>
								<td style="width:10%;padding-left:5px;"><?=number_format($row->amount, 2)?></td>
								<td style="width:10%;padding-left:5px;"><?=$row->remark?></td>
							</tr>
						<?php
							$i++;
						}
						?>	
						<tr>
							<td align="center" colspan='5' style="font-weight:bold;padding-left:5px;">Total</td>
							<td style="font-weight:bold;padding-left:5px;"><?=number_format($onaTotal->tamount, 2)?></td>
						</tr>
						</table>
					<?php
					}
					else
					{
						echo "No Pending On Accounts Yet!".'<br>';
					}
					?>
					<?php
					if($pt>0)
					{	
					?>
							<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
								<tr>
									<td align="center" style="font-weight:bold;padding-left:5px;width:80%;">All Pendings</td>
									<td style="font-weight:bold;padding-left:5px;width:20%;"><?=number_format($pt, 2)?></td>
								</tr>
							</table>
					<?php
					}
					?>	
			</div>	
			<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;cursor:pointer;" title="Paid">
				<tr onclick="showHideHistory();">
					<td align="center" style="width:100%;background-color:#BEBEBE ;font-weight:bold;">Paids</td>
				</tr>
			</table>		
			<div id="allPaid" style="display:none;">	
			<?php
			if($pic)
			{	
			?>	
				<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
					<tr>
						<td colspan="8" align="center" style="width:100%;background-color:#BEBEBE ;font-weight:bold;">Paid Cheques</td>
					</tr>
					<tr>
						<td align="center" style="width:5%;background-color:#b3d7ff87;">ROW</td>
						<td style="width:9%;background-color:#b3d7ff87;padding-left:5px;">Due Date</td>
						<td style="width:8%;background-color:#b3d7ff87;padding-left:5px;">Cheque No</td>
						<td style="width:9%;background-color:#b3d7ff87;padding-left:5px;">Invoice No</td>
						<td style="width:33%;background-color:#b3d7ff87;padding-left:5px;">D/C</td>
						<td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Amount</td>
						<td style="width:24%;background-color:#b3d7ff87;padding-left:5px;">Remark</td>
						
					</tr>
					<?php
					$i=1;	
					foreach($pic AS $row)
					{
					?>	
						<tr>
							<td align="center" style="width:5%;"><?=$i?></td>
							<td style="width:9%;padding-left:5px;"><?=$row->ddate?></td>
							<td style="width:8%;padding-left:5px;"><?=$row->cno?></td>
							<td style="width:9%;padding-left:5px;"><?=$row->invNo?></td>
							<td style="width:33%;padding-left:5px;"><?=getdbc($row->pto)?></td>
							<td style="width:12%;padding-left:5px;"><?=number_format($row->amount, 2)?></td>
							<td style="width:24%;padding-left:5px;"><?=$row->remark?></td>
						</tr>
					<?php
						$i++;
					}
					?>	
					<tr>
						<td align="center" colspan='5' style="font-weight:bold;padding-left:5px;">Total</td>
						<td style="font-weight:bold;padding-left:5px;"><?=number_format($picTotal->tamount, 2)?></td>
					</tr>
					</table>
				<?php
			}
			else
			{
				echo "No Paid Cheques Yet!".'<br>';
			}	
				?>
				<?php
			if($pot)
			{	
			?>	
				<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
					<tr>
						<td colspan="7" align="center" style="width:100%;background-color:#BEBEBE ;font-weight:bold;">Paid ON ACCOUNTS</td>
					</tr>
					<tr>
						<td align="center" style="width:5%;background-color:#b3d7ff87;">ROW</td>
						<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Invoice No</td>
						<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Invoice Date</td>
						<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Due Date</td>
						<td style="width:45%;background-color:#b3d7ff87;padding-left:5px;">D/C</td>
						<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Amount</td>
						<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Remark</td>
						
					</tr>
					<?php
					$i=1;	
					foreach($pot AS $row)
					{
					?>	
						<tr>
							<td align="center" style="width:5%;"><?=$i?></td>
							<td style="width:10%;padding-left:5px;"><?=$row->invNo?></td>
							<td style="width:10%;padding-left:5px;"><?=$row->invDate?></td>
							<td style="width:10%;padding-left:5px;"><?=$row->ddate?></td>
							<td style="width:45%;padding-left:5px;"><?=getdbc($row->pto)?></td>
							<td style="width:10%;padding-left:5px;"><?=number_format($row->amount, 2)?></td>
							<td style="width:10%;padding-left:5px;"><?=$row->remark?></td>
						</tr>
					<?php
						$i++;
					}
					?>	
					<tr>
						<td align="center" colspan='5' style="font-weight:bold;padding-left:5px;">Total</td>
						<td style="font-weight:bold;padding-left:5px;"><?=number_format($potTotal->tamount, 2)?></td>
					</tr>
					</table>
				<?php
			}
			else
			{
				echo "No Paid On Accounts Yet!".'<br>';
			}
				?>
				<?php
				if($paidTotal>0)
				{	
				?>
						<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
							<tr>
								<td align="center" style="font-weight:bold;padding-left:5px;width:80%;">All Paid</td>
								<td style="font-weight:bold;padding-left:5px;width:20%;"><?=number_format($paidTotal, 2)?></td>
							</tr>
						</table>
				<?php
				}		
				?>
				</div>
				
			<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
			   <a style="" title="Export PDF" href="<?=base_url('codeigniter/public/printpdfcdbc/')?><?=$dbc?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
			</div>
			<div class="row" style="margin:5px 5px 5px 0px;width:100%;">
			<?//=displayPagination()?>	
			</div>
			
		</div>
		
	</div>
</div>	

<script>
//showhide history
function showHideHistory()
{
	$("#allPaid").slideToggle();
}	

//showhide all pendings
function showHideAllpending()
{
	$("#allPendings").slideToggle();
}
//Bring search view sublayout
function searchFilter()
	{ 
		var formData = $("#reportform").serialize(); 
		$.ajax({
					 type: 'post',
					 url: "<?=base_url('codeigniter/public/searchcheque')?>",
					 data: formData,
					 success: function(result) {
						$("#tblCon").empty(); 
						$("#tblCon").append(result);
					  }
					});	 
	}
//sidebar
function w3_open() {
  document.getElementById("main").style.marginLeft = "25%";
  document.getElementById("mySidebar").style.width = "25%";
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("openNav").style.display = 'none';
}
function w3_close() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("openNav").style.display = "inline-block";
}
</script>

</body>
</html>