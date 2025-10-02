
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Groupe Form</h4>
			<h4>Create Groupe</h4>
		</div>
		<form id="form1" method="post" action="<?=base_url('codeigniter/public/expenses/groupeSave')?>">
			<div style="width:100%" style="margin-right:1%;">
				<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				  <tr>
					 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Groupe Name:</td>
					 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="gname" id="gname" type="text" placeholder="NAME" onblur="makeCapital(this.value,'gname')" required /></td>
				  </tr>
				  
				</table>
			</div>	
		
			<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
			   <input type="submit" name="btn_result"   style="width:200px;" class="btn btn-primary line" value="Save" />
			</div>
		</form>