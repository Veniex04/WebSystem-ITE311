<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        /* Navbar with Instagram gradient */
        .topbar {
            background: linear-gradient(45deg, var(--inst-1), var(--inst-2), var(--inst-3), var(--inst-4), var(--inst-5));
            color: #fff;
            padding: 10px 0;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            margin-bottom: 24px;
        }

        .topbar .brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #fff;
            text-decoration: none;
        }

        .content-wrapper {
            max-width: 1100px;
            margin: 0 auto;
            padding: 22px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        }

        .welcome-row {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 16px;
            flex-wrap:wrap;
        }

        .welcome {
            display:flex;
            align-items: center;
            gap: 14px;
        }

        .avatar {
            width:64px;
            height:64px;
            border-radius:12px;
            background: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,255,255,0.1));
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:1.5rem;
            color:#fff;
        }

        .role-badge {
            border-radius: 999px;
            padding: 6px 12px;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .role-admin { background: #9b1b6f; }
        .role-teacher { background: #cc5a3c; }
        .role-student { background: #3b82f6; }

        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            transition: transform .18s ease;
        }
        .stat-card:hover { transform: translateY(-6px); }

        .stat-icon {
            font-size: 1.6rem;
            color: var(--inst-3);
        }

        .course-card {
            border: 1px solid #eef2f7;
            border-radius: 12px;
            transition: all .2s ease;
            background: #fff;
        }
        .course-card:hover{
            border-color: var(--inst-3);
            box-shadow: 0 6px 18px rgba(220,39,67,0.06);
            transform: translateY(-3px);
        }

        .btn-enroll {
            background: linear-gradient(45deg, var(--inst-1), var(--inst-3));
            border: none;
            color: white;
            font-weight: 600;
        }

        .empty-state { text-align:center; padding:2.5rem 1rem; color:#6c757d; }

        .alert {
            border-radius: 10px;
        }

        /* Responsive tweaks */
        @media (max-width: 767px) {
            .welcome { flex-direction:column; align-items:flex-start; gap:8px; }
            .avatar { width:56px; height:56px; }
        }
    </style>
</head>
<body>

<!-- Topbar -->
<nav class="topbar">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="<?= site_url() ?>" class="brand">LMS</a>
        <div class="d-flex align-items-center gap-3">
            <a href="<?= site_url('profile') ?>" class="text-white text-decoration-none"><i class="bi bi-person-circle"></i> Profile</a>
            <a href="<?= site_url('logout') ?>" class="text-white text-decoration-none"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="content-wrapper">

        <!-- Flash messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Welcome -->
        <div class="welcome-row mb-4">
            <div class="welcome">
                <div class="avatar" style="background: linear-gradient(135deg,var(--inst-4),var(--inst-5));">
                    <i class="bi bi-laptop"></i>
                </div>
                <div>
                    <h3 class="mb-0 fw-bold">Welcome, <?= esc($user_name ?? session('name') ?? 'User') ?> 🎉</h3>
                    <?php
                        $displayRole = $user_role ?? session('user_role') ?? 'student';
                        $roleClass = $displayRole === 'admin' ? 'role-admin' : ($displayRole === 'teacher' ? 'role-teacher' : 'role-student');
                    ?>
                    <p class="mb-0 text-muted">Role: <span class="role-badge <?= $roleClass ?>"><?= ucfirst(esc($displayRole)) ?></span></p>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="<?= site_url('profile') ?>" class="btn btn-outline-primary">Profile</a>
                <a href="<?= site_url('settings') ?>" class="btn btn-outline-secondary">Settings</a>
            </div>
        </div>

        <!-- Role-specific quick stats -->
        <div class="row">
            <?php if ($displayRole === 'admin'): ?>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card p-3 text-center">
                        <div class="stat-icon mb-1"><i class="bi bi-people-fill"></i></div>
                        <small class="text-muted">Total Users</small>
                        <div class="h4 fw-bold mb-0"><?= esc($stats['total_users'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card p-3 text-center">
                        <div class="stat-icon mb-1"><i class="bi bi-book-half"></i></div>
                        <small class="text-muted">Total Courses</small>
                        <div class="h4 fw-bold mb-0"><?= esc($stats['total_courses'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card p-3 text-center">
                        <div class="stat-icon mb-1"><i class="bi bi-mortarboard-fill"></i></div>
                        <small class="text-muted">Active Students</small>
                        <div class="h4 fw-bold mb-0"><?= esc($stats['active_students'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card p-3 text-center">
                        <div class="stat-icon mb-1"><i class="bi bi-person-badge-fill"></i></div>
                        <small class="text-muted">Active Teachers</small>
                        <div class="h4 fw-bold mb-0"><?= esc($stats['active_teachers'] ?? 0) ?></div>
                    </div>
                </div>

            <?php elseif ($displayRole === 'teacher'): ?>
                <div class="col-md-4 mb-3">
                    <div class="card stat-card p-3 text-center">
                        <div class="stat-icon mb-1"><i class="bi bi-journal-bookmark-fill"></i></div>
                        <small class="text-muted">My Courses</small>
                        <div class="h4 fw-bold mb-0"><?= esc($stats['my_courses'] ?? 0) ?></div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-md-6 mb-3">
                    <div class="card stat-card p-3 text-center">
                        <div class="stat-icon mb-1"><i class="bi bi-journal-bookmark"></i></div>
                        <small class="text-muted">My Enrolled Courses</small>
                        <div class="h4 fw-bold mb-0"><?= esc($stats['my_courses'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card stat-card p-3 text-center">
                        <div class="stat-icon mb-1"><i class="bi bi-clock-history"></i></div>
                        <small class="text-muted">Upcoming Deadlines</small>
                        <div class="h4 fw-bold mb-0"><?= esc(isset($deadlines) ? count($deadlines) : 0) ?></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Main panels -->
        <div class="row mt-4">
            <?php if ($displayRole === 'admin'): ?>
                <!-- Admin Course Management -->
                <div class="col-12 mb-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0"><i class="bi bi-folder2-open"></i> Course Materials Management</h5>
                            <a href="<?= site_url('admin/course-management') ?>" class="btn btn-gradient">
                                <i class="bi bi-gear"></i> Manage Course Materials
                            </a>
                        </div>
                        <p class="text-muted mb-3">Upload and manage course materials for all courses. Students can view and download materials from their enrolled courses.</p>
                        
                        <?php if (!empty($courses)): ?>
                            <div class="row">
                                <?php foreach (array_slice($courses, 0, 3) as $course): ?>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded">
                                            <div>
                                                <div class="fw-semibold"><?= esc($course['title']) ?></div>
                                                <small class="text-muted">
                                                    <?php 
                                                    $materialsCount = 0;
                                                    if (isset($course['materials_count'])) {
                                                        $materialsCount = $course['materials_count'];
                                                    }
                                                    echo $materialsCount . ' materials';
                                                    ?>
                                                </small>
                                            </div>
                                            <a href="<?= site_url('materials/upload/' . $course['id']) ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-upload"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-3">
                                <i class="bi bi-folder-x text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2">No courses available</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Admin System Overview -->
                <div class="col-12 mb-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="mb-0">System Overview</h5>
                            <small class="text-muted">Manage users and courses</small>
                        </div>

                        <?php if (!empty($users)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Current Role</th>
                                            <th>Change Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $u): ?>
                                            <tr>
                                                <td><?= esc($u['name']) ?></td>
                                                <td><?= esc($u['email']) ?></td>
                                                <td><strong><?= ucfirst(esc($u['role'])) ?></strong></td>
                                                <td>
                                                    <?php if (session()->get('user_id') != $u['id']): ?>
                                                        <select class="form-select form-select-sm role-select" data-user-id="<?= $u['id'] ?>">
                                                            <option value="teacher" <?= $u['role'] === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                                            <option value="student" <?= $u['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                                                        </select>
                                                    <?php else: ?>
                                                        <em class="text-muted">You</em>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">No users found.</p>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ($displayRole === 'teacher'): ?>
                <!-- Teacher: Courses & Students -->
                <div class="col-12 mb-3">
                    <div class="card p-3">
                        <h5 class="mb-2">My Courses & Enrolled Students</h5>
                        <?php if (!empty($courses)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Course Name</th>
                                            <th>Students Enrolled</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $db = \Config\Database::connect();
                                            foreach ($courses as $index => $c): 
                                                $courseId = $c['id'];
                                                $students = $db->table('enrollments')
                                                    ->select('users.name, users.email')
                                                    ->join('users', 'users.id = enrollments.user_id')
                                                    ->where('enrollments.course_id', $courseId)
                                                    ->get()->getResultArray();
                                        ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= esc($c['name'] ?? $c['title'] ?? 'Unnamed Course') ?></td>
                                                <td><?= count($students) ?></td>
                                                <td>
                                                    <?php if (count($students) > 0): ?>
                                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="collapse" data-bs-target="#students-<?= $courseId ?>">View Students</button>
                                                    <?php else: ?>
                                                        <span class="text-muted">No Enrolled Students</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                            <?php if (count($students) > 0): ?>
                                                <tr id="students-<?= $courseId ?>" class="collapse bg-light">
                                                    <td colspan="4">
                                                        <ul class="mb-0">
                                                            <?php foreach ($students as $s): ?>
                                                                <li><?= esc($s['name']) ?> (<?= esc($s['email']) ?>)</li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">No courses found.</p>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else: ?>
                <!-- Student: Enrolled Courses & Available Courses -->
                <div class="col-lg-6 mb-3">
                    <div class="card p-3 h-100">
                        <h5 class="mb-2">My Enrolled Courses</h5>
                        <ul class="list-group list-group-flush" id="enrolledCoursesList">
                            <?php if (!empty($enrolledCourses)): ?>
                                <?php foreach ($enrolledCourses as $course): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold"><?= esc($course['title'] ?? $course['name'] ?? 'Unknown Course') ?></div>
                                            <small class="text-muted">
                                                Enrolled <?= isset($course['enrolled_at']) ? date('M d, Y', strtotime($course['enrolled_at'])) : '' ?>
                                                <?php if (isset($course['materials_count'])): ?>
                                                    • <?= $course['materials_count'] ?> material<?= $course['materials_count'] !== 1 ? 's' : '' ?>
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="<?= site_url('materials/list/' . $course['id']) ?>" 
                                               class="btn btn-sm btn-outline-primary"
                                               title="View Materials">
                                                <i class="bi bi-folder2-open"></i>
                                                Materials
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item text-muted no-enrollment-msg">You are not enrolled in any course yet.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="card p-3 h-100">
                        <h5 class="mb-2">Available Courses</h5>
                        <div id="availableCoursesContainer">
                            <?php if (!empty($courses)): ?>
                                <div class="row">
                                    <?php foreach ($courses as $course): ?>
                                        <div class="col-md-12 mb-2">
                                            <div class="course-card p-3 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="course-title fw-semibold"><?= esc($course['title'] ?? $course['name'] ?? 'Unknown Course') ?></div>
                                                    <div class="text-muted small"><?= esc($course['description'] ?? '') ?></div>
                                                </div>
                                                <div>
                                                    <button class="btn btn-enroll enroll-btn" data-course-id="<?= esc($course['id']) ?>" id="enroll-btn-<?= esc($course['id']) ?>">
                                                        <i class="bi bi-plus-circle"></i> Enroll
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="empty-state">
                                    <i class="bi bi-check-circle" style="font-size:2.2rem;"></i>
                                    <h5 class="mt-2">No available courses</h5>
                                    <p class="mb-0">Please check back later.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div id="alertBox" class="alert mt-3 d-none"></div>

                <div class="col-12">
                    <div class="alert alert-info mt-2">
                        Welcome to your student dashboard! Use the navigation above to explore your courses and deadlines.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1200;"></div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function(){
    // Enroll AJAX (jQuery)
    $(document).on('click', '.enroll-btn', function(e){
        e.preventDefault();
        const $btn = $(this);
        const courseId = $btn.data('course-id');
        if (!courseId) return;

        const original = $btn.html();
        $btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Enrolling...');

        $.ajax({
            url: "<?= base_url('course/enroll') ?>",
            method: "POST",
            data: {
                course_id: courseId,
                <?= csrf_token() ?>: "<?= csrf_hash() ?>"
            },
            dataType: "json"
        }).done(function(res){
            if (res.status === 'success' || res.status === true) {
                showBootstrapAlert('success', 'Success!', res.message || 'Enrolled successfully.');
                // disable/hide button
                $btn.hide();
                // update enrolled list UI
                $('#enrolledCoursesList').find('.no-enrollment-msg').remove();
                $('#enrolledCoursesList').append('<li class="list-group-item d-flex justify-content-between align-items-center">' + escapeHtml(res.course_title || 'New Course') + '<small class="text-muted">' + (res.enrollment_date ? res.enrollment_date : '') + '</small></li>');
            } else {
                showBootstrapAlert('danger', 'Error', res.message || 'Failed to enroll.');
                $btn.prop('disabled', false).html(original);
            }
        }).fail(function(){
            showBootstrapAlert('danger', 'Error', 'Server error. Please try again.');
            $btn.prop('disabled', false).html(original);
        });
    });

    // Role change (Admin)
    $(document).on('change', '.role-select', function(){
        const $sel = $(this);
        const userId = $sel.data('user-id');
        const newRole = $sel.val();
        const $row = $sel.closest('tr');

        $.ajax({
            url: "<?= base_url('dashboard') ?>",
            method: "POST",
            data: {
                id: userId,
                role: newRole,
                <?= csrf_token() ?>: "<?= csrf_hash() ?>"
            },
            dataType: "json"
        }).done(function(res){
            if (res.status === 'success' || res.status === true) {
                $row.find('td:nth-child(3)').html('<strong>' + capitalize(newRole) + '</strong>');
                showBootstrapAlert('success', 'Updated', 'Role updated successfully.');
            } else {
                showBootstrapAlert('danger', 'Error', res.message || 'Failed to update role.');
            }
        }).fail(function(){
            showBootstrapAlert('danger', 'Error', 'Server error. Please try again.');
        });
    });
});

// Utility: show bootstrap alert inside content wrapper
function showBootstrapAlert(type, title, message){
    const id = 'alert-' + Date.now();
    const html = `<div class="alert alert-${type} alert-dismissible fade show" id="${id}" role="alert">
        <strong>${title}</strong> ${escapeHtml(message)}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
    $('.content-wrapper').prepend(html);
    setTimeout(function(){ $('#' + id).alert('close'); }, 4500);
}

// escape html
function escapeHtml(text){
    if (!text) return '';
    return $('<div/>').text(text).html();
}

function capitalize(s){ return s.charAt(0).toUpperCase() + s.slice(1); }
</script>

</body>
</html>
