<?php
$title = 'Edit Form';
$page_title = 'Edit Form';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Form</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('forms'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php echo form_open('forms/edit/' . $form->id); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php echo form_error('title') ? 'is-invalid' : ''; ?>" 
                               id="title" name="title" value="<?php echo set_value('title', $form->title); ?>" required>
                        <?php echo form_error('title', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="submission_date">Submission Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control <?php echo form_error('submission_date') ? 'is-invalid' : ''; ?>" 
                               id="submission_date" name="submission_date" value="<?php echo set_value('submission_date', $form->submission_date); ?>" required>
                        <?php echo form_error('submission_date', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo set_value('description', $form->description); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="applicant_name">Applicant Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php echo form_error('applicant_name') ? 'is-invalid' : ''; ?>" 
                               id="applicant_name" name="applicant_name" value="<?php echo set_value('applicant_name', $form->applicant_name); ?>" required>
                        <?php echo form_error('applicant_name', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cao_number">CAO Number</label>
                        <input type="text" class="form-control" id="cao_number" name="cao_number" value="<?php echo set_value('cao_number', $form->cao_number); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="project_name">Project Name</label>
                <input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo set_value('project_name', $form->project_name); ?>">
            </div>

            <hr>
            <h5>Payment Information</h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="payment_receiver_name">Payment Receiver Name</label>
                        <input type="text" class="form-control" id="payment_receiver_name" name="payment_receiver_name" value="<?php echo set_value('payment_receiver_name', $form->payment_receiver_name); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bank_account_number">Bank Account Number</label>
                        <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" value="<?php echo set_value('bank_account_number', $form->bank_account_number); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo set_value('bank_name', $form->bank_name); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="transaction_type">Transaction Type</label>
                        <input type="text" class="form-control" id="transaction_type" name="transaction_type" value="<?php echo set_value('transaction_type', $form->transaction_type); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Form
                </button>
                <a href="<?php echo site_url('forms'); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>

<!-- Form Details Section -->
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Form Details</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addDetailModal">
                <i class="fas fa-plus"></i> Add Detail
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Work Area</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($details)): ?>
                    <?php foreach ($details as $detail): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($detail->description); ?></td>
                            <td><?php echo htmlspecialchars($detail->work_area); ?></td>
                            <td><?php echo number_format($detail->quantity); ?></td>
                            <td><?php echo number_format($detail->unit_price); ?></td>
                            <td><?php echo number_format($detail->total_amount); ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editDetailModal<?php echo $detail->id; ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?php echo site_url('forms/delete_detail/' . $detail->id . '/' . $form->id); ?>" 
                                   class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Detail Modal -->
                        <div class="modal fade" id="editDetailModal<?php echo $detail->id; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <?php echo form_open('forms/edit_detail/' . $detail->id . '/' . $form->id); ?>
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Detail</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="description" required><?php echo $detail->description; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Work Area</label>
                                                <input type="text" class="form-control" name="work_area" value="<?php echo $detail->work_area; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Quantity <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="quantity" value="<?php echo $detail->quantity; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Unit Price <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="unit_price" value="<?php echo $detail->unit_price; ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                        <td><strong><?php echo number_format($total_amount); ?></strong></td>
                        <td></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No details found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Detail Modal -->
<div class="modal fade" id="addDetailModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('forms/add_detail/' . $form->id); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Add Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Work Area</label>
                        <input type="text" class="form-control" name="work_area">
                    </div>
                    <div class="form-group">
                        <label>Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label>Unit Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="unit_price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- File Upload Section -->
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Uploaded Files</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#uploadFileModal">
                <i class="fas fa-upload"></i> Upload File
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Uploaded By</th>
                    <th>Upload Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($files)): ?>
                    <?php foreach ($files as $file): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($file->file_name); ?></td>
                            <td><?php echo htmlspecialchars($file->uploaded_by_name); ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($file->created_at)); ?></td>
                            <td>
                                <a href="<?php echo site_url('forms/download_file/' . $file->id); ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="<?php echo site_url('forms/delete_file/' . $file->id . '/' . $form->id); ?>" 
                                   class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No files uploaded</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Upload File Modal -->
<div class="modal fade" id="uploadFileModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open_multipart('forms/upload_file/' . $form->id); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Upload File</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="file" required>
                        <small class="form-text text-muted">Allowed: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Max 5MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$this->load->view('templates/layout', compact('title', 'page_title', 'content'));
?>
