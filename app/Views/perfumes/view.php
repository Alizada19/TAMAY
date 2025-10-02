
			<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
				<h4>View Perfume</h4>
			</div>
			<div style="width:800px;margin: 0 auto;">
					<div style="width:100%" style="margin-right:1%;" >
						<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
						  <tr>
							 <td colspan="4" style="width:10%;background-color:#b3d7ff87;padding-left:5px;text-align:center;">Perfume Specification</td>
						  </tr>
						  <tr>
							 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Perfume Name:</td>
							 <td colspan="3" style="width:26%;"><?=$row->name?></td>
						  </tr>
						  <tr>
							 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Group:</td>
							 <td colspan="3" style="width:26%;"><?=pgname($row->group)?></td>
						  </tr>
						  <tr>
							 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Category:</td>
							 <td colspan="3" style="width:26%;"><?=pcname($row->category)?></td>
						  </tr>
						  <tr>
							 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Remark:</td>
							 <td colspan="3" style="width:26%;"><?=$row->remark?></td>
						  </tr>
						</table>
					</div>
					<?php if($pimage){ ?> 
						<div style=""><img src="<?= base_url('codeigniter/public/')?><?=$pimage->image_path?>" alt="User Image" style="width: 100px; height: 100px;border:1px solid #000;"></div>
					<?php } ?>		
					<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
					   <a title="Edit Record" href="<?=base_url('codeigniter/public/perfumes/editView/')?><?=$row->Id?>"><input type="button" name="btn_result" style="width:200px;" class="btn btn-primary line" value="Edit" /></a>
					</div
			</div>
			
		
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