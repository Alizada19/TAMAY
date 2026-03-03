
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title> 
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url()?>assets/materialize/css/materialize.min.css" media="screen,projection" />
    <!-- Bootstrap Styles-->
    <link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" />
	 <!--<link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet" />-->
    <!-- FontAwesome Styles-->
    <link href="<?=base_url()?>assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="<?=base_url()?>assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="<?=base_url()?>assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="<?=base_url()?>assets/js/Lightweight-Chart/cssCharts.css">
	<!--Charts-->
	<script type="text/javascript" src="<?=base_url('charts/code/highcharts.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('charts/code/modules/exporting.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('charts/code/modules/export-data.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('charts/code/modules/accessibility.js')?>"></script>
	
	<style type="text/css">
		@media only screen and (max-width: 600px) {
		  .myw {
			max-width: 90%; 
		  }
		  
		    .expenseChart{
					width:100%;
				}
				
			.expenseChart2{
					width:100% !important;
				}	
		}
		  
		  @media only screen and (min-width: 600px) {
			  .myw {
				max-width: 30%;
			  }
	
				.expenseChart{
					width:48%;
				}
				
				.expenseChart2{
					width:48%;
				}
				
				.myexpense {
					width: 50% !important;
				  }
			}
		#expenseFilter, select {
			display: block;
		}
		table tr:hover {
		  background-color: #f5f5f5; /* Light gray background on hover */
		  cursor: pointer; /* Optional: Change cursor to pointer */
		}
	</style>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" >
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle waves-effect waves-dark" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand waves-effect waves-dark" href="index.html"><i class="large material-icons">track_changes</i> <strong>Tamay</strong></a>
				
		<div id="sideNav" href="" ><i class="material-icons dp48">toc</i></div>
            </div>

            <ul class="nav navbar-top-links navbar-right"> 
				<li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown4"><i class="fa fa-envelope fa-fw"></i> <i class="material-icons right">arrow_drop_down</i></a></li>				
				<li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown3"><i class="fa fa-tasks fa-fw"></i> <i class="material-icons right">arrow_drop_down</i></a></li>
				<li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown2"><i class="fa fa-bell fa-fw"></i> <i class="material-icons right">arrow_drop_down</i></a></li>
				  <li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown1"><i class="fa fa-user fa-fw"></i> <b>Admin</b> <i class="material-icons right">arrow_drop_down</i></a></li>
            </ul>
        </nav>
		<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
<li><a href="#"><i class="fa fa-user fa-fw"></i> My Profile</a>
</li>
<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
</li> 
<li><a href="<?=base_url('/codeigniter/public/login')?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
</li>
</ul>
<ul id="dropdown2" class="dropdown-content w250">
  <li>
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
</ul>
<ul id="dropdown3" class="dropdown-content dropdown-tasks w250">
<li>
		<a href="#">
			<div>
				<p>
					<strong>Task 1</strong>
					<span class="pull-right text-muted">60% Complete</span>
				</p>
				<div class="progress progress-striped active">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
						<span class="sr-only">60% Complete (success)</span>
					</div>
				</div>
			</div>
		</a>
	</li>
	<li class="divider"></li>
	<li>
		<a href="#">
			<div>
				<p>
					<strong>Task 2</strong>
					<span class="pull-right text-muted">28% Complete</span>
				</p>
				<div class="progress progress-striped active">
					<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100" style="width: 28%">
						<span class="sr-only">28% Complete</span>
					</div>
				</div>
			</div>
		</a>
	</li>
	<li class="divider"></li>
	<li>
		<a href="#">
			<div>
				<p>
					<strong>Task 3</strong>
					<span class="pull-right text-muted">60% Complete</span>
				</p>
				<div class="progress progress-striped active">
					<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
						<span class="sr-only">60% Complete (warning)</span>
					</div>
				</div>
			</div>
		</a>
	</li>
	<li class="divider"></li>
	<li>
		<a href="#">
			<div>
				<p>
					<strong>Task 4</strong>
					<span class="pull-right text-muted">85% Complete</span>
				</p>
				<div class="progress progress-striped active">
					<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%">
						<span class="sr-only">85% Complete (danger)</span>
					</div>
				</div>
			</div>
		</a>
	</li>
	<li class="divider"></li>
	<li>
