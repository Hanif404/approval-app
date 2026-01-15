<?php
$title = 'Edit User';
$page_title = 'Edit User';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit User: <?php echo htmlspecialchars($user->name); ?></h3>
        <div class="card-tools">
            <a href="<?php echo site_url('users'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php echo form_open('users/edit/' . $user->id); ?>
            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php echo form_error('name') ? 'is-invalid' : ''; ?>" 
                       id="name" name="name" value="<?php echo set_value('name', $user->name); ?>" required>
                <?php echo form_error('name', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control <?php echo form_error('email') ? 'is-invalid' : ''; ?>" 
                       id="email" name="email" value="<?php echo set_value('email', $user->email); ?>" required>
                <?php echo form_error('email', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="password">Password <small class="text-muted">(leave blank to keep current password)</small></label>
                <input type="password" class="form-control <?php echo form_error('password') ? 'is-invalid' : ''; ?>" 
                       id="password" name="password">
                <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="roles">Roles</label>
                <select class="form-control" id="roles" name="roles[]" multiple>
                    <?php 
                    $user_role_ids = array();
                    if (!empty($user->roles)) {
                        foreach ($user->roles as $role) {
                            $user_role_ids[] = $role->id;
                        }
                    }
                    ?>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role->id; ?>" <?php echo in_array($role->id, $user_role_ids) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($role->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple roles</small>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update User
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