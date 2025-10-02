<?php
namespace App\Models;

use CodeIgniter\Model;

class SalesattModel extends Model
{
    protected $table = 'salesfund';
    protected $allowedFields = ['image', 'Id', 'pid', 'username', 'saveDate', 'userid', 'etype'];
	protected $primaryKey = 'Id';
}
?>