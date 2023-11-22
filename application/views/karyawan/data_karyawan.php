<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <div>
            <a href="<?= base_url('karyawan/downloadFile') ?>"
                class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Download </a>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal"
                data-target="#exampleModal"><i class="fas fa-download fa-sm text-white-50"></i> Import </a>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Export </a>
        </div>
    </div>

    <?= $this->session->flashdata('flash'); ?>

    <div class="card">
        <div class="card-header py-3">
            <a href="<?= base_url('karyawan/tambah_karyawan') ?>" class="btn btn-primary"><i
                    class="bi bi-person-plus-fill"></i>
                Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="data_karyawan" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">NIK</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Divisi</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Foto</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('karyawan/import_data') ?>" method="post" enctype="multipart/form-data">
                    <input type="file" class="form-control" id="importexcel" name="importexcel" accept=".xlsx,.xls">
                    <div class="mt-1">
                        <span class="text-secondary">File yang harus diupload : .xls, xlsx</span>
                    </div>
                    <!-- <?= form_error('file','<div class="text-danger">','</div>') ?> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Keluar</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>