<?php

namespace App\Controllers\expenses;
use App\Controllers\BaseController;

use App\Models\expenses\ExpensesModel;

use CodeIgniter\I18n\Time;
class Subcategory extends BaseController
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
			
			$result = $this->ExpensesModel->getAllResult('subcategory');  
			$data['result']=$result; //echo $total; exit;
			$hdata['title']='List Subcategory';
			echo view('expenses/header', $hdata);
			echo view('expenses/subcategory/list', $data);
			echo view('expenses/footer');
    }
	
	//Add sub Category
	public function subcategoryAdd()
	{
			$data['']='';
			$hdata['title']='Add Subcategory';
			echo view('expenses/header', $hdata);
			echo  view('expenses/subcategory/add', $data);
			echo view('expenses/footer');
	}
	
	//Save sub Category
	public function subcategorySave()
	{
		
		$sname = $this->request->getPost('sname');
		//Check if Category is already created
		$check = $this->ExpensesModel->checkRecord('sname',$sname, 'subcategory'); 
		if($check<1)
		{	
			//Get username and id from the session
			$username = $this->session->get('name');
			$userid = $this->session->get('userid');
			$data = array(
					'sname'=>$sname,
					'userid'=>$userid,
					'username'=>$username,
					"saveDate" => date('Y-m-d H:i:s')
				  );
				 //echo "<pre />"; print_r($data); exit;
				 $rid = $this->ExpensesModel->saveRecord($data, 'subcategory'); 
				if($rid)
				{
					return redirect()->to(base_url('codeigniter/public/expenses/subcategoryView/'.$rid.'/1'.'')); exit;
				}
				else
				{
					echo "Your record is not saved successfully";
				}		
		}
		else
		{
			echo "Category Name Aready exist in the database!";
		}		
	}
	
	//sub Category view
	public function subcategoryView($rid,$flag)
	{
		    
		$row = $this->ExpensesModel->displayRecord($rid, 'subcategory');
		$data['row'] = $row;
		$data['flag'] = $flag;
		$hdata['title'] = 'View Subcategory';
		echo view('expenses/header', $hdata);
		echo view('expenses/subcategory/view', $data);
		echo view('expenses/footer');
	}
	//sub Category edit view
	public function subcategoryEditView($rid)
	{
		
		$row = $this->ExpensesModel->displayRecord($rid, 'subcategory');
		$data['row'] = $row;
		$hdata['title'] = 'Edit Subcategory';
		echo view('expenses/header', $hdata);
		echo view('expenses/subcategory/edit', $data);
		echo view('expenses/footer');
	}
	
	//Save Edit sub Category
	public function subcategoryEditSave($rid)
	{
		
		$sname = $this->request->getPost('sname');
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		$data = array(
				'sname'=>$sname,
			  );
			  
			$update = $this->ExpensesModel->updateRecord($data, $rid, 'subcategory'); 
			
			//Log table
			$dataLog = array(
				'sname'=>$sname,
				'tname'=>'subcategory',
				'pid'=>$rid,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );	  
			 //echo "<pre />"; print_r($data); exit;
			$this->ExpensesModel->saveRecord($dataLog, 'logs'); 
			
			if($update==1)
			{
				return redirect()->to(base_url('codeigniter/public/expenses/subcategoryView/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Record Not Update";
			}		
	}
}
