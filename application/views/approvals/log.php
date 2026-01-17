<?php
$title = 'Approval Log';
$page_title = 'Approval Log';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Approval Logs</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('forms/view/'.$id); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Note</th>
                    <th>Approved At</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($approvals)): ?>
                    <?php foreach ($approvals as $approval): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($approval->user_name); ?></td>
                            <td><?php echo htmlspecialchars($approval->role_name); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $approval->status == 'approved' ? 'success' : ($approval->status == 'rejected' ? 'danger' : 'warning'); ?>">
                                    <?php echo ucfirst($approval->status); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($approval->note ?? '-'); ?></td>
                            <td><?php echo $approval->approved_at ? date('Y-m-d H:i', strtotime($approval->approved_at)) : '-'; ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($approval->created_at)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No approval logs found</td>
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