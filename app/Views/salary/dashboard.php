<div id="sfilter" style="background-color: lavenderblush;clear:both;padding:5px 5px 5px 5px; margin-left:10px;margin-right:10px;border: 1px solid gray;display:block;margin-top:20px;">
    <form id="filter1" method="GET" action="">	
			<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
				<div class="col-sm-3" style="font-weight:bold;"><label for="sdate">From:</label></div>
				<div class="col-sm-3" >
					<input type="date" class="form-control" name="sdate" id="sdate">
				</div>
				<div class="col-sm-3" style="font-weight:bold;"><label for="edate">To:</label></div>
				<div class="col-sm-3" >
					<input type="date" class="form-control" name="edate" id="edate">
				</div>
			</div>
			<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
				<div class="col-sm-12">
					<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="location" name="location" onchange="bringEmp(this.value);">
						<option value="">Select Location</option>		
						<?=$locations?>			
					</select>
				</div>
			</div>
			<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
				<div class="col-sm-12">
					<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="status" name="status" ">
						<option value="1">Active</option>		
						<option value="2">Deactive</option>	
					</select>
				</div>
			</div>
			<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
				<div class="col-sm-2" style="font-weight:bold;">
					<button type="button" onclick="filterSearch();" class="btn btn-info">Generate Salary</button>
				</div>
				<div class="col-sm-2" style="font-weight:bold;">
					<button type="button" onclick="clearBoxes();" class="btn btn-info">Reset</button>
				</div>
			</div>
		</form>	
</div>
	<div id="attCon" style="margin-right:10px; margin-left:10px;">
	
	</div>	
</div>
<script>
	//Filter search
function filterSearch()
{  
	var formData = $("#filter1").serialize(); 
	$.ajax({
			 type: 'get',
			 url: "<?=base_url('codeigniter/public/salary/mainLayout')?>",
			 data: formData,
			 success: function(result) {
				$("#attCon").empty(); 
				$("#attCon").append(result);
			  }
			});	
}


//Bring sub employees
function bringEmp(value)
{
	var myDate = '&value='+value;
	$.ajax({
			 type: 'get',
			 url: "<?=base_url('codeigniter/public/attendance/bringEmp')?>",
			 data: myDate,
			 success: function(result) {
				$("#emps").empty(); 
				$("#emps").append(result);
			  }
			});	
}

//Bring sub employees by status
function bringEmpByStatus(value)
{  
	var formData = $("#filter1").serialize(); 
	$.ajax({
			 type: 'get',
			 url: "<?=base_url('codeigniter/public/attendance/bringStatus')?>",
			 data: formData,
			 success: function(result) {
				$("#emps").empty(); 
				$("#emps").append(result);
			  }
			});	
}	
</script>

