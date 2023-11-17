<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h3 class="fw-normal mb-2 text-gray-800"><?= $title ?></h3>

    <?= $this->session->flashdata('flash'); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('karyawan/tambah_gaji') ?>" method="post">
                <div class="form-group mb-3">
                    <label for="nama">Pilih Nama Karyawan</label>
                    <select class="form-control" name="nama" id="nama">
                        <option value="">Pilih</option>
                        <?php foreach ($karyawan as $kry) : ?>
                        <option value="<?= $kry['id'] ?>"><?= $kry['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="gaji">Gaji</label>
                    <input type="text" class="form-control" name="gaji" id="gaji" placeholder="Masukkan gaji"
                        value="<?= set_value('gaji') ?>">
                    <?= form_error('gaji', '<small class="text-danger pt-3">', '</small>'); ?>
                </div>
                <button type="submit" class="btn btn-primary" name="tambah">Tambah</button>
                <a href="<?= base_url('karyawan/data_gaji') ?>" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->