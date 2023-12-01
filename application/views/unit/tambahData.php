<div class="container-fluid">
    <h3 class="fw-normal mb-2 text-gray-800"><?= $title ?></h3>
    <?= $this->session->flashdata('flash'); ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="nama_unit">Nama Unit</label>
                    <input type="text" class="form-control mb-1" name="nama_unit" id="nama_unit"
                        placeholder="Masukkan nama unit" value="<?= set_value('nama_unit') ?>">
                    <small class="text-danger"><?= form_error('nama_unit') ?></small>
                </div>
                <button type="submit" class="btn btn-primary" name="tambah">Tambah</button>
                <a href="<?= base_url('unit') ?>" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>
</div>