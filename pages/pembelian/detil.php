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

                <form method="POST" id="formPembelian" onsubmit="return validateForm()">
                    <input type="hidden" name="items" id="itemsData">
                    <input type="hidden" name="total" id="totalHidden">
                    <input type="hidden" name="grand_total" id="grandTotalHidden">
                    <input type="hidden" name="diskon" id="diskonHidden">
                    <input type="hidden" name="bayar" id="bayarHidden">

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Supplier</label>
                            <select name="supplier" id="supplier" class="form-select" required>
                                <option value="">-- Pilih Supplier --</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" id="hp" class="form-control" readonly>
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
                                    <input type="text" id="kode" class="form-control" readonly data-bs-toggle="modal" data-bs-target="#modalBarang" style="cursor:pointer; background:#f8f9fa;">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" id="nama" class="form-control" readonly data-bs-toggle="modal" data-bs-target="#modalBarang" style="cursor:pointer; background:#f8f9fa;">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" id="satuan" class="form-control" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Harga Beli</label>
                                    <input type="number" id="harga" class="form-control" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">Qty</label>
                                    <input type="number" id="qty" value="1" class="form-control" min="1">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Subtotal</label>
                                    <input type="number" id="subtotal" class="form-control" readonly>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="tambah" class="btn btn-success w-100"><i class="bi bi-plus"></i>+</button>
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
                </form>
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

</script>