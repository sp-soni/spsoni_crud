<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">CRUD Generator</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>action/">CRUD</a>
        </li>    
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>action/projects.php">Projects</a>
        </li>    
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>action/db_backup.php">DB Backup</a>
        </li>           
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Project Settings
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>action/projects.php">Manage Project</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>action/project_modules.php">Manage Project Modules</a></li>
          </ul>
        </li> -->
      </ul>
    </div>
  </div>
</nav>