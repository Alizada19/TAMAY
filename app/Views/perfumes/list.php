<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
	<h4>Perfumes</h4>
</div>
<div style="clear:both;font-weight:bold;cursor:pointer;margin-left:2%; text-align:center;" title="Filter" onclick="showHideFilter();">
	Fiter
</div>
<div id="sfilter" style="background-color: lavenderblush;clear:both;padding:5px 5px 5px 5px; border: 1px solid gray;display:none;">
    <form id="filter1" method="post" action="">	

		<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
			<div class="col-sm-2" style="background-color:lavender;padding:0 0 0 0;">
				<input type="text" class="form-control" name="pid" id="pid" placeholder="ID">
			</div>
			<div class="col-sm-3" style="background-color:lavender;padding:0 0 0 0;">
				<input type="text" class="form-control" name="pname" id="pname" placeholder="NAME">
			</div>
			<div class="col-sm-3" style="padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="pgroup" name="pgroup" onchange="bringCat(this.value)">
					<?=$gstr?>	
				</select>
			</div>
			<div class="col-sm-3" style="background-color:lavender;padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="pcategory" name="pcategory">
					<option value="">Select Category</option>
				</select>
			</div>
			
		</div>
		<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
			<div class="col-sm-3" style="background-color:lavender;padding:0 0 0 0;">
				<input type="text" class="form-control" name="remark" id="remark" placeholder="REMARK">
			</div>
			<div class="col-sm-3" style="font-weight:bold; ">
				<button type="button" onclick="filterSearch(); hideSearch();" class="btn btn-info">Search</button>
			
				<button type="button" onclick="clearBoxes();" class="btn btn-info">Reset</button>
			</div>
		</div>
	</form>	
</div>
<div id="listCon" style="width:100%" style="margin-right:1%;">
<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="9" align="center" style="width:100%;background-color:#4caf50;font-weight:bold;">Perfume List</td>
	</tr>
	<tr>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">ID</td>
		<td style="width:30%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Name</td>
		<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Groupe</td>
		<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Category</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Remark</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Image</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">View</td>
	</tr>
<?php
	foreach($perfume As $row)
	{		
?>	
		<tr>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;"><?=$row->Id?></td>
			<td style="width:30%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;"><?=$row->name?></td>
			<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;"><?=pgname($row->group)?></td>
			<td style="width:15%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;"><?=pcname($row->category)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Remark</td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">
				<img src="<?= base_url()?><?=getImage($row->Id)?>" alt="No Image" style="width: 30px; height: 30px;">
			</td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">
				<a style="test-decoration: none;" title="View Record" href="<?=base_url('perfumes/view/')?><?=$row->Id?>/2" target="_blank">View</a>
			</td>
		</tr>
<?php
	}
?>	
	<a href="<?=base_url('perfumes/add')?>" target="_blank" title="Add Perfume">Add Perfume</a>
</table>
</div>		
<script>
function showHideFilter()
{
	$("#sfilter").slideToggle();
}	

//Filter search
function filterSearch()
{  
	var formData = $("#filter1").serialize(); 
	$.ajax({
				 type: 'get',
				 url: "<?=base_url('perfumes/searchFilter')?>",
				 data: formData,
				 success: function(result) {
					$("#listCon").empty(); 
					$("#listCon").append(result); console.log(window.location.pathname);
					
					history.pushState(null, null, newUrl);
				  }
				});	
}

//one hide search box
function hideSearch()
{
		$("#sfilter").css({'display':'none'});
}	

function clearBoxes()
{
		$("#sdate").val('')
		$("#edate").val('')
		$("#amount").val('')
		$("#ptype").prop("selectedIndex", 0);
		$("#groupe").prop("selectedIndex", 0);
		$("#category").prop("selectedIndex", 0);
		$("#subcategory").prop("selectedIndex", 0);
		$("#des").val('')
}	

//Bring Category
function bringCat(gid)
{

	var mydata = "&gid=" + gid
	$.ajax({
				 type: 'GET',
				 url: "<?=base_url('perfumes/bringCat')?>",
				 data: mydata,
				 success: function(result) {
					$("#pcategory").empty(); 
					$("#pcategory").append(result);
				  }
				});	
}
</script>