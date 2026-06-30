<?php
include '../../koneksi.php';
$simpan = mysqli_query($conn, "insert into supplier (id, nama, alamat, kota, hp) values ('','','','','')");
if($simpan == 1){
    echo "Data tersimpan";
} else {
    echo "Data gagal tersimpan";
}