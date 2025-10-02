
		<div style="display:inline-block; text-align:center;font-weight:bold;font-size:20px;">
			<h4>Expense Form</h4>
			<h4>View Expense</h4>
		</div>
			<div style="width:100%" style="margin-right:1%;">
				<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
				  <tr>
					  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Expense/Invoice Date:</td>
					  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->pdate?></td>
				  </tr>
				  <?php
					if($row->cno)
					{	
				  ?>
				  <tr>
					  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Cheque No:</td>
					  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->cno?></td>
				  </tr>
				  <?php
					}
				  ?>
				  <tr>
					  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Amount:</td>
					  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?='RM '.number_format($row->amount, 2)?></td>
				  </tr>
				  <tr>
					  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Payment Type:</td>
					  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=ptype($row->ptype)?></td>
				  </tr>
				  <!--<tr>
					  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Paid to:</td>
					  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?//=getdbc($row->crno)?></td>
				  </tr>-->
				  <tr>
					  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Groupe:</td>
					  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=gname($row->groupe)?></td>
				  </tr>
				  <tr>
					  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Category:</td>
					  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=cname($row->category)?></td>
				  </tr>
				  <tr>
					  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Subcategory:</td>
					  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=sname($row->subcategory)?></td>
				  </tr>
				  <tr>
					  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Description:</td>
					  <td colspan="3" style="width:26%;font-weight:bold;font-size:30px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->des?></td>
				  </tr>
				</table>
			</div>	
		
			<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
			   <a title="Edit Record" href="<?=base_url('codeigniter/public/expenses/editView/')?><?=$row->Id?>"><input type="button" name="btn_result" style="width:200px;" class="btn btn-primary line" value="Update" /></a>
			</div>
		