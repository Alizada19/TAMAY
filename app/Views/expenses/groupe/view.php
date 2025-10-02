<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
	<h4>Groupe Form</h4>
	<h4>View Groupe</h4>
</div>
<div style="width:100%" style="margin-right:1%;">
<div style="display:inline-block;">
	<!-- Success Alert -->
	<?php
		if($flag == 1)
		{	
	?>
	<div style="background-color:#b3d7ff87" class="alert  alert-dismissible d-flex align-items-center fade show ">
		
		<strong class="mx-2">Success!</strong> Your record has been saved successfully.
		
	</div>
	<?php
		}
	?>
</div>

	<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
	  <tr>
		  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Groupe Name:</td>
		  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->gname?></td>
	  </tr>
	  
	</table>
	
</div>	
<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
   <a title="Edit Record" href="<?=base_url('codeigniter/public/expenses/groupeEditView/')?><?=$row->Id?>"><input type="button" name="btn_result" style="width:200px;" class="btn btn-primary line" value="Update" /></a>
</div>
