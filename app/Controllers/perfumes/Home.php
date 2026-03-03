<?php

namespace App\Controllers\perfumes;
use App\Controllers\BaseController;
use App\Models\perfumes\HomeModel;
use CodeIgniter\I18n\Time;

require_once(APPPATH . '/ThirdParty/vendor2/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Home extends BaseController
{
    //my constructor
	public function __construct() 
	{

        $this->HomeModel = new HomeModel();
		$request = \Config\Services::request();
        helper('fornames');
	}
	
	public function index()
    {		
			$perPage = 200;
			$cpage = isset($_GET['page_no']) ? $_GET['page_no'] : 1; 
			$previous_page = $cpage - 1;
			$next_page = $cpage + 1;
			$offset=($cpage - 1) * $perPage;
			$total = $this->HomeModel->getOneTotal('Id','perfumes'); 
			$total_no_of_pages = ceil($total / $perPage); 
			$bita['perPage'] = $perPage;
			$bita['offset'] = $offset;
			$bita['cpage'] = $cpage;
			$bita['total_no_of_pages'] = $total_no_of_pages;
			$bita['previous_page'] = $previous_page;
			$bita['next_page'] = $next_page;
			$bita['total'] = $total;
			$perfumes = $this->HomeModel->perfumesAllResult($perPage, $offset);
			
			
			//$perfumes = $this->HomeModel->getAllPerfumes();
			//Get group
			$proup = $this->HomeModel->getAllResult('pgroup');
			$gstr='';
			$gstr.='<option value="">Select Group</option>';
			foreach($proup AS $g)
			{
					$gstr.='<option value="'.$g->Id.'">'.$g->gname.'</option>';	
			}
			$data['gstr'] = $gstr;
			
			$data['perfume']=$perfumes;
			$hdata['title']='Perfumes';
			echo view('perfumes/header', $hdata);
			echo view('perfumes/list', $data);
			echo view('perfumes/footer');
			if($total>$perPage)
			{	
				 displayPagination($bita);
			}
			
    }
	
	//Add Perfume
	public function add()
	{	
			
			//Get Groupes/category/subcategory
			$proupe = $this->HomeModel->getAllResult('pgroup');
			//echo "<pre />"; print_r($proupe); exit;
			$gstr='';
			foreach($proupe AS $g)
			{
					$gstr.='<option value="'.$g->Id.'">'.$g->gname.'</option>';	
			}
				
			 
			$data['gstr'] = $gstr;
			$hdata['title']='Add Perfume';
			echo view('perfumes/header', $hdata);
			echo  view('perfumes/add', $data);
			echo view('perfumes/footer');
	}
	
	//Bring category
	public function bringCat()
	{
		$gid = $this->request->getGet('gid');
		$pcat = $this->HomeModel->getAllResultByid('pcategory', $gid);
		//echo "<pre />"; print_r($pcat); exit;
		$cstr='';
		$cstr.='<option value="">Select Category</option>';
		foreach($pcat AS $c)
		{
				$cstr.='<option value="'.$c->Id.'">'.$c->cname.'</option>';	
		}
		echo $cstr;
	}	
	//Save Perfume
	public function save()
	{	
		$pname = $this->request->getPost('pname');
		$pgroup = trim($this->request->getPost('pgroup'));
		$pcategory = $this->request->getPost('pcategory');
		$remark = $this->request->getPost('remark');
		$pimage = $this->request->getPost('pimage');
		
			
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
				'name'=>$pname,
				'group'=>$pgroup,
				'category'=>$pcategory,
				'remark'=>$remark,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
				
			$rid = $this->HomeModel->saveRecord($data, 'perfumes'); 
			if($rid)
			{
				//upload perfume image
				$this->uploadimage($rid, $pname); 
				return redirect()->to(base_url('perfumes/view/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Your record is not saved successfully";
			}		
				
	}
	//upload perfume image
	public function uploadimage($rid, $pname)
    {	
        if (!empty($_FILES['pimage']['name'])) 
		{  
			$validation = \Config\Services::validation();

			// Validate the image upload
			$validation->setRules([
				'pimage' => [
					'uploaded[pimage]',
					'mime_in[pimage,image/jpg,image/jpeg,image/png]',
					'max_size[pimage,2048]',
				]
			]);
			
			if (!$validation->withRequest($this->request)->run()) {
				return redirect()->back()->with('error', $validation->getErrors());
			}
			
			// Store the file
			$file = $this->request->getFile('pimage');
			$extension = $file->getExtension();	
			if ($file->isValid() && !$file->hasMoved()) {
				$newName = $rid.'-'.$pname.'-1'.'.'.$extension; 
				$file->move(FCPATH . 'uploads/perfumes/', $newName);
				
				// Save the image path to the database (optional)
				$pimageModel = new \App\Models\PimageModel();
				$pimageModel->save([
					'rid' => $rid,
					'etype' => '1',
					'image_path' => 'uploads/perfumes/' . $newName,
				]);

				return redirect()->back()->with('success', 'Image uploaded successfully!');
			} else {
				return redirect()->back()->with('error', 'Failed to upload image.');
			}
		}
    }
	//view Perfume
	public function view($rid,$flag)
	{   
		$row = $this->HomeModel->displayRecord($rid, 'perfumes');
		//Get perfume image
		$pimage = $this->HomeModel->getPerfumeImage($rid);
		$data['pimage'] = $pimage;
		
		$data['row'] = $row;
		$data['flag'] = $flag;
		$hdata['title'] = 'View Perfume';
		echo view('perfumes/header', $hdata);
		echo view('perfumes/view', $data);
		echo view('perfumes/footer');
	}
	//Expenses edit view
	public function editView($rid)
	{
		
		$row = $this->HomeModel->displayRecord($rid, 'perfumes');
		//Groups
		$pgroup = $this->HomeModel->getAllResult('pgroup');
		//Category
		$pcat = $this->HomeModel->getAllResultByid('pcategory', $row->group);
	
		$gstr='';
		$cstr='';
		foreach($pgroup AS $g)
		{
			if($g->Id==$row->group)
			{
				$gstr.='<option value="'.$g->Id.'" selected>'.$g->gname.'</option>';	
			}
			else
			{
				$gstr.='<option value="'.$g->Id.'">'.$g->gname.'</option>';
			}		
		}

		foreach($pcat AS $c)
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
		$data['gstr'] = $gstr;
		$data['cstr'] = $cstr;
		
		$data['row'] = $row;
		$hdata['title'] = 'Edit Perfume';
		echo view('perfumes/header', $hdata);
		echo view('perfumes/edit', $data);
		echo view('perfumes/footer');
	}
	
	//Save Edit Perfumes
	public function editSave($rid)
	{
		$pname = $this->request->getPost('pname');
		$pgroup = trim($this->request->getPost('pgroup'));
		$pcategory = $this->request->getPost('pcategory');
		$remark = $this->request->getPost('remark');
		$pimage = $this->request->getPost('pimage');
		
			
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
				'name'=>$pname,
				'group'=>$pgroup,
				'category'=>$pcategory,
				'remark'=>$remark,
			  );
				 
			$update = $this->HomeModel->updateRecord($data, $rid, 'perfumes'); 
			//Log table
			$dataLog = array(
				'tname'=>'perfumes',
				'pid'=>$rid,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			$mainLoag=array_merge($data, $dataLog);	
			 //echo "<pre />"; print_r($data); exit;
			$this->HomeModel->saveRecord($mainLoag, 'logs');
			
			if($update==1)
			{   
				//upload perfume image
				$this->editImage($rid, $pname); 
				return redirect()->to(base_url('perfumes/view/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Your record is not saved successfully";
			}		
	}
	
	//Edit Upload Image
	public function editImage($rid, $pname)
    {	
        if (!empty($_FILES['pimage']['name'])) 
		{
			$validation = \Config\Services::validation();

			// Validate the image upload
			$validation->setRules([
				'pimage' => [
					'uploaded[pimage]',
					'mime_in[pimage,image/jpg,image/jpeg,image/png]',
					'max_size[pimage,2048]',
				]
			]);
			
			if (!$validation->withRequest($this->request)->run()) { 
				return redirect()->back()->with('error', $validation->getErrors());
			}
			
			// Store the file
			$file = $this->request->getFile('pimage');
			$extension = $file->getExtension();	
			if ($file->isValid() && !$file->hasMoved()) {
				//Get Perfume image
				$pimage = $this->HomeModel->getPerfumeImage($rid);
				if($pimage)
				{	
					$imagePath=FCPATH.$pimage->image_path;
					
					// Delete the old image if it exists
					if (file_exists($imagePath)) { 
						unlink($imagePath);
					}
				}
				// Generate a new file name and move the file
				$newName = $rid.'-'.$pname.'-V2'.'.'.$extension; 
				$file->move(FCPATH . 'uploads/perfumes/', $newName);
				
			    
				$imageModel = new \App\Models\PimageModel();
				
				// Fetch the record with two conditions
				$record = $imageModel->where('rid', $rid)
						 ->where('etype', '1')
						 ->first(); //echo "<pre />"; print_r($record); exit;
				if ($record) {
							// Update the image path
							$record['image_path'] = 'uploads/perfumes/' . $newName;
							$imageModel->save($record);
							echo "Record updated successfully!";
						} else {
							// insert
							$data=array(
								'rid' => $rid,
								'etype' => '1',
								'image_path' => 'uploads/perfumes/' . $newName
							
							);
							$imageModel->save($data);
							echo "Record Inserted successfully!";
						}
			} else { 
				return redirect()->back()->with('error', 'Failed to upload image.'); EXIT;
			}
		}
    }

	//Filter search
	function searchFilter()
	{
			$data['pid'] = trim($this->request->getGet('pid'));
			$data['pname'] = trim($this->request->getGet('pname'));
			$data['pgroup'] = $this->request->getGet('pgroup');
			$data['pcategory'] = $this->request->getGet('pcategory');
			$data['remark'] = $this->request->getGet('remark');
			
			//$sum = $this->HomeModel->filterSearchSum($data); 
			
			//Pagination start
			$perPage = 2;
			$cpage = isset($_GET['page_no']) ? $_GET['page_no'] : 1; 
			$previous_page = $cpage - 1;
			$next_page = $cpage + 1;
			$offset=($cpage - 1) * $perPage;
			$total = $this->HomeModel->filterOneTotal($data); 
			$total_no_of_pages = ceil($total / $perPage); 
			$bita['perPage'] = $perPage;
			$bita['offset'] = $offset;
			$bita['cpage'] = $cpage;
			$bita['total_no_of_pages'] = $total_no_of_pages;
			$bita['previous_page'] = $previous_page;
			$bita['next_page'] = $next_page;
			$bita['total'] = $total;
			$result = $this->HomeModel->filterSearchPagination($perPage, $offset, $data);
			//Pagination ends
			//$result = $this->HomeModel->filterSearch($data); 
			
			$data['perfume']=$result;
			//$data['sum']=$sum;
			
			echo view('perfumes/psublist', $data);
			if($total>$perPage)
			{	
				 //displayPagination($bita);
			}
			
			
			
			
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
	
	//Display perfume
	public function display()
	{	
			
			
			$data['a'] = 'a';
			echo  view('perfumes/display', $data);
	}
}
