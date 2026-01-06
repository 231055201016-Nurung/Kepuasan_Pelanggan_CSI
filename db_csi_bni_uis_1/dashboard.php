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
   JUMLAH RESPONDEN
========================= */
$sqlResponden = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM responden"
);
$jml = mysqli_fetch_assoc($sqlResponden)['total'];

/* =========================
   HITUNG CSI
========================= */
$q = mysqli_query($koneksi, "
    SELECT 
        id_atribut,
        AVG(nilai_kepentingan) AS MIS,
        AVG(nilai_kepuasan) AS MSS
    FROM kuesioner
    GROUP BY id_atribut
");

$totalMIS = 0;
$data = [];

while ($r = mysqli_fetch_assoc($q)) {
    $totalMIS += $r['MIS'];
    $data[] = $r;
}

$csi = 0;
foreach ($data as $d) {
    if ($totalMIS > 0) {
        $wf = $d['MIS'] / $totalMIS; // Weight Factor
        $csi += $wf * $d['MSS'];
    }
}

// Konversi ke persen
$csi = ($csi / 5) * 100;

/* =========================
   KATEGORI CSI
========================= */
if ($csi >= 81) {
    $kategori = "Sangat Puas";
    $warna = "success";
} elseif ($csi >= 66) {
    $kategori = "Puas";
    $warna = "primary";
} elseif ($csi >= 51) {
    $kategori = "Cukup Puas";
    $warna = "warning";
} else {
    $kategori = "Kurang Puas";
    $warna = "danger";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin | Kepuasan Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <h3 class="mb-4">Dashboard Admin Kepuasan Pelanggan</h3>

    <!-- Tombol Logout -->
    <div class="mb-3 d-flex justify-content-end">
        <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
    </div>

    <!-- Tombol Aksi -->
    <div class="mb-3">
        <a href="export_excel.php" class="btn btn-success btn-sm">Export Excel</a>
        <a href="laporan_pdf.php" class="btn btn-danger btn-sm">Laporan PDF</a>
    </div>

    <div class="row g-3">

        <!-- NILAI CSI -->
        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h6 class="text-muted">Nilai CSI</h6>
                    <h2><?= round($csi, 2) ?>%</h2>
                    <span class="badge bg-<?= $warna ?>">
                        <?= $kategori ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- TOTAL RESPONDEN -->
        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h6 class="text-muted">Total Responden</h6>
                    <h2><?= $jml ?></h2>
                </div>
            </div>
        </div>

        <!-- GRAFIK -->
        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h6 class="text-muted">Grafik Kepuasan</h6>
                    <a href="grafik.php" class="btn btn-primary btn-sm mt-2">
                        Lihat Grafik
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>
