<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
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
<body style="margin:0px 0px 0px 0px;font-family:'Sans-Serif'">
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
	  <a href="<?=base_url('codeigniter/public/').'pendingChequesCharts'?>" class="w3-bar-item w3-button">Pending Cheques in 30 days.</a>
	  <?php  } ?>
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
	<div style="display:inline-block;float:left;width:40%;margin-left:1%;">
		<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
		<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
	</div>
	<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
		<h4>Tamay Groupe</h4>
		<center><h5>Date:  <?=date('d/m/Y')?></h5></center>
	</div>
	<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
		
		<!--<img src="<?=base_url('codeigniter/public/')?>images/statustic.jpg" style="width:90px; height:90px;" alt="Groom">-->
	</div>