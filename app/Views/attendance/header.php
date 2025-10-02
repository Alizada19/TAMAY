<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>User Dashboard</title>
	<link href="<?=base_url('codeigniter/public/')?>assets/css/bootstrap.css" rel="stylesheet" />
	<link href="<?=base_url('codeigniter/public/')?>css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url('codeigniter/public/')?>css/temp/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?=base_url('codeigniter/public/')?>css/w3school.css">
	<script type="text/javascript" src="<?=base_url('codeigniter/public/')?>js/jq.js"></script>
	<style type="text/css">

	table, th, td {
	  border: 1px solid blue;
	}
	
	.cbg{
		background-color:red;
		color:white;
		//padding: 5px 5px 5px 5px;
		border: 2px solid red;
		border-radius: 20px 20px;
	}
	.bghover:hover{
			background-color:blue;
			cursor:pointer;
			color:white;
	}	
	</style>
</head>
<body style="margin:0px 0px 0px 0px; font-family: 'Sans-Serif'">
<?php $this->session = \Config\Services::session();?>
<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  <?php 
  if($this->session->get('myRole') == 1 OR $this->session->get('myRole') == 3)
  {
  ?>
  <a href="<?=base_url('codeigniter/public/attendance/empList')?>" target="_blank" class="w3-bar-item w3-button">List Employees</a>
  <a href="<?=base_url('codeigniter/public/attendance/addemp')?>" target="_blank" class="w3-bar-item w3-button">Add Employee</a>
  <a href="<?=base_url('codeigniter/public/attendance/searchlayout')?>" target="_blank" class="w3-bar-item w3-button">Search Attendance</a>
  <a href="<?=base_url('codeigniter/public/attendance/reportLayout')?>" target="_blank" class="w3-bar-item w3-button">Attendance Report</a>
  <a href="<?=base_url('codeigniter/public/salary/salaryDashboard')?>" target="_blank" class="w3-bar-item w3-button">Calculate Salary</a>
  <a href="<?=base_url('codeigniter/public/attendance/leaveList')?>" target="_blank" class="w3-bar-item w3-button">Leave</a>
  <a href="<?=base_url('codeigniter/public/attendance/leaveAdd')?>" target="_blank" class="w3-bar-item w3-button">Add Leave</a>
  <a href="<?=base_url('codeigniter/public/salary/salaryList')?>" target="_blank" class="w3-bar-item w3-button">Salary List</a>
  <?php
  }
  ?>
</div>
<div id="main">

<div class="w3-teal">
  <div class="w3-container">
    <div style=" ">
		<div style="display:inline-block; margin-top:0px; font-size:20px;">
		<h6>Username:  <?php $this->session = \Config\Services::session(); echo $this->session->get('name');?></h6>
		</div>
		<div style="display:inline-block; margin-top:0px; font-size:20px; float:right;">
			<h6><a href="<?=base_url('codeigniter/public/login')?>" title="Logout" style="text-decoration:none;color: inherit;">Logout</a></h6>
		</div>
	</div>
  </div>
</div>
<div style="display:inline-block;float:left;width:35%;margin-left:10px;">
	<img src="<?=base_url('codeigniter/public/')?>images/timer.PNG" style="width:100px; height:90px;" alt="Groom">
	<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
</div>
<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;margin-bottom:50px;">
	<h2><?=$title?></h2>
</div>