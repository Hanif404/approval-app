<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?php echo base_url('asset/templates/adminlte/img/AdminLTELogo.png')?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Approval</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url('asset/templates/adminlte/img/user2-160x160.jpg')?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <?php if ($this->session->userdata('user_id')): ?>
          <a href="#" class="d-block"><?php echo html_escape($this->session->userdata('name')); ?></a>
          <a href="<?php echo site_url('logout'); ?>" class="d-block" style="font-size:12px;">Logout</a>
        <?php else: ?>
          <a href="<?php echo site_url('login'); ?>" class="d-block">Guest - Sign In</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?php echo site_url('forms'); ?>" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>Forms</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo site_url('approvals'); ?>" class="nav-link">
            <i class="nav-icon fas fa-check"></i>
            <p>Approval</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo site_url('approval_flows'); ?>" class="nav-link">
            <i class="nav-icon fas fa-route"></i>
            <p>Approval Flows</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo site_url('roles'); ?>" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Roles</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo site_url('users'); ?>" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Users</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>