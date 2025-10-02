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
	.phover:hover{
	  background-color: #b3d7ff87;
	}
	</style>
</head>
<body style="margin:0px 0px 0px 0px;font-family:'Sans-serif'">
<?php $this->session = \Config\Services::session();?>
<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  
  <a href="<?=base_url('codeigniter/public/').'cdbtorsAdd'?>" target="_blank" onclick="w3_close()" class="w3-bar-item w3-button">Add Invoice</a>
  <a href="<?=base_url('codeigniter/public/').'cdbtorsAddPay'?>" target="_blank" onclick="w3_close()" class="w3-bar-item w3-button">Payment Invoice</a>
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
	<div style="margin:5px 5px 5px 5px;">
		<div style="display:inline-block;float:left;width:40%;">
			<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
			<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
		</div>
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Tamay</h4>
			<h4>Balance Sheet</h4>
			
			
		</div>
		<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
			<h5>Today: <?=date('d/m/Y')?></h5>
			
		</div>
	</div>
	<!-- Filter Search-->
	<div>
		<form id="form1" method="post" action="<?=base_url('codeigniter/public/dbcsearch')?>">
			<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				<tr>
					<td colspan="" style="width:2%;background-color:#b3d7ff87;">
						<select style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="type" name="type"  tabindex="107" onChange="searchFilter();">
							<option value="">Filter By Type</option>
							<option value="1">Owner</option>
							<option value="2">Supplier</option>
							<option value="3">Third Party</option>
							<option value="4">Government</option>
							<option value="5">Old Outstanding</option>
							<option value="6">Services</option>
							<option value="">All</option>
						</select>
					  </td>
				</tr>
			</table>
		</form>
	</div>
	<div style="margin:5px 5px 5px 5px;">
		
		
		<div id="tblCon">
			<table style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
				<tr>
					<td colspan="6" align="center" style="width:100%;background-color:#4caf50;">All Debtors & Creditors</td>
				</tr>
				<tr>
					<td align="center" style="width:5%;background-color:#b3d7ff87;">Row</td>
					<td style="width:30%;background-color:#b3d7ff87;padding-left:5px;">D/C</td>
					<td style="width:20%;background-color:#b3d7ff87;padding-left:5px;">Type</td>
					<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;">Debit</td>
					<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;">Credit</td>
					<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;">Balance</td>
				</tr>
			<?php
			$i=1;
			$bal='';
			//echo "<pre />"; print_r($result); exit;
			foreach($result AS $row)
			{
				
				
						
			?>
				<tr class="phover" style=" cursor: pointer;" title='Click To See Details' onclick="window.open('<?=base_url('codeigniter/public/cdbtorsList/')?><?=$row->dbc?>', '_blank');">
					<td align="center" style="width:5%"><?=$i?></td>
					<td style="width:20%;padding-left:5px;"><?=getdbc($row->dbc)?></td>
					<td style="width:20%;padding-left:5px;"><?=dbcType($row->type)?></td>
					<td style="width:15%;padding-left:5px;">
						<?='RM '.number_format(round($row->damount, 2), 2)?>
					</td>
					<td style="width:15%;padding-left:5px;">
						<?='RM '.number_format(round($row->camount, 2), 2)?>
					</td>
					<td style="width:15%;padding-left:5px;">
						<?php
							echo 'RM '.number_format(round($row->damount - $row->camount, 2), 2);
						?>
					</td>
				</tr>
				
			<?php
				$i++;
			}
			?>
			<tr>
				<td align="center" colspan="3" style="width:10%;background-color:#b3d7ff87;font-weight:bold;">Total</td>
				<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;"><?='RM '.number_format(round($dbcTotal->damount, 2), 2)?></td>
				<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;"><?='RM '.number_format(round($dbcTotal->camount, 2), 2)?></td>
				<td style="width:10%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;">
				<?php
					echo 'RM '.number_format(round($dbcTotal->damount - $dbcTotal->camount, 2), 2);
				?>
				</td>
			</tr>	
			</table>
			<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
			   <a style="" title="Export PDF" href="<?=base_url('codeigniter/public/printpdfbal')?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
			</div>
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
		var formData = $("#form1").serialize(); 
		$.ajax({
					 type: 'post',
					 url: "<?=base_url('codeigniter/public/dbcsearch')?>",
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