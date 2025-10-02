	
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
		<div style="width:100%" style="margin-right:1%;">
			<table  style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:20px;">IN:</td>
				  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->in?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:20px;">BREAK IN:</td>
				  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->bin?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:20px;">BREAK OUT:</td>
				  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->bout?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:20px;">OUT:</td>
				  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->out?></td>
			  </tr>
			</table>
		</div>	
	
		<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
		   <a title="Edit Record" href="<?=base_url('codeigniter/public/attendance/editViewPunch/')?><?=$row->Id?>"><input type="button" name="btn_result" style="width:200px;" class="btn btn-primary line" value="Update" /></a>
		</div>	
</div>	
