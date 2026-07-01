<?php
date_default_timezone_set('Asia/Jakarta');
$curdate = date('Y-m-d'); 
?>
<div>
    <div class="bg-body-tertiary p-5 rounded">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0"><i class="bi bi-cart-check"></i> Data Penjualan</h2>
                    <a href="index.php?menu=tambah-penjualan"  class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Penjualan
                    </a>
                </div>
                <hr>

                <div class="row g-3 mb-3 align-items-end">
                    <input type="hidden" name="filter" value="1">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control" value="<?php echo $curdate; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="<?php echo $curdate; ?>">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-primary" onclick="filter()">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                            <a href="penjualan.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </a>
                            <button type="button" class="btn btn-dark" onclick="window.print()">
                                <i class="bi bi-printer"></i> Print
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="tablePenjualan">
                        <thead class="table-dark">
                            <tr>
                                <th width="140">Aksi</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Konsumen</th>
                                <th>No HP</th>
                                <th class="text-end">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody id="tabledata">
                            
                        </tbody>
                    </table>
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

    $(document).ready(function() {
        loadData();
    });

    function loadData() {
        $.ajax({
            url: 'pages/penjualan/proses.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                aksi: 'tampil_data_awal'
            },
            success: function(response) {
                $('#tabledata').html(response.html);
            },
            error: function(xhr, status, error) {
                $('#tabledata').html("<tr><td colspan='6' style='text-align:center; color:red;'>Gagal memuat data dari server.</td></tr>");
                console.log(error);
            }
        });
    }

    function filter(){
        let tanggal_awal = document.getElementById('tanggal_awal').value;
        let tanggal_akhir = document.getElementById('tanggal_akhir').value;
        $.ajax({
            url: 'pages/penjualan/proses.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                aksi: 'tampil_data_awal_filter',
                tgl_mulai : tanggal_awal,
                tgl_selesai : tanggal_akhir
            },
            success: function(response) {
                $('#tabledata').html(response.html);
            },
            error: function(xhr, status, error) {
                $('#tabledata').html("<tr><td colspan='6' style='text-align:center; color:red;'>Gagal memuat data dari server.</td></tr>");
                console.log(error);
            }
        });
    }

    
</script>