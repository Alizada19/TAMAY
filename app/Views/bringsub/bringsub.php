<tr>
	<td style="width:12%;background-color:#b3d7ff87;"><?php
		if($para==1)
		{
			echo "Target";
		}
		else if($para==2)
		{
			echo "Commission";
		}
		else if($para==3)
		{
			echo "Transport";
		}
		else if($para==4)
		{
			echo "Voucher";
		}
		else if($para==5)
		{
			echo "Advance";
		}
		else if($para==6)
		{
			echo "Utility";
		}
		else if($para==7)
		{
			echo "Other";
		}
		else if($para==8)
		{
			echo "Promoter";
		}
		
	?>:</td>
	<td style="width:26%;">
		<input class="form-control line subdata" style="font-weight:bold;font-size:30px;" name="<?=$para?>sub[]" id="<?=$para?>sub" type="text" onblur="getexpenses();"; />
	</td>
</tr>