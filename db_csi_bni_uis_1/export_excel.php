<?php
session_start();
include 'koneksi.php';

/* =========================
   CEK AKSES ADMIN
========================= */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* =========================
   HEADER EXCEL
========================= */
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_CSI.xls");

/* =========================
   AMBIL DATA
========================= */
$query = mysqli_query($koneksi, "
    SELECT 
        a.nama_atribut,
        AVG(k.nilai_kepentingan) AS MIS,
        AVG(k.nilai_kepuasan) AS MSS
    FROM kuesioner k
    JOIN atribut a ON k.id_atribut = a.id_atribut
    GROUP BY k.id_atribut
");

/* =========================
   HITUNG TOTAL MIS
========================= */
$totalMIS = 0;
$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $totalMIS += $row['MIS'];
    $data[] = $row;
}
?>

<table border="1">
    <tr>
        <th>No</th>
        <th>Atribut</th>
        <th>MIS</th>
        <th>MSS</th>
        <th>WF</th>
        <th>WS</th>
    </tr>

<?php
$no = 1;
$totalWS = 0;

foreach ($data as $d) {
    $wf = ($totalMIS > 0) ? ($d['MIS'] / $totalMIS) : 0;
    $ws = $wf * $d['MSS'];
    $totalWS += $ws;
?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['nama_atribut'] ?></td>
        <td><?= round($d['MIS'], 2) ?></td>
        <td><?= round($d['MSS'], 2) ?></td>
        <td><?= round($wf, 4) ?></td>
        <td><?= round($ws, 4) ?></td>
    </tr>
<?php } ?>

    <tr>
        <th colspan="5">TOTAL WS</th>
        <th><?= round($totalWS, 4) ?></th>
    </tr>

<?php
$csi = ($totalWS / 5) * 100;
?>
    <tr>
        <th colspan="5">NILAI CSI (%)</th>
        <th><?= round($csi, 2) ?>%</th>
    </tr>
</table>
