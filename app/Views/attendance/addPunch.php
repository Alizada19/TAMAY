 <style>
	.table th, .table td {
		text-align: center;
	}
	.table thead {
		background-color: #f8f8f8;
	}
	.table-bordered {
		border: 2px solid #ddd;
	}
	.table-hover tbody tr:hover {
		background-color: #f1f1f1;
	}
	.table th {
		background-color: #f9f9f9;
	}
	.action-btn {
		text-decoration: none;
		padding: 5px 10px;
		background-color: #5bc0de;
		color: white;
		border-radius: 5px;
	}
	.action-btn:hover {
		background-color: #31b0d5;
	}
	
</style>
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
    <form id="punchForm" style="margin:5px 5px 5px 5px;">
		<div style="margin-left:50%; margin-bottom:50px; cursor:pointer;" title="Search">
			   <h4>
					<span class="toggle-icon glyphicon glyphicon-plus"></span>
			   </h4>
		</div>	
	   <div style="display:none;" id="search" class="form-group">
		  <div class="row">	
				<div class="col-sm-2 control-label" ><label for="sdate">From:</label></div>
				<div class="col-sm-2 control-label" >
					<input type="date" class="form-control" name="sdate" id="sdate">
				</div>
				<div class="col-sm-2 control-label" ><label for="sdate">To:</label></div>
				<div class="col-sm-2 control-label" >
					<input type="date" class="form-control" name="edate" id="edate">
				</div>
			</div>		
		</div>
		
		<div class="form-group">
			<div class="row">
				<label for="location" class="col-sm-2 control-label">Select Location</label>
				<div class="col-sm-2">
					<select id="location" name="location" class="form-control" onchange="bringEmp(this.value);" required>
						<?=$locations?>
					</select>
				</div>
			</div>
        </div>
        <div class="form-group">
			<div class="row">
				<label for="employee" class="col-sm-2 control-label">Select Employee</label>
				<div class="col-sm-2">
					<select id="empId" name="empId" class="form-control" onchange="bringAttById(this.value)" required>
						<option value="">-- Select Employee --</option>
						<?=$employees?>
					</select>
				</div>
			</div>
        </div>
		
        <div class="form-group" >
            <div class="col-sm-offset-2 col-sm-10">
				<div class="row">
					<div style="margin-left:0.5%; margin-bottom:5px;width:200px;">						
							<input type="date" class="form-control time-picker" id="cdate" name="cdate">
					</div>
					<div style="margin-left:5%; cursor:pointer;" title="Overtime">
						   <h5>
								<span class="toggle-icon2 glyphicon glyphicon-plus"></span>
						   </h5>
					</div>
				</div>
				<div id="att" style="margin-bottom:5px;">
					<div class="row">
						<div style="margin-left:0.5%; margin-bottom:5px;width:200px;">						
								<input type="time" class="form-control time-picker" id="value" name="value">
						</div>
					</div>
					<div class="row" style="padding-left:5px;">
						<button type="button" class="btn btn-primary" onclick="recordPunch('IN')" style="margin-right:5px;">IN</button>
						<button type="button" class="btn btn-info" onclick="recordPunch('BIN')" style="margin-right:5px;">BREAK IN</button>
						<button type="button" class="btn btn-warning" onclick="recordPunch('BOUT')" style="margin-right:5px;">BREAK OUT</button>
						<button type="button" class="btn btn-danger" onclick="recordPunch('OUT')" style="margin-right:5px;">OUT</button>
					</div>	
				</div>
				
				<table id="overtime" class="table table-bordered table-hover" style="width:100%;text-align:center; margin-left:-1%; display:none;">
					<tbody>
						<tr>
							<td style="width:10%;">Overtime:</td> 
							<td style="width:20%;">
								<select id="oth" name="oth" style="border:none; width:45%;">
									<option value="0">00</option>
									<option value="1">01</option>
									<option value="2">02</option>
									<option value="3">03</option>
									<option value="4">04</option>
									<option value="5">05</option>
									<option value="6">06</option>
									<option value="7">07</option>
									<option value="8">08</option>
									<option value="9">09</option>
									<option value="10">10</option>
								</select>
								:
								<select id="minutes" name="otm" style="border:none; width:45%; max-height: 100px; overflow-y: auto;">
									<option value="0">00</option>
									<option value="1">01</option>
									<option value="2">02</option>
									<option value="3">03</option>
									<option value="4">04</option>
									<option value="5">05</option>
									<option value="6">06</option>
									<option value="7">07</option>
									<option value="8">08</option>
									<option value="9">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
									<option value="32">32</option>
									<option value="33">33</option>
									<option value="34">34</option>
									<option value="35">35</option>
									<option value="36">36</option>
									<option value="37">37</option>
									<option value="38">38</option>
									<option value="39">39</option>
									<option value="40">40</option>
									<option value="41">41</option>
									<option value="42">42</option>
									<option value="43">43</option>
									<option value="44">44</option>
									<option value="45">45</option>
									<option value="46">46</option>
									<option value="47">47</option>
									<option value="48">48</option>
									<option value="49">49</option>
									<option value="50">50</option>
									<option value="51">51</option>
									<option value="52">52</option>
									<option value="53">53</option>
									<option value="54">54</option>
									<option value="55">55</option>
									<option value="56">56</option>
									<option value="57">57</option>
									<option value="58">58</option>
									<option value="59">59</option>
									<option value="60">60</option>
								</select>
							</td>
							<td style="width:10%;">Reason:</td>
							<td ><input type="text" class="form-control" id="resion" name="resion" style="width:100%;"></td>
							<td ><button type="button" class="btn btn-info" onclick="recordPunch('OT')">OT</button></td>
						</tr>
					</tbody>
				</table>
               
               
            </div>
        </div>
		
        <div id="responseMessage" class="alert alert-info" style="display:none; margin-top:10%;"></div>
    </form>	
	<div id="presult">
	
	</div>
		
