<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <title>Instagram-Themed LMS</title>
  <style>
    body {
      background-color: #f8f9fa;
    }

    .navbar {
      background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
    }

    .navbar-brand,
    .nav-link,
    .dropdown-item {
      color: white !important;
    }

    .nav-link:hover,
    .dropdown-item:hover {
      color: #ffd1dc !important;
    }

    .dropdown-menu {
      background-color: #cc2366;
      border: none;
    }

    .navbar-toggler {
      background-color: white;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 1.6rem;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .bi {
      vertical-align: -0.125em;
      margin-right: 5px;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg shadow">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="bi bi-mortarboard-fill"></i>LMS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon text-light"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-house-door-fill"></i>Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-book-fill"></i>Courses</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-pencil-square"></i>Assignments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-graph-up"></i>Grade</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle"></i>Profile
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Settings</a></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-question-circle-fill"></i> Help</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