</ul>   
<ul id="dropdown4" class="dropdown-content dropdown-tasks w250 taskList">
  <li>
                                <div>
                                    <strong>John Doe</strong>
                                    <span class="pull-right text-muted">
                                        <em>Today</em>
                                    </span>
                                </div>
                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</p>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <p>Lorem Ipsum has been the industry's standard dummy text ever since an kwilnw...</p>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the...</p>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
</ul>  
	   <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu waves-effect waves-dark" href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
					<li>
                        <a href="<?=base_url('expenses/calender')?>" target="_blank" class="waves-effect waves-dark"><i class="fa fa-desktop"></i>Calender</a>
                    </li>
					<li>
                        <a href="<?=base_url('expenses/list')?>" target="_blank" class="waves-effect waves-dark"><i class="fa fa-desktop"></i>Expenses</a>
                    </li>
                    <li>
                        <a href="<?=base_url('expenses/groupeList')?>" target="_blank" class="waves-effect waves-dark"><i class="fa fa-desktop"></i>Groupes</a>
                    </li>
					<li>
                        <a href="<?=base_url('expenses/categoryList')?>" target="_blank" class="waves-effect waves-dark"><i class="fa fa-desktop"></i>Categories</a>
                    </li>
					<li>
                        <a href="<?=base_url('expenses/subcategoryList')?>" target="_blank" class="waves-effect waves-dark"><i class="fa fa-desktop"></i>Subcategories</a>
                    </li>
					<li>
                        <a href="<?=base_url('cinoutreport/home')?>" target="_blank" class="waves-effect waves-dark"><i class="fa fa-desktop"></i>Customer IN/OUT Report</a>
                    </li>
					<li>
                        <a href="<?=base_url('attendance/index')?>" target="_blank" class="waves-effect waves-dark"><i class="fa fa-desktop"></i>Attendance</a>
                    </li>
					<li>
                        <a href="<?=base_url('attendance/empList')?>" target="_blank" class="waves-effect waves-dark"><i class="fa fa-desktop"></i>Employees</a>
                    </li>
					<li>
                        <a href="<?=base_url('perfumes/home')?>" target="_blank" class="waves-effect waves-dark"><i class="fa fa-desktop"></i>Perfumes</a>
                    </li>
					<li>
                        <a href="<?=base_url('perfumes/display')?>" target="_blank" class="waves-effect waves-dark"><i class="fa fa-desktop"></i>Display Perfumes</a>
                    </li>
                    <li>
                        <a href="ui-elements.html" class="waves-effect waves-dark"><i class="fa fa-desktop"></i> UI Elements</a>
                    </li>
					<li>
                        <a href="chart.html" class="waves-effect waves-dark"><i class="fa fa-bar-chart-o"></i> Charts</a>
                    </li>
                    <li>
                        <a href="tab-panel.html" class="waves-effect waves-dark"><i class="fa fa-qrcode"></i> Tabs & Panels</a>
                    </li>
                    
                    <li>
                        <a href="table.html" class="waves-effect waves-dark"><i class="fa fa-table"></i> Responsive Tables</a>
                    </li>
                    <li>
                        <a href="form.html" class="waves-effect waves-dark"><i class="fa fa-edit"></i> Forms </a>
                    </li>


                    <li>
                        <a href="#" class="waves-effect waves-dark"><i class="fa fa-sitemap"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>

                                </ul>

                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="empty.html" class="waves-effect waves-dark"><i class="fa fa-fw fa-file"></i> Empty Page</a>
                    </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
      
		<div id="page-wrapper">
		  <div class="header"> 
                        <h1 class="page-header">
                            Dashboard
                        </h1>
						<ol class="breadcrumb">
					  <li><a href="#">Home</a></li>
					  <li class="active">Dashboard</li>
					 
					</ol> 
									
		</div>
            <div id="page-inner">

				<div class="row">
					<div class="panel panel-primary myw">
					  <div class="panel-heading">Funds Injection</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url('addFund')?>"><h3>Add Fund.</h3></a></div>
					</div>
					<div class="panel panel-primary myw">
					  <div class="panel-heading">Sales</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url().'dailyform/'?>"><h3>Add Report</h3></a></div>
					</div>
					
					<div class="panel panel-primary myw">
					  <div class="panel-heading">On Account/Cheque</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url().'payment'?>"><h3>Add On Account/Cheque</h3></a></div>
					</div>
					
					
					<div class="panel panel-primary myw">
					  <div class="panel-heading">Suppliers Form</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url().'debtorcreditor/2'?>"><h3>Add Supplier</h3></a></div>
					</div>
					
					<div class="panel panel-primary myw">
					  <div class="panel-heading">Today's Report</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url().'nightlyreport/'?>"><h3>Today's Sales Report</h3></a></div>
					</div>
					
					<div class="panel panel-primary myw">
					  <div class="panel-heading">Sales Report</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url().'sreport/'?>"><h3>Search Sales Report</h3></a></div>
					</div>
	 
                    <div class="panel panel-primary myw">
					  <div class="panel-heading">Cheque Report</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url().'chequereports/'?>"><h3>Cheque Report</h3></a></div>
					</div>
                
					<div class="panel panel-primary myw">
					  <div class="panel-heading">On Account Payment</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url().'ocashreports/'?>"><h3>On Account Payment</h3></a></div>
					</div>
					
					<div class="panel panel-primary myw">
					  <div class="panel-heading">Unscheduled Report</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url().'uncashreports/'?>"><h3>Unscheduled Report</h3></a></div>
					</div>
					
					<div class="panel panel-primary myw">
					  <div class="panel-heading">All Payment Report</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url().'apayments/'?>"><h3>All Payment Report</h3></a></div>
					</div>
					
					<div class="panel panel-primary myw">
					  <div class="panel-heading">Reports by Supplier</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url().'supReports/'?>"><h3>Reports by Suppliers</h3></a></div>
					</div>
					<!--<div class="panel panel-primary myw">
					  <div class="panel-heading">Reports by Suppliers</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?//=base_url().'pendingChequesCharts'?>"><h3>Pending Cheques for coming 10 days.</h3></a></div>
					</div> -->
					
					<div class="panel panel-primary myw">
					  <div class="panel-heading">Customers In/Out </div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url('cinoutmain')?>"><h3>Customers In/Out.</h3></a></div>
					</div>
					<div class="panel panel-primary myw">
					  <div class="panel-heading">D/C</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url('cdbtorsMainList')?>"><h3>All D/C.</h3></a></div>
					</div>
					<div class="panel panel-primary myw">
					  <div class="panel-heading">Stock Transfer</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?=base_url('stockList')?>"><h3>Stock transfered List.</h3></a></div>
					</div>
					<!--<div class="panel panel-primary myw">
					  <div class="panel-heading">New D/C</div>
					  <div class="panel-body"><a target='blank' style="text-decoration:none;" href="<?//=base_url('cdbtorsMainListNew')?>"><h3>New D/C.</h3></a></div>
					</div>-->
                </div>
				
				<!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
						<div class="card"><div class="card-action">
					  <a title="More Details" target='blank' style="text-decoration:none; color:#000;" href="<?=base_url().'pendingChequesCharts'?>">Pending payment of this month</a>
					</div>
					<div class="card-image">
					  <div class="collection">
					  <?php
						$bg=""; 
						//define start date
						//$cdate = date("Y-m-d");	
						foreach($cmonth AS $row)
						{
							$flag=0;
							foreach($mymonth AS $rec)
							{	
								  
								  if($row==$rec->dates)
								  {		
									  if($rec->tamount<=5000)
									  {
										$bg = 'green';
									  }
									  else if($rec->tamount<=10000)
									  {
										$bg = 'orange';	
									  }
									  else if($rec->tamount>10000)
									  {
										$bg = 'red';	
									  }	
									 
							?>
									<a target='blank' href="<?=base_url('byonedaylist/')?><?=$rec->dates?>" class="collection-item"><?=date('l', strtotime($rec->dates))?>-<?=date_format(date_create($rec->dates), 'd/m/Y')?><span style="font-size:14px;" class=" badge <?=$bg?>" >RM <?=number_format($rec->tamount, 2)?></span></a>
						<?php		$flag=1;
								  }
								  	
							}
							//Missing dates
							if($flag==0)
							{
							?>	
								<a target='blank' class="collection-item"><?=date('l', strtotime($row))?>-<?=date_format(date_create($row), 'd/m/Y')?><span style="font-size:14px; color:#000;" class=" badge white" >RM 0</span></a>
							<?php	
							}		
							//Plus one the date
							//$cdate = date("Y-m-d", strtotime($cheques->dates. "+1 days"));
						}
						?>	  
						</div>
					</div> 
					</div>	  
                    </div>
                    <!-- Pending 7 past days-->
					<div class="col-md-4 col-sm-12 col-xs-12">
						<div class="card"><div class="card-action">
					  <a title="More Details" target='blank' style="text-decoration:none; color:#000;" >Pending payment in 7 Past Days</a>
					</div>
					<div class="card-image">
					  <div class="collection">
					  <?php
						$bg=""; 
						//define start date
						$cdate = date("Y-m-d", strtotime(date("Y-m-d"). "-1 days")); 
						foreach($pp7days AS $pending)
						{
							  
							  if($pending->tamount<=5000)
							  {
								$bg = 'green';
							  }
							  else if($pending->tamount<=10000)
							  {
								$bg = 'orange';	
							  }
							  else if($pending->tamount>10000)
							  {
								$bg = 'red';	
							  }
							
						?>
						
								<?php
								//Missing dates 	
								  /*if($pending->dates<$cdate) 
									{	
										for($j=date("Y-m-d", strtotime($pending->dates. "+1 days")); $j<=$cdate; $j++)
										{	 
											?>
												<a target='blank' class="collection-item"><?=date('l', strtotime($j))?>-<?=date_format(date_create($j), 'd/m/Y')?><span style="font-size:14px; color:#000;" class=" badge white" >RM 0</span></a>
											<?php		
										}		
									}*/
									?>
								<a target='blank' href="<?=base_url('byonedaylist/')?><?=$pending->dates?>" class="collection-item"><?=date('l', strtotime($pending->dates))?>-<?=date_format(date_create($pending->dates), 'd/m/Y')?><span style="font-size:14px;" class=" badge <?=$bg?>" >RM <?=number_format($pending->tamount, 2)?></span></a>
						<?php
							//Plus one the date
							$cdate = date("Y-m-d", strtotime($pending->dates. "-1 days"));
						}	
						?>	  
						</div>
					</div> 
					</div>	  
                    </div>
					
                </div>
                <!-- /. ROW  -->
				<!-- /. ROW  --> 
				<div class="row" style="" id="pchart">
					<div class="col-xs-12 col-sm-12 col-md-7"> 
						Chart
					</div>	
				</div>
				
				<div class="row" style="" id="dschart">
					<div class="col-xs-12 col-sm-12 col-md-7"> 
						Chart
					</div>	
				</div>
				<!-- /. ROW  --> 
				<div class="row">
					<div class="col-xs-12 col-sm-12"> 
					<div class="cirStats">
						  	<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-4"> 
										<div class="card-panel text-center">
											<span style="float:left; font-weight:bold;font-size:20px;">JOHONI JB</span>
											<h5>Conversional Rate</h5>
											<div class="easypiechart" id="easypiechart-blue" data-percent="<?=$gesi?>"><span class="percent"><?=$gesi?>%</span>
											</div>
											<span style="float:left;font-weight:bold;margin-top:-10px;">Total In: <?=$esic?></span>
											<span style="float:right;font-weight:bold;margin-top:-10px;">Total Purchases: <?=$esip?></span>
										</div>
								</div>
								<!--<div class="col-xs-12 col-sm-6 col-md-4"> 
										<div class="card-panel text-center">
											<span style="float:left; font-weight:bold;font-size:20px;">ESW</span>
											<h5>Conversional Rate</h5>
											<div class="easypiechart" id="easypiechart-red" data-percent="<?//=$gesw?>" ><span class="percent"><?//=$gesw?>%</span>
											</div>
											<span style="float:left;font-weight:bold;margin-top:-10px;">Total In: <?//=$eswc?></span>
											<span style="float:right;font-weight:bold;margin-top:-10px;">Total Purchases: <?//=$eswp?></span>
										</div>
								</div>-->
								<div class="col-xs-12 col-sm-6 col-md-4"> 
										<div class="card-panel text-center">
											<span style="float:left; font-weight:bold;font-size:20px;">JQ</span>
											<h5>Conversional Rate</h5>
											<div class="easypiechart" id="easypiechart-teal" data-percent="<?=$gjq?>" ><span class="percent"><?=$gjq?>%</span>
											</div>
											<span style="float:left;font-weight:bold;margin-top:-10px;">Total In: <?=$jqc?></span>
											<span style="float:right;font-weight:bold;margin-top:-10px;">Total Purchases: <?=$jqp?></span>
										</div>
								</div>
								
								<div class="col-xs-12 col-sm-6 col-md-4"> 
										<div class="card-panel text-center">
											<span style="float:left; font-weight:bold;font-size:20px;">E66A</span>
											<h5>Conversional Rate</h5>
											<div class="easypiechart" id="easypiechart-orange" data-percent="<?=$ge66a?>" ><span class="percent"><?=$ge66a?>%</span>
											</div>
											<span style="float:left;font-weight:bold;margin-top:-10px;">Total In: <?=$e66ac?></span>
											<span style="float:right;font-weight:bold;margin-top:-10px;">Total Purchases: <?=$e66ap?></span>
										</div>
								</div> 
								<!--<div class="col-xs-12 col-sm-6 col-md-4"> 
										<div class="card-panel text-center">
											<span style="float:left; font-weight:bold;font-size:20px;">ME PERFUME</span>
											<h5>Conversional Rate</h5>
											<div class="easypiechart" id="easypiechart-dark" data-percent="<?//=$ge66am?>" ><span class="percent"><?//=$ge66am?>%</span>
											</div>
											<span style="float:left;font-weight:bold;margin-top:-10px;">Total In: <?//=$e66acm?></span>
											<span style="float:right;font-weight:bold;margin-top:-10px;">Total Purchases: <?//=$e66apm?></span>
										</div>
								</div>-->
							</div>
						</div>							
						</div><!--/.row-->
						<!--<div class="col-xs-12 col-sm-12 col-md-5"> 
						     <div class="row">
									<div class="col-xs-12"> 
									<div class="card">
										<div class="card-image donutpad">
										  <div id="morris-donut-chart"></div>
										</div> 
										<div class="card-action">
										  <b>Donut Chart Example</b>
										</div>
									</div>	
								</div>
							 </div>
						</div><!--/.row-->
					</div>
					
				<!-- /. ROW  -->
				<div style="overflow:auto;font-family:'Sans-serif;';margin-bottom:5px;">
					<div class="expenseChart" style="float:left;margin-right:5px;">
						  <table class="table table-bordered table-striped" style="margin-bottom:0px;">
							<tr>
								<td style="padding: 0px 0px 0px 0px;cursor:pointer;" title="Select">
									<select id="expenseFilter" name="tableOptions" style="background-color:#337ab7;text-align:center;color:#fff;height:37px;cursor:pointer;" onchange="changeGroupe(this.value);">
										<option value="1">Group</option>
										<option value="2">Category</option>
									</select>	
								</td>  
							</tr>
						  </table>
						<div id="gcat">	
						  <table class="table table-striped" style="background-color: #fff;font-family:'Sans-serif;'; margin-top:0px;">		
							<tr style="font-weight:bold; background: linear-gradient(135deg, #1f2837, #4a5568); color:rgb(255, 255, 255)">
							  <td>Row</td>
							  <td>Group</td>
							  <td>Amount</td>
							  <td>Ratio</td>
							  <td>View</td>
							</tr>
							
							<?php
							$i=1;
							foreach($expenses AS $row)
							{
							?>		
								<tr>
								  <td><?=$i?></td>
								  <td><?=gname($row->groupe)?></td>
								  <td>					 
									RM <?=number_format($row->amount,2)?>
								  </td>
								  <td>
								 
								  <?php 
										if($sum>0)
										{
											echo round($row->amount/$sum *100, 1).' %';
										}	
								  ?>
								  </td>
								  <td title="Click for more details">
									<a href="<?=base_url('expenses/groupebased')?>/<?=$row->groupe?>" target="_blank" style="text-decoration:none;">
										 <img src="<?=base_url()?>images/view.png" alt="View" style="width: 20px; height: 20px;">
									</a>	 
								  </td>
								</tr>
							<?php
								$i++;
							}
							?>	
							  <tr style="font-weight:bold;">
								 <td colspan="2">Totlal:</td>	
								 <td colspan="3">RM <?=number_format($sum, 2)?></td>	
							  </tr>	
							</table>
						</div>	
					</div>	
					<!--expenses Chart -->
					<div class="expenseChart2" style="width:50%;float:right;">
						<div id="showExpenseChart">
							expense chart
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-5"> 
							<div style="float:right;width:100%;">
								 <table class="table table-striped" style="background-color: #fff;font-family:'Sans-serif;'; margin-top:0px;">		
										<tr style="font-weight:bold;">
											<td colspan="3" style="text-align:center;">MTD</td>
										</tr>
										<tr style="font-weight:bold; background: linear-gradient(135deg, #1f2837, #4a5568); color:rgb(255, 255, 255)">
										  <td>Row</td>
										  <td>Total Sales</td>
										  <td>Total Expenses</td> 
										</tr>
										<tr>
											  <td>1</td>
											  <td style="font-weight:bold;">
												<?php
													if($atsales)
													{
														echo number_format($atsales->tsales, 2);
													}		
												?>
											  </td>
											  <td style="font-weight:bold;"><?=number_format($sum, 2)?></td>
										</tr>	  
								 </table>		
							</div>
			  
					</div>		
						
					<div class="col-md-7"> 
						<div class="card">
						<div class="card-image">
						  <div id="morris-bar-chart"></div>
						</div> 
						<div class="card-action">
						  <b> Bar Chart Example</b>
						</div>
						</div>					
					</div>
					
				</div> 
			 
				
				
                <div class="row">
                    <div class="col-xs-12">
						<div class="card">
					<div class="card-image">
					  <div id="morris-area-chart"></div>
					</div> 
					<div class="card-action">
					  <b>Area Chart</b>
					</div>
					</div>	 
                    </div> 

                </div>
				<div class="row">
				<div class="col-md-12">
				
					</div>		
				</div> 	
                <!-- /. ROW  -->

	   
				
				
				
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
						<div class="card"><div class="card-action">
					  <b>Tasks Panel</b>
					</div>
					<div class="card-image">
					  <div class="collection">
						  <a href="#!" class="collection-item">Red<span class="new badge red" data-badge-caption="red">4</span></a>
						  <a href="#!" class="collection-item">Blue<span class="new badge blue" data-badge-caption="blue">4</span></a>
						  <a href="#!" class="collection-item"><span class="badge">1</span>Alan</a>
							<a href="#!" class="collection-item"><span class="new badge">4</span>Alan</a>
							<a href="#!" class="collection-item">Alan<span class="new badge blue" data-badge-caption="blue">4</span></a>
							<a href="#!" class="collection-item"><span class="badge">14</span>Alan</a>
							   <a href="#!" class="collection-item">Custom Badge Captions<span class="new badge" data-badge-caption="custom caption">4</span></a>
							<a href="#!" class="collection-item">Custom Badge Captions<span class="badge" data-badge-caption="custom caption">4</span></a>
						</div>
					</div> 
					
					</div>	  

                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
	<div class="card">
	<div class="card-action">
					  <b>User List</b>
					</div>
					<div class="card-image">
					  <ul class="collection">
    <li class="collection-item avatar">
      <i class="material-icons circle green">track_changes</i>
      <span class="title">Title</span>
      <p>First Line <br>
         Second Line
      </p>
      <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
    <li class="collection-item avatar">
      <i class="material-icons circle">folder</i>
      <span class="title">Title</span>
      <p>First Line <br>
         Second Line
      </p>
      <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
    <li class="collection-item avatar">
      <i class="material-icons circle green">track_changes</i>
      <span class="title">Title</span>
      <p>First Line <br>
         Second Line
      </p>
      <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
    <li class="collection-item avatar">
      <i class="material-icons circle red">play_arrow</i>
      <span class="title">Title</span>
      <p>First Line <br>
         Second Line
      </p>
      <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
  </ul>
					 </div>  
					</div>	 
					
                       

                    </div>
                </div>
                <!-- /. ROW  -->
			   <div class="fixed-action-btn horizontal click-to-toggle">
    <a class="btn-floating btn-large red">
      <i class="material-icons">menu</i>
    </a>
    <ul>
      <li><a class="btn-floating red"><i class="material-icons">track_changes</i></a></li>
      <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
      <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
      <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
    </ul>
  </div>
		
				<footer><p>Shared by <i class="fa fa-love"></i><a href="https://bootstrapthemes.co">BootstrapThemes</a>
