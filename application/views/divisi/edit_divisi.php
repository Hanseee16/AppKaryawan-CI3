<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_divisi" value="<?= $divisi['id_divisi'] ?>">
                <div class="form-group mb-3">
                    <label for="nama_divisi">Nama Divisi</label>
                    <input type="text" class="form-control" name="nama_divisi" id="nama_divisi"
                        placeholder="Masukkan nama_divisi" value="<?= $divisi['nama_divisi'] ?>">
                    <?= form_error('nama_divisi', '<small class="text-danger pt-3">', '</small>'); ?>
                </div>
                <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                <a href="<?= base_url('divisi') ?>" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>
</div>