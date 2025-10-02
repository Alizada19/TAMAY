<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>Customer In Out Form</title>
    <link href="<?=base_url('codeigniter/public/')?>css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?=base_url('codeigniter/public/')?>css/w3school.css">
	<script type="text/javascript" src="<?=base_url('codeigniter/public/')?>js/jq.js"></script>
	<style type="text/css">

	table, th, td {
	  border: 1px solid blue;
	}
	</style>
</head>
<body style="margin:0px 0px 0px 0px; font-family:'Sans-Serif'">
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
  <a href="<?=base_url('codeigniter/public/debtorcreditorlist')?>" target="_blank" class="w3-bar-item w3-button">Debtor/Creditor List</a>
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
		<h6>Username: <?=$sname?> </h6>
		</div>
		<div style="display:inline-block; margin-top:0px; font-size:20px; float:right;">
			<h6><a href="<?=base_url('codeigniter/public/login')?>" title="Logout" style="text-decoration:none;color: inherit;">Logout</a></h6>
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
			<h4>Tamay Group</h4>
			<h4>Customer In/Out Form</h4>
			
			
		</div>
		<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
			<h5>Today: <?=date('d/m/Y')?></h5>
			
		</div>
		<!-- Success Alert -->
		<?php
			if($dvalue == 1)
			{	
		?>
		<div style="background-color:#b3d7ff87; max-width: 45%;" class="alert  alert-dismissible d-flex align-items-center fade show ">
			
			<strong class="mx-2">Success!</strong> Your record has been saved successfully.
			
		</div>
		<?php
			}
			else if($dvalue == 0)
			{
		?>		
				<div style="background-color:#b3d7ff87" class="alert  alert-dismissible d-flex align-items-center fade show ">
			
					<strong class="mx-2">Failer!</strong> Your record has not been saved successfully.
					
				</div>
		<?php		
			}		
		?>
	</div>
	<form id="form1" method="post" action="<?=base_url('codeigniter/public/')?>cinoutsave">
	<div style="width:100%" style="margin-right:1%;">
		<div id="dailycsub">
			<!--Daily subparts -->
			<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				<tr>
					<td colspan="5" style="width:2%;background-color:#b3d7ff87;">
						<select style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="shop" name="shop"  tabindex="107" required>
							<?=$str?>
						</select>
					  </td>
				</tr>
				<tr>
					<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">No</td>
					<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">Customer In</td>
					<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">Purchase</td>
					<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">Local/Foreigner</td>
					<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">Remark</td>
				</tr>
				<?php
				if($res2)
				{	
				 $i=1;
				 foreach($res2 AS $row)
				 {	
				?>
				<tr>
					<td width="20%" align="center" style="background-color: #b3d7ff87"><?=$i?></td>
					<td width="20%" align="center" style="background-color: #b3d7ff87"><?=$row->cin?></td>
					<td width="20%" align="center" style="background-color: #b3d7ff87">
							<?php
								if($row->purchase == 1)
								{
									echo "Yes";
								}
								else if($row->purchasenot == 1)
								{
									echo "No";
								}		
							?>
					</td>
					<td width="20%" align="center" style="background-color: #b3d7ff87">
						<?php
								if($row->local == 1)
								{
									echo "Local";
								}
								else if($row->foreigner == 1)
								{
									echo "Foreigner";
								}		
							?>
					</td>
					<td width="20%" align="center" style="background-color: #b3d7ff87"><?=$row->remark?></td>
				</tr>
				<?php
					$i++;
				 }
				}	
				?>
				<?php
				if($res2)
				{
				?>
				<tr>
					<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">Toal</td>
					<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;"><?=$total->customers?></td>
					<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;"><?=$total->purchased?></td>
					<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">L:<?=$total->locals?>/F:<?=$total->foreigners?></td>
					<td width="20%" align="center" style="background-color: #b3d7ff87; font-weight:bold;">% <?=$percentage?></td>
				</tr>
				<?php
				}
				?>
			</table>
		</div>
		
		<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			<tr>
				<td width="25%" align="center" style="background-color: #b3d7ff87">Customer In</td>
				<td width="25%" align="center" style="background-color: #b3d7ff87">Purchase</td>
				<td width="25%" align="center" style="background-color: #b3d7ff87">Local/Foreigner</td>
				<td width="25%" align="center" style="background-color: #b3d7ff87">Remark</td>
			</tr>
			<tr>
				<td width="25%" align="center"><input style="width:100%; border:none;text-align:center" placeholder="No" type="text" id="cin" name="cin" required></td>
				<td width="25%" align="center">
					<label for="html">Yes</label>
					<input type="radio" id="y" name="parchase" value="1" checked>
					<label for="html">No</label>
					<input type="radio" id="n" name="parchase" value="2">
				</td>
				<td width="25%" align="center">
					<label for="html">Local</label>
					<input type="radio" id="y" name="lf" value="1" checked>
					<label for="html">Foreigner</label>
					<input type="radio" id="n" name="lf" value="2">
				</td>
				<td width="25%" align="center"><input style="width:100%; border:none;text-align:center" placeholder="Text" type="text"id="remark" name="remark"></td>
			</tr>
		</table>
	</div>	
    <div id="payCon">
	
	</div>
	</form>
	<div class="row" style="margin:5px 5px 5px 0px;width:100%;" id="sbutton">
	   <input type="submit" name="btn_result"   style="width:200px;" class="btn btn-primary line" value="Save" onclick="bringinout();"/>
	</div>
</div>
<script>
	
function makeCapital2(value, id)
{
	myString = value.charAt(0).toUpperCase() + value.slice(1);
	document.getElementById(id).value = myString;
	document.getElementById(id).style="background-color:#b3d7ff87;font-size:20px;font-weight:bold";
}	
function showHide(id,showHide)
{
		$("#"+id).slideToggle("slow");
		if(showHide=="show")
		{
		  //document.getElementById("plus").style="display:none";
		  //document.getElementById("minus").style="display:block";
		  $("#plus").css({"display":"none"});
		  $("#minus").css({"display":"block"});
		}
        else
        {
			$("#plus").css({"display":"block"});
		  $("#minus").css({"display":"none"});
		}		
		
}
function changeColor(value, id)
{
	document.getElementById(id).style="background-color:#b3d7ff87;";
}	

function clearMe()
{
		document.getElementById("height").value = '';
		document.getElementById("eColor").value = '';
		document.getElementById("eBrows").value = '';
		document.getElementById("hColor").value = '';
		document.getElementById("sColor").value = '';
}
function showFeatures()
{
	document.getElementById("height").value = "Medium";
	document.getElementById("eColor").value = "Hazel";
	document.getElementById("eBrows").value = "Separated";
	document.getElementById("hColor").value = "Black";
	document.getElementById("sColor").value = "Wheaten";
}

//Bring subparts
function bringinout()
{  
	var cin = $("#cin").val();
	if(cin!='')
	{		
		var formData = $("#form1").serialize(); 
		$.ajax({
			 type: 'post',
			 url: "<?=base_url('codeigniter/public/cinoutsave')?>",
			 data: formData,
			 success: function(result) {
				$("#dailycsub").empty(); 
				$("#dailycsub").append(result);
				$("#cin").val("");
			  }
			});
	}
	else
	{
		alert("CIN Field is empty my friend!");
	}		
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