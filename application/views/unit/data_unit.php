<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal"
                data-target="#exampleModal"><i class="bi bi-file-earmark-arrow-down-fill"></i> Import
            </a>
            <a href="<?= base_url('unit/exportData')?>"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="bi bi-file-earmark-arrow-up-fill"></i> Export </a>
        </div>
    </div>
    <?= $this->session->flashdata('flash'); ?>
    <div class="card">
        <div class="card-header py-3">
            <a href="<?= base_url('unit/tambahData') ?>" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i>
                Tambah Data</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama Unit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($unit as $unt) : ?>
                    <tr>
                        <td class="text-center"><?= $i++; ?>.</td>
                        <td class="text-center"><?= $unt['nama_unit']; ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('unit/editData/' . $unt['id_unit']) ?>" class="btn btn-warning"><i
                                    class="bi bi-pencil-square"></i></a>
                            <a href="<?= base_url('unit/hapusData/' . $unt['id_unit']) ?>" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data unit ini?');">
                                <i class="bi bi-trash3-fill"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
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
                <form action="<?= base_url('unit/importData') ?>" method="post" enctype="multipart/form-data">
                    <input type="file" class="form-control" id="importexcel" name="importexcel" accept=".xlsx,.xls"
                        require>
                    <div class="mt-1">
                        <span class="text-secondary">File yang harus diupload : .xls, xlsx</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Keluar</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>