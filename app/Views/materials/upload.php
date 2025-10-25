<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> | LMS</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --inst-1: #f09433;
            --inst-2: #e6683c;
            --inst-3: #dc2743;
            --inst-4: #cc2366;
            --inst-5: #bc1888;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .upload-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .upload-header {
            background: linear-gradient(45deg, var(--inst-1), var(--inst-2), var(--inst-3), var(--inst-4), var(--inst-5));
            color: white;
            padding: 30px;
            text-align: center;
        }

        .upload-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.8rem;
        }

        .upload-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .upload-body {
            padding: 40px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--inst-3);
            box-shadow: 0 0 0 0.2rem rgba(220, 39, 67, 0.25);
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            border: 3px dashed #dee2e6;
            border-radius: 12px;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            min-height: 120px;
        }

        .file-input-label:hover {
            border-color: var(--inst-3);
            background: rgba(220, 39, 67, 0.05);
        }

        .file-input-label.dragover {
            border-color: var(--inst-3);
            background: rgba(220, 39, 67, 0.1);
        }

        .file-icon {
            font-size: 2.5rem;
            color: var(--inst-3);
            margin-bottom: 10px;
        }

        .file-text {
            color: #6c757d;
            font-size: 1rem;
            margin: 0;
        }

        .file-name {
            color: var(--inst-3);
            font-weight: 600;
            margin-top: 10px;
        }

        .btn-upload {
            background: linear-gradient(45deg, var(--inst-1), var(--inst-3));
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 39, 67, 0.3);
            color: white;
        }

        .btn-upload:disabled {
            opacity: 0.6;
            transform: none;
            box-shadow: none;
        }

        .btn-back {
            background: #6c757d;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }

        .file-info {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .file-info h6 {
            color: #1976d2;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .file-info ul {
            margin: 0;
            padding-left: 20px;
        }

        .file-info li {
            color: #424242;
            margin-bottom: 5px;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: linear-gradient(45deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(45deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }

        .progress {
            height: 8px;
            border-radius: 4px;
            background: #e9ecef;
            margin-top: 10px;
        }

        .progress-bar {
            background: linear-gradient(45deg, var(--inst-1), var(--inst-3));
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="upload-container">
            <!-- Header -->
            <div class="upload-header">
                <h2><i class="bi bi-cloud-upload"></i> Upload Material</h2>
                <p>Add a new material to "<?= esc($course['title']) ?>"</p>
            </div>

            <!-- Body -->
            <div class="upload-body">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i>
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Upload Form -->
                <form action="<?= site_url('materials/upload/' . $course_id) ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                    <?= csrf_field() ?>
                    
                    <!-- File Input -->
                    <div class="mb-4">
                        <label class="form-label">Select Material File</label>
                        <div class="file-input-wrapper">
                            <input type="file" 
                                   class="form-control file-input" 
                                   id="material_file" 
                                   name="material_file" 
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.gif,.mp4,.mp3,.zip"
                                   required>
                            <label for="material_file" class="file-input-label" id="fileLabel">
                                <div>
                                    <i class="bi bi-cloud-upload file-icon"></i>
                                    <p class="file-text">Click to browse or drag and drop your file here</p>
                                    <p class="file-text small">Maximum file size: 10MB</p>
                                </div>
                            </label>
                        </div>
                        <div id="fileName" class="file-name" style="display: none;"></div>
                        <div class="progress" id="progressBar" style="display: none;">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- File Information -->
                    <div class="file-info">
                        <h6><i class="bi bi-info-circle"></i> Supported File Types</h6>
                        <ul>
                            <li><strong>Documents:</strong> PDF, DOC, DOCX, PPT, PPTX, TXT</li>
                            <li><strong>Images:</strong> JPG, JPEG, PNG, GIF</li>
                            <li><strong>Media:</strong> MP4, MP3</li>
                            <li><strong>Archives:</strong> ZIP</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 mt-4">
                        <a href="<?= site_url('materials/list/' . $course_id) ?>" class="btn-back">
                            <i class="bi bi-arrow-left"></i>
                            Back to Materials
                        </a>
                        <button type="submit" class="btn btn-upload" id="uploadBtn">
                            <i class="bi bi-upload"></i>
                            Upload Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('material_file');
            const fileLabel = document.getElementById('fileLabel');
            const fileName = document.getElementById('fileName');
            const uploadBtn = document.getElementById('uploadBtn');
            const progressBar = document.getElementById('progressBar');
            const progressBarFill = progressBar.querySelector('.progress-bar');

            // File input change handler
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Update file name display
                    fileName.textContent = `Selected: ${file.name} (${formatFileSize(file.size)})`;
                    fileName.style.display = 'block';
                    
                    // Update label
                    fileLabel.innerHTML = `
                        <div>
                            <i class="bi bi-file-earmark-check file-icon" style="color: #28a745;"></i>
                            <p class="file-text">File selected successfully</p>
                            <p class="file-text small">${file.name}</p>
                        </div>
                    `;
                    fileLabel.style.borderColor = '#28a745';
                    fileLabel.style.background = 'rgba(40, 167, 69, 0.1)';
                }
            });

            // Drag and drop functionality
            fileLabel.addEventListener('dragover', function(e) {
                e.preventDefault();
                fileLabel.classList.add('dragover');
            });

            fileLabel.addEventListener('dragleave', function(e) {
                e.preventDefault();
                fileLabel.classList.remove('dragover');
            });

            fileLabel.addEventListener('drop', function(e) {
                e.preventDefault();
                fileLabel.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change'));
                }
            });

            // Form submission handler
            document.getElementById('uploadForm').addEventListener('submit', function(e) {
                const file = fileInput.files[0];
                if (!file) {
                    e.preventDefault();
                    alert('Please select a file to upload.');
                    return;
                }

                // Show progress bar
                progressBar.style.display = 'block';
                uploadBtn.disabled = true;
                uploadBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Uploading...';

                // Simulate progress (in real implementation, you'd use XMLHttpRequest)
                let progress = 0;
                const interval = setInterval(() => {
                    progress += Math.random() * 30;
                    if (progress > 90) progress = 90;
                    progressBarFill.style.width = progress + '%';
                }, 200);

                // Reset after 3 seconds (form will submit normally)
                setTimeout(() => {
                    clearInterval(interval);
                    progressBarFill.style.width = '100%';
                }, 3000);
            });

            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });
    </script>
</body>
</html>
