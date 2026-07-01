<?php
// Hubungkan database jika ada
include '../../koneksi.php';

// Ambil parameter aksi
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

switch ($aksi) {
    case 'tampil_data_awal':

        $query = mysqli_query($conn, "SELECT 
                p.idpenjualan AS Kode,
                p.tanggal AS Tanggal,
                p.konsumen AS Konsumen,
                p.hp AS No_HP,
                SUM(pd.jumlah * pr.hargajual) AS Grand_Total
            FROM penjualan p
            LEFT JOIN penjualan_detil pd ON p.idpenjualan = pd.idpenjualan
            LEFT JOIN produk pr ON pd.idproduk = pr.id
            GROUP BY p.idpenjualan, p.tanggal, p.konsumen, p.hp
            ORDER BY p.tanggal DESC");

        $html_string = '';
        while ($row = mysqli_fetch_assoc($query)) {
            $html_string .= "<tr>
                                    <td style='text-align: center;'>
                                        <button type='button' class='btn btn-warning btn-sm' onclick=\"view('{$row['Kode']}')\">
                                            View
                                        </button>
                                    </td>
                                    <th>{$row['Kode']}</th>
                                    <td>{$row['Tanggal']}</td>
                                    <td>{$row['Konsumen']}</td>
                                    <td>{$row['No_HP']}</td>
                                    <td style='text-align:right;'>" . number_format($row['Grand_Total'], 0, ',', '.') . "</td>
                                </tr>";
        }

        // Jika data di database ternyata kosong
        if (mysqli_num_rows($query) == 0) {
            $html_string = "<tr><td colspan='6' style='text-align:center;'>Belum ada data produk.</td></tr>";
        }
        header('Content-Type: application/json');
        echo json_encode([
            'html' => $html_string
        ]);

        break;
    case 'tampil_data_awal_filter':
        $tgl_mulai = isset($_POST['tgl_mulai']) ? mysqli_real_escape_string($conn, $_POST['tgl_mulai']) : date('Y-m-01');
        $tgl_selesai = isset($_POST['tgl_selesai']) ? mysqli_real_escape_string($conn, $_POST['tgl_selesai']) : date('Y-m-d');

        // Query SQL dengan tambahan klausa WHERE BETWEEN
        $sql = "SELECT 
                p.idpenjualan AS kode, 
                p.tanggal AS tanggal, 
                p.konsumen AS konsumen, 
                p.hp AS no_hp, 
                SUM(pd.jumlah * pr.hargajual) AS grand_total 
            FROM penjualan p 
            INNER JOIN penjualan_detil pd ON p.idpenjualan = pd.idpenjualan 
            INNER JOIN produk pr ON pd.idproduk = pr.id 
            WHERE p.tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai'
            GROUP BY p.idpenjualan, p.tanggal, p.konsumen, p.hp 
            ORDER BY p.tanggal DESC";

        $query = mysqli_query($conn, $sql);
        $html_string = '';

        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $html_string .= "<tr> 
                <td style='text-align: center;'> 
                    <button type='button' class='btn btn-warning btn-sm' onclick=\"view('{$row['kode']}')\">view</button> 
                </td> 
                <th>{$row['kode']}</th> 
                <td>{$row['tanggal']}</td> 
                <td>{$row['konsumen']}</td> 
                <td>{$row['no_hp']}</td> 
                <td style='text-align:right;'>" . number_format($row['grand_total'], 0, ',', '.') . "</td> 
            </tr>";
            }
        } else {
            $html_string = "<tr><td colspan='6' style='text-align:center;'>Belum ada data penjualan untuk periode ini.</td></tr>";
        }

        header('Content-Type: application/json');
        echo json_encode([
            'html' => $html_string
        ]);
        break;
    case 'tampil_data':

        $kode = $_POST['kode'];
        $html_string = '';
        $grandtotal = 0;

        $query = mysqli_query($conn, "SELECT penjualan_detil.idpenjualan_detil, penjualan_detil.jumlah, produk.id, produk.nama, produk.satuan, produk.hargabeli, produk.hargajual FROM penjualan_detil JOIN produk ON penjualan_detil.idproduk = produk.id WHERE penjualan_detil.idpenjualan = '" . $kode . "';");

        while ($row = mysqli_fetch_assoc($query)) {
            // Hitung subtotal untuk baris ini
            $subtotal = $row['hargajual'] * $row['jumlah'];
            $grandtotal += $subtotal;

            $html_string .= "<tr>
                                    <td style='text-align: center;'>
                                        <button type='button' class='btn btn-warning btn-sm' onclick=\"view('{$row['idpenjualan_detil']}')\">
                                            View
                                        </button>
                                    </td>
                                    <th>{$row['id']}</th>
                                    <td>{$row['nama']}</td>
                                    <td>{$row['satuan']}</td>
                                    <td>" . number_format($row['hargajual'], 0, ',', '.') . "</td>
                                    <td>{$row['jumlah']}</td>
                                    <td>" . number_format($subtotal, 0, ',', '.') . "</td>
                                </tr>";
        }

        // Jika data di database ternyata kosong
        if (mysqli_num_rows($query) == 0) {
            // Diubah menjadi colspan='7' karena jumlah kolom pada tabel Anda ada 7 kolom
            $html_string = "<tr><td colspan='7' style='text-align:center;'>Belum ada data produk.</td></tr>";
        }


        header('Content-Type: application/json');

        echo json_encode([
            'html' => $html_string,
            'grandtotal' => $grandtotal
        ]);

        break;

    case 'simpan':
        // Menangkap data dari form_data.append
        $kodeTrans = $_POST['kode'] ?? '';
        $tanggal = $_POST['tanggal'] ?? '';
        $customer = $_POST['customer'] ?? '';
        $hp = $_POST['hp'] ?? '';
        $keterangan = $_POST['keterangan'] ?? 0;
        $kodebarang = $_POST['kodebarang'] ?? 0;
        $qty = $_POST['qty'] ?? 0;

        // Validasi sederhana agar data tidak kosong
        if (empty($tanggal) || empty($customer)) {
            echo "gagal: Tanggal dan customer tidak boleh kosong!";
            exit;
        }

        // Query Insert ke database (Sesuaikan dengan nama tabel & kolom Anda)
        $cek_query  = "SELECT COUNT(*) AS total FROM penjualan WHERE idpenjualan = '$kodeTrans'";
        $cek_result = mysqli_query($conn, $cek_query);
        $cek_data   = mysqli_fetch_assoc($cek_result);

        if ($cek_data['total'] < 1) {
            $query = "INSERT INTO penjualan (idpenjualan, tanggal, konsumen, hp) VALUES ('$kodeTrans', '$tanggal', '$customer', '$hp')";
            mysqli_query($conn, $query);
        }


        // simpan detil
        $query = "INSERT INTO penjualan_detil (idpenjualan, idproduk, jumlah) VALUES ('$kodeTrans', '$kodebarang', '$qty')";
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
                'message' => 'Data produk tidak ditemukan.'
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
    case 'show_barang':

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
                'message' => 'Data produk tidak ditemukan.'
            ]);
        }

        break;
    default:
        echo "Aksi tidak dikenal.";
        break;
}
exit;
