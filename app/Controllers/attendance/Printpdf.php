<?php
namespace App\Controllers\attendance;
use App\Controllers\BaseController;
use App\Models\DailyModel;
use App\Models\attendance\AttendanceModel;
use App\Models\salary\SalaryModel;
use TCPDF;  
class Printpdf extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->AttendanceModel = new AttendanceModel();
		$this->SalaryModel = new SalaryModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index()
    {   
         $sdate = $this->request->getGet('sdate'); 
         $edate = $this->request->getGet('edate'); 
		 if($sdate !='' AND $edate!='')
		 {
			 $fdm = $sdate; 
			 $now = $edate; 
		 }
		 else
		 {		
			 $fdm = date('Y-m-01'); 
			 $now = date('Y-m-d'); 
		 }
         $location = $this->request->getGet('location'); 
		 $emps = $this->request->getGet('emps'); 
		 $wod = $this->request->getGet('wod'); 
		 $ph = $this->request->getGet('ph'); 
		 $claims = $this->request->getGet('claims'); 
		 $epf = $this->request->getGet('epf'); 
		 $advance = $this->request->getGet('advance'); 
		 $abd = $this->request->getGet('abd'); 
		 $al = $this->request->getGet('al'); 
		 $mc = $this->request->getGet('mc'); 
		 $remark = $this->request->getGet('remark'); 
		 
		$data = array(
			'sdate'=>$fdm,
			'edate'=>$now,
			'location'=>$location,
			'emps'=>$emps
		  );
		 //echo "<pre />"; print_r($data); exit;
		$empAtt = $this->AttendanceModel->searchAttendanceTol($data);
		$empRecord = $this->AttendanceModel->displayemp($emps);
		$empOff = getDay($empRecord->offday); 
		$ewdays = $empRecord->wdays; 
		//Calculate allowed off days
		$aoffday=0;
		$offcount=1;
		if($ewdays == 26)
		{
			$aoffday=5;
		}
		else if($ewdays == 27)
		{
			$aoffday=3;
		}
		else if($ewdays == 28)
		{
			$aoffday=2;
		}
		else if($ewdays == 29)
		{
			$aoffday=1;
		}
			
		//manipulate records start
			// Initialize variables
			$start_date = new \DateTime($sdate); //print_r($start_date); exit;
			$end_date = new \DateTime($edate); // Today's date
			$all_dates = [];
			$current_index = 0;
			$notWorked=0;
			// Loop through all dates from start to end
			while ($start_date <= $end_date) 
			{
				$formatted_date = $start_date->format('Y-m-d');

				// Check if the current date exists in records
				if (isset($empAtt[$current_index]) && $empAtt[$current_index]['pdate'] == $formatted_date) { 
					// Add the existing record
					$all_dates[] = [
						'date' => $formatted_date,
						'in' => $empAtt[$current_index]['in'],
						'out' => $empAtt[$current_index]['out'],
						'bin' => $empAtt[$current_index]['bin'],
						'bout' => $empAtt[$current_index]['bout'],
						'otremark' => $empAtt[$current_index]['otremark'],
						'ot' => $empAtt[$current_index]['ot']
					];
					$current_index++; // Move to the next record
				} 
				else if($start_date->format('l') === $empOff AND $offcount <= $aoffday)
				{
					// Add a placeholder for missing date
					$all_dates[] = [
						'date' => $formatted_date,
						'offtype' => 'off'
						
					];
					$offcount++;
					$notWorked++;
				}
				else
				{
					// Add a placeholder for missing date
					$all_dates[] = [
						'date' => $formatted_date,
						'offtype' => 'Upsent'
						
					];
					$notWorked++;
				}		

				// Move to the next date
				$start_date->modify('+1 day');
			}
		
		//manipulate records ends
		//echo "<pre />"; print_r($all_dates); exit;
		// Sort the array in descending order by date
		usort($all_dates, function ($a, $b) {
			return strcmp($b['date'], $a['date']); // Compare dates in descending order
		});
		
		//echo "<pre />"; print_r($all_dates); exit;
		if($empRecord)
		{
			$required_hours = $empRecord->wh; 
			$tolerance = $empRecord->tolerance; 
			
				
			$tolerance_in_hours = $tolerance / 60;			
			
			$total_overtime = 0;
			$total_undertime = 0;
			$allOverTime='';
			$allunderTime='';
			$mainStr='';
			$totalMinutes=0;
			foreach ($all_dates as $row) 
			{
				//Get Week name from the date
				$rdate = date_format(date_create($row['date']), 'd-m-Y');
				$tempDate = new \DateTime($rdate);
				$day = $tempDate->format('l'); 
				
				if(!isset($row['offtype']))
				{	
					$overtime = 0;
					$undertime = 0;
					$ot='';
					$ut='';
					$rot='';
					$rut='';
					$bgcolor='';
					// Time-in and Time-out (datetime fields)
					$time_in = new \DateTime($row['in']);
					$time_out = new \DateTime($row['out']);
					if ($time_out <= $time_in) { 
						$time_out->modify('+1 day');  // Add 1 day (24 hours) to time_out
					}
					// Calculate the total worked time (difference between time-in and time-out)
					$worked_time = $time_in->diff($time_out);  
					$worked_hours = $worked_time->h + ($worked_time->i / 60); // Convert minutes to fraction of hours
					
					// If the worked hours are less than the required hours, check if it's within the tolerance
					if ($worked_hours < $required_hours) {
						// If within tolerance, treat it as working the full required hours
						if ($worked_hours == $required_hours-1 AND $worked_time->i <= $tolerance) {
							$worked_hours = $required_hours;
						}
					}
					
					// Calculate overtime or undertime
					if ($worked_hours > $required_hours + $tolerance_in_hours) 
					{ 
						// If worked hours exceed required hours + tolerance, consider overtime
						$overtime = ($worked_hours - $required_hours)*60; 
						if($overtime>=60)
						{
							
							$osHours = floor($overtime / 60); 
							$osMinutes = trim($overtime) % 60;  
							//$rot = '+ '.$osHours.':'.$osMinutes;
						}
						else
						{
							//$rot = '+ 0:'.$overtime;
						}		
						$total_overtime += $overtime;
					} 
					elseif ($worked_hours < $required_hours - $tolerance_in_hours) 
					{  
						// If worked hours are less than required hours - tolerance, consider undertime
						$undertime = ($required_hours - $worked_hours)*60;
						if($undertime>=60)
						{
							$usHours = floor($undertime / 60);
							$usMinutes = trim($undertime) % 60;
							$rut = '- '.$usHours.':'.$usMinutes;
						}
						else
						{
							$rut = '- 0:'.$undertime;
						}		
						$total_undertime += $undertime;
					}
					$in = strtotime($row['in']);
					$in = date("g:i A", $in);
					$out = strtotime($row['out']);
					$out = date("g:i A", $out);
					
					$bin = strtotime($row['bin']);
					$bin = date("g:i A", $bin);
					$bout = strtotime($row['bout']);
					$bout = date("g:i A", $bout);
					
					
					$breakIn = new \DateTime($row['bin']);
					$breakOut = new \DateTime($row['bout']);
					$bdif = $breakIn->diff($breakOut); 
					if($bdif->h > 0 AND $bdif->i > 5)
					{
						$bgcolor="background-color:#FF7F7F;";
					}
					else if($bdif->h < 1 AND $bdif->i < 55)
					{
						$bgcolor="background-color:#90EE90;";
					}	
					$rdate = date_format(date_create($rdate), 'd/m/Y');
					$mainStr.="<tr>
									<td>$rdate</td> 
									<td>$day</td>   
									<td>$in</td>
									<td>$bin</td>
									<td style=\"$bgcolor\">$bout</td>
									<td>$out</td>
									<td>	
										$rot $rut
									</td>
									<td>	
									 {$row['ot']}
									</td>
									<td>	
										{$row['otremark']}
									</td>
								</tr>";
					//Sum the OT
					if(isset($row['ot']))
					{
						list($hours, $minutes) = explode(':', $row['ot']);
						$totalMinutes += ($hours * 60) + $minutes;
					}

						
				}
				else if(isset($row['offtype']) AND $row['offtype']=='off')
				{
					$offdate = date_format(date_create($row['date']),'d/m/Y');
					$mainStr.="<tr style=\"background-color: #90EE90;\">
								<td>$offdate</td>
								<td colspan='1'>$day</td>  
								<td colspan=\"7\">off day</td>  
							</tr>";
				}
				else if(isset($row['offtype']) AND $row['offtype']=='Upsent')
				{
					$abdate = date_format(date_create($row['date']),'d/m/Y');
					$mainStr.="<tr style=\"background-color: #FF6961;\">
									<td>$abdate</td>
									<td>$day</td>
									<td colspan=\"7\">Absent</td>  
								</tr>";
				}	
				
				
			}
			
			/*if($total_overtime>=$total_undertime)
			{
				
				$mot = $total_overtime - $total_undertime;
				$overtime_hours = floor($mot / 60);
				$overtime_minutes = trim($mot) % 60;
				$allOverTime = '+ '.$overtime_hours.':'.$overtime_minutes;
			}*/
			//if($total_overtime<$total_undertime)
			//{ 
				$mut = $total_undertime;//-$total_overtime; 
				$undertime_hours = floor($mut / 60);
				$undertime_minutes = trim($mut) % 60;
				$allunderTime = '- '.$undertime_hours.':'.$undertime_minutes;
				
			//}	
			//Overtime final
			$hours = floor($totalMinutes / 60);
			$minutes = $totalMinutes % 60;
			$totalTime = sprintf('%02d:%02d', $hours, $minutes);
			//now final undertime minus overtime 
			// Convert to minutes
			list($h1, $m1) =  explode(":", $allunderTime);//array_map('intval', explode(":", $allunderTime));
			list($h2, $m2) = explode(":", $totalTime);
			$h1 = str_replace(' ', '', $h1); // Remove spaces
			$total_minutes1 = (abs((int)$h1 * 60)) + $m1;
			//echo $total_minutes1; exit;
			$total_minutes2 = ($h2 * 60) + $m2;
				
			// Subtract the minutes
			$diff_minutes = $total_minutes2 - $total_minutes1; 
			// Determine the sign
			$sign = ($diff_minutes < 0) ? "-" : "+";
			//echo $diff_minutes; exit;
			// Convert back to HH:MM format
			$diff_hours = floor(abs($diff_minutes) / 60);  
			$diff_remaining_minutes = abs($diff_minutes) % 60;
			
			$finalTime = sprintf('%s %02d:%02d',  $sign, $diff_hours, $diff_remaining_minutes);

			//echo $finalTime; exit;

			$mainStr.="<tr style=\"font-weight:bold;\">
								<td  colspan=\"6\">Total</td>  
								<td>	
									 $allunderTime 
								</td>
								<td>	
									 + 	$totalTime 
								</td>
								<td>	
									  	$finalTime 
								</td>
							</tr>";
			
		}
		
		ob_end_clean();
		ob_start();
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Alizada');
		$pdf->SetTitle('Attendance Report');
		$pdf->SetSubject('For one Month');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		//$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
	
		// add a page
		$pdf->AddPage('P', 'A4');
		$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		//Header subparts
		/*$pdf->Cell(265, 0, 'As on: '.date('d/m/Y'), 0, 1, 'R', 0, 0, '', '');
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->Cell(55, 7, $onerecord->dcnames, 0, 'L', 0, 0, '', '', true);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->Cell(55, 7, $onerecord->addr, 0, 'L', 0, 0, '', '', true);
		$pdf->Cell(55, 7, $onerecord->phone, 0, 'L', 0, 0, '', '', true);*/
		//Center the table
		
		
		$pdf->SetFont('helvetica', '', 7);
		
		
		// Get page width and margins
		//$pageWidth = $pdf->GetPageWidth();
		//$marginLeft = $pdf->getMargins()['left']; 
		//$marginRight = $pdf->getMargins()['right']; 

		// Calculate available content width (excluding margins)
		//$contentWidth = $pageWidth - $marginLeft - $marginRight;

		// Set table width to 60% of available width
		//$tableWidth = $contentWidth * 0.7;

		// Calculate left margin to center the table
		//$xPosition = 50;//($contentWidth - $tableWidth) / 2 + $marginLeft;
		
		// Move cursor to calculated position
		//$pdf->SetX($xPosition);
		// -----------------------------------------------------------------------------
	 if(1)
	 {		
		
		$tbl = '';
		$tbl .= '
			<table cellspacing="0.1" cellpadding="3" border="0.1" width="100%" align="center">
				<tr>
					<td colspan="6" align="left" style="font-weight:bold;background-color: #fff;">Note: A tolerance of ['.$empRecord->tolerance.'] minutes and up to ['.$aoffday.'] off days are allowed based on the month for this user profile.</td>
				</tr>
				<tr>
					<td colspan="6" align="center" style="font-weight:bold;background-color: #fff;">'.getEmp($empRecord->Id).'</td>
				</tr>
				<tr>
					<td style="font-weight:bold;width:10%;">Date</td>
					<td style="font-weight:bold;width:10%;">Day</td>
					<td style="font-weight:bold;width:10%;">Clock In</td>
					<td style="font-weight:bold;width:10%;">Break In</td>
					<td style="font-weight:bold;width:10%;">Break Out</td>
					<td style="font-weight:bold;width:10%;">Clock Out</td>
					<td style="font-weight:bold;width:10%;">Lateness</td>
					<td style="font-weight:bold;width:10%;">OverTime</td>
					<td style="font-weight:bold;width:20%;">Resion</td>
					
				</tr>'.$mainStr;
			
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, true, false, '');
		}
		// Get page width and margins
		$pageWidth = $pdf->GetPageWidth();
		$marginLeft = $pdf->getMargins()['left']; 
		$marginRight = $pdf->getMargins()['right']; 

		// Calculate available content width (excluding margins)
		$contentWidth = $pageWidth - $marginLeft - $marginRight;

		// Set table width to 60% of available width
		$tableWidth = $contentWidth * 0.7;

		// Calculate left margin to center the table
		$xPosition = 50;//($contentWidth - $tableWidth) / 2 + $marginLeft;
		
		// Move cursor to calculated position
		$pdf->SetX($xPosition);
		$tb2 = '';
		$tb2 .= '
			<table cellspacing="0.1" cellpadding="3" border="0.1" width="70%" align="center">
				<tr>
					<td colspan="2" align="center" style="font-weight:bold;background-color: #fff;">User Summary</td>
				</tr>
				<tr>
					<td style="width:50%;">Full Name</td>
					<td style="width:50%;">'.getEmp($empRecord->Id).'</td>	
				</tr>
				<tr>
					<td style="width:50%;">OT in Hours</td>
					<td style="width:50%;">'.$finalTime.'</td>	
				</tr>
				<tr>
					<td style="width:50%;">off day</td>
					<td style="width:50%;">'.getDay($empRecord->offday).'</td>	
				</tr>
				<tr>
					<td style="width:50%;">Worked off day</td>
					<td style="width:50%;">'.$wod.'</td>	
				</tr>
				<tr>
					<td style="width:50%;">Public Holiday</td>
					<td style="width:50%;">'.$ph.'</td>	
				</tr>
				<tr>
					<td style="width:50%;">Basic Salary</td>
					<td style="width:50%;">'.number_format($empRecord->bsalary,2).'</td>	
				</tr>
				<tr>
					<td style="width:50%;">Bonus/Claims</td>
					<td style="width:50%;">'.$claims.'</td>	
				</tr>
				<tr>
					<td style="width:50%;">MC</td>
					<td style="width:50%;">'.$mc.'</td>	
				</tr>
				<tr>
					<td style="fwidth:50%;">A/L</td>
					<td style="width:50%;">'.$al.'</td>	
				</tr>
				<tr>
					<td style="fwidth:50%;">Absent day</td>
					<td style="width:50%;">'.$abd.'</td>	
				</tr>
				<tr>
					<td style="fwidth:50%;">Advance</td>
					<td style="width:50%;">'.$advance.'</td>	
				</tr>
				<tr>
					<td style="fwidth:50%;">Remark</td>
					<td style="width:50%;">'.$remark.'</td>	
				</tr>
				';
			
			$tb2 .='</table>';
			$pdf->writeHTML($tb2, true, false, true, false, '');	

		// -----------------------------------------------------------------------------
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		
		$date = new \DateTime($sdate);
		$monthName = $date->format('F'); // Full month name (e.g., February)
		
		$pdf->Output(getEmp($empRecord->Id).' - '.$monthName.'.pdf', 'I');
		
		
		echo APPPATH; exit;
		
		

    }


