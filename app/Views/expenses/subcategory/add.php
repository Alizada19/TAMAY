
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Subcategory Form</h4>
			<h4>Create Subcategory</h4>
		</div>
		<form id="form1" method="post" action="<?=base_url('codeigniter/public/expenses/subcategorySave')?>">
			<div style="width:100%" style="margin-right:1%;">
				<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				  <tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Subcategory Name:</td>
					 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="sname" id="sname" type="text" placeholder="NAME" onblur="makeCapital(this.value,'sname')" required /></td>
				  </tr>
				  
				</table>
			</div>	
		
			<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
			   <input type="submit" name="btn_result"   style="width:200px;" class="btn btn-primary line" value="Save" />
			</div>
		</form>