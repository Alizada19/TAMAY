<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>Home</title>
    <link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>css/temp/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?=base_url()?>css/w3school.css">
	<script type="text/javascript" src="<?=base_url()?>js/jq.js"></script>
	<style type="text/css">

	table, th, td {
	  border: 1px solid blue;
	}
	

		.video-background {
		  position: absolute;
		  top: 0;
		  left: 0;
		  width: 100%;
		  height: 100%;
		  z-index: -1; /* Ensure the video stays in the background */
		}
		#background-video {
		  object-fit: cover;
		  width: 100%;
		  height: 100%;
		}
		
	</style>
</head>
<body style="margin:0px 0px 0px 0px; font-family:'Sans-Serif'">
<?php $this->session = \Config\Services::session();?>

<div  class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar" onclick="w3_close()">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  <a href="<?=base_url('expenses/add')?>" target="_blank" class="w3-bar-item w3-button">Add Expense</a>
  <a href="<?=base_url('expenses/groupeAdd')?>" target="_blank" class="w3-bar-item w3-button">Add Groupe</a>
  <a href="<?=base_url('expenses/categoryAdd')?>" target="_blank" class="w3-bar-item w3-button">Add Category</a>
  <a href="<?=base_url('expenses/subcategoryAdd')?>" target="_blank" class="w3-bar-item w3-button">Add Subcategory</a>
  
</div>

<div id="main">
	<!--Header-->
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
			<div style="display:inline-block;float:right;text-align:right; padding-top:30px;">
				<h5>Today: <?=date('Y-m-d')?></h5>
				
			</div>
		</div>
		<!--end of header-->
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Display Perfume</h4>
		</div>
		
		<div class="video-background">
			<video autoplay muted loop id="background-video">
			  <source src="<?=base_url()?>images/bg2.mp4" type="video/mp4">
			  Your browser does not support the video tag.
			</video>
		 </div>
		 
		<div>
			<img src="<?=base_url()?>images/perfumePlate.jpg" style="width:80%; height:80%;" alt="Groom">
		</div>	
		
</div>
</div><!--end of main-->	
<script>
function makeCapital(value, id)
{
	myString = value.toUpperCase();
	document.getElementById(id).value = myString;
	document.getElementById(id).style="background-color:#b3d7ff87;font-size:30px;font-weight:bold";
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