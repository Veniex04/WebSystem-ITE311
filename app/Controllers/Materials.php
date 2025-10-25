<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class Materials extends BaseController
{
    protected $helpers = ['form', 'url'];
    protected $materialModel;
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    /**
     * Display the file upload form and handle file upload process
     * 
     * @param int $course_id The course ID
     * @return mixed
     */
    public function upload($course_id = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Please login first.');
        }

        $userRole = session()->get('user_role');
        $userId = session()->get('user_id');

        // Validate course_id
        if (!$course_id) {
            return redirect()->back()->with('error', 'Course ID is required.');
        }

        // Check if course exists
        $course = $this->courseModel->find($course_id);
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found.');
        }

        // Check permissions - only teachers and admins can upload materials
        if (!in_array($userRole, ['teacher', 'admin'])) {
            return redirect()->back()->with('error', 'You do not have permission to upload materials.');
        }

        // For teachers, check if they own the course
        if ($userRole === 'teacher' && $course['instructor_id'] != $userId) {
            return redirect()->back()->with('error', 'You can only upload materials to your own courses.');
        }

        // Check for POST request (file upload)
        if ($this->request->getMethod() === 'POST') {
            return $this->handleFileUpload($course_id);
        }

        // Display upload form (GET request)
        $data = [
            'title' => 'Upload Material - ' . $course['title'],
            'course' => $course,
            'course_id' => $course_id
        ];

        return view('materials/upload', $data);
    }

    /**
     * Handle the file upload process using CodeIgniter's File Uploading Library
     * 
     * @param int $course_id The course ID
     * @return mixed
     */
    private function handleFileUpload($course_id)
    {
        // Load CodeIgniter's File Uploading Library
        $fileUpload = \Config\Services::fileUpload();
        
        // Load Validation Library
        $validation = \Config\Services::validation();

        // Get the uploaded file
        $file = $this->request->getFile('material_file');

        // Configure upload preferences
        $config = [
            'upload_path'   => WRITEPATH . 'uploads/materials/',
            'allowed_types' => 'pdf|doc|docx|ppt|pptx|txt|jpg|jpeg|png|gif|mp4|mp3|zip',
            'max_size'      => 10240, // 10MB in KB
            'max_width'     => 0,
            'max_height'    => 0,
            'encrypt_name'  => true,  // Generate unique filename
            'remove_spaces' => true
        ];

        // Create upload directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        // Set validation rules
        $validation->setRules([
            'material_file' => [
                'rules' => 'uploaded[material_file]|max_size[material_file,10240]|ext_in[material_file,pdf,doc,docx,ppt,pptx,txt,jpg,jpeg,png,gif,mp4,mp3,zip]',
                'errors' => [
                    'uploaded' => 'Please select a file to upload.',
                    'max_size' => 'File size cannot exceed 10MB.',
                    'ext_in'   => 'File type not allowed. Allowed types: PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, PNG, GIF, MP4, MP3, ZIP'
                ]
            ]
        ]);

        // Validate the file
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Check if file is valid
        if (!$file->isValid()) {
            return redirect()->back()->withInput()->with('error', 'File upload failed: ' . $file->getErrorString());
        }

        // Perform the file upload
        if ($file->move($config['upload_path'], $file->getRandomName())) {
            // Prepare data for database
            $materialData = [
                'course_id' => $course_id,
                'file_name' => $file->getClientName(),
                'file_path' => 'uploads/materials/' . $file->getName()
            ];
            
            // Log the prepared data for debugging
            log_message('info', 'Materials Controller: Prepared material data for database', $materialData);

            // Save to database using MaterialModel
            log_message('info', 'Materials Controller: Attempting to save material to database', $materialData);
            $materialId = $this->materialModel->insertMaterial($materialData);

            if ($materialId) {
                log_message('info', 'Materials Controller: Material saved successfully with ID: ' . $materialId);
                // Set success flash message and redirect to course management
                return redirect()->to('/materials/list/' . $course_id)
                    ->with('success', 'Material "' . $file->getClientName() . '" uploaded successfully!');
            } else {
                log_message('error', 'Materials Controller: Model failed, trying direct database insert');
                
                // Try direct database insert as backup
                $db = \Config\Database::connect();
                try {
                    $sql = "INSERT INTO materials (course_id, file_name, file_path, created_at) VALUES (?, ?, ?, ?)";
                    $query = $db->query($sql, [
                        $materialData['course_id'],
                        $materialData['file_name'],
                        $materialData['file_path'],
                        date('Y-m-d H:i:s')
                    ]);
                    
                    if ($query) {
                        $materialId = $db->insertID();
                        log_message('info', 'Materials Controller: Direct database insert successful with ID: ' . $materialId);
                        return redirect()->to('/materials/list/' . $course_id)
                            ->with('success', 'Material "' . $file->getClientName() . '" uploaded successfully!');
                    }
                } catch (\Exception $e) {
                    log_message('error', 'Materials Controller: Direct database insert also failed: ' . $e->getMessage());
                }
                
                // Delete uploaded file if database insert failed
                $filePath = $config['upload_path'] . $file->getName();
                if (file_exists($filePath)) {
                    unlink($filePath);
                    log_message('info', 'Materials Controller: Cleaned up uploaded file after database failure');
                }
                return redirect()->back()->withInput()->with('error', 'Failed to save material information to database. Please try again.');
            }
        } else {
            // Set failure flash message
            return redirect()->back()->withInput()->with('error', 'Failed to upload file: ' . $file->getErrorString());
        }
    }

    /**
     * Handle the deletion of a material record and associated file
     * 
     * @param int $material_id The material ID
     * @return mixed
     */
    public function delete($material_id = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Please login first.');
        }

        $userRole = session()->get('user_role');
        $userId = session()->get('user_id');

        // Validate material_id
        if (!$material_id) {
            return redirect()->back()->with('error', 'Material ID is required.');
        }

        // Get material information
        $material = $this->materialModel->getMaterialById($material_id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Get course information
        $course = $this->courseModel->find($material['course_id']);
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found.');
        }

        // Check permissions - only teachers and admins can delete materials
        if (!in_array($userRole, ['teacher', 'admin'])) {
            return redirect()->back()->with('error', 'You do not have permission to delete materials.');
        }

        // For teachers, check if they own the course
        if ($userRole === 'teacher' && $course['instructor_id'] != $userId) {
            return redirect()->back()->with('error', 'You can only delete materials from your own courses.');
        }

        // Delete the file from filesystem
        $filePath = WRITEPATH . $material['file_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete from database
        if ($this->materialModel->deleteMaterial($material_id)) {
            return redirect()->back()->with('success', 'Material deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete material.');
        }
    }

    /**
     * Handle secure file download for enrolled students
     * 
     * @param int $material_id The material ID
     * @return mixed
     */
    public function download($material_id = null)
    {
        // Load CodeIgniter's download helper
        helper('download');
        
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Please login first.');
        }

        $userRole = session()->get('user_role');
        $userId = session()->get('user_id');

        // Validate material_id
        if (!$material_id || !is_numeric($material_id)) {
            return redirect()->back()->with('error', 'Invalid material ID.');
        }

        // Get material information from database
        $material = $this->materialModel->getMaterialById($material_id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Get course information
        $course = $this->courseModel->find($material['course_id']);
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found.');
        }

        // Check if user is enrolled in the course (for students)
        $canDownload = false;

        if ($userRole === 'admin') {
            $canDownload = true; // Admins can download all materials
        } elseif ($userRole === 'teacher' && $course['instructor_id'] == $userId) {
            $canDownload = true; // Teachers can download materials from their courses
        } elseif ($userRole === 'student') {
            // Students can only download if they are enrolled in the course
            $canDownload = $this->enrollmentModel->isAlreadyEnrolled($userId, $material['course_id']);
        }

        if (!$canDownload) {
            return redirect()->back()->with('error', 'You do not have permission to download this material. Please ensure you are enrolled in this course.');
        }

        // Retrieve the file path from database
        $filePath = WRITEPATH . $material['file_path'];
        
        // Security check: Ensure file path is within allowed directory
        $allowedPath = WRITEPATH . 'uploads/materials/';
        if (!str_starts_with(realpath($filePath), realpath($allowedPath))) {
            log_message('error', 'Security violation: Attempted to download file outside allowed directory. User: ' . $userId . ', File: ' . $filePath);
            return redirect()->back()->with('error', 'Invalid file path.');
        }

        // Check if file exists on server
        if (!file_exists($filePath) || !is_file($filePath)) {
            log_message('error', 'File not found: ' . $filePath . ' for material ID: ' . $material_id);
            return redirect()->back()->with('error', 'File not found on server.');
        }

        // Check file size (prevent download of extremely large files)
        $fileSize = filesize($filePath);
        if ($fileSize > 100 * 1024 * 1024) { // 100MB limit
            return redirect()->back()->with('error', 'File is too large to download.');
        }

        // Log download activity for security/analytics
        log_message('info', 'File download: User ' . $userId . ' (' . $userRole . ') downloaded material ' . $material_id . ' (' . $material['file_name'] . ')');

        // Use CodeIgniter's download helper for secure file download
        try {
            // Set proper headers for secure download
            $this->response->setHeader('Content-Type', 'application/octet-stream');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $material['file_name'] . '"');
            $this->response->setHeader('Content-Length', $fileSize);
            $this->response->setHeader('Cache-Control', 'no-cache, must-revalidate');
            $this->response->setHeader('Pragma', 'no-cache');
            $this->response->setHeader('Expires', '0');

            // Use CodeIgniter's download helper function
            return $this->response->download($filePath, $material['file_name']);
            
        } catch (\Exception $e) {
            log_message('error', 'Download failed: ' . $e->getMessage() . ' for material ID: ' . $material_id);
            return redirect()->back()->with('error', 'Download failed. Please try again.');
        }
    }

    /**
     * List materials for a course
     * 
     * @param int $course_id The course ID
     * @return mixed
     */
    public function list($course_id = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Please login first.');
        }

        $userRole = session()->get('user_role');
        $userId = session()->get('user_id');

        // Validate course_id
        if (!$course_id) {
            return redirect()->back()->with('error', 'Course ID is required.');
        }

        // Get course information
        $course = $this->courseModel->find($course_id);
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found.');
        }

        // Check permissions
        $canView = false;
        $canUpload = false;

        if ($userRole === 'admin') {
            $canView = true;
            $canUpload = true;
        } elseif ($userRole === 'teacher' && $course['instructor_id'] == $userId) {
            $canView = true;
            $canUpload = true;
        } elseif ($userRole === 'student') {
            $canView = $this->enrollmentModel->isAlreadyEnrolled($userId, $course_id);
        }

        if (!$canView) {
            return redirect()->back()->with('error', 'You do not have permission to view materials for this course.');
        }

        // Get materials for the course
        $materials = $this->materialModel->getMaterialsByCourse($course_id);

        $data = [
            'title' => 'Course Materials - ' . $course['title'],
            'course' => $course,
            'materials' => $materials,
            'canUpload' => $canUpload,
            'userRole' => $userRole
        ];

        return view('materials/list', $data);
    }
}