//Show short nationality
	public function shortNat($id)
	{
		if($id==1)
		{
			return 'L';
		}
		else
		{
			return 'F';
		}		
	}	
	
	//per day salary 
	public function perday($bsalary, $wdays)
	{
		if(isset($bsalary) AND isset($wdays))
		{
			return round($bsalary/$wdays, 2);
		}
		else
		{
			return 0;
		}		
	}
	//per hour salary 
	public function perhour($perday, $wh)
	{	
		if(isset($perday) AND isset($wh))
		{	
			return round($perday/$wh, 2);
		}
		else
		{
			return 0;
		}		
	}
	
	//Find OT hours
	public function otHours($empId, $sdate, $edate)
	{
		$data['empId']=$empId; 
		$data['sdate']=$sdate; 
		$data['edate']=$edate; 
		
		$empAtt = $this->SalaryModel->bringAttendance($data);
		$empRecord = $this->SalaryModel->getEmployee($empId);
		
		$required_hours = $empRecord->wh; 
		$tolerance = $empRecord->tolerance;
		$tolerance_in_hours = $tolerance / 60;
		
		//echo "<pre />"; print_r($empAtt); exit;
			$total_overtime = 0;
			if($empAtt)
			{
				foreach ($empAtt as $row) 
				{
					
					$overtime = 0;
					// Time-in and Time-out (datetime fields)
					$time_in = new \DateTime($row['in']);
					$time_out = new \DateTime($row['out']);
					
					// Calculate the total worked time (difference between time-in and time-out)
					$worked_time = $time_in->diff($time_out);
					$worked_hours = $worked_time->h + ($worked_time->i / 60); // Convert minutes to fraction of hours

					
					// Calculate overtime or undertime
					if ($worked_hours > $required_hours + $tolerance_in_hours) 
					{
						// If worked hours exceed required hours + tolerance, consider overtime
						$overtime = $worked_hours - $required_hours;
								
						$total_overtime += $overtime;
					} 	
				}
				
				//$h = floor($total_overtime);
				//$m = round(($total_overtime - $h) * 60);
			}
			
			return round($total_overtime, 2);
	}
	
	//Worked Off Days
	public function workedOffdays($empId, $sdate, $edate)
	{	
		$data['empId']=$empId; 
		$data['sdate']=$sdate; 
		$data['edate']=$edate; 
		
		$empAtt = $this->SalaryModel->bringAttendance($data);
		$empRecord = $this->SalaryModel->getEmployee($empId);
		
		$empOff = getDay($empRecord->offday);
		$ewdays = $empRecord->wdays; 
		//Calculate allowed off days
		$aoffday=0;
		if($ewdays == 26)
		{
			$aoffday=5;
		}
		else if($ewdays == 27)
		{
			$aoffday=3;
		}
		else if($ewdays == 28)
		{
			$aoffday=2;
		}
		else if($ewdays == 29)
		{
			$aoffday=1;
		}	
		$required_hours = $empRecord->wh; 
		$tolerance = $empRecord->tolerance;
		$tolerance_in_hours = $tolerance / 60;
		
		$start_date = new \DateTime($sdate); //print_r($start_date); exit;
		$end_date = new \DateTime($edate); // Today's date
			
		$current_index = 0;
		$workedDays=0;
		//echo "<pre />"; print_r($empAtt); exit;
		// Loop through all dates from start to end
			
		while ($start_date <= $end_date) 
		{
			$formatted_date = $start_date->format('Y-m-d');
			
			// Check if the current date exists in records
			if (isset($empAtt[$current_index]) && $empAtt[$current_index]['pdate'] == $formatted_date && $start_date->format('l') == $empOff AND $workedDays <$aoffday) { 
				// Add the existing record
				$workedDays++;
				
			} 
	
			$start_date->modify('+1 day');
			$current_index++; // Move to the next record

		}
		return $workedDays;
		
	}
	//List the leave
	public function leaveList()
    {		
			
			$data['a']='a';
			$hdata['title']='Leave List';
			echo view('attendance/header', $hdata);
			echo view('attendance/leave/list', $data);
			echo view('attendance/footer');
    }
	
	//leave type main layout
	public function leaveAdd()
    {		
			
			$leaveTypes = $this->AttendanceModel->getLeaveTypes();
			$leaves='';			
			foreach($leaveTypes AS $row)
			{
					$leaves.='<option value="'.$row->Id.'">'.$row->leaveName.'</option>';	
			}
			$data['leaveTypes']=$leaves;
			
			$hdata['title']='Add Leave';
			echo view('attendance/leave/header', $hdata);
			echo view('attendance/leave/leaveAdd', $data);
			echo view('attendance/leave/footer');
    }
}


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	
	
	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'tamay.jpg'; 
		//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 10);
		// set cell padding
		//$this->setCellPaddings(1, 1, 1, 1);

		// set cell margins
		//$this->setCellMargins(1, 1, 1, 1);

		// set color for background
		//$this->SetFillColor(255, 255, 127);
		// Title
		// Multicell test
		//$this->MultiCell(55, 5, 'dfadfafda dfadfafda dfadfadf dfadfadf dfadf', 0, 'L', 0, 1, '', '', true);
		if ($this->page == 1) 
		{
			$image_file = K_PATH_IMAGES.'tamay.jpg';
			$this->Image($image_file, 15, 15, 15, '', 'JPG', '', 'C', false, 300, 'C', false, false, 0, false, false, false);
			$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+5, PDF_MARGIN_RIGHT);
			$this->Cell(55, 7, 'TAMAY', 0, 'L', 1, 0, '', '', true);
			$this->SetFont('helvetica', '', 10);
			$this->Cell(55, 7, 'Unit 12-02, Fahrenheit 88, No 179,', 0, 'L', 1, 0, '', '', true);
			$this->Cell(55, 7, 'Jalan Bukit Bintang, Kuala Lumpur', 0, 'L', 1, 0, '', '', true);
			$this->SetFont('helvetica', '', 10);
			$this->Cell(55, 7, '+60 32142 1197', 0, 'L', 1, 0, '', '', true);
			$this->SetFont('helvetica', 'B', 10);
			$this->setCellMargins(1, 1, 1, 1);
			//$this->Cell(55, 7, 'STATEMENT OF ACCOUNT (OUTSTANDING)',0, false, 'L', 0, '', 0, false, '', '');
			//$this->SetFont('helvetica', '', 12);
			
		}
	    //$this->Cell(55, 7, 'uuuuuuuuu', 0, 'L', 0, 0, '', '', true);
	    //$this->Cell(55, 7, 'uuuuuuuuu', 0, 'L', 0, 0, '', '', true);
	    //$this->Cell(270, 7, 'yyyyyyyyyyyyy', 0, 1, 'R', 0, '', '', '');
		
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
	
	
}