
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Expense Form</h4>
			<h4>Edit Expense</h4>
		</div>
		<form id="form1" method="post" action="<?=base_url('codeigniter/public/expenses/editSave/')?><?=$row->Id?>">
			<div style="width:100%" style="margin-right:1%;">
				<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				  <tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Expense/Invoice Date:</td>
					 <td colspan="3" style="width:26%;background-color:#b3d7ff87;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="pdate" id="pdate" type="date" value="<?=$row->pdate?>"  /></td>
				  </tr>
				  <tr>
					<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="ptype" name="ptype" onchanttge="showHideCheque(this.value)" required>
							<option value="">Select Payment Method</option>
							<?=$typeStr?>				
						</select>
					</td>
				  </tr>
				  <?php
					/*$flag=0;
					if($row->cno)
					{	
						$flag=1;
				  ?>
				  <!--<tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Cheque No:</td>
					 <td colspan="3" style="width:26%;background-color:#b3d7ff87;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="cno" id="cno"  placeholder="No" value="<?=$row->cno?>" type="text" readonly onblur="bringCheque(this.value)"  /></td>
				  </tr>-->
				  <?php
					}*/
				  ?>
				  <tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Amount:</td>
					 <td colspan="3" style="width:26%;background-color:#b3d7ff87;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="amount" id="amount"  placeholder="RM" value="<?=$row->amount?>" type="text" required /></td>
				  </tr>
				  
				 <!--<tr>
					<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="crno" name="crno">
							<option value="">If Creditor, Select</option>
							<?//=$dcstr?>				
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
					 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="des" id="des"  placeholder="Text" value="<?=$row->des?>" type="text" /></td>
				  </tr>
				</table>
			</div>	
		
			<div class="row" style="margin:5px 5px 5px 0px;width:100%;">
			   <input type="submit" name="btn_result" style="width:200px;" class="btn btn-primary line" value="Save" />
			</div>
		</form>
<script>
	/*if(<?//=$flag?> == 1)
	{
		
		$("#crno").on('mousedown', function(e) {
						e.preventDefault();  
					});
		$("#ptype").on('mousedown', function(e) {
						e.preventDefault();  
					});			
		$("#amount").attr("readonly", true);
			
	}	*/	
</script>