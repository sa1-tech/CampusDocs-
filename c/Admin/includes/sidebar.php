<aside class="main-sidebar sidebar-dark-primary elevation-8">
  <!-- Brand Logo -->
  <a href="../dashboard.php" >
  <img src="includes/l.png" alt="Site Logo" 
  style="max-width: 100%; height: auto; width: 250px; display: block; margin: 0 auto; object-fit: contain;">
<!--     <span class="brand-text font-weight-bold d-block mt-1" style="font-size: 18px;">CampusDocs 📚</span> -->
</a>


  <!-- Sidebar -->
  <div class="sidebar">
    <!-- User Panel -->
    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="info">
        <a href="#" class="d-block"><b><?php echo $_SESSION['admin_name']; ?></b></a>
      </div>
    </div> -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="info">
        <a href="#" class="d-block"><b><h5>CampusDocs📚</h5></b></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <li class="nav-item">
          <a href="homepage.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="users.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Registered Users</p>
          </a>
        </li>

        <li class="nav-header">Academic Content</li>

        <li class="nav-item">
          <a href="courses.php" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Courses</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="semesters.php" class="nav-link">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>Semesters</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="subjects.php" class="nav-link">
            <i class="nav-icon fas fa-book-open"></i>
            <p>Subjects</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="manage_units.php" class="nav-link">
            <i class="nav-icon fas fa-file-pdf"></i>
            <p>Units / Chapters</p>
          </a>
        </li>

        <!-- <li class="nav-header">Site Configuration</li>

        <li class="nav-item">
          <a href="settings.php" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Site Settings</p>
          </a>
        </li> -->

       
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
