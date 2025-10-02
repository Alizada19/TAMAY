<?php
namespace App\Models;

use CodeIgniter\Model;

class ImageModel extends Model
{
    protected $table = 'images';
    protected $allowedFields = ['image_path', 'empId', 'etype'];
	protected $primaryKey = 'Id';
}
?>