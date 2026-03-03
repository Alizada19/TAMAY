<?php

namespace App\Controllers\expenses;
use App\Controllers\BaseController;
use App\Models\expenses\ExpensesModel;
use CodeIgniter\I18n\Time;

require_once(APPPATH . '/ThirdParty/vendor2/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
class Expenses extends BaseController
{
    //my constructor
	public function __construct() 
	{

        $this->ExpensesModel = new ExpensesModel();
		$request = \Config\Services::request();
        helper('fornames');
	}
	
	public function index()
    {		
			
			/*$spreadsheet = new Spreadsheet();
			$activeWorksheet = $spreadsheet->getActiveSheet();
			$activeWorksheet->setCellValue('A1', 'Hello World !');
			$writer = new Xlsx($spreadsheet);
			//$writer->save('hello world.xlsx'); 
			ob_clean();
		    //ob_start();
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header("Content-Disposition: attachment;filename=\"2-download.xlsx\"");
			header("Cache-Control: max-age=0");
			header("Expires: Fri, 11 Nov 2011 11:11:11 GMT");
			header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");
			header("Cache-Control: cache, must-revalidate");
			header("Pragma: public");
			$writer->save("php://output");
			//ob_end_flush();
			exit;
			*/
			$perPage = 200;
			$cpage = isset($_GET['page_no']) ? $_GET['page_no'] : 1; 
			$previous_page = $cpage - 1;
			$next_page = $cpage + 1;
			$offset=($cpage - 1) * $perPage;
			$total = $this->ExpensesModel->getOneTotal('amount','expenses'); 
			$total_no_of_pages = ceil($total / $perPage); 
			$bita['perPage'] = $perPage;
			$bita['offset'] = $offset;
			$bita['cpage'] = $cpage;
			$bita['total_no_of_pages'] = $total_no_of_pages;
			$bita['previous_page'] = $previous_page;
			$bita['next_page'] = $next_page;
			$bita['total'] = $total;
			$result = $this->ExpensesModel->expensesAllResult($perPage, $offset);
			
			//for the filter search start
			$groupe = $this->ExpensesModel->getAllResult('groupe');
			$category = $this->ExpensesModel->getAllResult('category');
			$subcategory = $this->ExpensesModel->getAllResult('subcategory');
			$gstr='';
			$cstr='';
			$sstr='';
			$gstr.='<option value="">Groupe</option>';
			$cstr.='<option value="">Category</option>';
			$sstr.='<option value="">Subcategory</option>';
			foreach($groupe AS $g)
			{
					$gstr.='<option value="'.$g->Id.'">'.$g->gname.'</option>';	
			}
			foreach($category AS $c)
			{
					$cstr.='<option value="'.$c->Id.'">'.$c->cname.'</option>';	
			}	
			foreach($subcategory AS $s)
			{
					$sstr.='<option value="'.$s->Id.'">'.$s->sname.'</option>';	
			}	
			$data['gstr']=$gstr;
			$data['cstr']=$cstr;
			$data['sstr']=$sstr;
			//for the filter search end 
			 
			$sum = $this->ExpensesModel->mainOneTotal('amount','expenses'); 
			//$result = $this->ExpensesModel->expensesAllResult();  
			$data['result']=$result;
			$data['sum']=$sum;
			$hdata['title']='List Expenses';
			echo view('expenses/header', $hdata);
			echo view('expenses/list', $data);
			echo view('expenses/footer');
			if($total>$perPage)
			{	
				 //displayPagination2($bita);
			}
    }
	
	//Add Expense
	public function add()
	{	
			//Get Groupes/category/subcategory
			$groupe = $this->ExpensesModel->getAllGroups('groupe');
			$category = $this->ExpensesModel->getAllResult('category');
			$subcategory = $this->ExpensesModel->getAllResult('subcategory');
			$gstr='';
			$cstr='';
			$sstr='';
			foreach($groupe AS $g)
			{
					$gstr.='<option value="'.$g->Id.'">'.$g->gname.'</option>';	
			}
			foreach($category AS $c)
			{
					$cstr.='<option value="'.$c->Id.'">'.$c->cname.'</option>';	
			}	
			foreach($subcategory AS $s)
			{
					$sstr.='<option value="'.$s->Id.'">'.$s->sname.'</option>';	
			}	
			$data['gstr']=$gstr;
			$data['cstr']=$cstr;
			$data['sstr']=$sstr;
			//Bring the debtors and creditors
			 $db = \Config\Database::connect();
			 $dc = $db->query("SELECT * FROM debtorcreditor");
			 $dcres = $dc->getResult();
			 //echo "<pre />"; print_r($dcres); exit;
			 $str='';
			 foreach($dcres AS $dc)
			 {
				$str.='<option value="'.$dc->Id.'">'.$dc->dcnames.'</option>';
			 }	 
			$data['str'] = $str;
			$hdata['title']='Add Expense';
			echo view('expenses/header', $hdata);
			echo  view('expenses/add', $data);
			echo view('expenses/footer');
	}
	
	//Save expense
	public function save()
	{
		$pdate = $this->request->getPost('pdate');
		$amount = trim($this->request->getPost('amount'));
		$ptype = $this->request->getPost('ptype');
		$crno = $this->request->getPost('crno');
		$groupe = $this->request->getPost('groupe');
		$category = $this->request->getPost('category');
		$subcategory = $this->request->getPost('subcategory');
		$des = $this->request->getPost('des');
		$cno = $this->request->getPost('cno');
			
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
				'pdate'=>$pdate,
				'amount'=>$amount,
				'ptype'=>$ptype,
				'crno'=>$crno,
				'groupe'=>$groupe,
				'category'=>$category,
				'subcategory'=>$subcategory,
				'des'=>$des,
				'cno'=>$cno,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			 if($cno!='')
			 {
				$this->ExpensesModel->updateCheque($cno); 
			 }		
			$rid = $this->ExpensesModel->saveRecord($data, 'expenses'); 
			if($rid)
			{
				return redirect()->to(base_url('expenses/view/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Your record is not saved successfully";
			}		
				
	}
	
	//Expenses view
	public function view($rid,$flag)
	{
		    
		$row = $this->ExpensesModel->displayRecord($rid, 'expenses');
		$data['row'] = $row;
		$data['flag'] = $flag;
		$hdata['title'] = 'View Expense';
		echo view('expenses/header', $hdata);
		echo view('expenses/view', $data);
		echo view('expenses/footer');
	}
	//Expenses edit view
	public function editView($rid)
	{
		$row = $this->ExpensesModel->displayRecord($rid, 'expenses');
		//payment type start
		$types=array(
			'1'=>'OT',
			'2'=>'Cheque',
			'3'=>'Cash'
		);
		$typeStr='';
		foreach($types AS $key=>$value)
		{
			if($key==$row->ptype)
			{
				$typeStr.='<option value="'.$key.'" selected>'.$value.'</option>';	
			}
			else
			{
				$typeStr.='<option value="'.$key.'">'.$value.'</option>';
			}		
		}	
		$data['typeStr'] = $typeStr;
		//payment type end
		
		//display Pay to creditors and debtors 
		 $db = \Config\Database::connect();
		 $dcquery = $db->query("SELECT * FROM debtorcreditor");
		 $dcquery = $dcquery->getResult();
		 $dcstr='';  
		 foreach($dcquery AS $dc)
		 {
			if($dc->Id == $row->crno)
			{	
				$dcstr.='<option value="'.$dc->Id.'" selected>'.$dc->dcnames.'</option>';
			}
			else
			{
				$dcstr.='<option value="'.$dc->Id.'">'.$dc->dcnames.'</option>';
			}		
		 }
		 $data['dcstr'] = $dcstr;
		//Groupe name selction start
		$groupes = $this->ExpensesModel->getAllResult('groupe');
		$gstr='';
		foreach($groupes AS $g)
		{
			if($g->Id==$row->groupe)
			{
				$gstr.='<option value="'.$g->Id.'" selected>'.$g->gname.'</option>';
			}
			else
			{
				$gstr.='<option value="'.$g->Id.'">'.$g->gname.'</option>';
			}		
		}	
		$data['gstr'] = $gstr;
		//Groupe name selction end
		
		//Category name selction start
		$category = $this->ExpensesModel->getAllResult('category');
		$cstr='';
		foreach($category AS $c)
		{
			if($c->Id==$row->category)
			{
				$cstr.='<option value="'.$c->Id.'" selected>'.$c->cname.'</option>';
			}
			else
			{
				$cstr.='<option value="'.$c->Id.'">'.$c->cname.'</option>';
			}		
		}	
		$data['cstr'] = $cstr;
		//Category name selction end
		
		//subcategory name selction start
		$subcategory = $this->ExpensesModel->getAllResult('subcategory');
		$sstr='';
		foreach($subcategory AS $s)
		{
			if($s->Id==$row->subcategory)
			{
				$sstr.='<option value="'.$s->Id.'" selected>'.$s->sname.'</option>';
			}
			else
			{
				$sstr.='<option value="'.$s->Id.'">'.$s->sname.'</option>';
			}		
		}	
		$data['sstr'] = $sstr;
		//subcategory name selction end
		
		$data['row'] = $row;
		$hdata['title'] = 'Edit Expense';
		echo view('expenses/header', $hdata);
		echo view('expenses/edit', $data);
		echo view('expenses/footer');
	}
	
	//Save Edit expense
	public function editSave($rid)
	{
		
		$pdate = $this->request->getPost('pdate');
		$crno = $this->request->getPost('crno');
		$amount = trim($this->request->getPost('amount'));
		$ptype = $this->request->getPost('ptype');
		$groupe = $this->request->getPost('groupe');
		$category = $this->request->getPost('category');
		$subcategory = $this->request->getPost('subcategory');
		$des = $this->request->getPost('des');
		$cno = $this->request->getPost('cno');
		if($cno=='')
		{
			$cno=0;
		}		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
				
		$data = array(
				'pdate'=>$pdate,
				'crno'=>$crno,
				'amount'=>$amount,
				'ptype'=>$ptype,
				'groupe'=>$groupe,
				'category'=>$category,
				'subcategory'=>$subcategory,
				'des'=>$des,
				'cno'=>$cno,
				
			  );
			 
			$update = $this->ExpensesModel->updateRecord($data, $rid, 'expenses'); 
			
			//Log table
			$dataLog = array(
				'tname'=>'expenses',
				'pid'=>$rid,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			$mainLoag=array_merge($data, $dataLog);	
			 //echo "<pre />"; print_r($data); exit;
			$this->ExpensesModel->saveRecord($mainLoag, 'logs'); 
			
			if($update==1)
			{
				return redirect()->to(base_url('expenses/view/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Record Not Update";
			}		
	}
	
	//Filter search
	function filterSearch()
	{
			 //print_r($this->request->getGet('sdate')); exit;
			$data['sdate'] = $this->request->getGet('sdate');
			$data['edate'] = $this->request->getGet('edate');
			$data['amount'] = trim($this->request->getGet('amount'));
			$data['ptype'] = $this->request->getGet('ptype');
			$data['groupe'] = $this->request->getGet('groupe');
			$data['category'] = $this->request->getGet('category');
			$data['subcategory'] = $this->request->getGet('subcategory');
			$data['des'] = $this->request->getGet('des');
			$sum = $this->ExpensesModel->filterSearchSum($data); 
			$result = $this->ExpensesModel->filterSearch($data); 
			
			$data['result']=$result;
			$data['sum']=$sum;
			$hdata['title']='List Expenses';
			
			echo view('expenses/sublist', $data);
			
			
	}	
	
	//Groupe based Expenses
	function groupebased($gid)
	{    
			$result = $this->ExpensesModel->groupebased($gid);
			$sum = $this->ExpensesModel->groupebasedTotal($gid);
			//echo "<pre />"; print_r($result); exit;
			$data['result'] = $result;
			$data['sum'] = $sum;
			$hdata['title'] = 'Groupe Based';
			echo view('expenses/header', $hdata);
			echo view('expenses/groupebased', $data);
			echo view('expenses/footer');
	}

	//Bring sub parts for category
	function getCategory()
	{
		$result = $this->ExpensesModel->getCategory(); 
		$sum = $this->ExpensesModel->getCategoryTotal(); 
		$data['result'] = $result;
		$data['sum'] = $sum;
		echo view('expenses/categoryBased', $data);
	}
	
	//Bring sub parts for category
	function groupeSub()
	{
		$result = $this->ExpensesModel->expenses();
		$sum = $this->ExpensesModel->sumAmount();
		$data['result'] = $result;
		$data['sum'] = $sum;
		echo view('expenses/groupeBasedParts', $data);
	}	
	
	//Category based Expenses
	function categorybased($cid)
	{    
			$result = $this->ExpensesModel->categorybased($cid);
			$sum = $this->ExpensesModel->categorybasedTotal($cid);
			//echo "<pre />"; print_r($result); exit;
			$data['result'] = $result;
			$data['sum'] = $sum;
			$hdata['title'] = 'Category Based';
			echo view('expenses/header', $hdata);
			echo view('expenses/categorybased2', $data);
			echo view('expenses/footer');
	}
	
	//Bring cheque by no
	function bringCheque($cid)
	{    
			$result = $this->ExpensesModel->getCheque($cid);
			if($result)
			{	
				return $result->pto.'|'.$result->amount;
			}
			else
			{
				return '0';
			}			
	}
	
	//Calender
	function calender()
	{    
			
			$result = $this->ExpensesModel->getPendingCheques();
			$resultdb = $this->ExpensesModel->getPendingdb();
			$rtotal = $this->ExpensesModel->getTotalPendings();
			//echo "<pre />"; print_r($result); exit;
			$events=array();
			if($result)
			{	
				
				foreach($result AS $pc)
				{
					 $events[] = [
						  'title' => substr(getdbc($pc->pto),0,5).': RM '.number_format($pc->amount,2),
						  'start' => $pc->ddate,
						  'backgroundColor' => '#F8E71C',
						  'textColor' => '#333333',
						  'order' => '1',
						  'tooltip'=> substr(getdbc($pc->pto),0,5).': RM '.number_format($pc->amount,2)
						  
						];
						
				}	
			}
			//on accounts
			if($resultdb)
			{	
				foreach($resultdb AS $pon)
				{
					 $events[] = [
						  'title' => substr(getdbc($pon->pto),0,5).': RM '.number_format($pon->amount,2),
						  'start' => $pon->ddate,
						  'backgroundColor' => '#90EE90',
						  'textColor' => '#006400',
						  'order' => '2',
						  'tooltip' => substr(getdbc($pon->pto),0,12).': RM '.number_format($pon->amount,2),	
						];
						
				}	
			}
			//total
			if($rtotal)
			{	
				
				foreach($rtotal AS $rt)
				{
					 $events[] = [
						  'title' => 'Total: RM '.number_format($rt->total,2),
						  'start' => $rt->date,
						  'backgroundColor' => '#ADD8E6',
						  'textColor' => '#333333',
						  'order' => '3',
						  'tooltip' => 'Total: RM '.number_format($rt->total,2),
						];
						
				}	
			}
			//echo "<pre />"; print_r($events); exit;	
			$data['result'] = '';
			$data['events'] = $events;
			$hdata['title'] = 'Calender';
			echo view('expenses/headerCalender', $hdata);
			echo view('expenses/calender/calender', $data);
			echo view('expenses/footer');
	}
	//Print Daily excel
	function printDailyExel()
	{
		
		$sdate = $this->request->getPost('sdate');
		$data['sdate'] = $sdate;
		$edate = $this->request->getPost('edate');
		$data['edate'] = $edate;
		//save date file
		$sdate = date_format(date_create($edate),'d-m-Y');
		
		$sdate2 = new \DateTime($sdate);
		$edate2 = new \DateTime($edate);
		$diff = $sdate2->diff($edate2)->days;
		
		
		$data['amount'] = trim($this->request->getPost('amount'));
		$data['ptype'] = $this->request->getPost('ptype');
		$data['groupe'] = $this->request->getPost('groupe');
		$data['category'] = $this->request->getPost('category');
		$data['subcategory'] = $this->request->getPost('subcategory');
		$data['des'] = $this->request->getPost('des');
		
		$result = $this->ExpensesModel->filterSearch2($data);
		$investment = $this->ExpensesModel->investment($data);
		$result = array_merge($result, $investment);
		//echo "<pre />"; print_r($result); exit;
		
		
		$templatePath = FCPATH . 'template/eden.xlsx'; // my excel template here
		//echo $templatePath; exit;	
		$spreadsheet = IOFactory::load($templatePath);
		$sheet = $spreadsheet->getActiveSheet();
		
		$highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestColumn();
		//###################################################33
		//Start part for sales
		$dailySales = $this->ExpensesModel->getDailySales($data);
		//echo "<pre />"; print_r($dailySales); exit;
		
		
		$sheaderStart =3;
		$sheaderEnds =674;
		// Step 2: Build header map (type -> column)
       
		$sheaderMap = [
			 11 => 'S', //Johoni JB
			12 => 'I', //Chocolate JB
			
		];
		// ✅ Step 3: Build a date->row map once (no repeated scanning)
		$sdateRowMap = [];
		for($r = $sheaderStart + 1; $r <= $sheaderEnds; $r++)
		{
			$cellValue = $sheet->getCell("E{$r}")->getValue();
			if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($sheet->getCell("E{$r}"))) 
			{
				$sheetDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cellValue)
								->format('Y-m-d');
			} else 
			{
				$sheetDate = trim($cellValue) ? date('Y-m-d', strtotime($cellValue)) : null;
			}
			if ($sheetDate) 
			{
				$sdateRowMap[$sheetDate] = $r;
			}
		}
		//echo "<pre />"; print_r($headerMap); exit;
		// ✅ Step 4: Collect everything in PHP first
		$scellData = [];  // for formulas
        foreach ($dailySales as $row) 
		{
            $date  = $row['pdate'];
            $type  = $row['shop'];
            $amt   = $row['tsales'];
           
            if (!isset($sheaderMap[$type])) {
                continue; // skip if type not in template
            }
			
			$stargetRow = $sdateRowMap[$date] ?? null;
			if (!$stargetRow) {
				continue;
			}
			
			$col = $sheaderMap[$type];
			
			// Handle amount formulas
			$scellData[$stargetRow][$col][] = $amt;
        }
		//echo "<pre />"; print_r($scellData); exit;
		// ✅ Step 5: Write back to Excel (once per cell)
		foreach ($scellData as $rowIdx => $cols) {
			foreach ($cols as $col => $amounts) {
				$formula =  implode("+", $amounts);
				$sheet->setCellValue($col.$rowIdx, $formula);
			}
		}
		//end for sales part
		//#################################################3333333
		
		
		//########################################33
		//start of Expense part
		 // Step 1: Find the second "Date" in column E
        $headerRow = null;
        $foundCount = 0;
        for ($row = 1; $row <= $highestRow; $row++) {
            $val = strtolower(trim($sheet->getCell("E{$row}")->getValue()));
            if ($val === 'date') {
                $foundCount++;
                if ($foundCount == 1) {
                    $headerRow = $row;
                    break;
                }
            }
        }
		
        if (!$headerRow) {
            return "No valid 'Date' header found in column E";
        }
		
		// Step 2: Build header map (type -> column)
       
		$headerMap = [
			 2 => 'U', //PURCHASE
			19 => 'AZ', //UTILITIES
			 1 => 'AN', //RENTAL
			 8 => 'BD',  //MAINTENANCE
			'inv' => 'S',  //INVESTMENT
			12 => 'BB'  //INVESTMENT
		];
        
		// ✅ Step 3: Build a date->row map once (no repeated scanning)
		$dateRowMap = [];
		for ($r = $headerRow + 2; $r <= $highestRow; $r++) {
			$cellValue = $sheet->getCell("E{$r}")->getValue();
			if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($sheet->getCell("E{$r}"))) {
				$sheetDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cellValue)
								->format('Y-m-d');
			} else {
				$sheetDate = trim($cellValue) ? date('Y-m-d', strtotime($cellValue)) : null;
			}
			if ($sheetDate) {
				$dateRowMap[$sheetDate] = $r;
			}
		}
		
		// ✅ Step 4: Collect everything in PHP first
		$cellData = [];  // for formulas
		$descData = [];  // for descriptions
        foreach ($result as $row) 
		{
            $date  = $row['pdate'];
            $type  = $row['groupe'];
            $amt   = $row['amount'];
            $category   = $row['category'];
            $des   = $row['des']?' ( '.$row['des'].' )': '';
			
			
            if (!isset($headerMap[$type])) {
                continue; // skip if type not in template
            }
			
			$targetRow = $dateRowMap[$date] ?? null;
			if (!$targetRow) {
				continue;
			}
			
			$col = $headerMap[$type];
			
			// Handle description in previous column
			if ($col != 'U') {
				$colIndex = Coordinate::columnIndexFromString($col);
				$prevCol  = Coordinate::stringFromColumnIndex($colIndex - 1);
				$descData[$targetRow][$prevCol][] = cname($category).$des;
			}
	
			// Handle amount formulas
			$cellData[$targetRow][$col][] = $amt;
        }

		// ✅ Step 5: Write back to Excel (once per cell)
		foreach ($cellData as $rowIdx => $cols) {
			foreach ($cols as $col => $amounts) {
				$formula = "=" . implode("+", $amounts);
				$sheet->setCellValue($col.$rowIdx, $formula);
			}
		}
		
		foreach ($descData as $rowIdx => $cols) {
			foreach ($cols as $col => $descs) {
				$sheet->setCellValue($col.$rowIdx, implode(", ", $descs));
			}
		}
		//end of expense part
		//#####################################################3
		
		// 🔹 Save or output file
		$writer = new Xlsx($spreadsheet);
		//save the template
		$templatePath = FCPATH . 'template/eden.xlsx';
	    $writer->save($templatePath);
		ob_clean();
		//ob_start();
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Disposition: attachment;filename=\"EDEN REPORT AS ON $sdate.xlsx\"");
		header("Cache-Control: max-age=0");
		header("Expires: Fri, 11 Nov 2011 11:11:11 GMT");
		header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");
		header("Cache-Control: cache, must-revalidate");
		header("Pragma: public");
		$writer->save("php://output");
		//ob_end_flush();
		exit;
		
			
	}	
	//Print excel
	function printExel()
	{    
	
		$sdate = $this->request->getPost('sdate');
		$data['sdate'] = $sdate;
		$edate = $this->request->getPost('edate');
		$data['edate'] = $edate;
		$data['amount'] = trim($this->request->getPost('amount'));
		$data['ptype'] = $this->request->getPost('ptype');
		$data['groupe'] = $this->request->getPost('groupe');
		$data['category'] = $this->request->getPost('category');
		$data['subcategory'] = $this->request->getPost('subcategory');
		$data['des'] = $this->request->getPost('des');
		$result = $this->ExpensesModel->filterSearch($data); 
		$sum = $this->ExpensesModel->filterSearchSum($data); 
		//echo "<pre />"; print_r($result); exit;
		$spreadsheet = new Spreadsheet();
		$activeWorksheet = $spreadsheet->getActiveSheet();
		//set headers_list
		// Merge cells A1 to E1
		$activeWorksheet->mergeCells('A1:I1');
		// Set the description text
		$activeWorksheet->setCellValue('A1', 'Expenses from '.date('d-m-Y', strtotime($sdate)).' to '.date('d-m-Y', strtotime($edate)));
		//style
		// Apply bold and center alignment
		$activeWorksheet->getStyle('A1')->getFont()->setBold(true);
		$activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$activeWorksheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$activeWorksheet->getStyle('A1')->getFont()->setSize(12);
		$activeWorksheet->getRowDimension('1')->setRowHeight(30); // Increase row height

		$activeWorksheet->setCellValue('A2', '#');
		$activeWorksheet->setCellValue('B2', 'ID');
		$activeWorksheet->setCellValue('C2', 'Expense Date');
		$activeWorksheet->setCellValue('D2', 'Amount');
		$activeWorksheet->setCellValue('E2', 'Type');
		$activeWorksheet->setCellValue('F2', 'Group');
		$activeWorksheet->setCellValue('G2', 'Category');
		$activeWorksheet->setCellValue('H2', 'Subcategory');
		$activeWorksheet->setCellValue('I2', 'Description');
		//Set bold
		$activeWorksheet->getStyle('A2:I2')->getFont()->setBold(true);
		$activeWorksheet->getStyle('A2:I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$activeWorksheet->getStyle('A2:I2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$i=3;
		$j=1;
		foreach($result AS $row)
		{
			$activeWorksheet->setCellValue('A'.$i, $j);
			$activeWorksheet->setCellValue('B'.$i, $row->Id);
			$activeWorksheet->setCellValue('C'.$i, date('d-m-Y', strtotime($row->pdate)));
			$activeWorksheet->setCellValue('D'.$i, $row->amount);
			$activeWorksheet->setCellValue('E'.$i, ptype($row->ptype));
			$activeWorksheet->setCellValue('F'.$i, gname($row->groupe));
			$activeWorksheet->setCellValue('G'.$i, cname($row->category));
			$activeWorksheet->setCellValue('H'.$i, sname($row->subcategory));
			$activeWorksheet->setCellValue('I'.$i, $row->des);
			$activeWorksheet->getStyle('D' .$i)				
						->getNumberFormat()
						->setFormatCode('"RM "#,##0.00');
			
			$activeWorksheet->getStyle('A'.$i.':'.'I'.$i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$activeWorksheet->getStyle('A2:I2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$i++;
			$j++;
		}	
		$activeWorksheet->setCellValue('A'.$i, 'Total');
		$activeWorksheet->mergeCells('A'.$i.':'.'C'.$i);
		$activeWorksheet->setCellValue('D'.$i, $sum);
		$activeWorksheet->getStyle('D' .$i)				
						->getNumberFormat()
						->setFormatCode('"RM "#,##0.00');
		$activeWorksheet->getStyle("A$i:D$i")->getFont()->setBold(true);
		$activeWorksheet->getStyle('A2:I2')->getFont()->setBold(true);
		//Auto Size
		$activeWorksheet->getColumnDimension('A')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('B')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('C')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('D')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('E')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('F')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('G')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('H')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('I')->setAutoSize(true);
	
		
		//Style\Alignment
		$styleArray = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => Border::BORDER_THIN,
								'color' => ['argb' => 'FF000000'], // black
							],
						],
					];

					$activeWorksheet->getStyle('A2:I'.$i)->applyFromArray($styleArray);

		$activeWorksheet->setSelectedCell('A1'); // Set focus to A1
		$writer = new Xlsx($spreadsheet);
		//$writer->save('hello world.xlsx'); 
		ob_clean();
		//ob_start();
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Disposition: attachment;filename=\"Report.xlsx\"");
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
