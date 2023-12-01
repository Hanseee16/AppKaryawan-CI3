<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_unit" value="<?= $unit['id_unit'] ?>">
                <div class="form-group mb-3">
                    <label for="nama_unit">Nama Divisi</label>
                    <input type="text" class="form-control" name="nama_unit" id="nama_unit"
                        placeholder="Masukkan nama_unit" value="<?= $unit['nama_unit'] ?>">
                    <?= form_error('nama_unit', '<small class="text-danger pt-3">', '</small>'); ?>
                </div>
                <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                <a href="<?= base_url('unit') ?>" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>
</div>