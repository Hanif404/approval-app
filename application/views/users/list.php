<?php
$title = 'Users List';
$page_title = 'Users Management';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Users List</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('users/create'); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add User
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
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user->id; ?></td>
                                <td><?php echo htmlspecialchars($user->name); ?></td>
                                <td><?php echo htmlspecialchars($user->email); ?></td>
                                <td>
                                    <?php if (!empty($user->roles)): ?>
                                        <?php 
                                        $role_names = explode(',', $user->roles);
                                        foreach ($role_names as $role_name): 
                                        ?>
                                            <span class="badge badge-primary"><?php echo htmlspecialchars(trim($role_name)); ?></span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-muted">No roles</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $user->created_at ? date('Y-m-d H:i', strtotime($user->created_at)) : '-'; ?></td>
                                <td>
                                    <a href="<?php echo site_url('users/view/' . $user->id); ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo site_url('users/edit/' . $user->id); ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo site_url('users/delete/' . $user->id); ?>" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
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