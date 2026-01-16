<?php
$title = 'Edit Approval Flow';
$page_title = 'Edit Approval Flow';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Approval Flow</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('approval_flows'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php echo form_open('approval_flows/edit/' . $flow->id); ?>
            <div class="form-group">
                <label for="form_type">Form Type</label>
                <input type="text" class="form-control <?php echo form_error('form_type') ? 'is-invalid' : ''; ?>" 
                       id="form_type" name="form_type" 
                       value="<?php echo set_value('form_type', $flow->form_type); ?>" 
                       placeholder="e.g., general, invoice, reimbursement">
                <?php if (form_error('form_type')): ?>
                    <div class="invalid-feedback"><?php echo form_error('form_type'); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="role_id">Role</label>
                <select class="form-control <?php echo form_error('role_id') ? 'is-invalid' : ''; ?>" 
                        id="role_id" name="role_id">
                    <option value="">Select Role</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role->id; ?>" 
                                <?php echo set_select('role_id', $role->id, ($role->id == $flow->role_id)); ?>>
                            <?php echo htmlspecialchars($role->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (form_error('role_id')): ?>
                    <div class="invalid-feedback"><?php echo form_error('role_id'); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="step_order">Step Order</label>
                <input type="number" class="form-control <?php echo form_error('step_order') ? 'is-invalid' : ''; ?>" 
                       id="step_order" name="step_order" 
                       value="<?php echo set_value('step_order', $flow->step_order); ?>" 
                       min="1" placeholder="1">
                <?php if (form_error('step_order')): ?>
                    <div class="invalid-feedback"><?php echo form_error('step_order'); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Flow
                </button>
                <a href="<?php echo site_url('approval_flows'); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?php
$content = ob_get_clean();
$this->load->view('templates/layout', compact('title', 'page_title', 'content'));
?>