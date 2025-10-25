<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'course_id',
        'file_name',
        'file_path',
        'created_at'
    ];

    protected $useTimestamps = false; // Disable automatic timestamps
    protected $dateFormat = 'datetime';

    // Validation rules
    protected $validationRules = [
        'course_id' => 'required|integer|is_natural',
        'file_name' => 'required|max_length[255]',
        'file_path' => 'required|max_length[255]'
    ];

    protected $validationMessages = [
        'course_id' => [
            'required' => 'Course ID is required',
            'integer' => 'Course ID must be an integer',
            'is_natural' => 'Course ID must be a positive number'
        ],
        'file_name' => [
            'required' => 'File name is required',
            'max_length' => 'File name cannot exceed 255 characters'
        ],
        'file_path' => [
            'required' => 'File path is required',
            'max_length' => 'File path cannot exceed 255 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Insert a new material record
     * 
     * @param array $data Material data (course_id, file_name, file_path)
     * @return int|false Returns the inserted ID on success, false on failure
     */
    public function insertMaterial($data)
    {
        // Validate required fields
        if (!isset($data['course_id']) || !isset($data['file_name']) || !isset($data['file_path'])) {
            log_message('error', 'MaterialModel: Missing required fields in insertMaterial');
            return false;
        }

        // Prepare data for insertion
        $insertData = [
            'course_id' => (int) $data['course_id'],
            'file_name' => $data['file_name'],
            'file_path' => $data['file_path'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Skip validation completely for this insert
        $this->skipValidation = true;

        try {
            // Insert the record
            $result = $this->insert($insertData);
            
            if ($result) {
                $insertId = $this->getInsertID();
                log_message('info', 'MaterialModel: Successfully inserted material with ID: ' . $insertId);
                return $insertId;
            } else {
                log_message('error', 'MaterialModel: Failed to insert material. Errors: ' . json_encode($this->errors()));
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'MaterialModel: Exception during insert: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all materials for a specific course
     * 
     * @param int $course_id The course ID
     * @return array Array of materials for the course
     */
    public function getMaterialsByCourse($course_id)
    {
        return $this->where('course_id', $course_id)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get material by ID
     * 
     * @param int $id Material ID
     * @return array|null Material data or null if not found
     */
    public function getMaterialById($id)
    {
        return $this->find($id);
    }

    /**
     * Delete material by ID
     * 
     * @param int $id Material ID
     * @return bool True on success, false on failure
     */
    public function deleteMaterial($id)
    {
        return $this->delete($id);
    }

    /**
     * Get materials count for a course
     * 
     * @param int $course_id The course ID
     * @return int Number of materials for the course
     */
    public function getMaterialsCountByCourse($course_id)
    {
        return $this->where('course_id', $course_id)->countAllResults();
    }

    /**
     * Check if material exists for a course
     * 
     * @param int $course_id The course ID
     * @param string $file_name The file name
     * @return bool True if material exists, false otherwise
     */
    public function materialExists($course_id, $file_name)
    {
        return $this->where('course_id', $course_id)
                    ->where('file_name', $file_name)
                    ->countAllResults() > 0;
    }
}
