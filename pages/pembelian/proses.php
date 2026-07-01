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

        $query = mysqli_query($conn, "SELECT detail_pembelian.id, detail_pembelian.kode_pembelian, detail_pembelian.qty, produk.id, produk.nama, produk.satuan, produk.hargabeli, produk.hargajual 
        FROM detail_pembelian 
        JOIN produk ON detail_pembelian.kode_barang = produk.id 
        WHERE detail_pembelian.kode_pembelian = '".$kode."';");

        while ($row = mysqli_fetch_assoc($query)) {
            // Hitung subtotal untuk baris ini
            $subtotal = $row['hargabeli'] * $row['qty'];
            $grandtotal += $subtotal;

            $html_string .= "<tr>
                                    <td style='text-align: center;'>
                                        <button type='button' class='btn btn-warning btn-sm' onclick=\"view('{$row['id']}')\">
                                            View
                                        </button>
                                    </td>
                                    <th>{$row['id']}</th>
                                    <td>{$row['nama']}</td>
                                    <td>{$row['satuan']}</td>
                                    <td>" . number_format($row['hargabeli'], 0, ',', '.') . "</td>
                                    <td>{$row['qty']}</td>
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
        $supplier = $_POST['supplier'] ?? '';
        $hp = $_POST['hp'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';
        $kodebarang = $_POST['kodebarang'] ?? '';
        $qty = $_POST['qty'] ?? 1;

        // Validasi sederhana agar data tidak kosong
        if (empty($tanggal) || empty($supplier)) {
            echo "gagal: Tanggal dan supplier tidak boleh kosong!";
            exit;
        }

        // Query Insert ke database (Sesuaikan dengan nama tabel & kolom Anda)
        $cek_query  = "SELECT COUNT(*) AS total FROM pembelian WHERE kode_pembelian = '$kodeTrans'";
        $cek_result = mysqli_query($conn, $cek_query);
        $cek_data   = mysqli_fetch_assoc($cek_result);

        if ($cek_data['total'] < 1) {
            $query = "INSERT INTO pembelian (kode_pembelian, tanggal, idsupplier, no_hp) VALUES ('$kodeTrans', '$tanggal', '$supplier', '$hp')";
            mysqli_query($conn, $query);
        }


        // simpan detil
        $query = "INSERT INTO detail_pembelian (kode_pembelian, kode_barang, qty) VALUES ('$kodeTrans', '$kodebarang', '$qty')";
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
    case 'show_barang':

        $kode = $_POST['kode'] ?? '';

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
    case 'show_supplier':
        $kode = $_POST['kode'] ?? '';

        $query = mysqli_query($conn, "SELECT * FROM supplier WHERE id = '$kode'");
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
