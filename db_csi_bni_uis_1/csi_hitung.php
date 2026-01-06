<?php
// 1️⃣ PERHITUNGAN CSI (PHP)
include 'koneksi.php';

$q = mysqli_query($koneksi,"
SELECT 
    AVG(nilai_kepentingan) AS MIS,
    AVG(nilai_kepuasan) AS MSS
FROM kuesioner
GROUP BY id_atribut
");

$totalMIS = 0;
$data = [];

while($r = mysqli_fetch_assoc($q)){
    $totalMIS += $r['MIS'];
    $data[] = $r;
}

$csi = 0;
foreach($data as $d){
    $wf = $d['MIS'] / $totalMIS;
    $csi += $wf * $d['MSS'];
}

$csi = ($csi / 5) * 100;
?>

<!-- 2️⃣ TAMPILAN HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Hasil CSI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <!-- 🔽 LETAKNYA DI SINI 🔽 -->
    <h3>Nilai CSI = <?= round($csi,2) ?>%</h3>

</body>
</html>
