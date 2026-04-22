<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <?php echo $signature ? 'Edit Tanda Tangan: ' . htmlspecialchars($signature->name) : 'Tambah Tanda Tangan'; ?>
        </h3>
        <div class="card-tools">
            <a href="<?php echo site_url('signatures'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php
        $action = $signature ? site_url('signatures/edit/' . $signature->id) : site_url('signatures/create');
        echo form_open_multipart($action);
        ?>
            <div class="form-group">
                <label for="label">Category <span class="text-danger">*</span></label>
                <select class="form-control" id="label" name="label" required>
                    <option value="mengetahui" <?php echo set_select('label', 'mengetahui', $signature->label == 'mengetahui'); ?>>Mengetahui</option>
                    <option value="menyetujui" <?php echo set_select('label', 'menyetujui', $signature->label == 'menyetujui'); ?>>Menyetujui</option>
                </select>
            </div>
            <!-- <div class="form-group">
                <label>Label <span class="text-danger">*</span></label>
                <input type="text" name="label" class="form-control <?php echo form_error('label') ? 'is-invalid' : ''; ?>"
                       value="<?php echo set_value('label', $signature->label ?? ''); ?>"
                       placeholder="e.g. Yang Mengajukan, Mengetahui, Menyetujui" required>
                <?php echo form_error('label', '<div class="invalid-feedback">', '</div>'); ?>
            </div> -->

            <div class="form-group">
                <label>Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control <?php echo form_error('name') ? 'is-invalid' : ''; ?>"
                       value="<?php echo set_value('name', $signature->name ?? ''); ?>" required>
                <?php echo form_error('name', '<div class="invalid-feedback">', '</div>'); ?>
            </div>

            <!-- <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="position" class="form-control"
                       value="<?php echo set_value('position', $signature->position ?? ''); ?>">
            </div> -->

            <div class="form-group">
                <label>Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control" style="width:100px"
                       value="<?php echo set_value('sort_order', $signature->sort_order ?? 0); ?>">
            </div>

            <!-- <div class="form-group">
                <label>Gambar Tanda Tangan <?php echo $signature ? '<small class="text-muted">(kosongkan jika tidak diganti)</small>' : ''; ?></label>
                <?php if (!empty($signature->image_path)): ?>
                    <div class="mb-2">
                        <img src="<?php echo base_url('uploads/signatures/' . $signature->image_path); ?>"
                             style="max-height:80px;border:1px solid #ddd;padding:4px;" alt="ttd saat ini">
                        <small class="d-block text-muted">Gambar saat ini</small>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" class="form-control-file" accept="image/*">
            </div> -->

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> <?php echo $signature ? 'Perbarui' : 'Simpan'; ?>
            </button>
            <a href="<?php echo site_url('signatures'); ?>" class="btn btn-secondary">Batal</a>
        <?php echo form_close(); ?>
    </div>
</div>
