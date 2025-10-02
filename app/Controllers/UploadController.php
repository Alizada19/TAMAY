<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class UploadController extends ResourceController
{    
    public function uploadImage()
    {
        // Set CORS headers before anything else
        $this->response->setHeader("Access-Control-Allow-Origin", "*");
        $this->response->setHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
        $this->response->setHeader("Access-Control-Allow-Headers", "Content-Type, Authorization");

        // Handle preflight OPTIONS request
        if ($this->request->getMethod(true) === 'OPTIONS') {
            return $this->response->setStatusCode(200);
        }

        // Continue with your logic
        return $this->respond([
            'status' => 'success',
            'data'   => 'Your data here'
        ]);
    }
}
