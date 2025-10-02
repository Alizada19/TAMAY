<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>Edit Form</title>
    <link href="<?=base_url('codeigniter/public/')?>css/bootstrap.min.css" rel="stylesheet" />
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
  
  <a href="<?=base_url('codeigniter/public/').'cdbtorsMainList'?>" target="_blank" class="w3-bar-item w3-button">List Records</a>

</div>

<div id="main">

<div class="w3-teal">
  <div class="w3-container">
    <div style=" ">
		<div style="display:inline-block; margin-top:0px; font-size:20px;">
		<h6>Username: </h6>
		</div>
		<div style="display:inline-block; margin-top:0px; font-size:20px; float:right;">
			<h6><a href="<?=base_url('codeigniter/public/login')?>" title="Logout" style="text-decoration:none;color: inherit;">Logout</a></h6>
		</div>
		
	</div>
	
  </div>
</div>
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
	<form id="form1" method="post" action="<?=base_url('codeigniter/public/')?>cdbtorsUpdatePay/<?=$query->Id?>">
	
	<div style="margin:5px 5px 5px 5px;">
		<div style="display:inline-block;float:left;width:40%;">
			<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
			<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
		</div>
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Tamay</h4>
			<h4>Edit Payment Invoice</h4>
			
			
		</div>
		<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
			<h5>Today: <?=date('d/m/Y')?></h5>
			
		</div>
	</div>
	<div style="width:100%" style="margin-right:1%;">
		<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
		  <tr>
			 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Date:</td>
		     <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="ddate" id="ddate" type="date" placeholder="dd/mm/YY" value="<?=$query->ddate?>" onblur="" required /></td>
		  </tr>
		  <tr>
			  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Invoice No:</td>
			  <td colspan="3" style="width:30%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="dinvNo" id="dinvNo"  type="text" placeholder="No" value="<?=$query->dinvNo?>" onblur="" /></td> 
		  </tr>
		  <tr>
			  <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Reference:</td>
			  <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="ddescrip" id="ddescrip" type="text" placeholder="Text" value="<?=$query->ddescrip?>" onblur="" required /></td>
		  </tr>
		  <tr>
			  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Amount:</td>
			  <td colspan="3" style="width:30%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="camount" id="camount"  type="text" placeholder="RM 0" onblur="" value="<?=$query->camount?>" required /></td> 
		  </tr>
		  <tr>
			    <tr>
					<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="dbc" name="dbc"  tabindex="" required>
							<option value="">Select Name</option>
							<?=$str?>											
						</select>
					</td>
				</tr>
		  </tr>
		</table>	
   
	<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
	   <input type="submit" name="btn_result"   style="width:200px;" class="btn btn-primary line" value="Update" />
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