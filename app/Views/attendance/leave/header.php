<!DOCTYPE html>
<html lang="en" style=>
<head>
	<meta charset="utf-8">
	<title>Tamay</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="<?=base_url('codeigniter/public/')?>css/w3school.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<style>
        .custom-table {
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .custom-table th {
            background-color: #007bff !important;
            color: white;
            font-size: 18px;
            text-transform: uppercase;
            padding: 12px;
        }
        .custom-table td {
            padding: 10px;
        }
        .form-control, .form-select {
            border-radius: 6px;
            font-size: 14px;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .submit-btn {
            display: flex;
            justify-content: center;
            margin-top: 15px;
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