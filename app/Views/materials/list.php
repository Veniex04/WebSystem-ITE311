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

        .materials-container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .materials-header {
            background: linear-gradient(45deg, var(--inst-1), var(--inst-2), var(--inst-3), var(--inst-4), var(--inst-5));
            color: white;
            padding: 30px;
            text-align: center;
        }

        .materials-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.8rem;
        }

        .materials-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .materials-body {
            padding: 40px;
        }

        .material-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .material-card:hover {
            border-color: var(--inst-3);
            box-shadow: 0 8px 25px rgba(220, 39, 67, 0.1);
            transform: translateY(-2px);
        }

        .material-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-right: 20px;
        }

        .material-icon.pdf { background: linear-gradient(45deg, #ff6b6b, #ee5a52); }
        .material-icon.doc { background: linear-gradient(45deg, #4ecdc4, #44a08d); }
        .material-icon.ppt { background: linear-gradient(45deg, #feca57, #ff9ff3); }
        .material-icon.image { background: linear-gradient(45deg, #48cae4, #023e8a); }
        .material-icon.video { background: linear-gradient(45deg, #ff9a9e, #fecfef); }
        .material-icon.audio { background: linear-gradient(45deg, #a8edea, #fed6e3); }
        .material-icon.archive { background: linear-gradient(45deg, #d299c2, #fef9d7); }
        .material-icon.default { background: linear-gradient(45deg, #667eea, #764ba2); }

        .material-info h5 {
            margin: 0 0 5px 0;
            font-weight: 600;
            color: #333;
        }

        .material-info p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .material-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-download {
            background: linear-gradient(45deg, var(--inst-1), var(--inst-3));
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-download:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 39, 67, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-upload {
            background: #28a745;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-upload:hover {
            background: #218838;
            color: white;
            text-decoration: none;
        }

        .btn-delete {
            background: #dc3545;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }

        .btn-delete:hover {
            background: #c82333;
            color: white;
            text-decoration: none;
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

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #495057;
            margin-bottom: 10px;
        }

        .empty-state p {
            margin-bottom: 30px;
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

        .stats-card {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }

        .stats-card h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .stats-card p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .file-type-badge {
            background: rgba(220, 39, 67, 0.1);
            color: var(--inst-3);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="materials-container">
            <!-- Header -->
            <div class="materials-header">
                <h2><i class="bi bi-folder2-open"></i> Course Materials</h2>
                <p><?= esc($course['title']) ?></p>
            </div>

            <!-- Body -->
            <div class="materials-body">
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

                <!-- Statistics -->
                <?php if (!empty($materials)): ?>
                    <div class="stats-card">
                        <h3><?= count($materials) ?></h3>
                        <p>Material<?= count($materials) !== 1 ? 's' : '' ?> Available</p>
                    </div>
                <?php endif; ?>

                <!-- Materials List -->
                <?php if (!empty($materials)): ?>
                    <div class="row">
                        <?php foreach ($materials as $material): ?>
                            <?php
                            // Determine file type and icon
                            $fileExtension = strtolower(pathinfo($material['file_name'], PATHINFO_EXTENSION));
                            $fileType = 'default';
                            $icon = 'bi-file-earmark';
                            
                            if (in_array($fileExtension, ['pdf'])) {
                                $fileType = 'pdf';
                                $icon = 'bi-file-earmark-pdf';
                            } elseif (in_array($fileExtension, ['doc', 'docx'])) {
                                $fileType = 'doc';
                                $icon = 'bi-file-earmark-word';
                            } elseif (in_array($fileExtension, ['ppt', 'pptx'])) {
                                $fileType = 'ppt';
                                $icon = 'bi-file-earmark-ppt';
                            } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                $fileType = 'image';
                                $icon = 'bi-file-earmark-image';
                            } elseif (in_array($fileExtension, ['mp4', 'avi', 'mov'])) {
                                $fileType = 'video';
                                $icon = 'bi-file-earmark-play';
                            } elseif (in_array($fileExtension, ['mp3', 'wav', 'ogg'])) {
                                $fileType = 'audio';
                                $icon = 'bi-file-earmark-music';
                            } elseif (in_array($fileExtension, ['zip', 'rar', '7z'])) {
                                $fileType = 'archive';
                                $icon = 'bi-file-earmark-zip';
                            }
                            ?>
                            
                            <div class="col-md-6 mb-3">
                                <div class="material-card">
                                    <div class="d-flex align-items-center">
                                        <div class="material-icon <?= $fileType ?>">
                                            <i class="bi <?= $icon ?>"></i>
                                        </div>
                                        
                                        <div class="material-info flex-grow-1">
                                            <h5><?= esc($material['file_name']) ?></h5>
                                            <p>
                                                <span class="file-type-badge"><?= strtoupper($fileExtension) ?></span>
                                                <?php if (isset($material['created_at'])): ?>
                                                    • Uploaded <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        
                                        <div class="material-actions">
                                            <a href="<?= site_url('materials/download/' . $material['id']) ?>" 
                                               class="btn-download"
                                               title="Download <?= esc($material['file_name']) ?>">
                                                <i class="bi bi-download"></i>
                                                Download
                                            </a>
                                            
                                            <?php if ($canUpload && $userRole === 'admin'): ?>
                                                <a href="<?= site_url('materials/delete/' . $material['id']) ?>" 
                                                   class="btn-delete"
                                                   onclick="return confirm('Are you sure you want to delete this material?')"
                                                   title="Delete <?= esc($material['file_name']) ?>">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="bi bi-folder-x"></i>
                        <h4>No Materials Available</h4>
                        <p>There are no materials uploaded for this course yet.</p>
                        <?php if ($canUpload): ?>
                            <a href="<?= site_url('materials/upload/' . $course['id']) ?>" class="btn-upload">
                                <i class="bi bi-plus-circle"></i>
                                Upload First Material
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 mt-4">
                    <a href="<?= site_url('dashboard') ?>" class="btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Back to Dashboard
                    </a>
                    
                    <?php if ($canUpload): ?>
                        <a href="<?= site_url('materials/upload/' . $course['id']) ?>" class="btn-upload">
                            <i class="bi bi-cloud-upload"></i>
                            Upload New Material
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add click tracking for downloads
            document.querySelectorAll('.btn-download').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const fileName = this.getAttribute('title').replace('Download ', '');
                    console.log('Downloading:', fileName);
                    
                    // Optional: Add analytics tracking here
                    // gtag('event', 'download', {
                    //     'file_name': fileName,
                    //     'course_id': '<?= $course['id'] ?>'
                    // });
                });
            });

            // Add confirmation for delete actions
            document.querySelectorAll('.btn-delete').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this material? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>
