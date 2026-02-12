<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css'); ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo site_url(); ?>"><b>Approval</b>App</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <?php echo form_open('login'); ?>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email'); ?>">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>
        <?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>

        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
              <i class="fas fa-eye" id="password-icon"></i>
            </button>
          </div>
        </div>
        <?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>

        <div class="row">
          <div class="col-8">
            <p class="mb-0">
              <a href="<?php echo site_url('forgot-password'); ?>">Forgot password?</a>
            </p>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      <?php echo form_close(); ?>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js'); ?>"></script>
<script>
function togglePassword(id) {
  const input = document.getElementById(id);
  const icon = document.getElementById(id + '-icon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}
</script>
</body>
</html>