</p>
				
        
				</footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="<?=base_url()?>assets/js/jquery-1.10.2.js"></script>
	
	<!-- Bootstrap Js -->
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
	
	<script src="<?=base_url()?>assets/materialize/js/materialize.min.js"></script>
	
    <!-- Metis Menu Js -->
    <script src="<?=base_url()?>assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="<?=base_url()?>assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="<?=base_url()?>assets/js/morris/morris.js"></script>
	
	
	<script src="<?=base_url()?>assets/js/easypiechart.js"></script>
	<script src="<?=base_url()?>assets/js/easypiechart-data.js"></script>
	
	 <script src="<?=base_url()?>assets/js/Lightweight-Chart/jquery.chart.js"></script>
	
    <!-- Custom Js -->
    <script src="<?=base_url()?>assets/js/custom-scripts.js"></script>
 
<!--Chart parts-->
<script>
	
//Show expenses chart
 var expenseChar = Highcharts.chart('showExpenseChart', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'MTD Expenses'
    },
    tooltip: {
        valueSuffix: ' RM'
    },
    /*subtitle: {
        text:
        'Source:<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default">MDPI</a>'
    },*/
    plotOptions: {
        series: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: [{
                enabled: true,
                distance: 20
            }, {
                enabled: true,
                distance: -40,
                format: '{point.percentage:.1f}%',
                style: {
                    fontSize: '1.5em',
                    textOutline: 'none',
                    opacity: 0.7
                },
                filter: {
                    operator: '>',
                    property: 'percentage',
                    value: 5
                }
            }]
        }
    },
    series: [
        {
            name: 'Amount',
            colorByPoint: true,
            data: <?=json_encode($cexpenses)?>//[{name:"RENTALU",y:32000},{name:"G1",y:6000}]
        }
    ]
});

	
//Change groupe/Category
function changeGroupe(value)
{  
	var mainUrl='';
	if(value==2)
	{	
		mainUrl = "<?=base_url('expenses/getcategory')?>";
		expenseChar.series[0].setData(<?=json_encode($expenseBycategory)?>);
	}
	else if(value==1)
	{
		mainUrl = "<?=base_url('expenses/groupesub')?>";
		expenseChar.series[0].setData(<?=json_encode($cexpenses)?>);
	}		
	$.ajax({
		 url: mainUrl,
		 success: function(result) {
			$("#gcat").empty(); 
			$("#gcat").append(result);
			
		  }
		});	 
}
//Start of the donut chart
 /*Morris.Donut({
                element: 'morris-donut-chart',
                data: [{
                    label: "Profits",
                    value: 12
                }, {
                    label: "Users",
                    value: 30
                }, {
                    label: "Total Sales",
                    value: 20
                }],
				   colors: [
    '#A6A6A6','#414e63',
    '#e96562' 
  ],
                resize: true
            });*/
