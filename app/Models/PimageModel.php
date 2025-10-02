<?php
namespace App\Models;

use CodeIgniter\Model;

class PimageModel extends Model
{
    protected $table = 'pimages';
    protected $allowedFields = ['image_path', 'rid', 'etype'];
	protected $primaryKey = 'Id';
}
?>