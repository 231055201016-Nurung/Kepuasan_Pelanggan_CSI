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
   AMBIL DATA CSI
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

$totalMIS = 0;
$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $totalMIS += $row['MIS'];
    $data[] = $row;
}

$totalWS = 0;
foreach ($data as $d) {
    $wf = ($totalMIS > 0) ? ($d['MIS'] / $totalMIS) : 0;
    $ws = $wf * $d['MSS'];
    $totalWS += $ws;
}

$csi = ($totalWS / 5) * 100;

/* =========================
   KATEGORI
========================= */
if ($csi >= 81) $kategori = "Sangat Puas";
elseif ($csi >= 66) $kategori = "Puas";
elseif ($csi >= 51) $kategori = "Cukup Puas";
else $kategori = "Kurang Puas";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan CSI</title>
    <style>
        body { font-family: Arial; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:6px; }
        th { background:#eee; }
    </style>
</head>
<body onload="window.print()">

<h2 align="center">LAPORAN CUSTOMER SATISFACTION INDEX (CSI)</h2>
<p><strong>Nilai CSI:</strong> <?= round($csi,2) ?>%</p>
<p><strong>Kategori:</strong> <?= $kategori ?></p>

<table>
    <tr>
        <th>No</th>
        <th>Atribut</th>
        <th>MIS</th>
        <th>MSS</th>
    </tr>
    <?php $no=1; foreach($data as $d){ ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['nama_atribut'] ?></td>
        <td><?= round($d['MIS'],2) ?></td>
        <td><?= round($d['MSS'],2) ?></td>
    </tr>
    <?php } ?>
</table>

<p style="margin-top:40px;">
    Dicetak pada: <?= date('d-m-Y') ?>
</p>

</body>
</html>
