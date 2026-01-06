<?php
include 'koneksi.php';

$id_responden = $_POST['id_responden'];
$kepentingan = $_POST['kepentingan'];
$kepuasan = $_POST['kepuasan'];

foreach($kepentingan as $id_atribut => $nilai_kepentingan){
    $nilai_kepuasan = $kepuasan[$id_atribut];

    mysqli_query($koneksi,"
        INSERT INTO kuesioner
        (id_responden, id_atribut, nilai_kepentingan, nilai_kepuasan)
        VALUES
        ('$id_responden','$id_atribut','$nilai_kepentingan','$nilai_kepuasan')
    ");
}

header("Location: selesai.php");
exit;
