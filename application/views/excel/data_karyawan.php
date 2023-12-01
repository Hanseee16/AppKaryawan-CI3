<?php
header("Content-type:application/octet-stream/");

header("Content-Disposition:attachment; filename=$title.xls");

header("Pragma: no-cache");

header("Expires: 0");
?>
<table border="1" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Jenis Kelamin</th>
            <th>Divisi</th>
            <th>Unit</th>
            <th>Gaji</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($karyawan as $kry) : ?>
        <tr>
            <td style="text-align: center;"><?= $i++; ?></td>
            <td style="text-align: center;"><?= $kry['nama']; ?></td>
            <td style="text-align: center;"><?= $kry['nik']; ?></td>
            <td style="text-align: center;"><?= $kry['jenis_kelamin']; ?></td>
            <td style="text-align: center;"><?= $kry['nama_divisi']; ?></td>
            <td style="text-align: center;"><?= $kry['nama_unit']; ?></td>
            <td style="text-align: center;">
                <?= ($kry['gaji'] !== null) ? number_format($kry['gaji'], 0, ',', '.') : 'Belum Diinput'; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>