<?php

namespace App\Controllers\johoni;
use App\Controllers\BaseController;
use App\Models\johoni\JohoniModel;
use CodeIgniter\I18n\Time;

require_once(APPPATH . '/ThirdParty/vendor2/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Johoni extends BaseController
{
    //my constructor
	public function __construct() 
	{

        $this->JohoniModel = new JohoniModel();
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
	public function addSales()
	{		
		//get vbanks
		$vbanks = $this->JohoniModel->getVbanks(); 
		$str2='';
		foreach($vbanks AS $bank)
		{
			if($bank->Id == 1)
			{	
				$str2.='<option value="'.$bank->Id.'" selected>'.$bank->bname.'</option>';
			}
			else
			{
				$str2.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
			}		
		}


		$locations = $this->JohoniModel->getLocations(); 
		$str='';
		foreach($locations AS $row)
		 {
				if($row->Id == 10)
				{	
					$str.='<option value="'.$row->Id.'" selected>'.$row->name.'</option>';
				}
				else
				{
					$str.='<option value="'.$row->Id.'">'.$row->name.'</option>';
				}		
		 }	
			
			$data['str2']=$str2;
			$data['str']=$str;
			return view('johoni/addSales', $data);
			
	}
	
	//Add Fund
	public function addFund()
	{		
		//get vbanks
		$vbanks = $this->JohoniModel->getVbanks(); 
		$str2='';
		foreach($vbanks AS $bank)
		{
			if($bank->Id == 1)
			{	
				$str2.='<option value="'.$bank->Id.'" selected>'.$bank->bname.'</option>';
			}
			else
			{
				$str2.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
			}		
		}
		$data['str2']=$str2;
		return view('johoni/addFund', $data);
			
	}
	//edit Sales
	public function editSales($rid)
	{	
			$records = $this->JohoniModel->displayRecord($rid); //echo "<pre />"; print_r($row); exit;
			//get vbanks
			$vbanks = $this->JohoniModel->getVbanks(); 
			$str2='';
			foreach($vbanks AS $bank)
			{
				if($bank->Id == $records->vbank)
				{	
					$str2.='<option value="'.$bank->Id.'" selected>'.$bank->bname.'</option>';
				}
				else
				{
					$str2.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
				}		
			}
		
			$locations = $this->JohoniModel->getLocations(); //echo "<pre />"; print_r($locations); exit;
			$str='';
			foreach($locations AS $row)
			 {
					if($row->Id == $records->Id)
					{	
						$str.='<option value="'.$row->Id.'" selected>'.$row->name.'</option>';
					}
					else
					{
						$str.='<option value="'.$row->Id.'">'.$row->name.'</option>';
					}		
			 }
		    $data['str'] = $str;
		    $data['str2'] = $str2;
		    $data['row'] = $records;
		    $data['rid'] = $rid;
			return view('johoni/editSales', $data);
			
	}
	
	//edit Investment
	public function editFund($rid)
	{	

			$row = $this->JohoniModel->displayRecord2($rid, 'investment');
			//get vbanks
			$vbanks = $this->JohoniModel->getVbanks(); 
			$str2='';
			foreach($vbanks AS $bank)
			{
				if($bank->Id == $row->vbank)
				{	
					$str2.='<option value="'.$bank->Id.'" selected>'.$bank->bname.'</option>';
				}
				else
				{
					$str2.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
				}		
			}
		    $data['str2'] = $str2;
		    $data['row'] = $row;
		    $data['rid'] = $rid;
			return view('johoni/editFund', $data);
			
	}
	//Save Sales
	public function saveSales()
	{
		
		$sdate = $this->request->getPost('date');
		$tsales = trim($this->request->getPost('total_sales'));
		$card = trim($this->request->getPost('card'));
		$netcash = trim($this->request->getPost('netcash'));
		$description = $this->request->getPost('description');
		$files = $this->request->getFiles('attachments');
		$location = $this->request->getPost('location');
		$vbank = $this->request->getPost('vbank');
		$atome = trim($this->request->getPost('atome'));
		$ot = trim($this->request->getPost('ot'));
		if($sdate > date('Y-m-d'))
		{
			echo "You can not insert future date my friend!"; exit;
		}
			
		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
				'sdate'=>$sdate,
				'tsales'=>$tsales,
				'card'=>$card,
				'netcash'=>$netcash,
				'description'=>$description,
				'location'=>$location,
				'vbank'=>$vbank,
				'atome'=>$atome,
				'ot'=>$ot,
				
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  ); //echo "<pre />"; print_r($data); exit;
		//Transaction data	start 
		$container = array(); 
		/* Taypes of categories
		1. card 
		2. atome 
		3. ot
		*/ 

		$cardDeduction=0;
		$atomeDeduction=0;
		if($card)
		{	  
			
			$cardDeduction = $card * 0.02; //2% deduction
			//$card = $card - ($card * 0.02); //2% deduction
			$container[] = $data2 = array(
								'tdate'=>$sdate,
								'type'=>1,
								'bid'=>$vbank,
								'category'=>1,
								'amount'=>$card,
								'table'=>'johoni',			
								'userid'=>$userid,
								'username'=>$username,
								"saveDate" => date('Y-m-d H:i:s')
							); //echo "<pre />"; print_r($data); exit;	
			 				
		}  
		if($atome)
		{	  
			$atomeDeduction = $atome * 0.07; //7% deduction
			//$atome = $atome - ($atome * 0.07); //7% deduction
			$container[] = $data2 = array(
								'tdate'=>$sdate,
								'type'=>1,
								'bid'=>$vbank,
								'category'=>2,
								'amount'=>$atome,
								'table'=>'johoni',			
								'userid'=>$userid,
								'username'=>$username,
								"saveDate" => date('Y-m-d H:i:s')
							); //echo "<pre />"; print_r($data); exit;	
		}
		if($ot)
		{	  
			$container[] = $data2 = array(
								'tdate'=>$sdate,
								'type'=>1,
								'bid'=>$vbank,
								'category'=>3,
								'amount'=>$ot,
								'table'=>'johoni',			
								'userid'=>$userid,
								'username'=>$username,
								"saveDate" => date('Y-m-d H:i:s')
							); //echo "<pre />"; print_r($data); exit;	
		}
		//transaction data end
			$sameDate = $this->JohoniModel->getRecord($sdate, 'johoni'); 
			if($sameDate<1)
			{	
				
				$rid = $this->JohoniModel->saveRecord($data, $container, 'johoni', $cardDeduction, $atomeDeduction); 

				if($rid)
				{
					//sales Attachment
					if (isset($files['attachments'])) 
					{
						foreach ($files['attachments'] as $file)
						{
							//Attachment start
							 if ($file && $file->isValid() && !$file->hasMoved()) {
								 
								// ✅ File is selected and valid
								$originalName = $file->getClientName(); // original name from user
								$mimeType = $file->getClientMimeType(); // MIME type
								$size = $file->getSize(); // in bytes
								$extension = $file->getExtension();	
								//echo $originalName; exit;
								// Optional: Save it
								$randomNumber = rand(1000, 9999);
								$newName = $sdate.'-'.$randomNumber.'__'.$originalName;
								$uploadPath = FCPATH . 'uploads/salesFund/';
							
								//if (!is_dir($uploadPath)) {
									//mkdir($uploadPath, 0755, true); // 0755 permissions, recursive = true
								//}
								if($file->move($uploadPath, $newName))
								{	
									// Save the image path to the database (optional)
									$salesattModel = new \App\Models\SalesattModel();
									$salesattModel->save([ 
										'pid' => $rid,
										'image' => 'uploads/salesFund/' . $newName,
										'etype' => 'q',
										
										'userid'=>$userid,
										'username'=>$username,
										"saveDate" => date('Y-m-d H:i:s')
									]);
									echo "File uploaded successfully: $originalName ($mimeType, {$size} bytes)";
								}
								else
								{
									echo "File not moved!";
								}		
								
							} else {
								// ❌ No file selected or invalid
								echo "No file selected or invalid upload.";
							}
							//attachment ends
						}
					}
	
					return redirect()->to(base_url('johoniSalesView/'.$rid.'/1'.'')); exit;
				}
				else
				{
					echo "Your record is not saved successfully";
				}		
			}
			else
			{
				echo "You can not insert same record!";
			}		
	}
	
	//Save Funds
	public function saveFund()
	{
		
		$sdate = $this->request->getPost('sdate');
		$amount = trim($this->request->getPost('amount'));
		$description = $this->request->getPost('description');
		$vbank = $this->request->getPost('vbank');
		$files = $this->request->getFiles('attachments');
		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		if($sdate > date('Y-m-d'))
		{
			echo "You can not insert future date my friend!"; exit;
		}
		$data = array(
				'sdate'=>$sdate,
				'amount'=>$amount,
				'description'=>$description,
				'vbank'=>$vbank,
				
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  ); //echo "<pre />"; print_r($data); exit;
	    //Transaction data	start 
		/* Taypes of categories
		1. card 
		2. atome 
		3. ot
		*/ 


			  
		$data2=array(
						'tdate'=>$sdate,
						'type'=>1,
						'bid'=>$vbank,
						'category'=>4,
						'amount'=>$amount,
						'description'=>$description,
						'table'=>'investment',			
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					); //echo "<pre />"; print_r($data); exit;	

		//transaction data 		  
			
				$rid = $this->JohoniModel->saveInvestRecord($data, $data2, 'investment'); 
				if($rid)
				{
					//sales Attachment
					if (isset($files['attachments'])) 
					{
						foreach ($files['attachments'] as $file)
						{
							//Attachment start
							 if ($file && $file->isValid() && !$file->hasMoved()) {
								 
								// ✅ File is selected and valid
								$originalName = $file->getClientName(); // original name from user
								$mimeType = $file->getClientMimeType(); // MIME type
								$size = $file->getSize(); // in bytes
								$extension = $file->getExtension();	
								//echo $originalName; exit;
								// Optional: Save it
								$randomNumber = rand(1000, 9999);
								$newName = $sdate.'-'.$randomNumber.'__'.$originalName;
								$uploadPath = FCPATH . 'uploads/salesFund/';
							
								//if (!is_dir($uploadPath)) {
									//mkdir($uploadPath, 0755, true); // 0755 permissions, recursive = true
								//}
								if($file->move($uploadPath, $newName))
								{	
									// Save the image path to the database (optional)
									$salesattModel = new \App\Models\SalesattModel();
									$salesattModel->save([ 
										'pid' => $rid,
										'image' => 'uploads/salesFund/' . $newName,
										'etype' => 'inv',
										
										'userid'=>$userid,
										'username'=>$username,
										"saveDate" => date('Y-m-d H:i:s')
									]);
									echo "File uploaded successfully: $originalName ($mimeType, {$size} bytes)";
								}
								else
								{
									echo "File not moved!";
								}		
								
							} else {
								// ❌ No file selected or invalid
								echo "No file selected or invalid upload.";
							}
							//attachment ends
						}
					}
	
					return redirect()->to(base_url('viewFund/'.$rid.'/1'.'')); exit;
				}
				else
				{
					echo "Your record is not saved successfully";
				}		
					
	}
	//Update Sales
	public function johoniUpdateSave($rid)
	{
		
		$sdate = $this->request->getPost('date');
		$tsales = trim($this->request->getPost('total_sales'));
		$card = trim($this->request->getPost('card'));
		$netcash = trim($this->request->getPost('netcash'));
		$description = $this->request->getPost('description');
		$location = $this->request->getPost('location');
		$files = $this->request->getFiles('attachments');
		$vbank = $this->request->getPost('vbank');
		$atome = trim($this->request->getPost('atome'));
		$ot = trim($this->request->getPost('ot'));
		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		if($sdate > date('Y-m-d'))
		{
			echo "You can not insert future date my friend!"; exit;
		}
		$data = array(
				'sdate'=>$sdate,
				'tsales'=>$tsales,
				'card'=>$card,
				'netcash'=>$netcash,
				'description'=>$description,
				'location'=>$location,
				'vbank'=>$vbank,
				'atome'=>$atome,
				'ot'=>$ot,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
		//Transaction data	start
		$container = array();
		if($card)
		{	  
			$container[] = $data2 = array(
								'tdate'=>$sdate,
								'type'=>1,
								'bid'=>$vbank,
								'category'=>1,
								'amount'=>$card,
								'table'=>'johoni',			
								'userid'=>$userid,
								'username'=>$username,
								"saveDate" => date('Y-m-d H:i:s')
							); //echo "<pre />"; print_r($data); exit;	
		}  
		if($atome)
		{	  
			$container[] = $data2 = array(
								'tdate'=>$sdate,
								'type'=>1,
								'bid'=>$vbank,
								'category'=>2,
								'amount'=>$atome,
								'table'=>'johoni',			
								'userid'=>$userid,
								'username'=>$username,
								"saveDate" => date('Y-m-d H:i:s')
							); //echo "<pre />"; print_r($data); exit;	
		}
		if($ot)
		{	  
			$container[] = $data2 = array(
								'tdate'=>$sdate,
								'type'=>1,
								'bid'=>$vbank,
								'category'=>3,
								'amount'=>$ot,
								'table'=>'johoni',			
								'userid'=>$userid,
								'username'=>$username,
								"saveDate" => date('Y-m-d H:i:s')
							); //echo "<pre />"; print_r($data); exit;	
		}
		//echo "<pre />"; print_r($container); exit;
		//transaction data end	  
			$sameDate = $this->JohoniModel->getRecord($sdate, 'johoni'); 
			if($sameDate<2)
			{	
				$update = $this->JohoniModel->updateRecord($data, $container, $rid, 'johoni'); 
				if($update)
				{
					
					if (isset($files['attachments'])) 
					{
						foreach ($files['attachments'] as $file)
						{
							//Attachment start
							 if ($file && $file->isValid() && !$file->hasMoved()) {
								 
								// ✅ File is selected and valid
								$originalName = $file->getClientName(); // original name from user
								$mimeType = $file->getClientMimeType(); // MIME type
								$size = $file->getSize(); // in bytes
								$extension = $file->getExtension();	
								
								// Optional: Save it
								$randomNumber = rand(1000, 9999);
								$newName = $sdate.'-'.$randomNumber.'__'.$originalName;
								$uploadPath = FCPATH . 'uploads/salesFund/';
							
								//if (!is_dir($uploadPath)) {
									//mkdir($uploadPath, 0755, true); // 0755 permissions, recursive = true
								//}
								if($file->move($uploadPath, $newName))
								{	
									// Save the image path to the database (optional)
									$salesattModel = new \App\Models\SalesattModel();
									$salesattModel->save([ 
										'pid' => $rid,
										'image' => 'uploads/salesFund/' . $newName,
										'etype' => 'q',
										
										'userid'=>$userid,
										'username'=>$username,
										"saveDate" => date('Y-m-d H:i:s')
									]);
									echo "File uploaded successfully: $originalName ($mimeType, {$size} bytes)";
								}
								else
								{
									echo "File not moved!";
								}		
								
							} else {
								// ❌ No file selected or invalid
								echo "No file selected or invalid upload.";
							}
							//attachment ends
						}
					} 
					return redirect()->to(base_url('johoniSalesView/'.$rid.'/1'.'')); exit;
				}
				else
				{
					echo "Your record is not saved successfully";
				}		
			}
			else
			{
				echo "You can not insert same record!";
			}		
	}
	
	//Update Fund Save
	public function editFundSave($rid)
	{
		
		$sdate = $this->request->getPost('sdate');
		$amount = trim($this->request->getPost('amount'));
		$description = $this->request->getPost('description');
		$vbank = $this->request->getPost('vbank');
		$files = $this->request->getFiles('attachments');
		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		if($sdate > date('Y-m-d'))
		{
			echo "You can not insert future date my friend!"; exit;
		}
		$data = array(
				'sdate'=>$sdate,
				'amount'=>$amount,
				'description'=>$description,
				'vbank'=>$vbank,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
		//for transaction data	  
		$data2=array(
						'tdate'=>$sdate,
						'type'=>1,
						'bid'=>$vbank,
						'category'=>4,
						'amount'=>$amount,
						'description'=>$description,
						'table'=>'investment',			
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					); 	  
				
				$update = $this->JohoniModel->updateInvestRecord($data, $data2, $rid, 'investment'); 
				if($update)
				{
					
					if (isset($files['attachments'])) 
					{
						foreach ($files['attachments'] as $file)
						{
							//Attachment start
							 if ($file && $file->isValid() && !$file->hasMoved()) {
								 
								// ✅ File is selected and valid
								$originalName = $file->getClientName(); // original name from user
								$mimeType = $file->getClientMimeType(); // MIME type
								$size = $file->getSize(); // in bytes
								$extension = $file->getExtension();	
								
								// Optional: Save it
								$randomNumber = rand(1000, 9999);
								$newName = $sdate.'-'.$randomNumber.'__'.$originalName;
								$uploadPath = FCPATH . 'uploads/salesFund/';
							
								//if (!is_dir($uploadPath)) {
									//mkdir($uploadPath, 0755, true); // 0755 permissions, recursive = true
								//}
								if($file->move($uploadPath, $newName))
								{	
									// Save the image path to the database (optional)
									$salesattModel = new \App\Models\SalesattModel();
									$salesattModel->save([ 
										'pid' => $rid,
										'image' => 'uploads/salesFund/' . $newName,
										'etype' => 'inv',
										
										'userid'=>$userid,
										'username'=>$username,
										"saveDate" => date('Y-m-d H:i:s')
									]);
									echo "File uploaded successfully: $originalName ($mimeType, {$size} bytes)";
								}
								else
								{
									echo "File not moved!";
								}		
								
							} else {
								// ❌ No file selected or invalid
								echo "No file selected or invalid upload.";
							}
							//attachment ends
						}
					} 
					return redirect()->to(base_url('viewFund/'.$rid.'/1'.'')); exit;
				}
				else
				{
					echo "Your record is not saved successfully";
				}		
					
	}
	//Sales view
	public function salesView($rid,$flag)
	{
		$row = $this->JohoniModel->displayRecord($rid);
        		 
		$imageResult = $this->JohoniModel->getImages($rid, 'salesfund');
		$sexpenses = $this->JohoniModel->getShopExpenses($rid, 'qs');
		$data['sexpenses']=$sexpenses;
		
		$data['imageResult']=$imageResult;
		$data['row'] = $row;
		return view('johoni/salesView', $data);
	}
	//View Fund
	public function viewFund($rid,$flag)
	{
		    
		$row = $this->JohoniModel->displayRecord2($rid, 'investment'); 
		$imageResult = $this->JohoniModel->getImages2($rid, 'salesfund', 'inv');
		
		$data['imageResult']=$imageResult;
		$data['row'] = $row;
		return view('johoni/viewFund', $data);
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
		if($pdate > date('Y-m-d'))
		{
			echo "You can not insert future date my friend!"; exit;
		}
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


	//Add Cash Deposit
	public function addCash()
	{		
		//get vbanks
		$vbanks = $this->JohoniModel->getVbanks(); 
		$str2='';
		foreach($vbanks AS $bank)
		{
			if($bank->Id == 1)
			{	
				$str2.='<option value="'.$bank->Id.'" selected>'.$bank->bname.'</option>';
			}
			else
			{
				$str2.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
			}		
		}
		$data['str2']=$str2;
		return view('johoni/addCash', $data);
			
	}

	//Save Cash Deposit
	public function saveCash()
	{
		
		$sdate = $this->request->getPost('sdate');
		$amount = trim($this->request->getPost('amount'));
		$deduction = trim($this->request->getPost('deduction'));
		$description = $this->request->getPost('description');
		$vbank = $this->request->getPost('vbank');
		$deduction = $this->request->getPost('deduction');
		$files = $this->request->getFiles('attachments');
		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		if($sdate > date('Y-m-d'))
		{
			echo "You can not insert future date my friend!"; exit;
		}
		$data = array(
				'sdate'=>$sdate,
				'amount'=>$amount,
				'deduction'=>$deduction,
				'description'=>$description,
				'vbank'=>$vbank,
				
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  ); //echo "<pre />"; print_r($data); exit;
	    //Transaction data	start 
		/* Taypes of categories
		1. card 
		2. atome 
		3. ot
		*/ 


			  
		$data2=array(
						'tdate'=>$sdate,
						'type'=>1,
						'bid'=>$vbank,
						'category'=>6,
						'amount'=>$amount,
						'description'=>$description,
						'table'=>'cashdeposit',			
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					); //echo "<pre />"; print_r($data); exit;	

		//transaction data 		  		
		$rid = $this->JohoniModel->saveCashRecord($data, $data2, 'cashdeposit'); 
		if($rid)
		{
			//sales Attachment
			if (isset($files['attachments'])) 
			{
				foreach ($files['attachments'] as $file)
				{
					//Attachment start
						if ($file && $file->isValid() && !$file->hasMoved()) {
							
						// ✅ File is selected and valid
						$originalName = $file->getClientName(); // original name from user
						$mimeType = $file->getClientMimeType(); // MIME type
						$size = $file->getSize(); // in bytes
						$extension = $file->getExtension();	
						//echo $originalName; exit;
						// Optional: Save it
						$randomNumber = rand(1000, 9999);
						$newName = $sdate.'-'.$randomNumber.'__'.$originalName;
						$uploadPath = FCPATH . 'uploads/cashdeposit/';
					
						//if (!is_dir($uploadPath)) {
							//mkdir($uploadPath, 0755, true); // 0755 permissions, recursive = true
						//}
						if($file->move($uploadPath, $newName))
						{	
							// Save the image path to the database (optional)
							$salesattModel = new \App\Models\SalesattModel();
							$salesattModel->save([ 
								'pid' => $rid,
								'image' => 'uploads/cashdeposit/' . $newName,
								'etype' => 'cash',
								
								'userid'=>$userid,
								'username'=>$username,
								"saveDate" => date('Y-m-d H:i:s')
							]);
							echo "File uploaded successfully: $originalName ($mimeType, {$size} bytes)";
						}
						else
						{
							echo "File not moved!";
						}		
						
					} else {
						// ❌ No file selected or invalid
						echo "No file selected or invalid upload.";
					}
					//attachment ends
				}
			}

			return redirect()->to(base_url('viewCash/'.$rid.'/1'.'')); exit;
		}
		else
		{
			echo "Your record is not saved successfully";
		}		
					
	}
	//edit Cash Deposit
	public function editCash($rid)
	{	
			
			$row = $this->JohoniModel->displayRecord2($rid, 'cashdeposit');
			//get vbanks
			$vbanks = $this->JohoniModel->getVbanks(); 
			$str2='';
			foreach($vbanks AS $bank)
			{
				if($bank->Id == $row->vbank)
				{	
					$str2.='<option value="'.$bank->Id.'" selected>'.$bank->bname.'</option>';
				}
				else
				{
					$str2.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
				}		
			}
		    $data['str2'] = $str2;
		    $data['row'] = $row;
		    $data['rid'] = $rid;
			return view('johoni/editCash', $data);
			
	}

	//View Cash Deposit
	public function viewCash($rid,$flag)
	{
		    
		$row = $this->JohoniModel->displayRecord2($rid, 'cashdeposit'); 
		$imageResult = $this->JohoniModel->getImages2($rid, 'salesfund', 'cash');
		
		$data['imageResult']=$imageResult;
		$data['row'] = $row;
		return view('johoni/viewCash', $data);
	}

	//Update Cash deposit save
	public function editCashSave($rid)
	{
		
		$sdate = $this->request->getPost('sdate');
		$amount = trim($this->request->getPost('amount'));
		$deduction = $this->request->getPost('deduction');
		$description = $this->request->getPost('description');
		$vbank = $this->request->getPost('vbank');
		$files = $this->request->getFiles('attachments');
		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		if($sdate > date('Y-m-d'))
		{
			echo "You can not insert future date my friend!"; exit;
		}
		$data = array(
				'sdate'=>$sdate,
				'amount'=>$amount,
				'deduction'=>$deduction,
				'description'=>$description,
				'vbank'=>$vbank,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
		//for transaction data	  
		$data2=array(
						'tdate'=>$sdate,
						'type'=>1,
						'bid'=>$vbank,
						'category'=>6,
						'amount'=>$amount,
						'description'=>$description,
						'table'=>'cashdeposit',			
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					); 	  
				
				$update = $this->JohoniModel->updateCashRecord($data, $data2, $rid, 'cashdeposit'); 
				if($update)
				{
					
					if (isset($files['attachments'])) 
					{
						foreach ($files['attachments'] as $file)
						{
							//Attachment start
							 if ($file && $file->isValid() && !$file->hasMoved()) {
								 
								// ✅ File is selected and valid
								$originalName = $file->getClientName(); // original name from user
								$mimeType = $file->getClientMimeType(); // MIME type
								$size = $file->getSize(); // in bytes
								$extension = $file->getExtension();	
								
								// Optional: Save it
								$randomNumber = rand(1000, 9999);
								$newName = $sdate.'-'.$randomNumber.'__'.$originalName;
								$uploadPath = FCPATH . 'uploads/cashdeposit/';
							
								//if (!is_dir($uploadPath)) {
									//mkdir($uploadPath, 0755, true); // 0755 permissions, recursive = true
								//}
								if($file->move($uploadPath, $newName))
								{	
									// Save the image path to the database (optional)
									$salesattModel = new \App\Models\SalesattModel();
									$salesattModel->save([ 
										'pid' => $rid,
										'image' => 'uploads/cashdeposit/' . $newName,
										'etype' => 'cash',
										
										'userid'=>$userid,
										'username'=>$username,
										"saveDate" => date('Y-m-d H:i:s')
									]);
									echo "File uploaded successfully: $originalName ($mimeType, {$size} bytes)";
								}
								else
								{
									echo "File not moved!";
								}		
								
							} else {
								// ❌ No file selected or invalid
								echo "No file selected or invalid upload.";
							}
							//attachment ends
						}
					} 
					return redirect()->to(base_url('viewCash/'.$rid.'/1'.'')); exit;
				}
				else
				{
					echo "Your record is not saved successfully";
				}		
					
	}

	
}
