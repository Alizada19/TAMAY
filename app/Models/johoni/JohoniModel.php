<?php
namespace App\Models\johoni;
use CodeIgniter\Model;
class JohoniModel extends Model
{

	protected $table = 'johoni'; // ✅ This tells CodeIgniter which table to use
	protected $primaryKey = 'Id';
	protected $allowedFields = ['Id', 'sdate', 'tsales', 'card', 'netcash', 'description', 'username', 'saveDate', 'userid', 'vbank']; // Add other fields if needed
		
			
	//Save record		
	public function saveRecord($data, $container, $table, $cardDeduction = 0, $atomeDeduction = 0)
	{
		  
			//echo "<pre />"; print_r($container); exit;
			$this->db->transStart(); // Start transaction
			$query = $this->db->table($table);
			$res = $query->insert($data);
			$lastId = $this->db->insertID();
			foreach($container AS $data2)
			{
				
				
				//First get previous balance
				$query = $this->db->query("SELECT balance FROM transactions ORDER BY Id DESC LIMIT 1");
				$row = $query->getRow();
				$pbalance = $row ? $row->balance : 0; // Default to 0 if no records yet
				$newBalance = $pbalance + $data2['amount']; // Calculate new balance
				$data2['balance'] = $newBalance; // Set new balance
				//end of getting previous balance and setting new balance
				$data2['pid'] = $lastId;
				$query = $this->db->table('transactions');
				$res2 = $query->insert($data2);
				//echo "<pre >"; print_r($data2); exit;
				// Insert deduction amount as expenses in both johoni and expenses tables
				if($res2 AND $data2['category'] == 1)
				{
					$data2['amount'] = $cardDeduction; // 2% deduction
					$this->cardPayCharges($data2);
				}	
				if($res2 AND $data2['category'] == 2)
				{
					$data2['amount'] = $atomeDeduction; // 7% deduction
					$this->atomePayCharges($data2);
				}
			}
			$this->db->transComplete();
			if ($this->db->transStatus() === false) 
			{
				// Something went wrong
				echo  "Your transaction record has problem my friend!!!!!!!!!!!!:(";
			} 
			else
			{
				return $lastId;
			}
			
		
	}

	//Save investment record		
	public function saveInvestRecord($data, $data2, $table)
	{
		  
			//echo "<pre />"; print_r($container); exit;
		
			$query = $this->db->table($table);
			$res = $query->insert($data);
			$lastId = $this->db->insertID();
			
			if ($lastId) 
			{
				return $lastId;
			} 
			else
			{
				return 0;
			}
			
		
	}

	//Save Cash Deposit record		
	public function saveCashRecord($data, $data2, $table)
	{
		  
			//echo "<pre />"; print_r($data2); exit;
			$this->db->transStart(); // Start transaction
			$query = $this->db->table($table);
			$res = $query->insert($data);
			$lastId = $this->db->insertID();
			//First get previous balance
			$tquery = $this->db->query("SELECT balance FROM transactions ORDER BY Id DESC LIMIT 1");
			$row = $tquery->getRow();
			$pbalance = $row ? $row->balance : 0; // Default to 0 if no records yet
			$newBalance = $pbalance + $data2['amount']; // Calculate new balance
			$data2['balance'] = $newBalance; // Set new balance
			//end of getting previous balance and setting new balance
			$data2['pid'] = $lastId;
			$query = $this->db->table('transactions');
			$res2 = $query->insert($data2);
			//echo "<pre >"; print_r($data2); exit;
			$this->db->transComplete();
			if ($this->db->transStatus() === false) 
			{
				// Something went wrong
				echo  "Your transaction record has problem my friend!!!!!!!!!!!!:(";
			} 
			else
			{
				return $lastId;
			}
			
		
	}
	//Display records
	public function displayRecord($rid)
	{    
			//$query = $this->db->query("SELECT * FROM $table WHERE Id=$rid");
			//$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			//return $res;
			
			$res = $this->select('johoni.*, SUM(expenses.amount) as texpense')
						 ->join('expenses', "expenses.pid = johoni.Id AND expenses.etype = 'qs'", 'left')
						 ->where('johoni.Id', $rid) 
						 ->groupBy('johoni.Id')
						 ->asObject()
						 ->first();
			//echo "<pre />"; print_r($res); exit;			 
			return $res;
			//echo $res->sdate; exit;			 
					 
	}
	
