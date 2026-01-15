<?php
$title = 'View User';
$page_title = 'User Details';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">User Details</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('users'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="<?php echo site_url('users/edit/' . $user->id); ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">ID</th>
                <td><?php echo $user->id; ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($user->name); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($user->email); ?></td>
            </tr>
            <tr>
                <th>Roles</th>
                <td>
                    <?php if (!empty($user->roles)): ?>
                        <?php foreach ($user->roles as $role): ?>
                            <span class="badge badge-primary"><?php echo htmlspecialchars($role->name); ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="text-muted">No roles assigned</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Created At</th>
                <td><?php echo $user->created_at ? date('Y-m-d H:i:s', strtotime($user->created_at)) : '-'; ?></td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td><?php echo $user->updated_at ? date('Y-m-d H:i:s', strtotime($user->updated_at)) : '-'; ?></td>
            </tr>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
$this->load->view('templates/layout', compact('title', 'page_title', 'content'));
?>