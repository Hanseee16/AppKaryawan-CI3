<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="nik" value="<?= $karyawan['nik'] ?>">
                <div class="form-group mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama"
                        value="<?= $karyawan['nama'] ?>">
                    <!-- <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?> -->
                </div>
                <div class="form-group mb-3">
                    <label for="gaji">Gaji</label>
                    <input type="text" class="form-control" name="gaji" id="gaji" placeholder="Masukkan Gaji"
                        value="<?= $karyawan['gaji'] ?>">
                    <!-- <?= form_error('gaji', '<small class="text-danger pl-3">', '</small>'); ?> -->
                </div>
                <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                <a href="<?= base_url('karyawan/data_gaji') ?>" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->