</div>	
<script>
    function recordPunch(action) {
        var employeeId = document.getElementById("empId").value;
        if (!employeeId) {
            alert("Please select an employee.");
            return;
        }
        
      
        var now = new Date().toLocaleTimeString(); // Replace with server time in production
        // Display confirmation message
        var message = "Punch recorded for Employee ID: " + employeeId;
        var responseDiv = document.getElementById("responseMessage");
        responseDiv.style.display = "block";
        responseDiv.innerHTML = message;

		
         //Save Punches in to database
		var formData = $("#punchForm").serialize(); 
		
			$.ajax({
				 type: 'GET',
				 url: "<?=base_url('codeigniter/public/attendance/')?>savePunch/"+action,
				 data: formData,
				 success: function(result) {
					$("#presult").empty(); 
					$("#presult").append(result);
				  }
				});	

    }
//Bring employee's Attendance by id	
function bringAttById(empId)
{
	var sdate = $("#sdate").val();
	var edate = $("#edate").val();
	var location = $("#location").val();
	var mydata = "&empId=" + encodeURIComponent(empId)+"&sdate="+sdate+"&edate="+edate+"&location="+location;
	$.ajax({
				 type: 'GET',
				 url: "<?=base_url('codeigniter/public/attendance/')?>bringAtt",
				 data: mydata,
				 success: function(result) {
					$("#presult").empty(); 
					$("#presult").append(result);
				  }
				});	
}	
//Set default time for the input field
function setCurrentTimeAndDate() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0'); // Ensure 2-digit format
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            // Format the time as HH:MM
            const currentTime = `${hours}:${minutes}`;

            // Set the value of the input field
            document.getElementById('value').value = currentTime;
			
			//Set current date by default
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-based
            const day = String(now.getDate()).padStart(2, '0');

            // Format the date as YYYY-MM-DD
            const currentDate = `${year}-${month}-${day}`;

            // Set the value of the input field
            document.getElementById('cdate').value = currentDate;
        }

        // Call the function when the page loads
        window.onload = setCurrentTimeAndDate;		
//Bring sub employees
function bringEmp(value)
{
	var myDate = '&value='+value;
	$.ajax({
			 type: 'get',
			 url: "<?=base_url('codeigniter/public/attendance/bringEmp')?>",
			 data: myDate,
			 success: function(result) {
				$("#empId").empty(); 
				$("#empId").append(result);
			  }
			});	
}
//Show Hide the search
$(document).ready(function () {
            $("h4").click(function () {
                const icon = $(this).find(".toggle-icon");
                $("#search").slideToggle(); // Toggle content
                icon.toggleClass("glyphicon-plus glyphicon-minus"); // Toggle icons
            });
        });
//Show Hide the search
$(document).ready(function () {
            $("h5").click(function () {
                const icon = $(this).find(".toggle-icon2");
                $("#overtime").slideToggle(); // Toggle content
                icon.toggleClass("glyphicon-plus glyphicon-minus"); // Toggle icons
				$("#att").slideToggle();
            });
        });		

//showHide
function showHide(id)
{	
	$("#" + id).slideToggle(400, "swing");
}	
</script>