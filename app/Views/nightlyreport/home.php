<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>Nightly Sales Report For All Shops</title>
    <link href="<?=base_url('codeigniter/public/')?>css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?=base_url('codeigniter/public/')?>css/w3school.css">
	<script type="text/javascript" src="<?=base_url('codeigniter/public/')?>js/jq.js"></script>
	<style type="text/css">

	table, th, td {
	  border: 1px solid blue;
	}
	</style>
</head>
<body style="margin:0px 0px 0px 0px;">
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
  <a href="<?=base_url('codeigniter/public/').'pendingChequesCharts'?>" class="w3-bar-item w3-button">Pending Payments in 10 days.</a>
  <?php  } ?>
</div>
<div id="main">

<div class="w3-teal">
  <div class="w3-container">
    <div style=" ">
		<div style="display:inline-block; margin-top:0px; font-size:20px;">
		<h6>Username: <?=$this->session->get('name')?> </h6>
		</div>
		<div style="display:inline-block; margin-top:0px; font-size:20px; float:right;">
			<h6><a href="<?=base_url('codeigniter/public/login')?>" title="Logout" style="text-decoration:none;color: inherit;">Logout</a></h6>
		</div>
		
	</div>
	
  </div>
</div>
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
	<div style="margin:5px 5px 5px 5px;">
		<div style="display:inline-block;float:left;width:35%;">
			<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
			<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
		</div>
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>NIGHTLY SALES REPORT FOR ALL SHOPS</h4>
			<center><h5>All Shops</h5></center>
			
			
		</div>
		<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
			<h5>Today: <?=date('d/m/Y')?></h5>
			
		</div>
	</div>
	
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
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">1</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">ESI</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensi->totalSales)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensi->totalCard)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensi->totalCash)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensi->totaleamount)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensi->totalNcash)?></td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">2</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">ESW</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensw->totalSales)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensw->totalCard)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensw->totalCash)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensw->totaleamount)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edensw->totalNcash)?></td>
			</tr>
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">3</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-Q</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edenjo->totalSales)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edenjo->totalCard)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edenjo->totalCash)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edenjo->totaleamount)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edenjo->totalNcash)?></td>
			</tr>
			<!--<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">4</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">JOHONI-2</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?//=number_format($edenjo2->totalSales)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?//=number_format($edenjo2->totalCard)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?//=number_format($edenjo2->totalCash)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?//=number_format($edenjo2->totaleamount)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?//=number_format($edenjo2->totalNcash)?></td>
			</tr>-->
			<tr>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">5</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">E66A</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edena->totalSales)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edena->totalCard)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edena->totalCash)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edena->totaleamount)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($edena->totalNcash)?></td>
			</tr>
			<tr>
				<td align="center" colspan='2' style="width:10%;background-color:#b3d7ff87;">Total:</td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalSales)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalCard)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalCash)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totaleamount)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($eden->totalNcash)?></td>
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
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamay->totalSales)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamay->totalCard)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamay->totalCash)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamay->totaleamount)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($tamay->totalNcash)?></td>
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
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($bergaya->totalSales)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($bergaya->totalCard)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($bergaya->totalCash)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($bergaya->totaleamount)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($bergaya->totalNcash)?></td>
			</tr>
		</table>  -->
		
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
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($allshops->totalSales)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($allshops->totalCard)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($allshops->totalCash)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?=number_format($allshops->totaleamount)?></td>
				<td align="center" style="width:10%;background-color:#b3d7ff87;">RM <?php $all = $allshops->totalSales - $allshops->totaleamount; echo number_format($all)?></td>
			</tr>
		</table>
		<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
		   <a style="" title="Update Current Record" href="<?=base_url('codeigniter/public/printpdfNightReports/')?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
		</div>
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