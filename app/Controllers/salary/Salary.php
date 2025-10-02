<?php

namespace App\Controllers\salary;
use App\Controllers\BaseController;
use App\Models\salary\SalaryModel;
use CodeIgniter\I18n\Time;

require_once(APPPATH . '/ThirdParty/vendor2/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Salary extends BaseController
{
    //my constructor
	public function __construct() 
	{

        $this->SalaryModel = new SalaryModel();
		$request = \Config\Services::request();
        helper('fornames');
	}
	
	public function index()
    {		
			
			$data['a']='a';
			$hdata['title']='Attendance Dashboard';
			echo view('attendance/header', $hdata);
			echo view('attendance/dashboard', $data);
			echo view('attendance/footer');
    }
	//Salary List
	public function salaryList()
    {		
			
			$allSalary = $this->SalaryModel->getAllSalary();
			$total = $this->SalaryModel->getTotalSalary();
			//Locations
			$locations = $this->SalaryModel->getLocations();	
			$shops='';
			foreach($locations AS $shop)
			{
					$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';	
			}
			$data['locations'] = $shops;
			$data['total'] = $total;
			//echo "<pre />"; print_r($allSalary); exit;
	
			//echo "<pre />"; print_r($allSalary); exit;
			$data['records']=$allSalary;
			$hdata['title']='Salary Details';
			echo view('salary/header', $hdata);
			echo view('salary/salaryList', $data);
			echo view('salary/footer');
    }
	
	//Get basic salary
	public function bsalary($empId)
	{
		$empDetails = $this->SalaryModel->edetails($empId);
		return $empDetails->bsalary;
	}
	//Get full Name
	public function getName($empId)
	{
		$empDetails = $this->SalaryModel->edetails($empId);
		return $empDetails->name.' '.$empDetails->lname;
	}
	//Save user details for salary
	public function save()
    {		
			$empId = $this->request->getPost('empId'); 
			$sdate = $this->request->getPost('sdate'); 
			$nat = $this->request->getPost('nat'); 
			$bname = $this->request->getPost('bname'); 
			$accno = $this->request->getPost('accno'); 
			$bsalary = $this->request->getPost('bsalary'); 
			$wdays = $this->request->getPost('wdays');
			$wh = $this->request->getPost('wh'); 
			$perhour = $this->request->getPost('perhour');
			$otHours = $this->request->getPost('otHours');
			$location = $this->request->getPost('location'); 
			//OT In RM 
			if($otHours > 0)
			{	
				$otRm = trim(floatval($perhour)) * trim(floatval($otHours)) * 1.5;
			}
			else
			{
				$otRm = 0;
			}
			
			$perday = $this->request->getPost('perday'); 
			$wod = $this->request->getPost('wod'); 
			//Worked off day in RM
			$wodRm=0;
			if($wod!='')
			{
				$wodRm = $wod * $perday;
			}
			$ph = $this->request->getPost('ph');
			//Public Holiday in RM
			$phRm=0;
			if($ph!='')
			{
				$phRm = trim($ph) * trim($perday);
			}	
			$claims = $this->request->getPost('claims'); 
			//Calculate gross salary
			$gSalary = trim(floatval($claims)) + trim($phRm) + trim($wodRm) + trim($otRm) + trim($bsalary);
	
			$epf = $this->request->getPost('epf'); 
			$advance = $this->request->getPost('advance'); 
			$abd = $this->request->getPost('abd');
			//Calculate absent day
			$abdRm=0;
			$abdRm = trim(floatval($abd)) * trim($perday);
			//Calulate the lateness
			$lathrs = 0;
			if($otHours < 0)
			{
				$lathrs = $otHours;
			}
			//Calculate lateness in Rm
			$lateness = 0;
			if($otHours < 0)
			{
				$lateness = abs($otHours) * trim($perhour);
				 
			} 
			//Calculate total deduction
			$deduction = 0;
			if($otHours < 0)
			{
				$deduction = trim($lateness) + trim(floatval($abdRm)) + trim(floatval($advance)) + trim(floatval($epf));
			}
			else
			{
				$deduction = trim(floatval($abdRm)) + trim(floatval($advance)) + trim(floatval($epf));
			}
			//Calculate the Net salary
			$netSalary = trim(floatval($gSalary)) - trim($deduction);
			$remark = $this->request->getPost('remark');
			
			//Get username and id from the session
			$username = $this->session->get('name');
			$userid = $this->session->get('userid');
			$data = array(
				'empId'		=>$empId,
				'sdate'		=>$sdate,
				'nat'  		=>$nat,
				'bname'  	=>$bname,
				'accno'  	=>$accno,
				'bsalary' 	=>$bsalary,
				'wdays' 	=>$wdays,
				'perday' 	=>$perday,
				'wh' 		=>$wh,
				'perhour' 	=>$perhour,
				'otHours'	=>$otHours,
				'otRate'	=>1.5,
				'otRm'		=>$otRm,
				'wod'		=>$wod,
				'wodRm'		=>$wodRm,
				'ph'		=>$ph,
				'phRm'		=>$phRm,
				'claims'	=>$claims,
				'gSalary'	=>$gSalary,
				'epf'		=>$epf,
				'advance'	=>$advance,
				'abd'		=>$abd,
				'abdRm'		=>$abdRm,
				'lathrs'	=>$lathrs,
				'lateness'	=>$lateness,
				'deduction'	=>$deduction,
				'netSalary'	=>$netSalary,
				'remark'	=>$remark,
				'location'	=>$location,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			//echo "<pre />"; print_r($data); exit; 
			$rid = $this->SalaryModel->saveRecord($data, 'salary');   
			if($rid)
			{
				return redirect()->to(base_url('codeigniter/public/salary/view/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Your record is not saved successfully";
			}
			
    }	
	
	//View the salary details
	public function view($rid,$flag)
	{	
	
		//Get record details
		$rdetails = $this->SalaryModel->rdetails($rid);
		/*$edetails = $this->SalaryModel->edetails($rdetails->userid);
		$edetails->perday = $this->perday($edetails->bsalary, $edetails->wdays);
		$edetails->perhour = $this->perhour($edetails->perday, $edetails->wh);
		$edetails->otRate = 1.5;
		if($rdetails->otHours > 0)
		{	
			$edetails->otRm = $edetails->perhour * $rdetails->otHours * 1.5;
		}
		else
		{
			$edetails->otRm = 0;
		}	
		$rdetails->abrm = $rdetails->abd * $edetails->perday;*/
		//echo "<pre />"; print_r($edetails); exit;
		$data['rdetails'] = $rdetails;
		//$data['edetails'] = $edetails;
		
		$hdata['title']='Salary Details';
		echo view('salary/header', $hdata);
		echo view('salary/view', $data);
		echo view('salary/footer');
	}

	//Update Salary Record
	public function update($rid)
	{	
		//Get record details
		$rdetails = $this->SalaryModel->rdetails($rid);
		$edetails = $this->SalaryModel->edetails($rdetails->empId);
		$data['edetails'] = $edetails;
		$data['row'] = $rdetails;
		$hdata['title']='Update Record';
		echo view('salary/header', $hdata);
		echo view('salary/update', $data);
		echo view('salary/footer');
	}
	
	//Save the update
	public function updateSave($rid)
	{	
			$empId = $this->request->getPost('empId');
			$edetails = $this->SalaryModel->edetails($empId);	
			
			$sdate = $this->request->getPost('sdate'); 
			$nat = $edetails->nat;
			$bname = $edetails->bname;
			$accno = $edetails->accno;
			$bsalary = $edetails->bsalary;
			$wdays = $edetails->wdays;
			$wh = $edetails->wh-1;
			$otHours = $this->request->getPost('otHours');
			$perday = $edetails->bsalary / $edetails->wdays; 
			$perhour = $perday / $wh;
			
			//OT In RM 
			if($otHours > 0)
			{	
				$otRm = trim(floatval($perhour)) * trim(floatval($otHours)) * 1.5;
			}
			else
			{
				$otRm = 0;
			}
			
			
			$wod = $this->request->getPost('wod'); 
			//Worked off day in RM
			$wodRm=0;
			if($wod!='')
			{
				$wodRm = $wod * $perday;
			}
			$ph = $this->request->getPost('ph');
			//Public Holiday in RM
			$phRm=0;
			if($ph!='')
			{
				$phRm = trim($ph) * trim($perday);
			}	
			$claims = $this->request->getPost('claims'); 
			//Calculate gross salary
			$gSalary = trim(floatval($claims)) + trim($phRm) + trim($wodRm) + trim($otRm) + trim(floatval($bsalary));
	
			$epf = $this->request->getPost('epf'); 
			$advance = $this->request->getPost('advance'); 
			$abd = $this->request->getPost('abd');
			//Calculate absent day
			$abdRm=0;
			$abdRm = trim(floatval($abd)) * trim($perday);
			//Calulate the lateness
			$lathrs = 0;
			if($otHours < 0)
			{
				$lathrs = $otHours;
			}
			//Calculate lateness in Rm
			$lateness = 0;
			if($otHours < 0)
			{
				$lateness = abs($otHours) * trim($perhour);
				 
			} 
			//Calculate total deduction
			$deduction = 0;
			if($otHours < 0)
			{
				$deduction = trim($lateness) + trim(floatval($abdRm)) + trim(floatval($advance)) + trim(floatval($epf));
			}
			else
			{
				$deduction = trim(floatval($abdRm)) + trim(floatval($advance)) + trim(floatval($epf));
			}
			//Calculate the Net salary
			$netSalary = trim(floatval($gSalary)) - trim($deduction);
			$remark = $this->request->getPost('remark');
	
		
		$data = array(
			'empId'		=>$empId,
			'sdate'		=>$sdate,
			'nat'  		=>$nat,
			'bname'  	=>$bname,
			'accno'  	=>$accno,
			'bsalary' 	=>$bsalary,
			'wdays' 	=>$wdays,
			'perday' 	=>$perday,
			'wh' 		=>$wh,
			'perhour' 	=>$perhour,
			'otHours'	=>$otHours,
			'otRate'	=>1.5,
			'otRm'		=>$otRm,
			'wod'		=>$wod,
			'wodRm'		=>$wodRm,
			'ph'		=>$ph,
			'phRm'		=>$phRm,
			'claims'	=>$claims,
			'gSalary'	=>$gSalary,
			'epf'		=>$epf,
			'advance'	=>$advance,
			'abd'		=>$abd,
			'abdRm'		=>$abdRm,
			'lathrs'	=>$lathrs,
			'lateness'	=>$lateness,
			'deduction'	=>$deduction,
			'netSalary'	=>$netSalary,
			'remark'	=>$remark,
			
		  );
		  //echo "<pre />"; print_r($data); exit;
		 $update = $this->SalaryModel->updateRecord($data, $rid, 'salary');   
		 if($update == 1)
		 {
			return redirect()->to(base_url('codeigniter/public/salary/view/'.$rid.'/1'.'')); exit;
		 }
		 else
		 {
			echo "Your record is not saved successfully";
		 }
	}
		
	//Salary Dashboard
	public function salaryDashboard()
	{	
		//Locations
		$locations = $this->SalaryModel->getLocations();	
		$shops='';
		foreach($locations AS $shop)
		{
				$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';	
		}
		$data['locations']=$shops;
		
		//employees
		$employees = $this->SalaryModel->getEmployees();
		$allEmps='';
		foreach($employees AS $emp)
		{
				$allEmps.='<option value="'.$emp->Id.'">'.$emp->name.' '.$emp->lname.'</option>';	
		}
		$data['employees']=$allEmps;
		$hdata['title']='Salary Layout';
		echo view('salary/header', $hdata);
		echo view('salary/dashboard', $data);
		echo view('salary/footer');
	
	}
	
	//Salary Dashboard
	public function mainLayout()
	{	
		
		$sdate = $this->request->getGet('sdate'); 
		$edate = $this->request->getGet('edate'); 
		$location = $this->request->getGet('location');
		$status = $this->request->getGet('status');
		//My location	
		$employees = $this->SalaryModel->getEmpBylocation($location);
		//echo "<pre />"; print_r($employees); exit;
		foreach($employees AS &$row)
		{
			$row['fullName'] = $row['name'].' '.$row['lname']; 
			$row['nat'] = $this->shortNat($row['nat']); 
			$row['bname'] = getbname($row['bname']); 
			$row['perday'] = $this->perday($row['bsalary'], $row['wdays']); 
			$row['perhour'] = $this->perhour($row['perday'], $row['wh']); 
			$row['otHours'] = $this->otHours($row['Id'],$sdate, $edate); 
			$row['otRate'] = 1.5; 
			$row['otRm'] = $row['perhour'] * $row['otHours'] * 1.5; 
			$row['woffdays'] = $this->workedOffdays($row['Id'],$sdate, $edate); 
		}	
		//echo "<pre />"; print_r($employees); exit;
		$rows= json_encode($employees);
		$data['rows']=$rows;
		echo view('salary/mainLayout', $data);
		
	
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
			if (isset($empAtt[$current_index]) && $empAtt[$current_index]['pdate'] == $formatted_date) { 
				// Add the existing record
				$workedDays++;
				$current_index++; // Move to the next record
			} 
			// Move to the next date
			$start_date->modify('+1 day');
		}
		//echo $workedDays; exit;
		
	}	
	
	//Search Salary
	function searchSalary()
	{
		
			$sdate = $this->request->getPost('sdate');
			$data['sdate'] = $sdate;
			$location = $this->request->getPost('location'); 
			$data['location'] = $location;
			$nat = $this->request->getPost('nat');
			if($nat==1)
			{	
				$nat.='<option value="1" selected>Local</option>';
				$nat.='<option value="2">Foreigner</option>';
			}
			else if($nat=='')
			{
				$nat.='<option value="1" >Local</option>';
				$nat.='<option value="2">Foreigner</option>';
			}
			else
			{
				$nat.='<option value="1" >Local</option>';
				$nat.='<option value="2" selected>Foreigner</option>';
			}		
			$data['nat'] = $nat;			
			$allSalary = $this->SalaryModel->salarySearch($data); 
			$total = $this->SalaryModel->totalSearchSalary($data);
			//Locations
			$locations = $this->SalaryModel->getLocations();	
			$shops='';
			foreach($locations AS $shop)
			{
				if($shop->Id==$location)
				{	
					$shops.='<option value="'.$shop->Id.'" selected>'.$shop->name.'</option>';
				}
				else
				{	
					$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';
				}					
			}
			$data['locations'] = $shops;
			$data['total'] = $total;
			//echo "<pre />"; print_r($allSalary); exit;
	
			//echo "<pre />"; print_r($allSalary); exit;
			$data['records']=$allSalary;
			$hdata['title']='Salary Details';
			echo view('salary/header', $hdata);
			echo view('salary/searchSalaryList', $data);
			echo view('salary/footer');
			
			
	}
	
	//Generate file
	public function generateFile()
	{
			$sdate = $this->request->getPost('sdate');
			$data['sdate'] = $sdate;
			$location = $this->request->getPost('location'); 
			$data['location'] = $location;
			$data['nat'] = $this->request->getPost('nat');
			$allSalary = $this->SalaryModel->salarySearch($data); 
			$total = $this->SalaryModel->totalSearchSalary($data);
			//echo "<pre/>"; print_r($allSalary); exit;
			
			$spreadsheet = new Spreadsheet();
			$activeWorksheet = $spreadsheet->getActiveSheet();
			
			
			$activeWorksheet->setCellValue('A2', 'No');
			$activeWorksheet->setCellValue('B2', 'FULL NAME');
			$activeWorksheet->setCellValue('C2', 'L/F');
			$activeWorksheet->setCellValue('D2', 'BANK NAME');
			$activeWorksheet->setCellValue('E2', 'ACCOUNT NO');
			$activeWorksheet->setCellValue('F2', 'BASIC SALARY');
			$activeWorksheet->setCellValue('G2', 'WOKING DAYS');
			$activeWorksheet->setCellValue('H2', 'PERDAY (RM)');
			$activeWorksheet->setCellValue('I2', 'HOURS');
			$activeWorksheet->setCellValue('J2', 'PER HOUR (RM)');
			$activeWorksheet->setCellValue('K2', 'OT HRS');
			$activeWorksheet->setCellValue('L2', 'OT RATE');
			$activeWorksheet->setCellValue('M2', 'OT (RM)');
			$activeWorksheet->setCellValue('N2', 'WORKED OFF DAY');
			$activeWorksheet->setCellValue('O2', 'WORKED OFF DAY (RM)');
			$activeWorksheet->setCellValue('P2', 'PH');
			$activeWorksheet->setCellValue('Q2', 'PH (RM)');
			$activeWorksheet->setCellValue('R2', 'CLAIMS');
			$activeWorksheet->setCellValue('S2', 'GROSS SALARY');
			$activeWorksheet->setCellValue('T2', 'EPF');
			$activeWorksheet->setCellValue('U2', 'ADVANCE');
			$activeWorksheet->setCellValue('V2', 'ABSENT (DAY)');
			$activeWorksheet->setCellValue('W2', 'ABSENT (RM)');
			$activeWorksheet->setCellValue('X2', 'LATENESS (HRS)');
			$activeWorksheet->setCellValue('Y2', 'LATENESS (RM)');
			$activeWorksheet->setCellValue('Z2', 'TOTAL DEDUCTION (RM)');
			$activeWorksheet->setCellValue('AA2', 'NET SALARY (RM)');
			
			
			
			$i=3;
			$j=1;
			foreach($allSalary AS $row)
			{
				$activeWorksheet->setCellValue('A'.$i, $j);
				$activeWorksheet->setCellValue('B'.$i, getEmp($row->empId));
				$activeWorksheet->setCellValue('C'.$i, getNat2($row->nat));
				$activeWorksheet->setCellValue('D'.$i, getbname($row->bname));
				$activeWorksheet->setCellValue('E'.$i, $row->accno);
				$activeWorksheet->setCellValue('F'.$i, $row->bsalary);
				$activeWorksheet->getStyle('F' .$i)
								->getNumberFormat()
								->setFormatCode('"RM "#,##0.00');
				$activeWorksheet->setCellValue('G'.$i, $row->wdays);
				//$activeWorksheet->setCellValue('H' . $i, '=F' . $i . '/G' . $i);
				$activeWorksheet->setCellValue('H' . $i, '=IF(G'. $i . '=0, "Error", ROUND(F' . $i . '/G' . $i . ', 2))');
				$activeWorksheet->setCellValue('I'.$i, $row->wh);
				$activeWorksheet->setCellValue('J' . $i, '=IF(G'. $i . '=0, "Error", ROUND(H' . $i . '/I' . $i . ', 2))');
				

				$otHours=0;
				$utHours=0;
				if($row->otHours < 0)
				{
					$utHours = abs($row->otHours);
				}
				else
				{
					$otHours = $row->otHours;
				}
				$activeWorksheet->setCellValue('K'.$i, $otHours);
				$activeWorksheet->setCellValue('L'.$i, 1.5);
				$activeWorksheet->setCellValue('M' . $i, '=ROUND(K'.$i.'*J'.$i.'*L'.$i.', 2)');
				$activeWorksheet->setCellValue('N'.$i, $row->wod);
				$activeWorksheet->setCellValue('O' . $i, '=ROUND(N'.$i.'*H'.$i.', 2)');
				$activeWorksheet->setCellValue('P'.$i, $row->ph);
				$activeWorksheet->setCellValue('Q' . $i, '=ROUND(P'.$i.'*H'.$i.', 2)');
				$activeWorksheet->setCellValue('R'.$i, $row->claims);
				$activeWorksheet->getStyle('R' .$i)
								->getNumberFormat()
								->setFormatCode('"RM "#,##0.00');
				$activeWorksheet->setCellValue('S' . $i, '=R'.$i.'+Q'.$i.'+O'.$i.'+M'.$i.'+F'.$i);		
				$activeWorksheet->getStyle('S' .$i)				
								->getNumberFormat()
								->setFormatCode('"RM "#,##0.00');
				$activeWorksheet->setCellValue('T'.$i, $row->epf);
				$activeWorksheet->getStyle('T' .$i)				
								->getNumberFormat()
								->setFormatCode('"RM "#,##0.00');
				$activeWorksheet->setCellValue('U'.$i, $row->advance);
				$activeWorksheet->getStyle('U' .$i)				
								->getNumberFormat()
								->setFormatCode('"RM "#,##0.00');				
				$activeWorksheet->setCellValue('V'.$i, $row->abd);
				$activeWorksheet->setCellValue('W' . $i, '=V'.$i.'*H'.$i);
				$activeWorksheet->getStyle('W' .$i)				
								->getNumberFormat()
								->setFormatCode('"RM "#,##0.00');
				$activeWorksheet->setCellValue('X'.$i, $utHours);
				$activeWorksheet->setCellValue('Y' . $i, '=X'.$i.'*J'.$i);
				$activeWorksheet->getStyle('Y' .$i)				
								->getNumberFormat()
								->setFormatCode('"RM "#,##0.00');
				$activeWorksheet->setCellValue('Z'.$i, '=Y'.$i.'+W'.$i.'+U'.$i.'+T'.$i);
				$activeWorksheet->getStyle('Z' .$i)				
								->getNumberFormat()
								->setFormatCode('"RM "#,##0.00');
				$activeWorksheet->setCellValue('AA'.$i, '=S'.$i.'-Z'.$i);
				$activeWorksheet->getStyle('AA' .$i)				
								->getNumberFormat()
								->setFormatCode('"RM "#,##0.00');				
				
				$i++;
				$j++;
			}
			$activeWorksheet->getColumnDimension('B')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('C')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('D')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('E')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('F')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('G')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('H')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('I')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('J')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('k')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('L')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('M')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('N')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('P')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('Q')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('R')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('S')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('T')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('U')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('V')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('W')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('X')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('Y')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('Z')->setAutoSize(true);
			$activeWorksheet->getColumnDimension('AA')->setAutoSize(true);
			
			//Get TOTAL
			//$activeWorksheet->setCellValue('F'.$i, $total->tbsalary);
			//$activeWorksheet->getStyle('F' .$i)				
				//				->getNumberFormat()
					//			->setFormatCode('"RM "#,##0.00');
			//Set lef to all cells
			$activeWorksheet->getStyle('A1:Z100')
								->getAlignment()
								->setHorizontal(Alignment::HORIZONTAL_LEFT);
								
			$activeWorksheet->setSelectedCell('A1'); // Set focus to A1
			$writer = new Xlsx($spreadsheet);
			//$writer->save('hello world.xlsx'); 
			ob_clean();
		    //ob_start();
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header("Content-Disposition: attachment;filename=\"SalaryReport.xlsx\"");
			header("Cache-Control: max-age=0");
			header("Expires: Fri, 11 Nov 2011 11:11:11 GMT");
			header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");
			header("Cache-Control: cache, must-revalidate");
			header("Pragma: public");
			$writer->save("php://output");
			//ob_end_flush();
			exit;
			
	}	
}
