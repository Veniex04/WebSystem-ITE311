<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= esc($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --inst-1: #f09433;
            --inst-2: #e6683c;
            --inst-3: #dc2743;
            --inst-4: #cc2366;
            --inst-5: #bc1888;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f6f9;
            margin-bottom: 60px;
        }

        .topbar {
            background: linear-gradient(45deg, var(--inst-1), var(--inst-2), var(--inst-3), var(--inst-4), var(--inst-5));
            color: #fff;
            padding: 10px 0;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            margin-bottom: 24px;
        }

        .content-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            padding: 22px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        }

        .material-card {
            border: 1px solid #eef2f7;
            border-radius: 12px;
            transition: all 0.2s ease;
            background: #fff;
        }

        .material-card:hover {
            border-color: var(--inst-3);
            box-shadow: 0 6px 18px rgba(220,39,67,0.06);
            transform: translateY(-2px);
        }

        .file-icon {
            font-size: 2rem;
            color: var(--inst-3);
        }

        .btn-download {
            background: linear-gradient(45deg, var(--inst-1), var(--inst-3));
            border: none;
            color: white;
            font-weight: 600;
        }

        .btn-download:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220,39,67,0.3);
        }

        .btn-delete {
            background: #dc3545;
            border: none;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        .course-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>

<!-- Topbar -->
<nav class="topbar">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="<?= site_url('dashboard') ?>" class="text-white text-decoration-none fw-bold">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        <div class="d-flex align-items-center gap-3">
            <a href="<?= site_url('dashboard') ?>" class="text-white text-decoration-none">
                <i class="bi bi-house"></i> Dashboard
            </a>
            <a href="<?= site_url('logout') ?>" class="text-white text-decoration-none">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="content-wrapper">
        <!-- Flash messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Course Header -->
        <div class="course-header">
            <h2 class="mb-2">
                <i class="bi bi-book"></i> <?= esc($course['title']) ?>
            </h2>
            <p class="text-muted mb-3"><?= esc($course['description']) ?></p>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-primary">
                    <i class="bi bi-file-earmark-text"></i> <?= count($materials) ?> Materials
                </span>
                <?php if (in_array($user_role, ['teacher', 'admin'])): ?>
                    <a href="<?= site_url('admin/course/' . $course['id'] . '/upload') ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Upload Material
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Materials List -->
        <?php if (!empty($materials)): ?>
            <div class="row">
                <?php foreach ($materials as $material): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="material-card p-3 h-100">
                            <div class="d-flex align-items-start mb-3">
                                <div class="file-icon me-3">
                                    <?php
                                    $fileExtension = strtolower(pathinfo($material['file_name'], PATHINFO_EXTENSION));
                                    switch ($fileExtension) {
                                        case 'pdf':
                                            echo '<i class="bi bi-file-earmark-pdf"></i>';
                                            break;
                                        case 'doc':
                                        case 'docx':
                                            echo '<i class="bi bi-file-earmark-word"></i>';
                                            break;
                                        case 'ppt':
                                        case 'pptx':
                                            echo '<i class="bi bi-file-earmark-ppt"></i>';
                                            break;
                                        case 'txt':
                                            echo '<i class="bi bi-file-earmark-text"></i>';
                                            break;
                                        case 'zip':
                                            echo '<i class="bi bi-file-earmark-zip"></i>';
                                            break;
                                        case 'jpg':
                                        case 'jpeg':
                                        case 'png':
                                            echo '<i class="bi bi-file-earmark-image"></i>';
                                            break;
                                        default:
                                            echo '<i class="bi bi-file-earmark"></i>';
                                    }
                                    ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold"><?= esc($material['file_name']) ?></h6>
                                    <small class="text-muted">
                                        <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                    </small>
                                </div>
                            </div>

                            <?php if (!empty($material['description'])): ?>
                                <p class="text-muted small mb-3"><?= esc($material['description']) ?></p>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <?= isset($material['file_size']) ? formatFileSize($material['file_size']) : 'Unknown size' ?>
                                </small>
                                <div class="btn-group">
                                    <a href="<?= site_url('materials/download/' . $material['id']) ?>" 
                                       class="btn btn-sm btn-download">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                    <?php if (in_array($user_role, ['teacher', 'admin'])): ?>
                                        <a href="<?= site_url('materials/delete/' . $material['id']) ?>" 
                                           class="btn btn-sm btn-delete"
                                           onclick="return confirm('Are you sure you want to delete this material?')">
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
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-text" style="font-size: 4rem; color: #dee2e6;"></i>
                <h5 class="mt-3 text-muted">No Materials Available</h5>
                <p class="text-muted">This course doesn't have any materials yet.</p>
                <?php if (in_array($user_role, ['teacher', 'admin'])): ?>
                    <a href="<?= site_url('admin/course/' . $course['id'] . '/upload') ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Upload First Material
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
function formatFileSize($bytes) {
    if ($bytes === 0) return '0 Bytes';
    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}
?>
