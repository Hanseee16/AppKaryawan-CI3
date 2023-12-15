<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <div>
            <a href="<?= base_url('karyawan/downloadFile') ?>"
                class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-download fa-sm"></i>
                Download </a>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal"
                data-target="#exampleModal"><i class="bi bi-file-earmark-arrow-down-fill"></i> Import
            </a>
            <a href="<?= base_url('karyawan/exportData')?>"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="bi bi-file-earmark-arrow-up-fill"></i> Export </a>
        </div>
    </div>

    <?= $this->session->flashdata('flash'); ?>

    <div class="card">
        <div class="card-header py-3 d-flex align-items-start justify-content-between">
            <a href="<?= base_url('karyawan/tambah_karyawan') ?>" class="btn btn-primary"><i
                    class="bi bi-person-plus-fill"></i>
                Tambah Data</a>

            <form action="<?= base_url('karyawan/filterData') ?>" class="d-flex align-items-start ml-5"
                style="gap: 10px;" method="post" id="filterForm">
                <div class="form-group mb-3">
                    <select class="form-control" name="filter_type" id="filter_type" required>
                        <option value="">Pilih</option>
                        <option value="divisi">Filter Divisi</option>
                        <option value="unit">Filter Unit</option>
                    </select>
                </div>
                <div class="form-group mb-3" id="filterDivisi" style="display: none;">
                    <select class="form-control" name="id_divisi" id="id_divisi">
                        <option value="">Pilih Divisi</option>
                        <?php foreach ($divisi as $dvs) : ?>
                        <option value="<?= $dvs['id_divisi'] ?>"><?= $dvs['nama_divisi'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-3" id="filterUnit" style="display: none;">
                    <select class="form-control" name="id_unit" id="id_unit">
                        <option value="">Pilih Unit</option>
                        <?php foreach ($unit as $unt) : ?>
                        <option value="<?= $unt['id_unit'] ?>"><?= $unt['nama_unit'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>


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
                    <input type="file" class="form-control" id="importexcel" name="importexcel" accept=".xlsx,.xls"
                        require>
                    <div class="mt-1">
                        <span class="text-secondary">File yang harus diupload : .xls, xlsx</span>
                    </div>
                    <!-- <?= form_error('file','<div class="text-danger">','</div>') ?> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Keluar</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>