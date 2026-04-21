<?php
$title = 'CAO List';
$page_title = 'CAO Reports';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">CAO List</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('cao/export_pdf?date_from=' . $date_from . '&date_to=' . $date_to); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="<?php echo site_url('cao/export_csv?date_from=' . $date_from . '&date_to=' . $date_to); ?>" class="btn btn-success btn-sm">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col-md-12">
                <form method="GET" action="<?php echo site_url('cao/index'); ?>" class="form-inline">
                    <div class="form-group mr-2">
                        <label for="date_from" class="mr-2">Date From:</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo htmlspecialchars($date_from); ?>">
                    </div>
                    <div class="form-group mr-2">
                        <label for="date_to" class="mr-2">To:</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo htmlspecialchars($date_to); ?>">
                    </div>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="<?php echo site_url('cao/index'); ?>" class="btn btn-secondary ml-2">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>NO CAO</th>
                        <th>TANGGAL</th>
                        <th>NAMA PENERIMA</th>
                        <th>NO REKENING</th>
                        <th>JENIS TRANSAKSI</th>
                        <th>CAO PENGAJUAN</th>
                        <th>CAO TRANSAKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cao_forms)): ?>
                        <?php foreach ($cao_forms as $cao): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cao->cao_number); ?></td>
                                <td><?php echo date('Y-m-d', strtotime($cao->submission_date)); ?></td>
                                <td><?php echo htmlspecialchars($cao->payment_receiver_name); ?></td>
                                <td><?php echo htmlspecialchars($cao->bank_account_number); ?></td>
                                <td><?php echo htmlspecialchars($cao->transaction_type); ?></td>
                                <td><?php echo htmlspecialchars($cao->created_by_name); ?></td>
                                <td class="text-right"><?php echo number_format($cao->total_amount, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No CAO found</td>
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
