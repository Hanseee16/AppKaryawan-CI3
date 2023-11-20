<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Select "Logout" below if you are ready to end your current session.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    Cancel
                </button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('/assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('/assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('/assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('/assets/') ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('/assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('/assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url('/assets/') ?>js/demo/datatables-demo.js"></script>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>

<!-- sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- server side -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

<!-- server side data karyawan -->
<script>
$(document).ready(function() {
    var table = $('#data_karyawan').DataTable({
        search: {
            return: true
        },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url('karyawan/getDataKaryawan'); ?>",
            "type": "POST"
        },
        "aLengthMenu": [
            [10, 20, 50],
            [10, 20, 50]
        ],
        "columnDefs": [{
            "target": [-1],
            "orderable": false
        }]
    });
});
</script>

<!-- server side data gaji karyawan -->
<script>
$(document).ready(function() {
    var table = $('#data_gaji').DataTable({
        search: {
            return: true
        },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url('karyawan/getDataGaji'); ?>",
            "type": "POST"
        },
        "aLengthMenu": [
            [10, 20, 50],
            [10, 20, 50]
        ],
        "columnDefs": [{
            "target": [-1],
            "orderable": false
        }]
    });
});
</script>

<!-- gaji -->
<script>
document.getElementById('gaji').addEventListener('input', function(e) {
    // Mengambil nilai yang dimasukkan
    let gaji = e.target.value;

    // Menghilangkan tanda titik jika ada
    gaji = gaji.replace(/\./g, '');

    // Menambahkan titik setiap 3 digit dari belakang
    gaji = gaji.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    // Memasukkan nilai yang sudah diformat kembali ke input
    e.target.value = gaji;
});
</script>

<!-- sweet alert logout -->
<script>
function showConfirmDialog(event) {

    // Mencegah tindakan default dari tautan
    event.preventDefault();

    Swal.fire({
        title: 'Yakin ingin keluar?',
        text: 'Anda akan keluar dari sesi saat ini.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Keluar!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {

            // Redirect ke halaman logout jika dikonfirmasi
            window.location.href =
                "<?= base_url('auth/logout') ?>";
        }
    });
}
</script>

</body>

</html>