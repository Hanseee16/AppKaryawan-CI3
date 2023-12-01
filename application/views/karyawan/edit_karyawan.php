<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $karyawan['id'] ?>">
                <div class="form-group mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama"
                        value="<?= $karyawan['nama'] ?>">
                    <?= form_error('nama', '<small class="text-danger pt-3">', '</small>'); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK"
                        value="<?= $karyawan['nik'] ?>">
                    <?= form_error('nik', '<small class="text-danger pt-3">', '</small>'); ?>
                </div>
                <div class="form-group mb-3">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                        <option selected>Pilih Jenis Kelamin</option>
                        <?php
                                foreach ($jenis_kelamin as $jk) { ?>
                        <?php if ($jk == $karyawan['jenis_kelamin']) : ?>
                        <option value="<?= $jk ?>" selected><?= $jk ?></option>
                        <?php else : ?>
                        <option value="<?= $jk ?>"><?= $jk ?></option>
                        <?php endif; ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="id_divisi">Divisi</label>
                    <select class="form-control" name="id_divisi" id="id_divisi">
                        <option value="" selected>Pilih Divisi</option>
                        <?php foreach ($divisi as $key => $value) { ?>
                        <option value="<?= $value['id_divisi'] ?>"
                            <?= $value['id_divisi'] == $karyawan['id_divisi'] ? 'selected' : '' ?>>
                            <?= $value['nama_divisi'] ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="id_unit">Unit</label>
                    <select class="form-control" name="id_unit" id="id_unit">
                        <option selected>Pilih Unit</option>
                        <?php foreach ($unit as $key => $value) { ?>
                        <option value="<?= $value['id_unit'] ?>"
                            <?= $value['id_unit'] == $karyawan['id_unit'] ? 'selected' : '' ?>>
                            <?= $value['nama_unit'] ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Foto</label>
                    <input type="file" class="form-control" name="foto" id="preview_gambar" accept="image/*">
                </div>
                <div class="form-group mb-3">
                    <label>Preview Foto:</label>
                    <br>
                    <img src="<?= base_url('./assets/img/upload/' . $karyawan['foto']) ?>" id="gambar_load" width="250">
                </div>
                <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                <a href="<?= base_url('karyawan/data_karyawan') ?>" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#gambar_load').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$('#preview_gambar').change(function() {
    previewImage(this);
});
</script>