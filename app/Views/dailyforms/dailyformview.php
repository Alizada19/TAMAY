<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>TAMAY GROUP NIGHTLY SALES REPORT</title>
    <link href="<?=base_url('codeigniter/public/')?>css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?=base_url('codeigniter/public/')?>css/w3school.css">
	<script type="text/javascript" src="<?=base_url('codeigniter/public/')?>js/jq.js"></script>
	<style type="text/css">

	table, th, td {
	  border: 1px solid blue;
	}
	</style>
</head>
<body style="margin:0px 0px 0px 0px;overflow: auto;">
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
		<h6>Username: <?=$username?> </h6>
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
			<h4>Nightly Sales Report Form</h4>
			
		</div>
		<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
			<h5>Today: <?=date('d/m/Y')?></h5>
			
		</div>
		<div style="display:inline-block;">
			<!-- Success Alert -->
			<?php
				if($success == 1)
				{	
			?>
			<div style="background-color:#b3d7ff87" class="alert  alert-dismissible d-flex align-items-center fade show ">
				
				<strong class="mx-2">Success!</strong> Your record has been saved successfully.
				
			</div>
			<?php
				}
			?>
		</div>
	</div>
	<div style="width:100%" style="margin-right:1%;">
		<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
		  <tr>
			 <td style="width:10%;background-color:#b3d7ff87;">Shop:</td>
		     <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;"><?=bname($query->shop)?></td>
		  </tr>
		  <tr>
			 <td style="width:10%;background-color:#b3d7ff87;">Date:</td>
		     <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;"><?=date_format(date_create($query->sdate), 'd/m/Y')?></td>
		  </tr>
		  <tr>
			  <td style="width:10%;background-color:#b3d7ff87;">Total Sales:</td>
			 <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$query->tsales?></td>
		  </tr>
		  <tr>
			  <td style="width:12%;background-color:#b3d7ff87;">Card:</td>
			  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$query->scard?></td>
		  </tr>
		  <tr>
			  <td style="width:12%;background-color:#b3d7ff87;">Cash:</td>
			  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$query->scash?></td> 
		  </tr>
		</table>
	</div>	
    <div style="background-color:#ff5d0f7a;width:100%;clear:both; border: 1px solid blue;text-align:center;font-weight:bold;font-size:20px;">
	  EXPENSES
    </div>
	<div>
		  <table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			  <?php 
			  foreach($sub1 AS $pro)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Target:</td>
				 <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$pro->sub1?></td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub2
			  foreach($sub2 AS $st)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Commission:</td>
				 <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$st->sub2?></td>
			  </tr>
			  <?php
			  }
			  ?>
			  <?php
			  //sub3
			  foreach($sub3 AS $ts)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Transport:</td>
				 <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$ts->sub3?></td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub4
			  foreach($sub4 AS $cs)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Vourcher:</td>
				 <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$cs->sub4?></td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub5
			  foreach($sub5 AS $ad)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Advance:</td>
				 <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$ad->sub5?></td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub6
			  foreach($sub6 AS $rf)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Utility:</td>
				 <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$rf->sub6?></td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub7
			  foreach($sub7 AS $mc)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Other:</td>
				 <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$mc->sub7?></td>
			  </tr>
			  <?php
			  }
			  ?>
			   <?php
			  //sub8
			  foreach($sub8 AS $mc)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Promoter:</td>
				 <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$mc->sub8?></td>
			  </tr>
			  <?php
			  }
			  ?>
			  
		  </div>
		  
		 <!-- <tr>
			  <td style="width:12%;background-color:#b3d7ff87;">Amount:</td>
			  <td colspan="3" style="width:30%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="eamount" id="eamount"  type="text" placeholder="RM 0" onblur="makeCapital(this.value,'eamount')"/></td> 
		  </tr>-->
		</table>
	</div>
	<div>
		<table id="exsub" style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
		
		</table>
	</div>
	<div>
	<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
		  <tr>
			<td style="width:10%;background-color:#b3d7ff87;">Total Expenses:</td>
			 <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$query->texpens?></td> 
			  
			  <td style="width:10%;background-color:#b3d7ff87;">Net Cash:</td>
			  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM <?=$query->ncash?></td> 
		  </tr>
	</table>
    <table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
		  <tr>
			<td style="width:10%;background-color:#b3d7ff87;">Cashier Name:</td>
			  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;"><?=$query->cname?></td> 
			  
			  <td style="width:10%;background-color:#b3d7ff87;">Receiver Name:</td>
			  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;"><?=$query->rname?></td> 
		  </tr>
	</table>		
	</div>
	<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
	   <a title="Update Current Record" href="<?=base_url('codeigniter/public/dailyformUpdate/')?><?=$query->Id?>"><input type="button" name="btn_result" style="width:200px;" class="btn btn-primary line" value="Update Record" /></a>
	   <a style="margin-left:20px;" title="Update Current Record" href="<?=base_url('codeigniter/public/printpdf/')?><?=$query->Id?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
	</div>
</div>
<script>
function makeCapital(value, id)
{
	myString = value.charAt(0).toUpperCase() + value.slice(1);
	document.getElementById(id).value = myString;
	document.getElementById(id).style="background-color:#b3d7ff87;font-size:30px;font-weight:bold";
}
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
function bringExp(value)
{  
		 $.ajax({
			     url: "<?=base_url('codeigniter/public/bringsub')?>/"+value, 
				 //type: "POST",
				 //async: true,
                 success: function(result) {
					 //console.log(result);
					//$("#exsub").empty(); 
                    $("#exsub").append(result);
                    //$("#dId").css('width':'100%');
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