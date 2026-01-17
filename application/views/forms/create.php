<?php
$title = 'Create Form';
$page_title = 'Create New Form';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create New Form</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('forms'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php echo form_open('forms/create'); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php echo form_error('title') ? 'is-invalid' : ''; ?>" 
                               id="title" name="title" value="<?php echo set_value('title'); ?>" required>
                        <?php echo form_error('title', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="submission_date">Submission Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control <?php echo form_error('submission_date') ? 'is-invalid' : ''; ?>" 
                               id="submission_date" name="submission_date" value="<?php echo set_value('submission_date'); ?>" required>
                        <?php echo form_error('submission_date', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo set_value('description'); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="applicant_name">Applicant Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php echo form_error('applicant_name') ? 'is-invalid' : ''; ?>" 
                               id="applicant_name" name="applicant_name" value="<?php echo set_value('applicant_name'); ?>" required>
                        <?php echo form_error('applicant_name', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cao_number">CAO Number</label>
                        <input type="text" class="form-control" id="cao_number" name="cao_number" value="<?php echo set_value('cao_number'); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="project_name">Project Name</label>
                <input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo set_value('project_name'); ?>">
            </div>

            <hr>
            <h5>Payment Information</h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="payment_receiver_name">Payment Receiver Name</label>
                        <input type="text" class="form-control" id="payment_receiver_name" name="payment_receiver_name" value="<?php echo set_value('payment_receiver_name'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bank_account_number">Bank Account Number</label>
                        <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" value="<?php echo set_value('bank_account_number'); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo set_value('bank_name'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="transaction_type">Transaction Type</label>
                        <input type="text" class="form-control" id="transaction_type" name="transaction_type" value="<?php echo set_value('transaction_type'); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Form
                </button>
                <a href="<?php echo site_url('forms'); ?>" class="btn btn-secondary">
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