<div style="margin-top: 10%;">
	<form id="form1" method="post" enctype="multipart/form-data" action="#">
	
		<div>
			<input type="date" name="sdate" id="sdate"  value="<?=$sdate?>" style="width:20%; height:30px;	text-align:center;">
		</div>
		<div>
			<input type="date" name="edate" id="edate"  value="<?=$edate?>" style="width:20%; height:30px;	text-align:center;margin-top:5px;margin-bottom:5px;">
		</div>
		
	</form>	
			<input type="submit" value="Search by date" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/searchExcel')?>')" style="width:110px;" class="btn btn-primary line"></button>
			
			<input type="submit" value="Ungroup" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/ungroup')?>')" style="width:100px;" class="btn btn-primary line"></button>
			
			<!--<input type="submit" value="Chart" name="btn_result" onclick="submitForm('<?//=base_url('codeigniter/public/schart')?>')" style="width:100px;" class="btn btn-primary line"></button>-->
			<input type="submit" value="Group by Category" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/gcategory')?>')" style="width:160px;" class="btn btn-primary line"></button>
			
			<input type="submit" value="Chart" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/schart')?>')" style="width:100px;" class="btn btn-primary line"></button>
			
			<a title="Upload excel file" target="_blank" href="<?=base_url('codeigniter/public/excel')?>"><input type="button" name="btn_result" style="width:150px;" class="btn btn-primary line" value="Upload Excel File"  /></a>
	<div id="mainDive">
	<div style="width:98%; margin-right:1%; margin-left:1%;">	
		<div style="text-align:center; font-weight:bold;font-size: 18px;">
			List of transfered stocks
		</div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr style="font-weight:bold;">
					<td>No</td>
					<td>Category Name</td>
					<td>Cost</td>
					<td>Created Date</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
			<?php
				$i=1;
				foreach($records AS $row)
				{
			?>
				<tr>
					<td><?=$i?></td>
					<td><?=$row->category?></td>
					<td>RM <?=number_format($row->cost, 2)?></td>
					<td><?=date_format(date_create($row->cdate), 'd-m-Y')?></td>
					<td style="">
						</a>
						<input 
							type="button" 
							value="Remove" 
							name="btn_result" 
							onclick="if(confirm('Are you sure you want to delete this record?')) { submitForm('<?= base_url('codeigniter/public/removeExcel/') . $row->Id ?>'); }" 
							style="width:80px;" 
							class="btn btn-primary line">
					</td>

				</tr>
			<?php
					$i++;
				}
			?>
				<tr style="font-weight:bold;">
					<td colspan="4">Total Cost</td>
					<td>RM <?=number_format($total->cost, 2)?></td>
				</tr>
			</tbody>
		</table>
	</div>
	</div>
</div>
<script>
function submitForm(actionUrl) {
    let form = document.getElementById("form1");
    form.action = actionUrl;  // Change form action dynamically
	//form.target = "_blank";
    form.submit();  // Submit the form
}
</script>