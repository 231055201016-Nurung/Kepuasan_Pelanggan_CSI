<?php
$koneksi = mysqli_connect("localhost","root","","db_csi_bni_uis_1");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
