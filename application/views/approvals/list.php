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
        <table class="table table-bordered table-striped">
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

<?php
$content = ob_get_clean();
$this->load->view('templates/layout', compact('title', 'page_title', 'content'));
?>