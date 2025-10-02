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
  <a href="<?=base_url('codeigniter/public/').'dailySalesReportList'?>" target="_blank" class="w3-bar-item w3-button">List Daily Report</a>
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
	<form id="form1" method="post" action="<?=base_url('codeigniter/public/')?>dailyformAdd">
	
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
			<h5>Today: <?=date('Y-m-d')?></h5>
			
		</div>
	</div>
	<div style="width:100%" style="margin-right:1%;">
		<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
		  <tr>
			<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
				<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="shname" name="shname"  tabindex="1005" required>
					<option value="">Please Select The Shop</option>
					<?php
						if($sname == 'bergaya' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC')
						{	
					?>
					<!--<option value="1">Buy And Save</option>-->
					<?php
						}
					?>
					<?php
						if($sname == 'tamay' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC' OR $sname == 'GLCA')
						{	
					?>
					<option value="2">Gilasco</option>
					<?php
						}
					?>
					<?php
						if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC' OR $sname == 'ESICIO')
						{	
					?>
					<option value="3">ESI</option>
					<?php
						}
					?>
					<?php
						if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC' OR $sname == 'ESWCIO')
						{	
					?>
					<option value="4">ESW</option>
					<?php
						}
					?>
					<?php
						if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC' OR $sname == 'JQ')
						{	
					?>
					<option value="5">Johoni-Q</option>
					<?php
						}
					?>
					<?php
						/*if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC')
						{	
					?>
					<option value="7">Johoni-2</option>
					<?php
						} */
					?>
					<?php
						if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC' OR $sname == 'E66A' OR $sname == 'E66AA')
						{	
					?>
					<option value="6">E66A</option>
					<?php
						}
					?>
					<?php
						if($shop == 10 OR $sname == 'Valid')
						{	
					?>
							<option value="10">ME Perfume</option>
					<?php
						}
					?>
					<?php
						if($shop == 11 OR $sname == 'Valid')
						{	
					?>
							<option value="11">Johoni Scent JB</option>
					<?php
						}
					?>
					<?php
						if($shop == 12 OR $sname == 'Valid')
						{	
					?>
							<option value="12">Gilasco Chocolate JB</option>
					<?php
						}
					?>
				</select>
			</td>
		  </tr>
		  <tr>
			 <td style="width:10%;background-color:#b3d7ff87;">Date:</td>
		     <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="sdate" id="sdate" type="date" onblur="makeCapital(this.value,'sdate')" required /></td>
		  </tr>
		  <tr>
			  <td style="width:10%;background-color:#b3d7ff87;">Total Sales:</td>
			  <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="tsales" id="tsales" type="text" placeholder="RM 0" onblur="makeCapital(this.value,'tsales')" required /></td>
		  </tr>
		  <tr>
			  <td style="width:12%;background-color:#b3d7ff87;">Card:</td>
			  <td colspan="3" style="width:30%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="scard" id="scard"  type="text" placeholder="RM 0" onblur="makeCapital(this.value,'scard'); getTotal()" required /></td> 
		  </tr>
		  <tr>
			  <td style="width:12%;background-color:#b3d7ff87;">Cash:</td>
			  <td colspan="3" style="width:30%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="scash" id="scash"  type="text" placeholder="RM 0" onblur="makeCapital(this.value,'scash')" required /></td> 
		  </tr>
		</table>
	</div>	
    <div style="background-color:#ff5d0f7a;width:100%;clear:both; border: 1px solid blue;text-align:center;font-weight:bold;font-size:20px;">
	  EXPENSES
    </div>
	<div>
		  <table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			  <tr>
				  <td colspan="4" style="width:100%;background-color:#b3d7ff87;">
					<select style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="etype" name="etype" onchange="bringExp(this.value)" tabindex="1007">
						<option value="">Please Select The Type of Expenses</option>
						<option value="1">Target</option>
						<option value="2">Commission</option>
						<option value="8">Promoter</option>
						<option value="3">Transport</option>
						<option value="4">Voucher</option>
						<option value="5">Advance</option>
						<option value="6">Utility</option>
						<option value="7">Other</option>
					</select>
				  </td>
			  </tr>
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
			  <td style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="texpens" id="texpens" type="text" onblur="makeCapital(this.value,'texpens'); netCash();" /></td>
			  
			  <td style="width:10%;background-color:#b3d7ff87;">Net Cash:</td>
			  <td style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="ncash" id="ncash" type="text" onblur="makeCapital(this.value,'ncash')" required /></td>
		  </tr>
	</table>
    <table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
		  <tr>
			<td style="width:10%;background-color:#b3d7ff87;">Cashier Name:</td>
			  <td style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="cname" id="cname" type="text" onblur="makeCapital(this.value,'cname')" /></td>
			  
			  <td style="width:10%;background-color:#b3d7ff87;">Receiver Name:</td>
			  <td style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="rname" id="rname" type="text" onblur="makeCapital(this.value,'rname')" /></td>
		  </tr>
	</table>		
	</div>
	
	
	<!--
	<div id="rel2" style="width:100%;margin-top:30px;">
	 <div style="float:left;">
		<div style="float:left; border: 2px solid;margin:2px 2px 2px 2px;padding-right:2px;padding-left:2px;">
			<span style="display:block;">Ruling authority, age</span>
			<textarea name="o11" style="height:150px;width:250px;margin: border:none; margin: 2px 2px 2px 2px; font-size:15px;">Duplicated
Based on ruling 15079 dated 23/12/2022 of authority age corrected and distributed in absence.
			</textarea>
			<input class="form-control" style="font-weight:bold;font-size:20px;" name="oo" value="o1" type="radio" tabindex="" />
		</div>
		<div style="float:left; border: 2px solid;margin:2px 2px 2px 2px;padding-right:2px;padding-left:2px;">
			<span style="display:block;">Ruling  authority</span>
			<textarea name="o22" style="height:150px;width:250px;margin: border:none; margin: 2px 2px 2px 2px; font-size:15px;">Duplicated
Based on ruling no. 22543 dated 28/12/2022 of authority surname inserted in absence.
			</textarea>
			<input class="form-control" style="font-weight:bold;font-size:20px;" name="oo" value="o2" type="radio" tabindex="" />
		</div>
		<div style="float:left; border: 2px solid;margin:2px 2px 2px 2px;padding-right:2px;padding-left:2px;">
			<span style="display:block;font-size:15px; font-weight:bold;">Ruling National authority, Age & <br>Surname</span>
			<textarea name="o33" style="height:140px;width:250px;margin: border:none; margin: 2px 2px 2px 2px; font-size:15px;">Based on ruling no. 12417 dated on 29/11/2022 of national authority age corrected and surname inserted in
absence.
			</textarea>
			<input class="form-control" style="font-weight:bold;font-size:20px;" name="oo" value="o3" type="radio" tabindex="" />
		</div>
		<div style="float:left; border: 2px solid;margin:2px 2px 2px 2px;padding-right:2px;padding-left:2px;">
			<span style="display:block;">Ruling of NSIA, Age</span>
			<textarea name="o44" style="height:150px;width:250px;margin: border:none; margin: 2px 2px 2px 2px; font-size:15px;">Based on ruling of National Statistics and information authority Age corrected to 20 years old in 2022 and ID issued in absence.
			</textarea>
			<input class="form-control" style="font-weight:bold;font-size:20px;" name="oo" value="o4" type="radio" tabindex="" />
		</div>
		<div style="float:left; border: 2px solid;margin:2px 2px 2px 2px;padding-right:2px;padding-left:2px;">
			<span style="display:block;font-size:15px; font-weight:bold;">Ruling NSIA, Age, Surname, received</span>
			<textarea name="o55" style="height:190px;width:250px;margin: border:none; margin: 2px 2px 2px 2px; font-size:15px;">Based on ruling dated on 06/12/2022 of National Statistics and Information Authority age corrected in absence and also, surname “Safi” has been added.
His father “Allah Mohammad” received.
			</textarea>
			<input class="form-control" style="font-weight:bold;font-size:20px;" name="oo" value="o5" type="radio" tabindex="" />
		</div>
		<div style="float:left; border: 2px solid;margin:2px 2px 2px 2px;padding-right:2px;padding-left:2px;">
			<span style="display:block;font-weight:bold;font-size:20px;">Letter, civil Registration, Age</span>
			<textarea name="o66" style="height:180px;width:250px;margin: border:none; margin: 2px 2px 2px 2px; font-size:15px;">Based on letter no. (14539/14309), dated: 04/12/2022 of civil registration directorate, Age corrected 
			</textarea>
			<input class="form-control" style="font-weight:bold;font-size:20px;" name="oo" value="o6" type="radio" tabindex="" />
		</div>
		<div style="float:left; border: 2px solid;margin:2px 2px 2px 2px;padding-right:2px;padding-left:2px;">
			<span style="display:block;">None</span>
			<input class="form-control" style="font-weight:bold;font-size:20px;" name="oo" value="none" type="radio" checked="checked" tabindex="" />
		</div>
	 </div>
	</div> -->
	<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
	   <input type="submit" name="btn_result"   style="width:200px;" class="btn btn-primary line" value="Save" onclick="getexpenses();getTotal();netCash();"/>
	</div>
	</form>
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

//Get total Sales
function getTotal()
{
	var stotal = $("#tsales").val();
	var scard = $("#scard").val();
	var total;
	if(stotal == '')
	{
		total = 0;
	}
	if(stotal == '')
	{   
		total = 0;
	}	
	total = parseFloat(stotal) - parseFloat(scard);
	$("#scash").val(total);
}	

// Net Cash
function netCash()
{
	var scash = $("#scash").val();
	var texpens = $("#texpens").val();
	var total;
	if(scash == '')
	{
		scash = 0;
	}
	if(texpens == '')
	{   
		texpens = 0;
	}	
	total = parseFloat(scash) - parseFloat(texpens);
	console.log(total);
	$("#ncash").val(total); 
	
}

// expenses	
function getexpenses()
{
	var inputs = $(".subdata");
	var total = 0;
	for(var i = 0; i < inputs.length; i++){
		total += parseFloat($(inputs[i]).val());
	}
	$("#texpens").val(total);
}	

//Get total Sales
function getTotal()
{
	var stotal = $("#tsales").val();
	var scard = $("#scard").val();
	var total;
	if(stotal == '')
	{
		total = 0;
	}
	if(stotal == '')
	{   
		total = 0;
	}	
	total = parseFloat(stotal) - parseFloat(scard);
	$("#scash").val(total);
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