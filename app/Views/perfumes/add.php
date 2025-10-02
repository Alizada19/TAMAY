
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Add Perfume</h4>
		</div>
		
		<form id="form1" method="post" enctype="multipart/form-data" action="<?=base_url('codeigniter/public/perfumes/save')?>" style="width:800px;margin: 0 auto;">
			<div style="width:100%" style="margin-right:1%;">
				<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				  <tr>
					 <td colspan="4" style="width:10%;background-color:#b3d7ff87;padding-left:5px;text-align:center;">PERFUME SPECIFICATION</td>
				  </tr>
				  <tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">PERFUME NAME:</td>
					 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="pname" id="pname" type="text" required /></td>
				  </tr>
				  <tr>
					<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="pgroup" name="pgroup" onchange="bringCat(this.value)" required>
							<option value="">SELECT GROUP</option>
							<?=$gstr?>							
						</select>
					</td>
				  </tr>
				  <tr>
					<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="pcategory" name="pcategory" required>
							<option value="">SELECT CATEGORY</option>
										
						</select>
					</td>
				  </tr>
				  <tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">REMARK:</td>
					 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="remark" id="remark"  placeholder="REMARK" type="text" /></td>
				  </tr>
				  <tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Image:</td>
					 <td colspan="3" style="width:26%;">
						<input type="file" name="pimage">
					 </td>
				  </tr>
				</table>
			</div>	
		
			<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
			   <input type="submit" name="btn_result"   style="width:200px;" class="btn btn-primary line" id="save" value="Save" />
			</div>
		</form>
		
<script>
	function showHideCheque(value)
	{	
		if(value==2)
		{	
			$("#shcheque").show();
			 $("#crno").off('mousedown');
		}
		else
		{
			$("#cno").val("");
			$("#shcheque").hide();
			$("#amount").removeAttr("readonly");
			$("#crno").off('mousedown');
			$("#save").removeAttr("disabled");
		}		
	}	
	function bringCheque(cid)
	{
		 $.ajax({
			     url: "<?=base_url('codeigniter/public/expenses/bringCheque')?>/"+cid, 
                 success: function(result) {
					 if(result!=0)
					 {
						var values = result.split('|'); 
						$("#amount").val(values[1]);
						$("#crno").val(values[0].trim());
						$("#amount").attr("readonly", true);
						//Prevent user to open the creditor dropdown
						$("#crno").on('mousedown', function(e) {
							e.preventDefault();  
						});
						$("#save").removeAttr("disabled");
					 }
					 else
					 {
						$("#amount").val("");
						$("#crno").val("");
						$("#amount").removeAttr("readonly");
						$("#crno").removeAttr("readonly");
						$("#crno").off('mousedown');
						$("#save").attr("disabled", true);
					 }		
					 
                  }
				});
	}	
//Bring Category
function bringCat(gid)
{

	var mydata = "&gid=" + gid
	$.ajax({
				 type: 'GET',
				 url: "<?=base_url('codeigniter/public/perfumes/bringCat')?>",
				 data: mydata,
				 success: function(result) {
					$("#pcategory").empty(); 
					$("#pcategory").append(result);
				  }
				});	
}	
</script>		