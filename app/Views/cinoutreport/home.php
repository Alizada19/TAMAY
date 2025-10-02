
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
	<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
		<h4>CIN/OUT REPORT</h4>
		<h4>Main Page</h4>
	</div>
	
<div id="sfilter" style="background-color: lavenderblush;clear:both;padding:5px 5px 5px 5px; border: 1px solid gray;display:block;margin-top:20px;">
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
				<div class="col-sm-6">
					<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="type" name="type">
						<option value="">Select Type</option>		
						<option value="1" selected>Purchase</option>				
						<!--<option value="2">Locality</option>-->			
					</select>
				</div>
				<div class="col-sm-6">
					<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="shop" name="shop">
						<option value="">Select Shop</option>		
						<!--<option value="3">ESI</option>-->				
						<!--<option value="4">ESW</option>-->			
						<option value="5">JOHONI QUILL</option>				
						<option value="6">E66A</option>				
						<option value="11">JOHONI JB</option>				
						<!--<option value="10">ME</option>-->			
					</select>
				</div>
			</div>
			<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
				<div class="col-sm-1" style="font-weight:bold;">
					<button type="button" onclick="filterSearch();" class="btn btn-info">Search</button>
				</div>
				<div class="col-sm-5" style="font-weight:bold;">
					<button type="button" onclick="clearBoxes();" class="btn btn-info">Reset</button>
				</div>
			</div>
		</form>	
</div>
	<div id="cinoutCon">
	
	</div>	
</div>
<script>
	//Filter search
function filterSearch()
{  
	var formData = $("#filter1").serialize(); 
	$.ajax({
			 type: 'get',
			 url: "<?=base_url('codeigniter/public/cinoutreport/bypurchase')?>",
			 data: formData,
			 success: function(result) {
				$("#cinoutCon").empty(); 
				$("#cinoutCon").append(result);
			  }
			});	
}
</script>