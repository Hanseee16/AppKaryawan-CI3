<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <?= $this->session->flashdata('flash'); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?= base_url('karyawan/tambah') ?>" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i>
                Tambah Data</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
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
                        <?php
                                $no = 1;
                                foreach ($karyawan as $kry) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-center"><?= $kry['nama'] ?></td>
                            <td class="text-center text-uppercase"><?= $kry['nik'] ?></td>
                            <td class="text-center"><?= $kry['jenis_kelamin'] ?></td>
                            <td class="text-center"><?= $kry['nama_divisi'] ?></td>
                            <td class="text-center"><?= $kry['nama_unit'] ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal<?= $kry['id'] ?>">
                                    <i class="bi bi-image-fill"></i>
                                </button>
                                <!-- Modal foto -->
                                <div class="modal fade" id="exampleModal<?= $kry['id'] ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel<?= $kry['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel<?= $kry['id'] ?>">
                                                    Foto</h4>
                                                <a href="" class="text-secondary" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <img src="<?= base_url('./assets/img/upload/' . $kry['foto']) ?>"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('karyawan/edit/') ?><?= $kry['id'] ?>" class="btn btn-warning"
                                    onclick="editConfirmation(event, '<?= $kry['id'] ?>')">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="<?= base_url('karyawan/hapus/') ?><?= $kry['id'] ?>"
                                    onclick="hapusData(event, '<?= base_url('karyawan/hapus/') ?><?= $kry['id'] ?>')"
                                    class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->