//End of donut chart
 const chart = Highcharts.chart('pchart', {
	chart: {
		type: 'column'
	},
	title: {
		text: 'MTD Sales'
	},
	
	/* plotOptions: {
			  series: {
				cursor: "pointer",
				point: {
				  events: {
					click: function () {
					  window.open(this.options.ownURL)
					},
				  },
				},
			  },
			},*/
	 plotOptions: {
			column: {
				//stacking: 'normal',
				//pointPadding: 0,
				//groupPadding: 0,
				dataLabels: {
					enabled: true,
					 format: this.value,
					style: {
						
						fontSize:'14px'
					}
				}
				
				
			}
			
		}, 
	yAxis: {
		title: {
			text: 'Amount'
		},
		labels: {
					formatter: function() {
								return Highcharts.numberFormat(this.value)+' RM';
							},
					style: {
						
						fontSize:'12px'
					}
				},
				
		min: 0,
		max:70000
	},
	xAxis: {
				categories: <?=json_encode($sxdata)?>,
				labels: {
					style: {
						
						fontSize:'12px',
						font:'Sans-serif'
					}
				}
			},
	series: [{
		name: 'Sales',
		data: <?=json_encode($sdata)?>,
		font:'Sans-serif'
	}]
});
//Daily sales for all shops chart
 const chart2 = Highcharts.chart('dschart', {
	chart: {
		type: 'line'
	},
	title: {
		text: 'MTD Daily Sales'
	},
	
	/* plotOptions: {
			  series: {
				cursor: "pointer",
				point: {
				  events: {
					click: function () {
					  window.open(this.options.ownURL)
					},
				  },
				},
			  },
			},*/
	 plotOptions: {
			column: {
				//stacking: 'normal',
				//pointPadding: 0,
				//groupPadding: 0,
				dataLabels: {
					enabled: true,
					style: {
						
						fontSize:'14px'
					}
				}
				
				
			}
			
		}, 
	yAxis: {
		title: {
			text: 'Amount'
		},
		labels: {
					formatter: function() {
								return Highcharts.numberFormat(this.value,2)+' RM';
							},
					style: {
						
						fontSize:'12px'
					}
				},
				
		min: 0,
		max:30000
	},
	xAxis: {
				categories: <?=json_encode($sxdata2)?>,
				labels: {
					style: {
						
						fontSize:'12px',
						font:'Sans-serif'
					}
				}
			},
	series: [{
		name: 'Sales',
		data: <?=json_encode($sdata2)?>,
		font:'Sans-serif'
	}]
});

</script>
</body>

</html>