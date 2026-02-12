<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Forgot Password</title>
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
      <p class="login-box-msg">Enter your email to reset password</p>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
      <?php endif; ?>

      <?php echo form_open('forgot-password'); ?>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email'); ?>">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>
        <?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>

        <div class="row">
          <div class="col-7">
            <a href="<?php echo site_url('login'); ?>" class="text-center">Back to Login</a>
          </div>
          <div class="col-5">
            <button type="submit" class="btn btn-primary btn-block">Reset</button>
          </div>
        </div>
      <?php echo form_close(); ?>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js'); ?>"></script>
</body>
</html>
