<!-- Table for displaying the punches -->
<table class="table table-bordered table-hover" style="width:70%;margin-left:15%;margin-right:15%;text-align:center;">
	<thead>
		<tr>
			<td  colspan="6" style="text-align:center;font-weight:bold;"><?=getEmp($empId)?></td>
		</tr>
		<tr>
			<th>Date</th> 
			<th>Clock In</th>
			<th>Break In</th>
			<th>Break Out</th>
			<th>Clock Out</th>
			<th>OverTime</th>
		</tr>
	</thead>
	<tbody>
<?php
	$othrs='';
	$otmin='';
	$overTime='';
	$overTimeh=0;
	$overTimem=0;
	foreach($records As $row)
	{
		if(isset($row['date']) AND !isset($row['offtype']))
		{
		 $differenceInSeconds=strtotime($row['out'])-strtotime($row['in']);
			 // If the difference is negative, it means the time crosses midnight
			if ($differenceInSeconds < 0) {
				$differenceInSeconds += 24 * 60 * 60; // Add 24 hours in seconds
			}

			// Convert seconds to hours
			$hours = floor($differenceInSeconds / 3600); 
			$minutes = ($differenceInSeconds % 3600) / 60; // 
			if($hours==0)
			{
				$hours='00';
			}
			if($minutes==0)
			{
				$minutes='00';
			}		
			$whours = $hours.':'.$minutes;	//worked hours
			
			//Break	
			$bdif=strtotime($row['bout'])-strtotime($row['bin']);
			 // If the difference is negative, it means the time crosses midnight
			if ($bdif < 0) {
				$bdif += 24 * 60 * 60; // Add 24 hours in seconds
			}

			// Convert seconds to hours
			$bhours = floor($bdif / 3600); 		//break hours
			$bminutes = ($bdif % 3600) / 60; // 
			if($bhours==0)
			{
				$bhours='00';
			}
			if($bminutes==0)
			{
				$bminutes='00';
			}		
			$btime = $bhours.':'.$bminutes; 
			//echo $whours.'|'.$nwh; exit;
			$awhrs=strtotime($whours);
			$nwhrs=strtotime($nwh.':00'); 
			$lessTime='';
			$mixotime='';
			if($awhrs>$nwhrs)
			{
				$odif=$awhrs-$nwhrs;
				if ($odif < 0) {
						$odif += 24 * 60 * 60; // Add 24 hours in seconds
					}

					// Convert seconds to hours
					$oh = floor($odif / 3600); 		//break hours
					$omin = ($odif % 3600) / 60; // 
					if($oh==0)
					{
						$oh='00';
					}
					if($omin==0)
					{
						$omin='00';
					}		
					//$oh.':'.$omin;
					//$overTimeh +=(int)$oh;
					//$overTimem +=(int)$omin;
					//$mixotime = '+ '.$oh.':'.$omin;
			}
			else if($awhrs<$nwhrs)
			{
				$ldif=$nwhrs-$awhrs;
				if ($ldif < 0) {
						$ldif += 24 * 60 * 60; // Add 24 hours in seconds
					}

					// Convert seconds to hours
					$lh = floor($ldif / 3600); 		//break hours
					$lmin = ($ldif % 3600) / 60; // 
					if($lh==0)
					{
						$lh='00';
					}
					if($lmin==0)
					{
						$lmin='00';
					}		
					$lh.':'.$lmin; 
					$overTimeh -=(int)$lh;
					$overTimem -=(int)$lmin;
					$mixotime = '- '.$lh.':'.$lmin;
			}
			
			$abtime= strtotime($btime); 
			$nbtime=strtotime('1:00');
			$morebTime='';
			$lessbTime='';
			if($abtime>$nbtime)
			{
					$mbdfi = $abtime-$nbtime; 
					if ($mbdfi < 0) {
							$mbdfi += 24 * 60 * 60; // Add 24 hours in seconds
						}

						// Convert seconds to hours
						$mbh = floor($mbdfi / 3600); 		//break hours
						$mbmin = ($mbdfi % 3600) / 60; // 
						if($mbh==0)
						{
							$mbh='00';
						}
						if($mbmin==0)
						{
							$mbmin='00';
						}		
						$morebTime = $mbh.':'.$mbmin;
			}
			else if($abtime<$nbtime)
			{
				$lbdfi = $nbtime-$abtime; 
				if ($lbdfi < 0) {
						$lbdfi += 24 * 60 * 60; // Add 24 hours in seconds
					}

					// Convert seconds to hours
					$lbh = floor($lbdfi / 3600); 		//break hours
					$lbmin = ($lbdfi % 3600) / 60; // 
					if($lbh==0)
					{
						$lbh='00';
					}
					if($lbmin==0)
					{
						$lbmin='00';
					}		
					$lessbTime = $lbh.':'.$lbmin;
			}
			//check if btime greather 65 or less than 55
			$bgcolor=''; 
			$cbtime=strtotime($btime);
			$c65=strtotime('01:05');
			$c55=strtotime('00:55');
			if($cbtime>$c65)
			{
				$bgcolor="background-color:#FF7F7F;";
			}
			else if($cbtime<$c55)
			{
				$bgcolor="background-color:#90EE90;";
			}
		}	
			
		if(isset($row['date']) AND !isset($row['offtype']))
		{	
			if(isset($row['in']))
			{
					$in = strtotime($row['in']);
					$in = date("g:i A", $in);
			}
			else
			{	
				$in=0;
			}
			if(isset($row['bin']))
			{
					$bin = strtotime($row['bin']);
					$bin = date("g:i A", $bin);
			}
			else
			{	
				$bin=0;
			}
			if(isset($row['bout']))
			{
					$bout = strtotime($row['bout']);
					$bout = date("g:i A", $bout);
			}
			else
			{	
				$bout=0;
			}
			if(isset($row['out']))
			{
					$out = strtotime($row['out']);
					$out = date("g:i A", $out);
			}
			else
			{	
				$out=0;
			}	
?>	
		<tr>
			<td><?=$row['date']?></td>  
			<td><?=$in?></td>
			<td><?=$bin?></td>
			<td style="<?=$bgcolor?>"><?=$bout?></td>
			<td><?=$out?></td>
			<td>
				<?=$mixotime?>
			</td>
		</tr>
<?php
		}
		else if(isset($row['offtype']))
		{
			if($row['offtype']=='off')
			{
?>
				<tr>
					<td colspan="1"><?=$row['date']?></td>  
					<td colspan="5">Off Day</td>  
				</tr>

<?php
			}
			else
			{
?>
				<tr>
					<td colspan="1"><?=$row['date']?></td>  
					<td colspan="5">Absent</td>  
				</tr>

<?php	
			}
		}		
	} 
	//Calculate total overtime
	$overTimeh += floor($overTimem / 60); 
	if($overTimem<0)
	{
		$overTimem = $overTimem + 60;
	}
	else
	{		
		$overTimem = $overTimem % 60;	
	}	
	
	if($overTimeh=='0')
	{
		$overTimeh='00';
	}
	if($overTimem=='0')
	{
		$overTimem='00';
	}		
	$overTime=$overTimeh.':'.$overTimem;
	
?>	
	<tr>
		<td colspan="5" style="text-align:center;">Total</td>
		<td><?=$overTime?></td>
	</tr>	
	</tbody>
</table>