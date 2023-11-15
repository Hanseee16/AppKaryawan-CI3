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
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama"
                        value="<?= set_value('nama') ?>">
                    <small class="text-danger"><?= form_error('nama') ?></small>
                </div>
                <div class="form-group mb-3">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK"
                        value="<?= set_value('nik') ?>">
                    <small class="text-danger"><?= form_error('nik') ?></small>
                </div>
                <div class="form-group mb-3">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                        <option value="" <?= set_select('jenis_kelamin', '', TRUE) ?>>Pilih</option>
                        <option value="Pria" <?= set_select('jenis_kelamin', 'Pria') ?>>Pria</option>
                        <option value="Wanita" <?= set_select('jenis_kelamin', 'Wanita') ?>>Wanita</option>
                    </select>
                    <small class="text-danger"><?= form_error('jenis_kelamin') ?></small>
                </div>
                <div class="form-group mb-3">
                    <label for="id_divisi">Divisi</label>
                    <select class="form-control" name="id_divisi" id="id_divisi">
                        <option value="" <?= set_select('id_divisi', '', TRUE) ?>>Pilih</option>
                        <option value="1" <?= set_select('id_divisi', '1') ?>>Divisi-1</option>
                        <option value="2" <?= set_select('id_divisi', '2') ?>>Divisi-2</option>
                    </select>
                    <small class="text-danger"><?= form_error('id_divisi') ?></small>
                </div>
                <div class="form-group mb-3">
                    <label for="id_unit">Unit</label>
                    <select class="form-control" name="id_unit" id="id_unit">
                        <option value="" <?= set_select('id_unit', '', TRUE) ?>>Pilih</option>
                        <option value="1" <?= set_select('id_unit', '1') ?>>Unit-1</option>
                        <option value="2" <?= set_select('id_unit', '2') ?>>Unit-2</option>
                    </select>
                    <small class="text-danger"><?= form_error('id_unit') ?></small>
                </div>
                <div class="form-group mb-3">
                    <label>Foto</label>
                    <input type="file" class="form-control" name="foto" id="preview_gambar" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary" name="tambah">Tambah</button>
                <a href="<?= base_url('karyawan/data_karyawan') ?>" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->