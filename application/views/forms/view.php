<?php
$title = 'View Form';
$page_title = 'Form Details';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Details</h3>
        <div class="card-tools">
            <?php if ($form->status == 'draft'): ?>
            <a href="<?php echo site_url('forms/submit/' . $form->id); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-paper-plane"></i> Submit
            </a>
            <a href="<?php echo site_url('forms/edit/' . $form->id); ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <?php endif; ?>
            <a href="<?php echo site_url('forms'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Title:</th>
                        <td><?php echo htmlspecialchars($form->title); ?></td>
                    </tr>
                    <tr>
                        <th>Submission Date:</th>
                        <td><?php echo date('Y-m-d', strtotime($form->submission_date)); ?></td>
                    </tr>
                    <tr>
                        <th>Applicant Name:</th>
                        <td><?php echo htmlspecialchars($form->applicant_name); ?></td>
                    </tr>
                    <tr>
                        <th>CAO Number:</th>
                        <td><?php echo htmlspecialchars($form->cao_number); ?></td>
                    </tr>
                    <tr>
                        <th>Project Name:</th>
                        <td><?php echo htmlspecialchars($form->project_name); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Payment Receiver:</th>
                        <td><?php echo htmlspecialchars($form->payment_receiver_name); ?></td>
                    </tr>
                    <tr>
                        <th>Bank Account:</th>
                        <td><?php echo htmlspecialchars($form->bank_account_number); ?></td>
                    </tr>
                    <tr>
                        <th>Bank Name:</th>
                        <td><?php echo htmlspecialchars($form->bank_name); ?></td>
                    </tr>
                    <tr>
                        <th>Transaction Type:</th>
                        <td><?php echo nl2br(htmlspecialchars($form->transaction_type)); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge badge-<?php echo $form->status == 'approved' ? 'success' : ($form->status == 'rejected' ? 'danger' : ($form->status == 'submitted' ? 'info' : 'warning')); ?>">
                                <?php echo ucfirst($form->status); ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-borderless">
                    <tr>
                        <th width="20%">Description:</th>
                        <td><?php echo nl2br(htmlspecialchars($form->description)); ?></td>
                    </tr>
                    <tr>
                        <th>Created By:</th>
                        <td><?php echo htmlspecialchars($form->created_by_name); ?> on <?php echo date('Y-m-d H:i', strtotime($form->created_at)); ?></td>
                    </tr>
                    <?php if ($form->updated_at): ?>
                    <tr>
                        <th>Last Updated:</th>
                        <td><?php echo date('Y-m-d H:i', strtotime($form->updated_at)); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Form Details Section -->
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Form Details</h3>
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
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                        <td><strong><?php echo number_format($total_amount); ?></strong></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No details found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Uploaded Files Section -->
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Uploaded Files</h3>
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
                                    <i class="fas fa-download"></i> Download
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

<?php
$content = ob_get_clean();
$this->load->view('templates/layout', compact('title', 'page_title', 'content'));
?>
