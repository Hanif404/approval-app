<?php
$title = 'Create User';
$page_title = 'Create New User';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create New User</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('users'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php echo form_open('users/create'); ?>
            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php echo form_error('name') ? 'is-invalid' : ''; ?>" 
                       id="name" name="name" value="<?php echo set_value('name'); ?>" required>
                <?php echo form_error('name', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control <?php echo form_error('email') ? 'is-invalid' : ''; ?>" 
                       id="email" name="email" value="<?php echo set_value('email'); ?>" required>
                <?php echo form_error('email', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control <?php echo form_error('password') ? 'is-invalid' : ''; ?>" 
                           id="password" name="password" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>
                <?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control <?php echo form_error('confirm_password') ? 'is-invalid' : ''; ?>" 
                           id="confirm_password" name="confirm_password" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password')">
                            <i class="fas fa-eye" id="confirm_password-icon"></i>
                        </button>
                    </div>
                </div>
                <?php echo form_error('confirm_password', '<div class="text-danger">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="roles">Roles</label>
                <select class="form-control" id="roles" name="roles[]" multiple>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role->id; ?>" <?php echo in_array($role->id, set_value('roles', array())) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($role->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple roles</small>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create User
                </button>
                <a href="<?php echo site_url('users'); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?php
$content = ob_get_clean();
$this->load->view('templates/layout', compact('title', 'page_title', 'content'));
?>
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