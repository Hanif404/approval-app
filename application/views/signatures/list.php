<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Tanda Tangan</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('signatures/create'); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Label</th>
                    <th>Nama</th>
                    <!-- <th>Jabatan</th> -->
                    <!-- <th>Tanda Tangan</th> -->
                    <th>Urutan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($signatures)): ?>
                    <?php foreach ($signatures as $i => $s): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo htmlspecialchars($s->label); ?></td>
                            <td><?php echo htmlspecialchars($s->name); ?></td>
                            <!-- <td><?php echo htmlspecialchars($s->position ?? '-'); ?></td>
                            <td>
                                <?php if ($s->image_path): ?>
                                    <img src="<?php echo base_url('uploads/signatures/' . $s->image_path); ?>"
                                         style="max-height:50px;max-width:120px;" alt="ttd">
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td> -->
                            <td><?php echo $s->sort_order; ?></td>
                            <td>
                                <a href="<?php echo site_url('signatures/edit/' . $s->id); ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo site_url('signatures/delete/' . $s->id); ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Hapus tanda tangan ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">Belum ada data</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
