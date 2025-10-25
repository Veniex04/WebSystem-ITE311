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

        .management-container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .management-header {
            background: linear-gradient(45deg, var(--inst-1), var(--inst-2), var(--inst-3), var(--inst-4), var(--inst-5));
            color: white;
            padding: 30px;
            text-align: center;
        }

        .management-header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 2.2rem;
        }

        .management-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .management-body {
            padding: 40px;
        }

        .course-card {
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .course-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
            background: var(--course-color, #667eea);
        }

        .course-card:hover {
            border-color: var(--inst-3);
            box-shadow: 0 12px 30px rgba(220, 39, 67, 0.15);
            transform: translateY(-3px);
        }

        .course-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .course-info {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        .course-stats {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .stat-item i {
            color: var(--inst-3);
        }

        .course-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-view {
            background: linear-gradient(45deg, #4f46e5, #7c3aed);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-upload {
            background: linear-gradient(45deg, #10b981, #059669);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-back {
            background: #6c757d;
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 5rem;
            color: #dee2e6;
            margin-bottom: 25px;
        }

        .empty-state h3 {
            color: #495057;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .empty-state p {
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        .alert-success {
            background: linear-gradient(45deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(45deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin: 0;
        }

        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
        }

        .course-color-1 { --course-color: #4f46e5; }
        .course-color-2 { --course-color: #10b981; }
        .course-color-3 { --course-color: #f59e0b; }
        .course-color-4 { --course-color: #8b5cf6; }
        .course-color-5 { --course-color: #ef4444; }
        .course-color-6 { --course-color: #06b6d4; }

        @media (max-width: 768px) {
            .course-grid {
                grid-template-columns: 1fr;
            }
            
            .header-actions {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .course-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="management-container">
            <!-- Header -->
            <div class="management-header">
                <h1><i class="bi bi-folder2-open"></i> Course Materials Management</h1>
                <p>Manage course materials and upload files for students</p>
            </div>

            <!-- Body -->
            <div class="management-body">
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

                <!-- Header Actions -->
                <div class="header-actions">
                    <h2 class="page-title">Available Courses</h2>
                    <a href="<?= site_url('dashboard') ?>" class="btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Back to Dashboard
                    </a>
                </div>

                <!-- Courses Grid -->
                <?php if (!empty($courses)): ?>
                    <div class="course-grid">
                        <?php 
                        $colorIndex = 1;
                        foreach ($courses as $course): 
                            $colorClass = 'course-color-' . $colorIndex;
                            $colorIndex = ($colorIndex > 6) ? 1 : $colorIndex + 1;
                        ?>
                            <div class="course-card <?= $colorClass ?>">
                                <div class="course-title">
                                    <?= esc($course['title']) ?>
                                </div>
                                
                                <div class="course-info">
                                    <div><strong>Instructor:</strong> <?= esc($course['instructor_name'] ?? 'Not Assigned') ?></div>
                                    <div><strong>Course ID:</strong> <?= esc($course['id']) ?></div>
                                    <?php if (!empty($course['description'])): ?>
                                        <div class="mt-2"><?= esc($course['description']) ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="course-stats">
                                    <div class="stat-item">
                                        <i class="bi bi-file-earmark-text"></i>
                                        <span><?= esc($course['materials_count'] ?? 0) ?> Materials</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="bi bi-calendar3"></i>
                                        <span>Created <?= date('M d, Y', strtotime($course['created_at'])) ?></span>
                                    </div>
                                </div>

                                <div class="course-actions">
                                    <a href="<?= site_url('materials/list/' . $course['id']) ?>" 
                                       class="btn-view"
                                       title="View all materials for <?= esc($course['title']) ?>">
                                        <i class="bi bi-eye"></i>
                                        View Materials
                                    </a>
                                    
                                    <a href="<?= site_url('materials/upload/' . $course['id']) ?>" 
                                       class="btn-upload"
                                       title="Upload new material to <?= esc($course['title']) ?>">
                                        <i class="bi bi-upload"></i>
                                        Upload
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="bi bi-folder-x"></i>
                        <h3>No Courses Available</h3>
                        <p>There are no courses in the system yet. Please create courses first before managing materials.</p>
                        <a href="<?= site_url('dashboard') ?>" class="btn-back">
                            <i class="bi bi-arrow-left"></i>
                            Back to Dashboard
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add click tracking for analytics
            document.querySelectorAll('.btn-view, .btn-upload').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const action = this.classList.contains('btn-view') ? 'view_materials' : 'upload_materials';
                    const courseTitle = this.getAttribute('title');
                    
                    console.log('Admin action:', action, 'for course:', courseTitle);
                    
                    // Optional: Add analytics tracking here
                    // gtag('event', action, {
                    //     'course_title': courseTitle,
                    //     'admin_user': '<?= $user_name ?>'
                    // });
                });
            });

            // Add hover effects for course cards
            document.querySelectorAll('.course-card').forEach(function(card) {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
