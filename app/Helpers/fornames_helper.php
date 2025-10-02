<?php
	function bname($name)
	{ 
		$shop = '';
		if($name == 1)
		{
			$shop = "BUY&SAVE";
		}
		else if($name == '2')
		{
			$shop = "GILASCO";
		}
		else if($name == '3')
		{
			$shop = "ESI";
		}
		else if($name == '4')
		{
			$shop = "ESW";
		}
		else if($name == '5')
		{
			$shop = "JOHONI-Q";
		}	
		else if($name == '6')
		{
			$shop = "E66A";
		}
		else if($name == '10')
		{
			$shop = "ME PERFUME";
		}
		else if($name == '11')
		{
			$shop = "Johoni Scent JB";
		}
		else if($name == '12')
		{
			$shop = "Gilasco Chocolate JB";
		}
		return $shop;	
	}
	
	//Bring name of the banks
	function bankName($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('banks');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->bname;
		}
		
	}
	
	//Get debitor and creditor names
	function getdbc($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('debtorcreditor');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->dcnames;
		}
		
	}
	
	//Pagination
	function displayPagination($bita)
	{ 
		$data['records'] = $bita;
	    echo view('pagination/home', $data);
	}
	//Get Debtor and Creditor type
	function dbcType($type)
	{ 
		$typeName = '';
		if($type == 1)
		{
			$typeName = "Owner";
		}
		else if($type == 2)
		{
			$typeName = "Supplier";
		}		
		else if($type == 3)
		{
			$typeName = "Third Party";
		}
		else if($type == 4)
		{
			$typeName = "Government";
		}
		else if($type == 5)
		{
			$typeName = "Old Outstanding";
		}
		else if($type == 6)
		{
			$typeName = "Services";
		}
	
		return $typeName;	
	}
	
	//Payment Type
	function ptype($type)
	{ 
		$typeName = '';
		if($type == 1)
		{
			$typeName = "Online Transfere";
		}
		else if($type == 2)
		{
			$typeName = "Cheque";
		}		
		else if($type == 3)
		{
			$typeName = "Cash";
		}
		return $typeName;	
	}
	
	//Groupe Name
	function gname($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('groupe');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->gname;
		}	
	}
	
	//category Name
	function cname($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('category');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->cname;
		}	
	}
	
	//subcategory Name
	function sname($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('subcategory');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->sname;
		}	
	}
	
	//location
	function location($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('locations');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->name;
		}	
	}

	//Get the vbank
	function vbank($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('vbanks');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->bname;
		}	
	}
	//department
	function getDep($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('departments');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->name;
		}	
	}
	//Nationality
	function getNat($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('nationality');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->country;
		}	
	}
	//get employee name
	function getEmp($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('employees');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->name.' '.$query->lname;
		}	
	}
	//get employee ic
	function getIc($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('employees');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->ic;
		}	
	}
	
	//get employee department
	function getDep2($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('employees');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->department;
		}	
	}
	//perfume group name
	function pgname($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('pgroup');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->gname;
		}	
	}
	//perfume category name
	function pcname($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('pcategory');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->cname;
		}	
	}
	//Get day of the week
	function getDay($type)
	{ 
		$typeName = '';
		if($type == 1)
		{
			$typeName = "Monday";
		}
		else if($type == 2)
		{
			$typeName = "Tuesday";
		}		
		else if($type == 3)
		{
			$typeName = "Wednesday";
		}
		else if($type == 4)
		{
			$typeName = "Thursday";
		}
		else if($type == 5)
		{
			$typeName = "Friday";
		}
		else if($type == 6)
		{
			$typeName = "Saturday";
		}
		else if($type == 7)
		{
			$typeName = "Sunday";
		}
		else if($type == 8)
		{
			$typeName = "None";
		}
		return $typeName;	
	}
	
	//Get Image path
	function getImage($rid)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('pimages');
		$query = $builder->getWhere(['rid' => $rid]);
		if($query AND isset($query->getRow()->image_path))
		{	
			return $query = $query->getRow()->image_path;
		}
			
	}
	
	//Get gender
	function getGender($id)
	{ 
		$typeName = '';
		if($id == 1)
		{
			$typeName = "Male";
		}
		else if($id == 2)
		{
			$typeName = "Female";
		}		
		return $typeName;	
	}
	
	//Get marrital Status
	function getMstatus($id)
	{ 
		$typeName = '';
		if($id == 1)
		{
			$typeName = "Single";
		}
		else if($id == 2)
		{
			$typeName = "Marride";
		}		
		return $typeName;	
	}
	
	//Bring name of the all banks
	function getbname($id)
	{ 
		//connect Database
		$db = \Config\Database::connect();
		$builder = $db->table('allbanks');
		$query = $builder->getWhere(['Id' => $id]);
		$query = $query->getRow();
		if($query)
		{	
			return $query->bname;
		}
		
	}
	
	//Get Nationality L/F
	function getNat2($id)
	{ 
		$typeName = '';
		if($id == 1)
		{
			$typeName = "Local";
		}
		else 
		{
			$typeName = "Foreigner";
		}		
		return $typeName;	
	}
	//Calculate Age from a given DOB
	function calculateAge($dob) 
	{
		$birthDate = new DateTime($dob);
		$today = new DateTime();
		$age = $birthDate->diff($today)->y;
		return $age;
	}	
	
	//Get description of the type
	function getDesType($type)
	{ 
		$typeName = '';
		if($type == 1)
		{
			$typeName = "Card";
		}
		else if($type == 2)
		{
			$typeName = "Atome";
		}
		else if($type == 3)
		{
			$typeName = "Online Transfer";
		}
		else if($type == 4)
		{
			$typeName = "Investment";
		}
		else if($type == 5)
		{
			$typeName = "Expenses";
		}
		else if($type == 6)
		{
			$typeName = "Cash Deposit";
		}
		return $typeName;
	}	
?>