<?php
$title = 'Approval Flows';
$page_title = 'Approval Flows Management';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Approval Flows</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('approval_flows/create'); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Flow
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Form Type</th>
                    <th>Role</th>
                    <th>Step Order</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($flows)): ?>
                    <?php foreach ($flows as $flow): ?>
                        <tr>
                            <td><?php echo $flow->id; ?></td>
                            <td><span class="badge badge-info"><?php echo htmlspecialchars($flow->form_type); ?></span></td>
                            <td><?php echo htmlspecialchars($flow->role_name); ?></td>
                            <td><span class="badge badge-secondary"><?php echo $flow->step_order; ?></span></td>
                            <td><?php echo $flow->created_at ? date('Y-m-d H:i', strtotime($flow->created_at)) : '-'; ?></td>
                            <td>
                                <a href="<?php echo site_url('approval_flows/edit/' . $flow->id); ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo site_url('approval_flows/delete/' . $flow->id); ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this approval flow?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No approval flows found</td>
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