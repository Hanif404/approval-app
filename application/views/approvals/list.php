<?php
$title = 'Forms Approval List';
$page_title = 'Forms Approval List';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Forms Approval List</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-12">
                <form method="GET" action="<?php echo site_url('approvals/index'); ?>" class="form-inline">
                    <div class="form-group mr-2">
                        <label for="submission_date_from" class="mr-2">Submission Date From:</label>
                        <input type="date" class="form-control" id="submission_date_from" name="submission_date_from" value="<?php echo isset($submission_date_from) ? htmlspecialchars($submission_date_from) : ''; ?>">
                    </div>
                    <div class="form-group mr-2">
                        <label for="submission_date_to" class="mr-2">To:</label>
                        <input type="date" class="form-control" id="submission_date_to" name="submission_date_to" value="<?php echo isset($submission_date_to) ? htmlspecialchars($submission_date_to) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="<?php echo site_url('approvals/index'); ?>" class="btn btn-secondary ml-2">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Applicant</th>
                        <th>Submission Date</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($forms)): ?>
                        <?php foreach ($forms as $form): ?>
                            <tr>
                                <td><?php echo $form->id; ?></td>
                                <td><?php echo htmlspecialchars($form->title); ?></td>
                                <td><?php echo htmlspecialchars($form->applicant_name); ?></td>
                                <td><?php echo date('Y-m-d', strtotime($form->submission_date)); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $form->approval_status == 'approved' ? 'success' : ($form->approval_status == 'rejected' ? 'danger' : ($form->approval_status == 'pending' ? 'warning' : 'info')); ?>">
                                        <?php echo ucfirst($form->approval_status); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($form->created_by_name); ?></td>
                                <td>
                                    <a href="<?php echo site_url('approvals/view/' . $form->id); ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No forms found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$this->load->view('templates/layout', compact('title', 'page_title', 'content'));
?>