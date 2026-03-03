<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>Search Report</title>
    <link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?=base_url()?>css/w3school.css">
	<script type="text/javascript" src="<?=base_url()?>js/jq.js"></script>
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
  
  <a href="<?=base_url().'dailyform/'?>" class="w3-bar-item w3-button">Add Report</a>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'payment'?>" class="w3-bar-item w3-button">Add Payments</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'debtorcreditor/2'?>" class="w3-bar-item w3-button">Add Debtor/Creditor</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'nightlyreport/'?>" class="w3-bar-item w3-button">Today's Report</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'sreport/'?>" class="w3-bar-item w3-button">Search Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'chequereports/'?>" class="w3-bar-item w3-button">Cheque Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'ocashreports/'?>" class="w3-bar-item w3-button">OT /Cash Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'apayments/'?>" class="w3-bar-item w3-button">Payment Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'supReports/'?>" class="w3-bar-item w3-button">Reports by Suppliers</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'pendingChequesCharts'?>" class="w3-bar-item w3-button">Pending Payment in 30 days.</a>
  <?php  } ?>
</div>
<?php $this->session = \Config\Services::session();?>
<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  
  <a href="<?=base_url().'dailyform/'?>" class="w3-bar-item w3-button">Add Report</a>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'payment'?>" class="w3-bar-item w3-button">Add Payments</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'debtorcreditor/2'?>" class="w3-bar-item w3-button">Add Debtor/Creditor</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'nightlyreport/'?>" class="w3-bar-item w3-button">Today's Report</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'sreport/'?>" class="w3-bar-item w3-button">Search Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'chequereports/'?>" class="w3-bar-item w3-button">Cheque Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'ocashreports/'?>" class="w3-bar-item w3-button">Creditors Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'apayments/'?>" class="w3-bar-item w3-button">Payment Reports</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'supReports/'?>" class="w3-bar-item w3-button">Reports by Suppliers</a>
  <?php  } ?>
  <?php 
  if($this->session->get('myRole') == 1)
  {
   ?>
  <a href="<?=base_url().'pendingChequesCharts'?>" class="w3-bar-item w3-button">Pending Cheques for coming 30 days.</a>
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
			<h6><a href="<?=base_url('login')?>" title="Logout" style="text-decoration:none;color: inherit;">Logout</a></h6>
		</div>
		
	</div>
	
  </div>
</div>
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
	<div style="margin:5px 5px 5px 5px;">
		<div style="display:inline-block;float:left;width:40%;">
			<img src="<?=base_url()?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
			<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
		</div>
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Search Sales Report</h4>
			<center><h5>Shops</h5></center>
			
			
		</div>
		<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
			<h5>Today: <?=date('d/m/Y')?></h5>
			
		</div>
	</div>
	<div style="margin:5px 5px 5px 5px;">
		<form id="reportform" method="post" action="<?=base_url('sreport')?>rsearch">
			<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				<tr>
					<td align="center" style="width:2%;background-color:#b3d7ff87;">Start Date:</td>
					<td style="width:2%;"><input class="form-control line" style="font-weight:bold;font-size:15px;" name="sdate" id="sdate" type="date" onblur=""/></td>
					<td align="center" style="width:2%;background-color:#b3d7ff87;">End Date:</td>
					<td style="width:2%;"><input class="form-control line" style="font-weight:bold;font-size:15px;" name="edate" id="edate" type="date" onblur=""/></td>
					<td colspan="" style="width:2%;background-color:#b3d7ff87;">
						<select style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="slocation" name="slocation"  tabindex="107">
							<option value="">Please select location</option>
							<!--<option value="1">B&S</option>-->
							<option value="2">Gilasco</option>
							<option value="3">ESI</option>
							<option value="4">ESW</option>
							<option value="5">Johoni-Q</option>
							<!--<option value="7">Johoni-2</option>-->
							<option value="6">E66A</option>
							<option value="20">All Shops</option>
							<option value="21">All Shops By Date</option>
							<option value="22">All Shops By Expenses Type</option>
							<option value="23">Investment</option>

						</select>
					  </td>
					  <td align="center" style="width:1%;background-color:#b3d7ff87;"><input type="button" name="btn_result"  onclick="searchFilter()" style="" class="btn btn-primary" value="Search" /></td>
				
				</tr>
			</table>
		</form>
		<div id="rcon">
		
		</div>
		<div class="row" id="buttons" style="margin:5px 5px 5px 0px;width:100%; display:none;">
		  <span>
			<input type="button"  name="btn_result"  style="width:200px;" class="btn btn-primary line" value="Print" /> 
		  </span>
		  <span style="margin-left: 10px;">	
		   <input type="button" name="btn_result"   style="width:200px;" class="btn btn-primary line" value="Export PDF" />
		  </span> 
		</div>
		
	</div>
</div>	
<script>
function searchFilter()
{ 
	var formData = $("#reportform").serialize(); 
	$.ajax({
				 type: 'post',
				 url: "<?=base_url('sreport/')?>rsearch",
				 data: formData,
				 success: function(result) {
					$("#rcon").empty(); 
					$("#rcon").append(result);
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