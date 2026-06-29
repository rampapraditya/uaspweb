<?php
// Hubungkan database jika ada
include '../../koneksi.php';

// Ambil parameter aksi
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

switch ($aksi) {
    case 'tampil_data':
        
        $html_string = '';

        $query = mysqli_query($conn, "SELECT * FROM produk");
        while ($row = mysqli_fetch_assoc($query)) {
            // Format angka harga
            $harga_beli = number_format($row['hargabeli']);
            $harga_jual = number_format($row['hargajual']);

            $html_string .= "<tr>
                                <th>{$row['id']}</th>
                                <td>{$row['nama']}</td>
                                <td>{$row['satuan']}</td>
                                <td style='text-align: right;'>{$harga_beli}</td>
                                <td style='text-align: right;'>{$harga_jual}</td>
                                <td style='text-align: center;'>
                                    <button type='button' class='btn btn-warning btn-sm' onclick=\"edit('{$row['id']}')\">
                                        Edit
                                    </button>
                                    <button type='button' class='btn btn-danger btn-sm' onclick=\"hapus('{$row['id']}', '{$row['nama']}')\">
                                        Hapus
                                    </button>
                                </td>
                            </tr>";
        }

        // Jika data di database ternyata kosong
        if (mysqli_num_rows($query) == 0) {
            $html_string = "<tr><td colspan='6' style='text-align:center;'>Belum ada data produk.</td></tr>";
        }

        // Lempar string HTML kembali ke AJAX
        echo $html_string;
        break;

    case 'simpan':
        // Menangkap data dari form_data.append
        $kode      = $_POST['kode'] ?? '';
        $nama      = $_POST['nama'] ?? '';
        $satuan    = $_POST['satuan'] ?? '';
        $hargabeli = $_POST['hargabeli'] ?? 0;
        $hargajual = $_POST['hargajual'] ?? 0;

        // Validasi sederhana agar data tidak kosong
        if (empty($kode) || empty($nama)) {
            echo "gagal: Kode dan Nama Produk tidak boleh kosong!";
            exit;
        }

        // Query Insert ke database (Sesuaikan dengan nama tabel & kolom Anda)
        $query = "INSERT INTO produk (id, nama, satuan, hargabeli, hargajual) 
                  VALUES ('$kode', '$nama', '$satuan', '$hargabeli', '$hargajual')";
        
        $simpan = mysqli_query($conn, $query);

        if ($simpan) {
            echo "sukses"; // Kirim teks 'sukses' kembali ke AJAX jika berhasil
        } else {
            echo "gagal: " . mysqli_error($conn); // Kirim pesan error jika gagal
        }
        break;
    case 'ambil_data':
        $kode = $_POST['kode'] ?? '';

        // Query mengambil data berdasarkan ID/Kode
        $query = mysqli_query($conn, "SELECT * FROM produk WHERE id = '$kode'");
        $data  = mysqli_fetch_assoc($query);

        if ($data) {
            echo json_encode([
                'status' => 'sukses',
                'data'   => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'gagal',
                'message'=> 'Data produk tidak ditemukan.'
            ]);
        }
        break;
    case 'ganti':
        $kode      = $_POST['kode'] ?? '';
        $nama      = $_POST['nama'] ?? '';
        $satuan    = $_POST['satuan'] ?? '';
        $hargabeli = $_POST['hargabeli'] ?? 0;
        $hargajual = $_POST['hargajual'] ?? 0;

        // Validasi sederhana agar data tidak kosong
        if (empty($kode) || empty($nama)) {
            echo "gagal: Kode dan Nama Produk tidak boleh kosong!";
            exit;
        }

        $query = "UPDATE produk SET nama = '$nama',  satuan = '$satuan',  hargabeli = '$hargabeli',  hargajual = '$hargajual' WHERE id = '$kode'";
        $simpan = mysqli_query($conn, $query);

        if ($simpan) {
            echo "sukses"; // Kirim teks 'sukses' kembali ke AJAX jika berhasil
        } else {
            echo "gagal: " . mysqli_error($conn); // Kirim pesan error jika gagal
        }
        break;
    case 'hapus_data':
        
        // Tangkap kode produk yang mau dihapus dari form_data.append('kode', ...)
        $kode = $_POST['kode'] ?? '';

        // Validasi jika kode kosong
        if (empty($kode)) {
            echo "gagal: Kode produk tidak valid!";
            exit;
        }

        // Query DELETE berdasarkan Primary Key (id)
        $query = "DELETE FROM produk WHERE id = '$kode'";
        $hapus = mysqli_query($conn, $query);

        // Kirim respon teks kembali ke AJAX
        if ($hapus) {
            echo "sukses";
        } else {
            echo "gagal: " . mysqli_error($conn);
        }
        break;
    default:
        echo "Aksi tidak dikenal.";
        break;
}
exit;
