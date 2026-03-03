<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
	<h4>List of Expenses Payment</h4>
</div>
<div style="clear:both;font-weight:bold;cursor:pointer;margin-left:2%;" title="Filter" onclick="showHideFilter();">
	Fiter
</div>
<div id="sfilter" style="background-color: lavenderblush;clear:both;padding:5px 5px 5px 5px; border: 1px solid gray;display:none;">
    <form id="filter1" method="post" >	
		<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
			<div class="col-sm-2" style="font-weight:bold;"><label for="sdate">From:</label></div>
			<div class="col-sm-2" style="padding:0 0 0 0;">
				<input type="date" class="form-control" name="sdate" id="sdate">
			</div>
			<div class="col-sm-2" style="font-weight:bold;"><label for="edate">To:</label></div>
			<div class="col-sm-2" style="padding:0 0 0 0;">
				<input type="date" class="form-control" name="edate" id="edate">
			</div>
			<div class="col-sm-2" style="font-weight:bold;"><label for="amount">Amount:</label></div>
			<div class="col-sm-2" style="padding:0 0 0 0;">
				<input type="text" class="form-control" name="amount" id="amount">
			</div>
		</div>
		<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
			<div class="col-sm-3" style="padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="ptype" name="ptype">
					<option value="">Method</option>		
					<option value="1">OT</option>		
					<option value="2">Cheque</option>		
					<option value="3">Cash</option>		
							
				</select>
			</div>
			<div class="col-sm-3" style="padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="groupe" name="groupe">
					<?=$gstr?>			
				</select>
			</div>
			<div class="col-sm-3" style="background-color:lavender;padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="category" name="category">
					<?=$cstr?>			
				</select>
			</div>
			<div class="col-sm-3" style="background-color:lavender;padding:0 0 0 0;">
				<select  style="background-color:lavenderblush;width:100%;height:35px;text-align:center;font-weight:bold;"  id="subcategory" name="subcategory">
					<?=$sstr?>			
				</select>
			</div>
		</div>
		<div style="width:100%; margin:5px 5px 5px 5px;" class="row">
			<div class="col-sm-1" style="background-color:lavenderblush;font-weight:bold;"><label for="des">Description:</label></div>
			<div class="col-sm-5" style="background-color:lavender;padding:0 0 0 0;">
				<input type="text" class="form-control" name="des" id="des">
			</div>
			<div class="col-sm-1" style="font-weight:bold;">
				<button type="button" onclick="filterSearch(); hideSearch();" class="btn btn-info">Search</button>
			</div>
			<div class="col-sm-2" style="font-weight:bold;">
				<button type="submit" class="btn btn-info" formaction="<?=base_url('expenses/printExcel')?>">Generate Excel</button>
			</div>
			<div class="col-sm-2" style="font-weight:bold;">
				 <button type="submit" class="btn btn-info" formaction="<?=base_url('expenses/printDailyExcel')?>">Daily Excel</button>
			</div>
			<div class="col-sm-4" style="font-weight:bold;">
				<button type="button" onclick="clearBoxes();" class="btn btn-info">Reset</button>
			</div>
		</div>
	</form>	
</div>
<div id="listCon" style="width:100%" style="margin-right:1%;">
<table cellpadding="5px" style="width:100%;font-size:15px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td colspan="9" align="center" style="width:100%;background-color:#4caf50;font-weight:bold;">Expenses List</td>
	</tr>
	<tr>
		<td align="center" style="width:5%;background-color:#b3d7ff87;font-weight:bold;">Row</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Expense Date</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Amount</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Payment Type</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Groupe</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Category</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Subcategory</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Description</td>
		<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;font-weight:bold;">Action</td>
		
	</tr>
	<?php
	$i=1;
	foreach($result As $row)
	{
	?>
		<tr>
			<td align="center" style="width:5%;background-color:#b3d7ff87;"><?=$i?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->pdate?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">RM <?=number_format($row->amount,2)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=ptype($row->ptype)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=gname($row->groupe)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=cname($row->category)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=sname($row->subcategory)?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=$row->des?></td>
			<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">
				<a style="test-decoration: none;" title="View Record" href="<?=base_url('expenses/view/')?><?=$row->Id?>/2" target="_blank">View</a>
				<a style="test-decoration: none;" title="Edit Record" href="<?=base_url('expenses/editView/')?><?=$row->Id?>" target="_blank">Edit</a>
			</td>
		</tr>
	
	<?php
		$i++;
	}
	?>
	<tr>
		<td colspan="8" align="center" style="width:5%;background-color:#b3d7ff87;font-weight:bold;">Total Amount:</td>
		<td style="width:5%;background-color:#b3d7ff87;font-weight:bold;padding-left:5px;">RM <?=number_format($sum, 2)?></td>
	</tr>
</table>
		<!--<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">	
		   <a style="" title="Update Current Record" href="<?=base_url('expenses/printpdf')?>" target="_blank"><input type="button"  name="btn_result" style="width:200px;" class="btn btn-primary line" value="Export PDF" /></a>
		</div>-->
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
				 url: "<?=base_url('expenses/searchFilter')?>",
				 data: formData,
				 success: function(result) {
					$("#listCon").empty(); 
					$("#listCon").append(result);
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
</script>