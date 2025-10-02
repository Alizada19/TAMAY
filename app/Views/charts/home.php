<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>Cheque Reports</title>
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
  <a href="<?=base_url('codeigniter/public/').'pendingChequesCharts'?>" class="w3-bar-item w3-button">Pending Cheques for coming 7 days.</a>
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
			<h4>TAMAY BUSINESS GROUP</h4>
			<center><h5>Reported On:  <?=date('Y-m-d')?></h5></center>
			<center><h5>Pending payment in 10 days!</h5></center>
		</div>
	
						<div class="container-fluid" style="clear:both;width:40%; border-style: groove;">
							<!-- Control the column width, and how they should appear on different devices -->
							<div class="row">
								 <div class="col-md-4" style=" padding-top:20px; padding-bottom:20px; font-weight:bold;font-size:20px">Day</div>
								 <div class="col-md-4" style=" padding-top:20px; padding-bottom:20px; font-weight:bold;font-size:20px">Date</div>
								 <div class="col-md-4" style="padding-top:20px; padding-bottom:20px;font-weight:bold;font-size:20px">Amount</div>
							</div>
							
							<?php
								$bg="";
								foreach($pChequeCharts AS $cheques)
								{
									if(in_array($cheques->dates, $aweek))
									{	
									  if($cheques->tamount>=20000)
									  {
										$bg = "class='cbg'";
									  }
									  else
									  {
										$bg = '';	
									  }		
							?>
									<div class="row bghover">	
									  <div class="col-md-4" style=" padding-top:20px; padding-bottom:20px;font-size:20px"><?=date('l', strtotime($cheques->dates))?></div>		
									  <div class="col-md-4" style=" padding-top:20px; padding-bottom:20px;font-size:20px"><?=date_format(date_create($cheques->dates), 'd/m/Y')?></div>
									  <div class="col-md-4" style="padding-top:20px; padding-bottom:20px;font-size:20px"><span <?=$bg?>>RM <?=number_format($cheques->tamount, 2)?></span></div>
									</div>
							<?php
									}
								}
							?>	
							
							<br>
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