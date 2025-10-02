<?php
	$ppath='none';
	$ipath='none';
	if($pimage)
	{
			$ppath=$pimage->image_path;
	}
	if($idimage)
	{
		$ipath=$idimage->image_path;
	}		
?>	
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
		<div style="width:100%;margin-right:1%;">
			<?php if($pimage){ ?> 
			<span style="margin-left:40%;"><img src="<?= base_url('codeigniter/public/')?><?=$ppath?>" alt="User Image" style="width: 100px; height: 100px;border:1px solid #000;"></span>
			<?php } ?>
			<table  style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Name:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->name?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Last Name:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->lname?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Location:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=location($row->location)?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Department:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=getDep($row->department)?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Nationality:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=getNat($row->nat)?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Contact No:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->phone1?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Emergency Contact:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->phone2?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Email:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->email?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Commencement Date:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->jdate?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Address:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->addr?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Basic Salary:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->bsalary?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Status:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;">
					<?php
						if($row->active==1)
						{
							echo "Active";
						}
						else
						{
							echo "Deactive";	
						}		
					?>
				  </td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Working Hours:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->wh?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">off Day:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=getDay($row->offday)?></td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Working Days In Month</td>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;width:26%;font-weight:bold;font-size:20px;padding-left:10px;"><?=$row->wdays?></td>
			  </tr>
			  <tr>
				  <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Tolerance:</td>
				  <td colspan="1" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;"><?=$row->tolerance?></td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Gender</td>
				<td style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;;width:10%;background-color:#b3d7ff87;padding-left:5px;"><?=getGender($row->gender)?></td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Marital Status</td>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;width:26%;font-weight:bold;font-size:20px;padding-left:10px;"><?=getMstatus($row->mstatus)?></td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Date of Birth</td>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;width:26%;font-weight:bold;font-size:20px;padding-left:10px;"><?=$row->dob?></td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Bank Name</td>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;width:26%;font-weight:bold;font-size:20px;padding-left:10px;"><?=getbname($row->bname)?></td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Account No</td>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;width:26%;font-weight:bold;font-size:20px;padding-left:10px;"><?=$row->accno?></td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Account Holder</td>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;width:26%;font-weight:bold;font-size:20px;padding-left:10px;"><?=$row->acch?></td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">EPF</td>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;width:26%;font-weight:bold;font-size:20px;padding-left:10px;"><?=$row->epf?></td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">SOCSO</td>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;width:26%;font-weight:bold;font-size:20px;padding-left:10px;"><?=$row->socso?></td>
			  </tr>
			   <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">IC/PASSPORT</td>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;width:26%;font-weight:bold;font-size:20px;padding-left:10px;"><?=$row->ic?></td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">Profile Picture:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;">
					<?php if($pimage){ ?>
					<img src="<?= base_url('codeigniter/public/')?><?=$ppath?>" alt="User Image" style="width: 50px; height: 50px;border:1px solid #000;"> <a href="<?= base_url('codeigniter/public/attendance/downloadProfile/')?><?=$row->Id?>" title="Download It">Download</a>
					<?php } ?>
				  </td>
			  </tr>
			  <tr>
				  <td style="width:12%;background-color:#b3d7ff87;padding-left:5px;">ID:</td>
				  <td colspan="2" style="width:26%;font-weight:bold;font-size:20px;padding-left:10px;background-color:#b3d7ff87;">
				  <?php if($idimage){ ?>
					<!--<img src="<?//= base_url('codeigniter/public/')?><?//=$ipath?>" alt="User Image" style="width: 50px; height: 50px;border:1px solid #000;">--> <a href="<?= base_url('codeigniter/public/attendance/downloadId/')?><?=$row->Id?>" title="Download It">Download</a>
				  <?php } ?>
				  </td>
			  </tr>
			</table>
			
		</div>	
	
		<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
		   <a title="Edit Record" href="<?=base_url('codeigniter/public/attendance/editViewemp/')?><?=$row->Id?>"><input type="button" name="btn_result" style="width:200px;" class="btn btn-primary line" value="Update" /></a>
		</div>	
</div>	
