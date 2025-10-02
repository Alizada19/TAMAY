<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>TAMAY GROUP NIGHTLY SALES REPORT</title>
    <link href="<?=base_url('codeigniter/public/')?>css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="<?=base_url('codeigniter/public/')?>js/jq.js"></script>
	<style type="text/css">

	table, th, td {
	  border: 1px solid blue;
	}
	</style>
</head>
<body style="margin:0px 0px 0px 0px;overflow: auto;">
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
<form id="form2" method="post" action="<?=base_url('codeigniter/public/updatedRecord/')?><?=$Id?>">	
	<div style="margin:5px 5px 5px 5px;">
		<div style="display:inline-block;float:left;width:40%;">
			<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
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
			<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
				<select style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="shname" name="shname"  tabindex="1005" required>
					<option value="">Please Select The Shop</option>
					<?php
						if($sname == 'bergaya' OR $sname == 'Admin')
						{
							if($query->shop == 1)
							{
								?>
								<!--<option value="1" selected>Buy And Save</option>-->
								<?php
							}
							else	
							{		
					?>
					<!--<option value="1">Buy And Save</option>-->
					<?php
							}
						}
					?>
					<?php
						if($sname == 'tamay' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC' OR $sname == 'GLCA')
						{	
							if($query->shop == 2)
							{
								?>
								<option value="2" selected>Gilasco</option>
								<?php
							}
							else	
							{
					?>
					<option value="2">Gilasco</option>
					<?php
							}
						}
					?>
					<?php
						if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC' OR $sname == 'ESICIO')
						{	
							if($query->shop == 3)
							{
								?>
								<option value="3" selected>ESI</option>
								<?php
							}
							else	
							{
					?>
					<option value="3">ESI</option>
					<?php
							}
						}
					?>
					<?php
						if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC' OR $sname == 'ESWCIO')
						{	
							if($query->shop == 4)
							{
								?>
								<option value="4" selected>ESW</option>
								<?php
							}
							else	
							{
					?>
					<option value="4">ESW</option>
					<?php
							}
						}
					?>
					<?php
						if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC' OR $sname == 'JQ')
						{
							if($query->shop == 5)
							{
								?>
								<option value="5" selected>Johoni-Q</option>
								<?php
							}
							else	
							{
					?>
					
					<option value="5">Johoni-Q</option>
					<?php
							}
						}
					?>
					<?php /*
						if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC')
						{
							if($query->shop == 7)
							{
								?>
								<option value="7" selected>Johoni-2</option>
								<?php
							}
							else	
							{
					?>
					
					<option value="7">Johoni-2</option>
					<?php
							}
						} */
					?>
					<?php
						if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid' OR $sname == 'ACC' OR $sname == 'E66A' OR $sname == 'E66AA')
						{	
							if($query->shop == 6)
							{
								?>
								<option value="6" selected>Eden 66A</option>
								<?php
							}
							else	
							{
					?>
					<option value="6">E66A</option>
					<?php
							}
						}
					?>
					<?php
						if($sname == 'eden' OR $sname == 'Admin' OR $sname == 'Valid')
						{	
							if($query->shop == 11)
							{
								?>
								<option value="11" selected>Johoni Scent JB</option>
								<?php
							}
							else	
							{
					?>
								<option value="11">Johoni Scent JB</option>
					<?php
							}
						}
					?>
					<?php
						if($sname == 'Admin' OR $sname == 'Valid')
						{	
							if($query->shop == 12)
							{
								?>
								<option value="12" selected>Gilasco Chocolate JB</option>
								<?php
							}
							else	
							{
					?>
								<option value="12">Gilasco Chocolate JB</option>
					<?php
							}
						}
					?>
				</select>
			</td>
		  </tr>
		  <!--<tr>
			 <td style="width:10%;background-color:#b3d7ff87;">Shop:</td>
		     <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;"><?=bname($query->shop)?></td>
			 
		  </tr>-->
		  <tr>
			 <td style="width:10%;background-color:#b3d7ff87;">Date:</td>
		     <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="sdate" id="sdate" type="date" onblur="makeCapital(this.value,'sdate')" value="<?=$query->sdate?>" required /></td>
		  </tr>
		   <tr>
			  <td style="width:10%;background-color:#b3d7ff87;">Total Sales:</td>
			  <td colspan="3" style="width:30%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="tsales" id="tsales"  type="text" placeholder="RM 0" value="<?=$query->tsales?>" onblur="makeCapital(this.value,'tsales')"/></td>
		  </tr>
		  <tr>
			  <td style="width:12%;background-color:#b3d7ff87;">Card:</td>
			  <td colspan="3" style="width:30%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="scard" id="scard"  type="text" placeholder="RM 0" value="<?=$query->scard?>" onblur="makeCapital(this.value,'scard'); getTotal()"/></td>
		  </tr>
		  <tr>
			  <td style="width:12%;background-color:#b3d7ff87;">Cash:</td>
			  <td colspan="3" style="width:30%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="scash" id="scash"  type="text" placeholder="RM 0" value="<?=$query->scash?>" onblur="makeCapital(this.value,'scash')"/></td>  
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
					<select style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="etype" name="etype" onchange="bringExp2(this.value)" tabindex="1007">
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
		</table>
	</div>	
	<div>
		  <table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			  <?php 
			  $i=1;
			  foreach($sub1 AS $pro)
			  {
					
				?> 
			  	
			  <tr id="<?=$pro->Id?>">
				 <td style="width:12%;background-color:#b3d7ff87;">Target:</td>
					<td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$pro->sub1?>" name="1sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="1subh[]" id="<?=$i?>subh[]" value="<?=$pro->Id?>">
				 </td>
				 <td style="width:12%;background-color:#b3d7ff87; cursor:pointer;" onclick="removeMe(<?=$pro->Id?>)">Remove</td>
			  </tr>
			  
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub2
			  $i=1;
			  foreach($sub2 AS $st)
			  {
				?>  
			  <tr id="<?=$st->Id?>">
				 <td style="width:12%;background-color:#b3d7ff87;">Commission:</td>
				 <!--<td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;">RM </td>-->
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$st->sub2?>" name="2sub[]" id="<?=$i?>
					sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="2subh[]" id="<?=$i?>subh[]" value="<?=$st->Id?>">
				 </td>
				 <td style="width:12%;background-color:#b3d7ff87; cursor:pointer;" onclick="removeMe(<?=$st->Id?>)">Remove</td>
			  </tr>
			  <?php
			  $i++;
			  }
			  ?>
			  <?php
			  //sub3
			  foreach($sub3 AS $ts)
			  {
				?>  
			  <tr id="<?=$ts->Id?>">
				 <td style="width:12%;background-color:#b3d7ff87;">Transport:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$ts->sub3?>" name="3sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="3subh[]" id="<?=$i?>subh[]" value="<?=$ts->Id?>">
				 </td>
				 <td style="width:12%;background-color:#b3d7ff87; cursor:pointer;" onclick="removeMe(<?=$ts->Id?>)">Remove</td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub4
			  foreach($sub4 AS $cs)
			  {
				?>  
			  	
			  <tr id="<?=$cs->Id?>">
				 <td style="width:12%;background-color:#b3d7ff87;">Voucher:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$cs->sub4?>" name="4sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="4subh[]" id="<?=$i?>subh[]" value="<?=$cs->Id?>">
				 </td>
				 <td style="width:12%;background-color:#b3d7ff87; cursor:pointer;" onclick="removeMe(<?=$cs->Id?>)">Remove</td>
			  </tr>
			  
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub5
			  foreach($sub5 AS $ad)
			  {
				?>  
			  <tr id="<?=$ad->Id?>">
				 <td style="width:12%;background-color:#b3d7ff87;">Advance:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$ad->sub5?>" name="5sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="5subh[]" id="<?=$i?>subh[]" value="<?=$ad->Id?>">
				 </td>
				 <td style="width:12%;background-color:#b3d7ff87; cursor:pointer;" onclick="removeMe(<?=$ad->Id?>)">Remove</td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub6
			  foreach($sub6 AS $rf)
			  {
				?>  
			  <tr id="<?=$rf->Id?>">
				 <td style="width:12%;background-color:#b3d7ff87;">Utility:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$rf->sub6?>" name="6sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="6subh[]" id="<?=$i?>subh[]" value="<?=$rf->Id?>">
				 </td>
				 <td style="width:12%;background-color:#b3d7ff87; cursor:pointer;" onclick="removeMe(<?=$rf->Id?>)">Remove</td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub7
			  foreach($sub7 AS $mc)
			  {
				?>  
			  <tr id="<?=$mc->Id?>">
				 <td style="width:12%;background-color:#b3d7ff87;">Other:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$mc->sub7?>" name="7sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="7subh[]" id="<?=$i?>subh[]" value="<?=$mc->Id?>">
				 </td>
				 <td style="width:12%;background-color:#b3d7ff87; cursor:pointer;" onclick="removeMe(<?=$mc->Id?>)">Remove</td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub8
			  foreach($sub8 AS $mte)
			  {
				?>  
			  <tr id="<?=$mte->Id?>">
				 <td style="width:12%;background-color:#b3d7ff87;">Promoter:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$mte->sub8?>" name="8sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="8subh[]" id="<?=$i?>subh[]" value="<?=$mte->Id?>">
					 <td style="width:12%;background-color:#b3d7ff87; cursor:pointer;" onclick="removeMe(<?=$mte->Id?>)">Remove</td>
				 </td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub9
			  /*foreach($sub9 AS $had)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Hamid Advance:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$had->sub9?>" name="<?=$i?>sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="<?=$i?>subh[]" id="<?=$i?>subh[]" value="<?=$had->Id?>">
				 </td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub10
			  foreach($sub10 AS $vo)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Voucher:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$vo->sub10?>" name="<?=$i?>sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="<?=$i?>subh[]" id="<?=$i?>subh[]" value="<?=$vo->Id?>">
				 </td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub11
			  foreach($sub11 AS $util)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Utilities:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$util->sub11?>" name="<?=$i?>sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="<?=$i?>subh[]" id="<?=$i?>subh[]" value="<?=$util->Id?>">
				 </td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  <?php
			  //sub12
			  foreach($sub12 AS $she)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">sherin Asal:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$she->sub12?>" name="<?=$i?>sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="<?=$i?>subh[]" id="<?=$i?>subh[]" value="<?=$she->Id?>">
				 </td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			   <?php
			  //sub13
			  foreach($sub13 AS $oth)
			  {
				?>  
			  <tr>
				 <td style="width:12%;background-color:#b3d7ff87;">Other:</td>
				 <td style="width:26%;"> 
					<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" value="<?=$oth->sub13?>" name="<?=$i?>sub[]" id="<?=$i?>sub" type="text" onblur="getexpenses()"; />
					<input type="text" hidden=hidden name="<?=$i?>subh[]" id="<?=$i?>subh[]" value="<?=$oth->Id?>">
				 </td>
			  </tr>
			  <?php
			  }*/
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
			<td style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="texpens" id="texpens" value="<?=$query->texpens?>" type="text" onblur="makeCapital(this.value,'texpens'); netCash();"/></td>
			  
			  <td style="width:10%;background-color:#b3d7ff87;">Net Cash:</td>
			  <td style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="ncash" id="ncash" value="<?=$query->ncash?>" type="text" onblur="makeCapital(this.value,'ncash')"/></td>
		  </tr>
	</table>
    <table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
		  <tr>
			<td style="width:10%;background-color:#b3d7ff87;">Cashier Name:</td>
			  <td style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="cname" id="cname" value="<?=$query->cname?>" type="text" onblur="makeCapital(this.value,'cname')"/></td>
			  
			  <td style="width:10%;background-color:#b3d7ff87;">Receiver Name:</td>
			  <td style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="rname" id="rname" value="<?=$query->rname?>" type="text" onblur="makeCapital(this.value,'rname')"/></td> 
		  </tr>
	</table>		
	</div>
	<div>
		<input type="text" hidden=hidden name="sname" id="sname" value="<?=$query->shop?>">
	</div>
	<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
	   <input type="submit" name="btn_result"   style="width:200px;" class="btn btn-primary line" value="Update" onclick="getexpenses();getTotal();netCash();"/>
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
function bringExp2(value)
{  
		 $.ajax({
			     url: "<?=base_url('codeigniter/public/bringsub2')?>/"+value, 
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

//Remove Me
function removeMe(id)
{
	$.ajax({
			 url: "<?=base_url('codeigniter/public/removesub')?>/"+id, 
			 type: "POST",
			 //async: true,
			 success: function(result) {
				 if(result == 1)
				 {	 console.log('Updated');
					$("#"+id).remove(); 
				 }
				 else
				 {
					console.log('Not updated');
				 }		
			  }
			});
}	
</script>
</body>
</html>