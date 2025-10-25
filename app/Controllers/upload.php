<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Upload extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index($courseId)
    {
        helper(['form', 'url']);

        $uploadPath = FCPATH . 'uploads/materials/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $rules = [
            'material_file' => [
                'uploaded[material_file]',
                'max_size[material_file,10240]', // 10MB max
            ]
        ];

        if (!$this->validate($rules)) {
            return json_encode([
                'status' => 'error',
                'message' => $this->validator->getErrors()
            ]);
        }

        $file = $this->request->getFile('material_file');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            
            try {
                $file->move($uploadPath, $newName);
                
                // Save to database
                $db = \Config\Database::connect();
                $data = [
                    'course_id' => $courseId,
                    'file_name' => $newName,
                    'original_name' => $file->getClientName(),
                    'description' => $this->request->getPost('description'),
                    'uploaded_by' => $this->session->get('user_id'),
                    'upload_date' => date('Y-m-d H:i:s')
                ];
                
                $db->table('materials')->insert($data);

                return json_encode([
                    'status' => 'success',
                    'message' => 'File uploaded successfully'
                ]);
            } catch (\Exception $e) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Error uploading file: ' . $e->getMessage()
                ]);
            }
        }

        return json_encode([
            'status' => 'error',
            'message' => 'Invalid file'
        ]);
    }
}