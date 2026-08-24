<?php
$title = 'View Form';
$page_title = 'Form Details';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Details</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#uploadFileModal">
                <i class="fas fa-upload"></i> Upload Slip File
            </button>
            <a href="<?php echo site_url('forms/list_slip'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Nama Projek:</th>
                        <td><?php echo htmlspecialchars($form->project_name); ?></td>
                    </tr>
                    <tr>
                        <th>Nomor CAO:</th>
                        <td><?php echo htmlspecialchars($form->cao_number); ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan:</th>
                        <td><?php echo date('Y-m-d', strtotime($form->submission_date)); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Nama Penerima:</th>
                        <td><?php echo htmlspecialchars($form->payment_receiver_name); ?></td>
                    </tr>
                    <tr>
                        <th>Nomor Rekening Bank:</th>
                        <td><?php echo htmlspecialchars($form->bank_account_number); ?></td>
                    </tr>
                    <tr>
                        <th>Nama Bank:</th>
                        <td><?php echo htmlspecialchars($form->bank_name); ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Transaksi:</th>
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
                        <th width="20%">Dibuat Oleh:</th>
                        <td><?php echo htmlspecialchars($form->created_by_name); ?> on <?php echo date('Y-m-d H:i', strtotime($form->created_at)); ?></td>
                    </tr>
                    <?php if ($form->updated_at): ?>
                    <tr>
                        <th>Terakhir Diperbarui:</th>
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
                    <th>Keterangan</th>
                    <th>Area</th>
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
                                <a href="<?php echo site_url('forms/view_file/' . $file->id); ?>" class="btn btn-secondary btn-sm" target="_blank">
                                    <i class="fas fa-eye"></i> View
                                </a>
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

<!-- File Upload Section -->
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Uploaded Slip Files</h3>
        <div class="card-tools"></div>
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
                <?php if (!empty($slipFiles)): ?>
                    <?php foreach ($slipFiles as $file): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($file->file_name); ?></td>
                            <td><?php echo htmlspecialchars($file->uploaded_by_name); ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($file->created_at)); ?></td>
                            <td>
                                <a href="<?php echo site_url('forms/view_file/' . $file->id); ?>" class="btn btn-secondary btn-sm" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo site_url('forms/download_file/' . $file->id); ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="<?php echo site_url('forms/delete_slip_file/' . $file->id . '/' . $form->id); ?>" 
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
                    <h4 class="modal-title">Upload Slip File</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="is_slip" value="1">
                    <div class="form-group">
                        <label>File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="file" required>
                        <small class="form-text text-muted">Allowed: JPG, JPEG, PNG, PDF (Max 5MB)</small>
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
