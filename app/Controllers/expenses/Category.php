<?php

namespace App\Controllers\expenses;
use App\Controllers\BaseController;

use App\Models\expenses\ExpensesModel;

use CodeIgniter\I18n\Time;
class Category extends BaseController
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
			
			$result = $this->ExpensesModel->getAllResult('category');  
			$data['result']=$result; //echo $total; exit;
			$hdata['title']='List Category';
			echo view('expenses/header', $hdata);
			echo view('expenses/category/list', $data);
			echo view('expenses/footer');
    }
	
	//Add Category
	public function categoryAdd()
	{
			$data['']='';
			$hdata['title']='Add Category';
			echo view('expenses/header', $hdata);
			echo  view('expenses/category/add', $data);
			echo view('expenses/footer');
	}
	
	//Save Category
	public function categorySave()
	{
		
		$cname = $this->request->getPost('cname');
		//Check if Category is already created
		$check = $this->ExpensesModel->checkRecord('cname',$cname, 'category'); 
		if($check<1)
		{	
			//Get username and id from the session
			$username = $this->session->get('name');
			$userid = $this->session->get('userid');
			$data = array(
					'cname'=>$cname,
					'userid'=>$userid,
					'username'=>$username,
					"saveDate" => date('Y-m-d H:i:s')
				  );
				 //echo "<pre />"; print_r($data); exit;
				 $rid = $this->ExpensesModel->saveRecord($data, 'category'); 
				if($rid)
				{
					return redirect()->to(base_url('codeigniter/public/expenses/categoryView/'.$rid.'/1'.'')); exit;
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
	
	//Category view
	public function categoryView($rid,$flag)
	{
		    
		$row = $this->ExpensesModel->displayRecord($rid, 'category');
		$data['row'] = $row;
		$data['flag'] = $flag;
		$hdata['title'] = 'View Category';
		echo view('expenses/header', $hdata);
		echo view('expenses/category/view', $data);
		echo view('expenses/footer');
	}
	//Category edit view
	public function categoryEditView($rid)
	{
		
		$row = $this->ExpensesModel->displayRecord($rid, 'category');
		$data['row'] = $row;
		$hdata['title'] = 'Edit Category';
		echo view('expenses/header', $hdata);
		echo view('expenses/category/edit', $data);
		echo view('expenses/footer');
	}
	
	//Save Edit Category
	public function categoryEditSave($rid)
	{
		
		$cname = $this->request->getPost('cname');
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		$data = array(
				'cname'=>$cname,
			  );
			  
			$update = $this->ExpensesModel->updateRecord($data, $rid, 'category'); 
			
			//Log table
			$dataLog = array(
				'cname'=>$cname,
				'tname'=>'category',
				'pid'=>$rid,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );	  
			 //echo "<pre />"; print_r($data); exit;
			$this->ExpensesModel->saveRecord($dataLog, 'logs'); 
			
			if($update==1)
			{
				return redirect()->to(base_url('codeigniter/public/expenses/categoryView/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Record Not Update";
			}		
	}
}
