<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h3 class="fw-normal mb-2 text-gray-800"><?= $title ?></h3>

    <?= $this->session->flashdata('flash'); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="nama_divisi">Nama Divisi</label>
                    <input type="text" class="form-control" name="nama_divisi" id="nama_divisi"
                        placeholder="Masukkan nama divisi" value="<?= set_value('nama_divisi') ?>">
                    <small class="text-danger"><?= form_error('nama_divisi') ?></small>
                </div>
                <button type="submit" class="btn btn-primary" name="tambah">Tambah</button>
                <a href="<?= base_url('divisi') ?>" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->