	//Get locations
	public function getLocations()
	{
			$db = \Config\Database::connect();
			$res = $db->table('locations')
				->select('*')
				->where('active', '1')
				->get()
				->getResult();
			return $res;			 		 
	}

	//Get vbanks records 		
	public function getVbanks()
	{
			$db = \Config\Database::connect();
			$res = $db->table('vbanks')
				->select('*')
				->where('active', '1')
				->get()
				->getResult();
			return $res;			 		 
	}
	//Display records of funds
	public function displayRecord2($rid, $table)
	{
			$query = $this->db->query("SELECT * FROM $table WHERE Id=$rid");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
			
						 
			//echo "<pre />"; print_r($res); exit;		 
	}
	
	//Get images
	public function getImages($rid, $table)
	{
			$query = $this->db->query("SELECT * FROM $table WHERE pid=$rid AND etype='q'");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get images
	public function getImages2($rid, $table, $etype)
	{
			$query = $this->db->query("SELECT * FROM $table WHERE pid=$rid AND etype='$etype'");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get shop expenses for the sales book
	public function getShopExpenses($pid, $etype)
	{
			$query = $this->db->query("SELECT * FROM expenses WHERE pid=$pid AND etype='$etype'");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Update one record
	public function updateRecord($data, $container, $rid, $table)
	{
		
		    $this->db->transStart(); // Start transaction
			$query = $this->db->table($table);
			$query->set($data);
			$query->where('Id', $rid);
			$res = $query->update(); 
			foreach($container AS $data2)
			{
				if(isset($data2['category']) AND $data2['category'] == 1)
				{ 
					$cardDeduction = $data2['amount'] * 0.02;
					//$data2['amount']=$data2['amount'] - ($data2['amount'] * 0.02); //2% deduction
					$query = $this->db->table('transactions');
					$query->where('pid', $rid);
					$query->where('category', 1);
					$res2 = $query->update($data2);
					// If no rows were affected, insert instead
					if ($this->db->affectedRows() === 0) 
					{
						$data2['pid']=$rid;
						$this->db->table('transactions')->insert($data2);
					}
					//Recalculate balace
					$this->recalculateSalesTransactionBalance('johoni', $rid, 1);

					// Insert/update deduction amount as expenses in both johoni and expenses tables
					$this->cardPayChargesUpdate($data2, $cardDeduction, $rid);
				}
				else if(isset($data2['category']) AND $data2['category'] == 2)
				{ 
					$atomeDeduction = $data2['amount'] * 0.07;
					//$data2['amount']=$data2['amount'] - ($data2['amount'] * 0.07); //7% deduction
					$query = $this->db->table('transactions');
					$query->where('pid', $rid);
					$query->where('category', 2);
					$res2 = $query->update($data2);
					// If no rows were affected, insert instead
					if ($this->db->affectedRows() === 0) 
					{
						$data2['pid']=$rid;
						$data2['amount']=$data2['amount'] - ($data2['amount'] * 0.07); //7% deduction
						$this->db->table('transactions')->insert($data2);
					}
					//Recalculate balace
					$this->recalculateSalesTransactionBalance('johoni', $rid, 2);

					// Insert/update deduction amount as expenses in both johoni and expenses tables
					$this->atomePayChargesUpdate($data2, $atomeDeduction, $rid);
				}
				else if(isset($data2['category']) AND $data2['category'] == 3)
				{ 
					$query = $this->db->table('transactions');
					$query->where('pid', $rid);
					$query->where('category', 3);
					$res2 = $query->update($data2);
					// If no rows were affected, insert instead
					if ($this->db->affectedRows() === 0) 
					{
						$data2['pid']=$rid;
						$this->db->table('transactions')->insert($data2);
					}
					//Recalculate balace
					$this->recalculateSalesTransactionBalance('johoni', $rid, 3);
				}
				//echo "<pre >"; print_r($data2); exit;
			}
			$this->db->transComplete();
			
			if ($this->db->transStatus() === false) 
			{
				// Something went wrong
				echo  "Your transaction record has problem my friend!!!!!!!!!!!!:(";
			} 
			else
			{
				return $res;
			}
	}
	
	//Update investment record
	//Update one record
	public function updateInvestRecord($data, $data2, $rid, $table)
	{
			$query = $this->db->table($table);
			$query->set($data);
			$query->where('Id', $rid);
			$res = $query->update(); 
			
			if ($res) 
			{
				return $res;
			} 
			else
			{
				return 0;
			}
	}

	//Update cash deposit record
	public function updateCashRecord($data, $data2, $rid, $table)
	{
		    $this->db->transStart(); // Start transaction
			$query = $this->db->table($table);
			$query->set($data);
			$query->where('Id', $rid);
			$res = $query->update(); 
			
			if($res)
			{ 
				$query = $this->db->table('transactions');
				$query->where('pid', $rid);
				$query->where('category', 6);
				$res2 = $query->update($data2);
				$this->recalculateSalesTransactionBalance('cashdeposit', $rid, 6);
			}
				
			
			$this->db->transComplete();
			if ($this->db->transStatus() === false) 
			{
				// Something went wrong
				echo  "Your transaction record has problem my friend!!!!!!!!!!!!:(";
			} 
			else
			{
				return $res;
			}
	}
	//Get all results
	public function getAllResult($table)
	{
			$query = $this->db->query("SELECT * FROM $table ORDER BY saveDate DESC");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get one Total
	public function getOneTotal($value1,$table)
	{
		    
			$query = $this->db->query("SELECT COUNT($value1) total FROM $table");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//Check Record
	public function checkRecord($value1, $value2, $table)
	{
		    
			$query = $this->db->query("SELECT COUNT($value1) AS total FROM $table WHERE $value1='$value2'");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//Get all result expenses payments
	public function expensesAllResult($perpage, $offset)
	{
			$query = $this->db->query("SELECT * FROM expenses ORDER BY pdate DESC limit $offset, $perpage");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//main one Total
	public function mainOneTotal($value1,$table)
	{
		    
			$query = $this->db->query("SELECT SUM($value1) AS total FROM $table");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//temp can be removed
	public function temp($perpage, $offset)
	{
			$query = $this->db->query("SELECT * FROM expenses limit $offset, $perpage");
			$res = $query->getResult(); 
			return $res;
	}
	
	//Filter Search
	public function filterSearch($data, $perpage, $offset)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND pdate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['amount']!='')
			{
				$amount=$data['amount']; 
				$str.=" AND amount=$amount";
			}
			if($data['groupe']!='')
			{
				$groupe=$data['groupe']; 
				$str.=" AND groupe=$groupe";
			}
			if($data['category']!='')
			{
				$category=$data['category']; 
				$str.=" AND category=$category";
			}	
			if($data['subcategory']!='')
			{
				$subcategory=$data['subcategory']; 
				$str.=" AND subcategory=$subcategory";
			}
			if($data['des']!='')
			{
				$des=$data['des']; 
				$str.=" AND des='$des'";
			}
			if($data['ptype']!='')
			{
				$ptype=$data['ptype']; 
				$str.=" AND ptype=$ptype";
			}
			$query = $this->db->query("SELECT * FROM expenses WHERE $str limit $offset, $perpage");
			$res = $query->getResult(); 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Filter Search for report expenses
	public function reportExpenses($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND pdate BETWEEN '$sdate' AND '$edate'";
			}
			
			$query = $this->db->query("SELECT * FROM expenses WHERE $str ORDER by pdate");
			$res = $query->getResult(); 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Filter Search for report expenses total
	public function reportExpensesTotal($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND pdate BETWEEN '$sdate' AND '$edate'";
			}
			
			$query = $this->db->query("SELECT SUM(amount) AS total FROM expenses WHERE $str");
			$res = $query->getRow()->total;
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Filter Search Sum
	public function filterSearchSum($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND pdate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['amount']!='')
			{
				$amount=$data['amount']; 
				$str.=" AND amount=$amount";
			}
			if($data['groupe']!='')
			{
				$groupe=$data['groupe']; 
				$str.=" AND groupe=$groupe";
			}
			if($data['category']!='')
			{
				$category=$data['category']; 
				$str.=" AND category=$category";
			}	
			if($data['subcategory']!='')
			{
				$subcategory=$data['subcategory']; 
				$str.=" AND subcategory=$subcategory";
			}
			if($data['des']!='')
			{
				$des=$data['des']; 
				$str.=" AND des='$des'";
			}
			if($data['ptype']!='')
			{
				$ptype=$data['ptype']; 
				$str.=" AND ptype=$ptype";
			}
			$query = $this->db->query("SELECT SUM(amount) AS total FROM expenses WHERE $str");
			$res = $query->getRow()->total; 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Count total
	public function filterSearchTotal($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND pdate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['amount']!='')
			{
				$amount=$data['amount']; 
				$str.=" AND amount=$amount";
			}
			if($data['groupe']!='')
			{
				$groupe=$data['groupe']; 
				$str.=" AND groupe=$groupe";
			}
			if($data['category']!='')
			{
				$category=$data['category']; 
				$str.=" AND category=$category";
			}	
			if($data['subcategory']!='')
			{
				$subcategory=$data['subcategory']; 
				$str.=" AND subcategory=$subcategory";
			}
			if($data['des']!='')
			{
				$des=$data['des']; 
				$str.=" AND des='$des'";
			}
			if($data['ptype']!='')
			{
				$ptype=$data['ptype']; 
				$str.=" AND ptype=$ptype";
			}
			$query = $this->db->query("SELECT COUNT(*) AS total FROM expenses WHERE $str");
			$res = $query->getRow()->total; 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Groupe based report
	public function greport()
	{
			$query = $this->db->query("SELECT * FROM expenses WHERE groupe!=0 ORDER BY groupe");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get all the expenses
	public function expenses()
	{
			$query = $this->db->query("SELECT t1.groupe AS groupe, SUM(t1.amount) AS amount FROM expenses AS t1 WHERE groupe!=0 AND MONTH(pdate)=MONTH(CURRENT_DATE()) GROUP BY t1.groupe");
			$res = $query->getResult(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Sum amounts for the expenses
	public function sumAmount()
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS tamount FROM expenses AS t1 WHERE groupe!=0 AND MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getRow()->tamount; 
			return $res;
	}
	
	//Groupe based expenses
	public function groupebased($gid)
	{
			$query = $this->db->query("SELECT * FROM expenses WHERE groupe!=0 AND groupe=$gid AND MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getResult(); 
			return $res;
	}
	//Groupe based total expenses
	public function groupebasedTotal($gid)
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS total FROM expenses AS t1 WHERE groupe!=0 AND groupe=$gid AND MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//Get Category
	public function getCategory()
	{
			$query = $this->db->query("SELECT t1.category AS category, SUM(t1.amount) AS amount FROM expenses AS t1 WHERE MONTH(pdate)=MONTH(CURRENT_DATE()) GROUP BY t1.category");
			$res = $query->getResult(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get Category total sub parts
	public function getCategoryTotal()
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS total FROM expenses AS t1 WHERE MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getRow()->total; //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//category based expenses
	public function categorybased($cid)
	{
			$query = $this->db->query("SELECT * FROM expenses WHERE category=$cid AND MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getResult(); 
			return $res;
	}
	//category based total expenses
	public function categorybasedTotal($cid)
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS total FROM expenses AS t1 WHERE category=$cid AND MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//Get all the expenses
	public function cexpenses()
	{
			$query = $this->db->query("SELECT t1.groupe AS groupe, SUM(t1.amount) AS amount FROM expenses AS t1 WHERE groupe!=0 AND MONTH(pdate)=MONTH(CURRENT_DATE()) GROUP BY t1.groupe");
			$res = $query->getResultArray(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Expenses by category
	public function expenseBycategory()
	{
			$query = $this->db->query("SELECT t1.category AS category, SUM(t1.amount) AS amount FROM expenses AS t1 WHERE MONTH(pdate)=MONTH(CURRENT_DATE()) GROUP BY t1.category");
			$res = $query->getResultArray(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get cheque record
	public function getCheque($cid)
	{
			$query = $this->db->query("SELECT pto, amount FROM payments WHERE cno=$cid AND ptype='1'");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Update cheque by cheque no
	public function updateCheque($cno)
	{
		  
			$query = $this->db->table("payments");
			$query->set('status', 2);
			$query->where('cno', $cno);
			$res = $query->update(); 
			if($res == 1)
			{	
				return 1;
			}
			else
			{	
				return 0;
			}
	}
	
	//Get fid from the expenses
	public function getFid($rid)
	{
			$query = $this->db->query("SELECT fid FROM expenses WHERE Id=$rid");
			$res = $query->getRow()->fid; 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Check if record already inserted
	public function getRecord($sdate, $table)
	{	
			$query = $this->db->query("SELECT * FROM $table WHERE sdate = ?", [$sdate]);
			$res = $query->getNumRows();
			return $res;

	}

	//Recalculate transaction balances for sales book
	public function recalculateSalesTransactionBalance($table, $id, $category)
	{  
		// Get previous balance and id of the record
		$query_prev = $this->db->query("
			SELECT Id, balance FROM transactions
			WHERE Id < (
				SELECT Id FROM transactions 
				WHERE pid = ? AND category = ? AND `table` = ?
			)
			ORDER BY Id DESC
			LIMIT 1
		", [$id, $category, $table]);
		//echo $this->db->getLastQuery()->getQuery(); exit;
		//echo $query_prev->getRow()->balance; exit;
		$prevBalance = $query_prev->getRow() ? $query_prev->getRow()->balance : 0;
		$foundId = $query_prev->getRow() ? $query_prev->getRow()->Id : 0;
		
		// Get all transactions from this point forward
		$query = $this->db->query("
				SELECT Id, type, amount FROM transactions 
				WHERE Id > ?
				ORDER BY Id ASC
			", [$foundId]);
		$transactions = $query->getResult();
		//echo "<pre />"; print_r($transactions); exit;
		//echo $this->db->getLastQuery()->getQuery(); exit;
		$newBalance=0;
		foreach ($transactions as $row) 
		{
				
			if ($row->type == 1) 
			{  
				$newBalance = $prevBalance + $row->amount;
			} 
			elseif ($row->type == 2) 
			{
				$newBalance = $prevBalance - $row->amount;
			}
			
			$this->db->table('transactions')
					->where('Id', $row->Id)
					->update(['balance' => $newBalance]);
			$prevBalance = $newBalance; // Update previous balance for next iteration		
		}
		
	}
	//Insert card pay charges in both johoni and expenses tables
	public function cardPayCharges($data2)
	{
		    $data = array(
				'pdate' => $data2['tdate'],
				'amount' => $data2['amount'],
				'groupe' => 36,
				'pid'=>$data2['pid'],
				'userid' => $data2['userid'],
				'username' => $data2['username'],
				'saveDate' => $data2['saveDate'],
			);
			$data3 = array(
				'tdate'=> $data2['tdate'],
				'type'=>2,
				'bid'=>$data2['bid'],
				'category'=>5,
				'amount'=>$data2['amount'],
				'pid'=>$data2['pid'],
				'table'=>'expenses',			
				'userid'=>$data2['userid'],
				'username' => $data2['username'],
				'saveDate' => $data2['saveDate'],
			);
			//echo "<pre >"; print_r($data2); exit;
			$query = $this->db->table('expenses');
			$res = $query->insert($data);
			$lastId = $this->db->insertID();
			//First get previous balance
			$tquery = $this->db->query("SELECT balance FROM transactions ORDER BY Id DESC LIMIT 1");
			$row = $tquery->getRow();
			$pbalance = $row ? $row->balance : 0; // Default to 0 if no records yet
			$newBalance = $pbalance - $data3['amount']; // Calculate new balance
			$data3['balance'] = $newBalance; // Set new balance
			//end of getting previous balance and setting new balance
			$data3['pid'] = $lastId;
			$query = $this->db->table('transactions');
			$res2 = $query->insert($data3);
			//echo "<pre >"; print_r($data2); exit;

			if ($res) 
			{
				return $lastId;
			} 
			else
			{
				return 0;
			}
	}

	//Insert atome  pay charges in both johoni and expenses tables
	public function atomePayCharges($data2)
	{
		    $data = array(
				'pdate' => $data2['tdate'],
				'amount' => $data2['amount'],
				'groupe' => 37,
				'pid'=>$data2['pid'],
				'userid' => $data2['userid'],
				'username' => $data2['username'],
				'saveDate' => $data2['saveDate'],
			);
			$data3 = array(
				'tdate'=> $data2['tdate'],
				'type'=>2,
				'bid'=>$data2['bid'],
				'category'=>5,
				'amount'=>$data2['amount'],
				'table'=>'expenses',
				'pid'=>$data2['pid'],			
				'userid'=>$data2['userid'],
				'username' => $data2['username'],
				'saveDate' => $data2['saveDate'],
			);
			//echo "<pre >"; print_r($data3); exit;
			$query = $this->db->table('expenses');
			$res = $query->insert($data);
			$lastId = $this->db->insertID();
			//First get previous balance
			$tquery = $this->db->query("SELECT balance FROM transactions ORDER BY Id DESC LIMIT 1");
			$row = $tquery->getRow();
			$pbalance = $row ? $row->balance : 0; // Default to 0 if no records yet
			$newBalance = $pbalance - $data3['amount']; // Calculate new balance
			$data3['balance'] = $newBalance; // Set new balance
			//end of getting previous balance and setting new balance
			$data3['pid'] = $lastId;
			$query = $this->db->table('transactions');
			$res3 = $query->insert($data3);
			//echo "<pre >"; print_r($data2); exit;

			if ($res) 
			{
				return $lastId;
			} 
			else
			{
				return 0;
			}
	}

	//Insert/update card  pay charges in both johoni and expenses tables
	public function cardPayChargesUpdate($data2, $cardDeduction, $rid)
	{
		    $data = array(
				'pdate' => $data2['tdate'],
				'amount' => $cardDeduction,
				'groupe' => 36,
				'userid' => $data2['userid'],
				'username' => $data2['username'],
				'saveDate' => $data2['saveDate'],
			);
			$data3 = array(
				'tdate'=> $data2['tdate'],
				'type'=>2,
				'bid'=>$data2['bid'],
				'category'=>5,
				'amount'=>$cardDeduction,
				'table'=>'expenses',			
				'userid'=>$data2['userid'],
				'username' => $data2['username'],
				'saveDate' => $data2['saveDate'],
			);
			//echo "<pre >"; print_r($data); exit;
			$query = $this->db->table('expenses');
			$query->set($data);
			$query->where('pid', $rid);
			$query->where('groupe', 36);
			$res = $query->update(); 
			
			// If no rows were affected, insert instead
			if ($this->db->affectedRows() === 0) 
			{
				$data['pid'] = $rid;
				$this->db->table('expenses')->insert($data);
				$lastId = $this->db->insertID();
				$data3['pid'] = $lastId;
				$this->db->table('transactions')->insert($data3);
				$this->recalculateSalesTransactionBalance('expenses', $lastId, 5);
			}
			else 
			{   
				$tquery = $this->db->query("SELECT Id FROM expenses WHERE pid = $rid AND groupe = 36");
				$row = $tquery->getRow();
				$mrpid = $row ? $row->Id : 0;
			
				//echo "<pre />"; print_r($data3); exit;
				$query = $this->db->table('transactions');
				$query->where('pid', $mrpid);
				$query->where('category', 5);
				$res2 = $query->update($data3);
				//Recalculate balace
				$this->recalculateSalesTransactionBalance('expenses', $mrpid, 5);
			}
	}

	//Insert/update atome  pay charges in both johoni and expenses tables
	public function atomePayChargesUpdate($data2, $atomeDeduction, $rid)
	{
		    $data = array(
				'pdate' => $data2['tdate'],
				'amount' => $atomeDeduction,
				'groupe' => 37,
				'userid' => $data2['userid'],
				'username' => $data2['username'],
				'saveDate' => $data2['saveDate'],
			);
			$data3 = array(
				'tdate'=> $data2['tdate'],
				'type'=>2,
				'bid'=>$data2['bid'],
				'category'=>5,
				'amount'=>$atomeDeduction,
				'table'=>'expenses',			
				'userid'=>$data2['userid'],
				'username' => $data2['username'],
				'saveDate' => $data2['saveDate'],
			);
			//echo "<pre >"; print_r($data); exit;
			$query = $this->db->table('expenses');
			$query->set($data);
			$query->where('pid', $rid);
			$query->where('groupe', 37);
			$res = $query->update(); 
			// If no rows were affected, insert instead
			if ($this->db->affectedRows() === 0) 
			{
				$data['pid'] = $rid;
				$this->db->table('expenses')->insert($data);
				$lastId = $this->db->insertID();
				$data3['pid'] = $lastId;
				$this->db->table('transactions')->insert($data3);
				$this->recalculateSalesTransactionBalance('expenses', $lastId, 5);
			}
			else 
			{   
				$tquery = $this->db->query("SELECT Id FROM expenses WHERE pid = $rid AND groupe = 37");
				$row = $tquery->getRow();
				$mrpid = $row ? $row->Id : 0;
			
				//echo "<pre />"; print_r($data3); exit;
				$query = $this->db->table('transactions');
				$query->where('pid', $mrpid);
				$query->where('category', 5);
				$res2 = $query->update($data3);
				//Recalculate balace
				$this->recalculateSalesTransactionBalance('expenses', $mrpid, 5);
			}
				
			
	}
}	
?>




