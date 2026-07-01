<?php
date_default_timezone_set('Asia/Jakarta');
$curdate = date('Y-m-d');

$qProduk = "SELECT * FROM produk";
$resultProduk = mysqli_query($conn, $qProduk);

function generate_uuid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

$trans = generate_uuid();

// cari data supplier
$qSupplier = "SELECT * FROM supplier";
$resultSupplier = mysqli_query($conn, $qSupplier);

// cari produk
$qProduk = "SELECT * FROM produk";
$resultProduk = mysqli_query($conn, $qProduk);

?>
<div>
    <div class="bg-body-tertiary p-5 rounded">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0"><i class="bi bi-bag-plus"></i> Tambah Pembelian</h2>
                    <a href="pembelian.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <hr>

                <div>
                    <input type="hidden" name="kodetrans" id="kodetrans" value="<?php echo $trans ?>">
                    <input type="hidden" name="items" id="itemsData">
                    <input type="hidden" name="total" id="totalHidden">
                    <input type="hidden" name="grand_total" id="grandTotalHidden">
                    <input type="hidden" name="diskon" id="diskonHidden">
                    <input type="hidden" name="bayar" id="bayarHidden">

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo $curdate; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Supplier</label>
                            <select name="supplier" id="supplier" class="form-select" onchange="displaysupplier()">
                                <option value="">-- Pilih Supplier --</option>
                                <?php while ($rowSupplier = mysqli_fetch_assoc($resultSupplier)) : ?>
                                    <option value="<?php echo $rowSupplier['id'] ?>"><?php echo $rowSupplier['nama'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="hp" id="hp" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control">
                        </div>
                    </div>

                    <hr>

                    <div class="card border-light-subtle mb-4">
                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-2">
                                    <label class="form-label">Kode Barang</label>
                                    <input type="text" id="kodebarang" class="form-control" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Nama Barang</label>
                                    <select id="namabarang" name="namabarang" class="form-control" onchange="displaybarang()">
                                        <option value="">- Pilih Barang -</option>
                                        <?php while ($rowProduk = mysqli_fetch_assoc($resultProduk)) : ?>
                                            <option value="<?php echo $rowProduk['id'] ?>"><?php echo $rowProduk['nama'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" id="satuan" class="form-control" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Harga Beli</label>
                                    <input type="number" id="harga" class="form-control" readonly oninput="hitung()" onchange="hitung()">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">Qty</label>
                                    <input type="number" id="qty" value="1" class="form-control" min="1" oninput="hitung()" onchange="hitung()">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Subtotal</label>
                                    <input type="number" id="subtotal" class="form-control" readonly>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="tambah" class="btn btn-success w-100" onclick="simpan()"><i class="bi bi-plus"></i>+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th width="60">Aksi</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="tabledata"></tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 offset-md-6">
                            <table class="table table-bordered align-middle mb-0">
                                <tr>
                                    <td width="150"><strong>Total</strong></td>
                                    <td id="totalHarga" class="text-end">Rp 0</td>
                                </tr>
                                <tr>
                                    <td><strong>Diskon (%)</strong></td>
                                    <td><input type="number" id="diskon" value="0" class="form-control" min="0" max="100"></td>
                                </tr>
                                <tr class="table-primary">
                                    <td><strong>Grand Total</strong></td>
                                    <td id="grandTotal" class="text-end"><strong>Rp 0</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Bayar</strong></td>
                                    <td><input type="number" id="bayar" class="form-control" min="0"></td>
                                </tr>
                                <tr>
                                    <td><strong>Kembalian</strong></td>
                                    <td id="kembalian" class="text-end">Rp 0</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" name="simpan_pembelian" class="btn btn-success btn-lg">
                            <i class="bi bi-save"></i> Simpan Pembelian
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="mb-3">
                        <label>Kode Produk</label>
                        <input type="text" id="kode" name="kode" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" id="nama" name="nama" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Satuan</label>
                        <input type="text" id="satuan" name="satuan" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Harga Beli</label>
                        <input type="text" id="hargabeli" name="hargabeli" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Harga Jual</label>
                        <input type="text" id="hargajual" name="hargajual" class="form-control" autocomplete="off">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

    let save_method = "";
    let totalMentah = 0;

    $(document).ready(function() {
        loadData();
    });

    function loadData() {
        let idtrans = document.getElementById('kodetrans').value;

        $.ajax({
            url: 'pages/pembelian/proses.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                aksi: 'tampil_data',
                kode: idtrans
            },
            success: function(response) {
                $('#tabledata').html(response.html);

                // Simpan nilai total mentah dari server ke variabel global
                totalMentah = parseFloat(response.grandtotal) || 0;

                // Tampilkan teks total dengan format rupiah
                $('#totalHarga').text('Rp ' + totalMentah.toLocaleString('id-ID'));

                // Pemicu hitung diskon, grand total, dan kembalian secara otomatis
                hitungPembayaran();
            },
            error: function(xhr, status, error) {
                $('#tabledata').html("<tr><td colspan='7' style='text-align:center; color:red;'>Gagal memuat data dari server.</td></tr>");
                totalMentah = 0;
                $('#totalHarga').text('Rp 0');
                hitungPembayaran();
            }
        });
    }

    function hitungPembayaran() {
        // Ambil nilai diskon dan uang bayar dari input
        let persenDiskon = parseFloat(document.getElementById('diskon').value) || 0;
        let uangBayar = parseFloat(document.getElementById('bayar').value) || 0;

        // Batasi diskon maksimal 100% dan minimal 0%
        if (persenDiskon > 100) persenDiskon = 100;
        if (persenDiskon < 0) persenDiskon = 0;

        // Hitung Potongan Diskon dan Grand Total
        let nominalDiskon = totalMentah * (persenDiskon / 100);
        let grandTotal = totalMentah - nominalDiskon;

        // Hitung Uang Kembalian
        let kembalian = uangBayar - grandTotal;
        // Jika uang bayar belum cukup, set kembalian menjadi 0 (jangan minus)
        if (kembalian < 0) kembalian = 0;

        // Cetak hasil hitungan ke layar HTML dengan format Rupiah
        document.getElementById('grandTotal').innerHTML = '<strong>Rp ' + grandTotal.toLocaleString('id-ID') + '</strong>';
        document.getElementById('kembalian').innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
    }
    
    function displaysupplier(){
        let idsupplier = document.getElementById('supplier').value;

        if (idsupplier != "") {
            let form_data = new FormData();
            form_data.append('aksi', 'show_supplier');
            form_data.append('kode', idsupplier);

            $.ajax({
                url: 'pages/pembelian/proses.php',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(response) {
                    $('#hp').val(response.data.hp);
                },
                error: function(xhr, status, error) {
                    console.error('Gagal mengambil data untuk edit:', error);
                }
            });
        } else {
            $('#hp').val("");
        }
    }

    function displaybarang() {
        let idbarang = document.getElementById('namabarang').value;

        if (idbarang != "") {
            let form_data = new FormData();
            form_data.append('aksi', 'show_barang');
            form_data.append('kode', idbarang);

            $.ajax({
                url: 'pages/penjualan/proses.php',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'sukses') {
                        $('#kodebarang').val(response.data.id);
                        $('#nama').val(response.data.nama);
                        $('#satuan').val(response.data.satuan);
                        $('#harga').val(response.data.hargajual);
                        hitung();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Gagal mengambil data untuk edit:', error);
                }
            });
        } else {
            $('#kodebarang').val("");
            $('#satuan').val("");
            $('#harga').val(0);
            hitung();
        }
    }

    function hitung() {
        let harga = document.getElementById('harga').value || 0;
        let qty = document.getElementById('qty').value || 0;
        document.getElementById('subtotal').value = harga * qty;
    }

    function simpan() {
        let kodetrans = document.getElementById('kodetrans').value;
        let tanggal = document.getElementById('tanggal').value;
        let supplier = document.getElementById('supplier').value;
        let hp = document.getElementById('hp').value;
        let keterangan = document.getElementById('keterangan').value;
        let kodebarang = document.getElementById('kodebarang').value;
        let qty = document.getElementById('qty').value;

        if (tanggal == "") {
            alert("Tanggal tidak boleh kosong");
        } else if (supplier == "") {
            alert("Supplier tidak boleh kosong");
        } else if (kodebarang == "") {
            alert("Pilih barang terlebih dahulu");
        } else if (qty == "") {
            alert("Jumlah barang tidak boleh kosong");
        } else {

            var form_data = new FormData();
            form_data.append('aksi', "simpan");
            form_data.append('kode', kodetrans);
            form_data.append('tanggal', tanggal);
            form_data.append('supplier', supplier);
            form_data.append('hp', hp);
            form_data.append('keterangan', keterangan);
            form_data.append('kodebarang', kodebarang);
            form_data.append('qty', qty);

            $.ajax({
                url: "pages/pembelian/proses.php",
                dataType: 'TEXT',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(response, status, xhr) {
                    alert(response);
                    loadData();

                },
                error: function(response, status, xhr) {
                    alert(status);
                }
            });
        }
    }

</script>