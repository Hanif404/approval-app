<?php
$title = 'Edit Role';
$page_title = 'Edit Role';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Role: <?php echo htmlspecialchars($role->name); ?></h3>
        <div class="card-tools">
            <a href="<?php echo site_url('roles'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php echo form_open('roles/edit/' . $role->id); ?>
            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php echo form_error('name') ? 'is-invalid' : ''; ?>" 
                       id="name" name="name" value="<?php echo set_value('name', $role->name); ?>" required>
                <?php echo form_error('name', '<div class="text-danger">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control <?php echo form_error('description') ? 'is-invalid' : ''; ?>" 
                          id="description" name="description" rows="3"><?php echo set_value('description', $role->description); ?></textarea>
                <?php echo form_error('description', '<div class="text-danger">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Role
                </button>
                <a href="<?php echo site_url('roles'); ?>" class="btn btn-secondary">
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
