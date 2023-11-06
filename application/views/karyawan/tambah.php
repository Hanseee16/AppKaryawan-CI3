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
                    <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK"
                        value="<?= set_value('nik') ?>">
                    <?= form_error('nik', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                        <option selected>Pilih Jenis Kelamin</option>
                        <option value="Pria" <?= set_select('jenis_kelamin', 'Pria'); ?>>Pria</option>
                        <option value="Wanita" <?= set_select('jenis_kelamin', 'Wanita'); ?>>Wanita</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="id_divisi">Divisi</label>
                    <select class="form-control" name="id_divisi" id="id_divisi">
                        <option value="">Pilih Divisi</option>
                        <?php foreach ($divisi as $key => $value) { ?>
                        <option value="<?= $value['id_divisi'] ?>" <?= set_select('id_divisi', $value['id_divisi']); ?>>
                            <?= $value['nama_divisi'] ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="id_unit">Unit</label>
                    <select class="form-control" name="id_unit" id="id_unit">
                        <option value="">Pilih Unit</option>
                        <?php foreach ($unit as $key => $value) { ?>
                        <option value="<?= $value['id_unit'] ?>" <?= set_select('id_unit', $value['id_unit']) ?>>
                            <?= $value['nama_unit'] ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Foto</label>
                    <input type="file" class="form-control" name="foto" id="preview_gambar" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary" name="tambah">Tambah</button>
                <a href="<?= base_url('karyawan') ?>" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->