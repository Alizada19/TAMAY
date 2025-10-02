<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
    <link href="<?=base_url('codeigniter/public/')?>css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?=base_url('codeigniter/public/')?>css/temp/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?=base_url('codeigniter/public/')?>css/w3school.css">
	<link rel="stylesheet" href="<?=base_url('codeigniter/public/')?>css/onlyCalender.css">
	<script type="text/javascript" src="<?=base_url('codeigniter/public/')?>js/jq.js"></script>
	<style type="text/css">

	table, th, td {
	  border: 1px solid blue;
	}
	</style>
</head>
<body style="margin:0px 0px 0px 0px; font-family:'Sans-Serif'">
<?php $this->session = \Config\Services::session();?>

<div  class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar" onclick="w3_close()">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  <a href="<?=base_url('codeigniter/public/expenses/add')?>" target="_blank" class="w3-bar-item w3-button">Add Expense</a>
  <a href="<?=base_url('codeigniter/public/expenses/groupeAdd')?>" target="_blank" class="w3-bar-item w3-button">Add Groupe</a>
  <a href="<?=base_url('codeigniter/public/expenses/categoryAdd')?>" target="_blank" class="w3-bar-item w3-button">Add Category</a>
  <a href="<?=base_url('codeigniter/public/expenses/subcategoryAdd')?>" target="_blank" class="w3-bar-item w3-button">Add Subcategory</a>
  
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
				<h6><a href="<?=base_url('codeigniter/public/login')?>" title="Logout" style="text-decoration:none;color: inherit;">Logout</a></h6>
			</div>
		</div>
	  </div>
	</div>
	<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
		<div style="margin:5px 5px 5px 5px;">
			<div style="display:inline-block;">
				<img src="<?=base_url('codeigniter/public/')?>images/republic.png" style="width:90px; height:90px;" alt="Groom">
				<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
			</div>
			
		</div>
		<!--end of header-->