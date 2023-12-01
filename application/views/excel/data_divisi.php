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
            <th>Nama Divisi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($divisi as $dvs) : ?>
        <tr>
            <td style="text-align: center;"><?= $i++; ?></td>
            <td style="text-align: center;"><?= $dvs['nama_divisi']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>