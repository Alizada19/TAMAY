	
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
	<form id="form1" method="post" action="<?=base_url('codeigniter/public/attendance/saveEditPunch/')?><?=$row->Id?>">
		<div style="width:100%" style="margin-right:1%;">
			<table  style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:20px;">IN:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" value="<?=$row->in?>" name="in" id="in" type="time" required /></td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:20px;">BREAK IN:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" value="<?=$row->bin?>" name="bin" id="bin" type="time" required /></td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:20px;">BREAK OUT:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" value="<?=$row->bout?>" name="bout" id="bout" type="time" required /></td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:20px;">OUT:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" value="<?=$row->out?>" name="out" id="out" type="time" required /></td>
			  </tr>
			</table>
		</div>	
		
		<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
		   <input type="submit" name="btn_result"   style="width:200px;" class="btn btn-primary line" id="save" value="Save" />
		</div>
		
	</form>		
</div>	
