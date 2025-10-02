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
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
	<div style="display:inline-block;float:left;width:40%;">
			<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
			<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
		</div>
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Tamay</h4>
			<center><h5>Reported On:  <?=date('d/m/Y')?></h5></center>
		</div>
		<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
			
			<!--<img src="<?=base_url('codeigniter/public/')?>images/statustic.jpg" style="width:90px; height:90px;" alt="Groom">-->
		</div>
	<div style="margin:5px 5px 5px 5px;">
		
		<form id="reportform" method="post" action="<?=base_url('/searchcheque')?>">
			<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				<tr>
					<td align="center" style="width:2%;background-color:#b3d7ff87;">Start Date:</td>
					<td style="width:2%;"><input class="form-control line" style="font-weight:bold;font-size:15px;" name="sdate" id="sdate" type="date" onblur=""/></td>
					<td align="center" style="width:2%;background-color:#b3d7ff87;">End Date:</td>
					<td style="width:2%;"><input class="form-control line" style="font-weight:bold;font-size:15px;" name="edate" id="edate" type="date" onblur=""/></td>
					<td align="center" style="width:2%;background-color:#b3d7ff87;">Cheque No:</td>
					<td style="width:2%;"><input class="form-control line" placeholder="No" style="font-weight:bold;font-size:15px;" name="cno" id="cno" type="text" onblur=""/></td>
					<td colspan="" style="width:2%;background-color:#b3d7ff87;">
						<select style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="status" name="status"  tabindex="107">
							<option value="">Status</option>
							<option value="1">Pending</option>
							<option value="2">Paid</option>
							<option value="3">Cancelled</option>
						</select>
					  </td>
					  <td align="center" style="width:1%;background-color:#b3d7ff87;"><input type="button" name="btn_result"  onclick="searchFilter()" style="" class="btn btn-primary" value="Search" /></td>
				
				</tr>
			</table>
		</form>
		<div id="tblCon">
			<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
				<tr>
					<td colspan="9" align="center" style="width:100%;background-color:#4caf50;">Cheques</td>
				</tr>
				<tr>
					<td align="center" style="width:5%;background-color:#b3d7ff87;">Row</td>
					<td style="width:10%;background-color:#b3d7ff87;">Due Date</td>
					<td style="width:10%;background-color:#b3d7ff87;">Bank</td>
					<td style="width:7%;background-color:#b3d7ff87;">Cheque No</td>
					<td style="width:10%;background-color:#b3d7ff87;">Amount</td>
					<td style="width:28%;background-color:#b3d7ff87;">Paid to</td>
					<td style="width:13%;background-color:#b3d7ff87;">Remark</td>
					<td style="width:7%;background-color:#b3d7ff87;">Status</td>
					<td style="width:10%;background-color:#b3d7ff87;">Action</td>
				</tr>
			<?php
			$i=1;
			foreach($chequeresult AS $cheque)
			{
			?>
				<tr>
					<td align="center" style="width:5%"><?=$i?></td>
					<td style="width:10%"><?=$cheque->ddate?></td>
					<td style="width:10%"><?=bankName($cheque->bname)?></td>
					<td style="width:7%"><?=$cheque->cno?></td>
					<td style="width:10%">RM <?=number_format($cheque->amount, 2)?></td>
					<td style="width:28%"><?=getdbc($cheque->pto)?></td>
					<td style="width:13%"><?=$cheque->remark?></td>
					<td style="width:7%">
					<?php 
					if($cheque->status == 1)
					{
						echo "Pending";
					}
					else if($cheque->status == 2)
					{
						echo "Paid";
					}
					else if($cheque->status == 3)
					{
						echo "Cancelled";
					}
					?>
					</td>
					<td style="width:10%">
						<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('codeigniter/public/paymentupdatec/')?><?=$cheque->Id?>" target="_blank">Edit</a>
					</td>
				</tr>
				
			<?php
				$i++;
			}
			?>
			<tr>
				<td align="center" colspan="8" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Total</td>
				<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;">RM <?=number_format($chequetotal->totalAmount, 2)?></td>
			</tr>	
			</table>

			<div class="row" style="margin:5px 5px 5px 0px;width:100%;">
			<?//=displayPagination()?>	
			</div>
			<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
			   <a style="" title="Update Current Record" href="<?=base_url('/codeigniter/public/printpdfcheque/')?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a> 
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