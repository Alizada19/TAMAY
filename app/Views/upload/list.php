<div style="margin-top: 10%;">
	<form id="form1" method="post" enctype="multipart/form-data" action="<?=base_url('codeigniter/public/searchExcel')?>">
	<div style="margin-left:1%;">
		<div>
			<input type="date" name="sdate" id="sdate"  value="<?=date('Y-m-d')?>" style="width:20%; height:30px;text-align:center;">
		</div>
		<div>
			<input type="date" name="edate" id="edate"  value="<?=date('Y-m-d')?>" style="width:20%; height:30px;	text-align:center;margin-top:5px;margin-bottom:5px;">
		</div>
		
		<div style="margin-bottom:5px;">
			<input type="submit" name="btn_result"   style="width:100px;" class="btn btn-primary line" id="search" value="Search" />
			<a title="Upload excel file" target="_blank" href="<?=base_url('codeigniter/public/excel')?>"><input type="button" name="btn_result" style="width:150px;" class="btn btn-primary line" value="Upload Excel File"  /></a>
		</div>
	</div>
	</form>
	<div id="mainDive">
	<div style="width:98%; margin-right:1%; margin-left:1%;">	
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td>No</td>
					<td>Category Name</td>
					<td>Cost</td>
					<td>Created Date</td>
				</tr>
			</thead>
			<tbody>
			
				
			</tbody>
		</table>
	</div>
	</div>
</div>