<?php
// Hubungkan database jika ada
include '../../koneksi.php';

// Ambil parameter aksi
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

switch ($aksi) {
    case 'tampil_data':
        $query = mysqli_query($conn, "SELECT * FROM produk");
        $html_string = '';

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
                                    <button type='button' class='btn btn-warning' onclick='edit({$row['id']})'>
                                        Edit
                                    </button>
                                    <button type='button' class='btn btn-danger' onclick='hapus({$row['id']})'>
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

    case 'hapus_data':
        // Contoh aksi lain jika ada
        $id = $_POST['id'] ?? '';
        // Proses hapus di sini...
        echo "Data dengan ID $id berhasil dihapus";
        break;

    default:
        echo "Aksi tidak dikenal.";
        break;
}
exit;
