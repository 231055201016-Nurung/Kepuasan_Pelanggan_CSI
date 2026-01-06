<?php
session_start();
include 'koneksi.php';
if(!isset($_SESSION['role']) || $_SESSION['role']!='admin'){
    header("Location: login.php");
    exit;
}

$data = mysqli_query($koneksi,"
SELECT 
    a.nama_atribut,
    AVG(k.nilai_kepentingan) AS kepentingan,
    AVG(k.nilai_kepuasan) AS kepuasan
FROM kuesioner k
JOIN atribut a ON k.id_atribut=a.id_atribut
GROUP BY a.id_atribut
");

$atribut=[]; $kepentingan=[]; $kepuasan=[];
while($d=mysqli_fetch_assoc($data)){
    $atribut[]=$d['nama_atribut'];
    $kepentingan[]=$d['kepentingan'];
    $kepuasan[]=$d['kepuasan'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grafik CSI</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<!-- TOMBOL BACK -->
<div class="mb-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Kembali</a>
</div>

<h4>Grafik Kepuasan Pelanggan</h4>
<canvas id="grafikCSI"></canvas>

<script>
new Chart(document.getElementById('grafikCSI'), {
    type:'bar',
    data:{
        labels: <?= json_encode($atribut) ?>,
        datasets:[
            {label:'Kepentingan', data: <?= json_encode($kepentingan) ?>, backgroundColor:'rgba(54, 162, 235, 0.6)'},
            {label:'Kepuasan', data: <?= json_encode($kepuasan) ?>, backgroundColor:'rgba(255, 99, 132, 0.6)'}
        ]
    },
    options:{
        scales:{ y:{ beginAtZero:true, max:5 } }
    }
});
</script>

</body>
</html>
