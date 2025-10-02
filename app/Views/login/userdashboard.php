<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>User Dashboard</title>
	<link href="<?=base_url('codeigniter/public/')?>assets/css/bootstrap.css" rel="stylesheet" />
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
<body style="margin:0px 0px 0px 0px; font-family: 'Sans-Serif'">
<?php $this->session = \Config\Services::session();?>
<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  <?php 
  if($this->session->get('myRole') == 1 OR $this->session->get('myRole') == 3)
  {
  ?>
  <a href="<?=base_url('codeigniter/public/').'dailyform/'?>" class="w3-bar-item w3-button">Add Report</a>
  <?php
  }
  ?>
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
			<h6><a href="<?=base_url('codeigniter/public/login')?>" title="Logout" style="text-decoration:none;color: inherit;">Logout</a></h6>
		</div>
	</div>
  </div>
</div>
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
		<div style="display:inline-block;float:left;width:35%;">
		 <?php 
		  if($this->session->get('myRole') == 101)
		  {
		   ?>
			<img src="<?=base_url('codeigniter/public/')?>images/bergaya.jpg" style="width:90px; height:90px;" alt="Groom">
		<?php
		  }
		  else
		  {		
		?>
			<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
		<?php
		  }
		?>	
			<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
		</div>
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<center><h2>User Dashboard</h2></center>
			
		</div>
		<h2>Primary Access</h2>
	<?php 
	 if($this->session->get('myRole') == 1 OR $this->session->get('myRole') == 4 OR $this->session->get('myRole') == 102)
	 {
	?>	
		<div class="panel panel-primary">
		  <div class="panel-heading">Daily Reports Form</div>
		  <div class="panel-body"><a target='blank' href="<?=base_url('codeigniter/public/').'dailyform/'?>"><h3>Add Report</h3> </a></div>
		</div>
	<?php
	}
	?>	
	<?php 
	 if($this->session->get('myRole') == 1 OR $this->session->get('myRole') == 4)
	 {
	?>	
		<div class="panel panel-primary">
		  <div class="panel-heading">Customers In/Out</div>
		  <div class="panel-body"><a target='blank' href="<?=base_url('codeigniter/public/cinoutmain')?>"><h3>Customers In/Out</h3> </a></div>
		</div>
	<?php
	}
	?>
	<?php 
	 if($this->session->get('myRole') == 1 OR $this->session->get('myRole') == 100 OR $this->session->get('myRole') == 101 OR $this->session->get('myRole') == 900 OR $this->session->get('myRole') == 102)
	 {
	?>	
		<div class="panel panel-primary">
		  <div class="panel-heading">Attendance</div>
		  <div class="panel-body"><a target='_blank' href="<?=base_url('codeigniter/public/attendance/').'addPunch/'?>"><h3>Add Punch</h3> </a></div>
		</div>
	<?php
	}
	?>
	<?php 
	 if($this->session->get('myRole') == 1 OR $this->session->get('myRole') == 200)
	 {
	?>	
		<div class="panel panel-primary">
		  <div class="panel-heading">Perfumes</div>
		  <div class="panel-body"><a target='_blank' href="<?=base_url('codeigniter/public/perfumes/').'home'?>"><h3>List</h3> </a></div>
		</div>
	<?php
	}
	?>
	<?php  
	 if($this->session->get('myRole') == 1 OR $this->session->get('myRole') == 900)
	 {
	?>	
		<div class="panel panel-primary">
		  <div class="panel-heading">Search Attendance</div>
		  <div class="panel-body"><a target='_blank' href="<?=base_url('codeigniter/public/attendance/searchlayout')?>"><h3>Search Attendance</h3> </a></div>
		</div>
	<?php
	}
	?>
	<?php  
	 if($this->session->get('myRole') == 1 OR $this->session->get('myRole') == 900)
	 {
	?>	
		<div class="panel panel-primary">
		  <div class="panel-heading">Attendance Report</div>
		  <div class="panel-body"><a target='_blank' href="<?=base_url('codeigniter/public/attendance/reportLayout')?>"><h3> Attendance Report</h3> </a></div>
		</div>
	<?php
	}
	?>
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