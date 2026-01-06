<?php
include 'koneksi.php';

$nama  = $_POST['nama'];
$email = $_POST['email'];

mysqli_query($koneksi,
    "INSERT INTO responden (nama, email, tanggal_isi)
     VALUES ('$nama','$email',NOW())"
);

$id_responden = mysqli_insert_id($koneksi);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="1;url=input_kuesioner.php?id_responden=<?= $id_responden ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5 text-center">
    <h4>Terima kasih 🙏</h4>
    <p>Anda akan diarahkan ke kuesioner...</p>
</body>
</html>
