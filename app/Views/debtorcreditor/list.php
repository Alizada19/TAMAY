<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>D/C Main List</title>
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
  <a href="<?=base_url('codeigniter/public/').'pendingChequesCharts'?>" class="w3-bar-item w3-button">Pending Cheques for coming 7 days.</a>
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
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
	<div style="display:inline-block;float:left;width:40%;">
			<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
			<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
		</div>
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>TAMAY BUSINESS GROUP</h4>
			<center><h5>Date: <?=date('d/m/Y')?></h5></center>
		</div>
		<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
			
			<!--<img src="<?=base_url('codeigniter/public/')?>images/statustic.jpg" style="width:90px; height:90px;" alt="Groom">-->
		</div>
	<div style="margin:5px 5px 5px 5px;">
		
		
		<div id="tblCon">
			<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				<tr>
					<td colspan="8" align="center" style="width:100%;background-color:#4caf50;">Debtors/Creditors</td>
				</tr>
				<tr>
					<td align="center" style="width:10%;background-color:#b3d7ff87;">ID</td>
					<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Name</td>
					<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Type</td>
					<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Address</td>
					<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Phone No</td>
					<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Date of Creation</td>
					<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Created By</td>
					<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Action</td>
				</tr>
			<?php
			$i=1;
			foreach($result AS $row)
			{
			?>
				<tr>
					<td align="center" style="width:10%"><?=$i?></td>
					<td style="width:10%;padding-left:5px;"><?=$row->dcnames?></td>
					<td style="width:10%;padding-left:5px;"><?=dbcType($row->type)?></td>
					<td style="width:10%;padding-left:5px;"><?=$row->addr?></td>
					<td style="width:10%;padding-left:5px;"><?=$row->phone?></td>
					<td style="width:10%;padding-left:5px;"><?=date_format(date_create($row->saveDate), 'd/m/Y')?></td>
					<td style="width:10%;padding-left:5px;"><?=$row->username?></td>
					<td style="width:10%;padding-left:5px;">
						<a style="test-decoration: none;" title="View Record" href="<?=base_url('codeigniter/public/debtorcreditorView/')?><?=$row->Id?>" target="_blank">View</a>
						<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('codeigniter/public/debtorcreditoredit/')?><?=$row->Id?>" target="_blank">Edit</a>
					</td>
				</tr>
				
			<?php
				$i++;
			}
			?>
			<tr>
				<td align="center" colspan="7" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Total</td>
				<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;"><?=$total?></td>
			</tr>	
			
			</table>

			<div class="row" style="margin:5px 5px 5px 0px;width:100%;">
			<?//=displayPagination()?>	
			</div>
			
		</div>
		
	</div>
</div>	

<script>

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