<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
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