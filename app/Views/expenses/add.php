
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Expense Form</h4>
			<h4>Create Expense</h4>
		</div>
		<form id="form1" method="post" action="<?=base_url('codeigniter/public/expenses/save')?>">
			<div style="width:100%" style="margin-right:1%;">
				<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				  <tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Expense Date:</td>
					 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="pdate" id="pdate" type="date" required /></td>
				  </tr>
				  <tr>
					<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="ptype" name="ptype" ontempchange="showHideCheque(this.value)" required>
							<option value="">Select Payment Method</option>
							<option value="1">OT</option>				
							<option value="2">Cheque</option>				
							<option value="3">Cash</option>								
						</select>
					</td>
				  </tr>
				  <tr id="shcheque" style="display:none;">
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Cheque No:</td>
					 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="cno" id="cno"  placeholder="No" type="text" onblur="bringCheque(this.value)" /></td>
				  </tr>
				  <tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Amount:</td>
					 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="amount" id="amount"  placeholder="RM" type="text" required /></td>
				  </tr>
				  <!--<tr>
					<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="crno" name="crno">
							<option value="">If Creditor, Select</option>
							<?//=$str?>			
						</select>
					</td>
				  </tr>-->
				  <tr>
					<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="groupe" name="groupe" required>
							<option value="">Groupe Name</option>
							<?=$gstr?>			
						</select>
					</td>
				  </tr>
				  <tr>
					<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="category" name="category" required>
							<option value="">Category Name</option>
							<?=$cstr?>				
						</select>
					</td>
				  </tr>
				  <tr>
					<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="subcategory" name="subcategory">
							<option value="">Subcategory Name</option>
							<?=$sstr?>					
						</select>
					</td>
				  </tr>
				  <tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Description:</td>
					 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="des" id="des"  placeholder="Text" type="text" /></td>
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
</script>		