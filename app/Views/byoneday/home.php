<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>Pending Payment</title>
    <link href="<?=base_url('codeigniter/public/')?>css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url('codeigniter/public/')?>css/temp/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?=base_url('codeigniter/public/')?>css/w3school.css">
	<script type="text/javascript" src="<?=base_url('codeigniter/public/')?>js/jq.js"></script>
	<style type="text/css">

	table, th, td {
	  border: 1px solid blue;
	}
	
	.cbg{
		background-color:red;
		color:white;
		//padding: 5px 5px 5px 5px;
		border: 2px solid red;
		border-radius: 20px 20px;
	}
	.bghover:hover{
			background-color:blue;
			cursor:pointer;
			color:white;
	}	
	</style>
</head>
<body style="margin:0px 0px 0px 0px; font-family:'Sans-serif'">
<?php $this->session = \Config\Services::session();?>
<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  
  <a href="<?=base_url('codeigniter/public/').'dailyform/'?>" class="w3-bar-item w3-button">Add Report</a>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url('codeigniter/public/').'payment'?>" class="w3-bar-item w3-button">Add Payments</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url('codeigniter/public/').'debtorcreditor/2'?>" class="w3-bar-item w3-button">Add Debtor/Creditor</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url('codeigniter/public/').'nightlyreport/'?>" class="w3-bar-item w3-button">Today's Report</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url('codeigniter/public/').'sreport/'?>" class="w3-bar-item w3-button">Search Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url('codeigniter/public/').'chequereports/'?>" class="w3-bar-item w3-button">Cheque Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url('codeigniter/public/').'ocashreports/'?>" class="w3-bar-item w3-button">OT /Cash Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url('codeigniter/public/').'apayments/'?>" class="w3-bar-item w3-button">Payment Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url('codeigniter/public/').'supReports/'?>" class="w3-bar-item w3-button">Reports by Suppliers</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url('codeigniter/public/').'pendingChequesCharts'?>" class="w3-bar-item w3-button">Pending Payment in 10 days.</a>
  <?php  } ?>
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
		<div style="display:inline-block;float:left;width:40%;">
			<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
			<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
		</div>
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Tamay</h4>
			<center><h5>Payment On:  <?=date_format(date_create($sdate), 'd/m/Y')?></h5></center>
		</div>
		<div id="tblCon">
			<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				<tr>
					<td colspan="9" align="center" style="width:100%;background-color:#4caf50;">Cheque Payment</td>
				</tr>
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">Row</td>
					<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Due Date</td>
					<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Invoice No</td>
					<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Amount</td>
					<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Cheque No</td>
					<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Bank Name</td>
					<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Paid to</td>
					<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Status</td>
					<td style="width:10%;background-color:#b3d7ff87;padding:0px 5px 0px 5px;">Remark</td>
				</tr>
			<?php
			$i=1;
			foreach($presult AS $result)
			{
				$bgc='';
				if($result->ptype == 1)
				{
					$bgc="background-color:#ffffc5";
				}
				else if($result->ptype == 2)
				{
					$bgc="background-color:#90EE90";
				}	
			?>
				<tr style="<?=$bgc?>">
					<td align="center" style="width:10%"><?=$i?></td>
					<td style="width:10%;padding:0px 5px 0px 5px;"><?=date_format(date_create($result->ddate), 'd/m/Y')?></td>
					<td style="width:10%;padding:0px 5px 0px 5px;"><?=$result->invNo?></td>
					<td style="width:10%;padding:0px 5px 0px 5px;">RM <?=number_format($result->amount, 2)?></td>
					<td style="width:10%;padding:0px 5px 0px 5px;"><?=$result->cno?></td>
					<td style="width:10%;padding:0px 5px 0px 5px;"><?=bankName($result->bname)?></td>
					<td style="width:10%;padding:0px 5px 0px 5px;"><?=getdbc($result->pto)?></td>
					<td style="width:10%;padding:0px 5px 0px 5px;">
					<?php 
						if($result->status==1)
						{
							echo "Pending";
						}
						else if($result->status==2)
						{
							echo "Paid";
						}
						else if($result->status==3)
						{
							echo "Conceled";
						}	
						?>
					
					</td>
					<td style="width:10%;padding:0px 5px 0px 5px;"><?=$result->remark?></td>
				</tr>
				
			<?php
				$i++;
			}
			?>
			<tr style="background-color: #ffffc5;">
				<td colspan="8" style="width:10%;font-weight:bold;padding:0px 5px 0px 5px;">Total Cheques</td>
				<td style="width:10%;font-weight:bold;padding:0px 5px 0px 5px;">RM <?=number_format($ctotal->totalAmount, 2)?></td>
			</tr>
			<tr style="background-color: #90EE90">
				<td colspan="8" style="width:10%;font-weight:bold;padding:0px 5px 0px 5px;">Total Creditors</td>
				<td style="width:10%;font-weight:bold;padding:0px 5px 0px 5px;">RM <?=number_format($crtotal->totalAmount, 2)?></td>
			</tr>
			<tr>
				<td colspan="8" style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding:0px 5px 0px 5px;">Total All</td>
				<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding:0px 5px 0px 5px;">RM <?=number_format($ptotal->totalAmount, 2)?></td>
			</tr>	
			</table>
			<!--<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
			   <a style="" title="Export PDF" href="<?=base_url('codeigniter/public/printpdfDatebased/')?><?=$sdate?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
			</div>-->
		</div>
						
</div>	

<script>

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