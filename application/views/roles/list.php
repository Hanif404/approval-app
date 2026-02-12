<?php
$title = 'Roles List';
$page_title = 'Roles Management';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Roles List</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('roles/create'); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Role
            </a>
        </div>
    </div>
    <div class="card-body">        
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($roles)): ?>
                        <?php foreach ($roles as $role): ?>
                            <tr>
                                <td><?php echo $role->id; ?></td>
                                <td><?php echo htmlspecialchars($role->name); ?></td>
                                <td><?php echo htmlspecialchars($role->description); ?></td>
                                <td><?php echo $role->created_at ? date('Y-m-d H:i', strtotime($role->created_at)) : '-'; ?></td>
                                <td>
                                    <a href="<?php echo site_url('roles/edit/' . $role->id); ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo site_url('roles/delete/' . $role->id); ?>" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete this role?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No roles found</td>
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
