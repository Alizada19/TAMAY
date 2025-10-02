<?php
namespace App\Controllers\uploadexcel;
use App\Controllers\BaseController;
use App\Models\upload\ExcelModel;
use CodeIgniter\I18n\Time;

require_once(APPPATH . '/ThirdParty/vendor2/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel extends BaseController
{
    //my constructor
	public function __construct() 
	{

        $this->ExcelModel = new ExcelModel();
		$request = \Config\Services::request();
        helper('fornames');
	}
	
	public function index()
    {	
        
		$hdata['title']='';
		echo view('upload/header', $hdata);
		echo view('upload/upload_excel');
		echo view('upload/footer');
	}
	
	public function stockList()
    {	
        
		$hdata['title']='Stock transfered list';
		echo view('upload/header', $hdata);
		echo view('upload/list');
		echo view('upload/footer');
	}
	
    public function import()
    { 
        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet()->toArray();
			
			//Get username and id from the session
			$username = $this->session->get('name');
			$userid = $this->session->get('userid');
			//echo "<pre />"; print_r($sheet); exit;
			$successCount = 0;
			$failCount = 0;
            foreach ($sheet as $index => $row) {
                if ($index == 0) continue; // skip header
				
				if(isset($row[0]) AND isset($row[1]) AND isset($row[2]))
				{	
					  $data = array(
						'category' => $row[0],
						'cost' => $row[1],
						'cdate' => date_format(date_create($row[2]), 'Y-m-d'),
						
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					  );
					  $result = $this->ExcelModel->saveRecord($data, 'excel');
					  if ($result) 
					  {
							$successCount++;
					  }
					  else 
					  {
							$failCount++;
					  }
				}
				//echo "<pre />"; print_r($data); exit;
				
            }
			//echo "success: ".$successCount."fails: ".$failCount; exit;
            return redirect()->to(base_url('codeigniter/public//excel'))->with('success', "$successCount record(s) imported successfully.".($failCount > 0 ? "$failCount failed." : ""));
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }
	
	//Search the stock 
	function search()
	{       
			$sdate = $this->request->getPost('sdate');
			$edate = $this->request->getPost('edate');
			$data['sdate'] = $sdate;
			$data['edate'] = $edate;
							
			$records = $this->ExcelModel->search($data); 
			$total = $this->ExcelModel->totalSearch($data);
			//echo "<pre />"; print_r($records); exit;
			
			// Step 2: Group the data
			$grouped = [];

			foreach ($records as $row) {
				$date = $row->cdate;
				$category = $row->category;
				$cost = $row->cost;

				 // Initialize date group
				if (!isset($grouped[$date])) {
					$grouped[$date] = [
						'categories' => [], // holds category-wise cost
						'total' => 0        // holds daily total
					];
				}

				// Initialize category if not set
				if (!isset($grouped[$date]['categories'][$category])) {
					$grouped[$date]['categories'][$category] = 0;
				}

				// Accumulate cost by category
				$grouped[$date]['categories'][$category] += $cost;

				// Accumulate total cost for the day
				$grouped[$date]['total'] += $cost;
			}
			
			//echo "<pre />"; print_r($grouped); exit;
			$data['grouped']=$grouped;
			$data['total']=$total;
			$hdata['title']='Stock List';
			echo view('upload/header', $hdata);
			echo view('upload/searchList', $data);
			echo view('upload/footer');		
	}
	
	//Search the one by one 
	function ungroup()
	{	
			$sdate = $this->request->getPost('sdate');
			$edate = $this->request->getPost('edate');
			$data['sdate'] = $sdate;
			$data['edate'] = $edate;
							
			$records = $this->ExcelModel->searchSingle($data); 
			$total = $this->ExcelModel->totalSearch($data);
			
			//echo "<pre />"; print_r($allSalary); exit;
	
			//echo "<pre />"; print_r($allSalary); exit;
			$data['records']=$records;
			$data['total']=$total;
			$hdata['title']='Stock List';
			echo view('upload/header', $hdata);
			echo view('upload/ungroup', $data);
			echo view('upload/footer');		
	}
	
	//Remove Excel record
	function removeExcel($rid)
	{
		$sdate = $this->request->getPost('sdate');
		$edate = $this->request->getPost('edate');
		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$deleted = $this->ExcelModel->deleteRecord($rid);
		$records = $this->ExcelModel->searchSingle($data); 
		$total = $this->ExcelModel->totalSearch($data);
		if($deleted)
		{
			
			$data['records']=$records;
			$data['total']=$total;
			$hdata['title']='Stock List';
			echo view('upload/header', $hdata);
			echo view('upload/ungroup', $data);
			echo view('upload/footer');
		}
		else
		{
			return 0;
		}		
		
	}

	//Chart 
	function schart()
	{       
			$sdate = $this->request->getPost('sdate'); 
			$edate = $this->request->getPost('edate');
			$data['sdate'] = $sdate;
			$data['edate'] = $edate;
							
			$records = $this->ExcelModel->searchCategory($data); 
			//$total = $this->ExcelModel->totalSearch($data);
			
			foreach($records AS &$row)
			{
				$row->name =  $row->category;
				unset($row->category);
				$row->y = (float) $row->cost;
				unset($row->cost);
			}	
			//echo "<pre />"; print_r($records); exit;
			$data['record'] = $records;
			$hdata['title']='Chart List';
			echo view('upload/cheader', $hdata);
			echo view('upload/schart', $data);
			echo view('upload/cfooter');		
	}	
	
	//Group by category
	function gcategory()
	{
		$sdate = $this->request->getPost('sdate'); 
		$edate = $this->request->getPost('edate');
		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		
		$records = $this->ExcelModel->searchCategory($data); 
		$total = $this->ExcelModel->totalSearch($data);
		
		$data['records']=$records;
		$data['total']=$total;
		$hdata['title']='Stock list by category';
		echo view('upload/header', $hdata);
		echo view('upload/gcategory', $data);
		echo view('upload/footer');	
	}	
}
